# Contrato de la API de noticias de la UNAL

## Propósito

Este directorio conserva una observación reproducible de la API legada de
`unal_news` antes de reemplazar `cundd/rest` por una implementación nativa de
TYPO3. Su objetivo es permitir la refactorización sin cambiar de manera
accidental las rutas, los códigos HTTP ni la estructura de las respuestas que
sí utilizan los consumidores.

La captura se hizo el 8 de septiembre de 2026 en un entorno DDEV aislado,
partiendo de:

- etiqueta Git: `typo3-v12-complete`;
- TYPO3: 12.4.45;
- `cundd/rest`: 6.0.0;
- instantánea de base de datos: `typo3-v12-complete`;
- registro existente usado en las pruebas: `537`;
- identificador inexistente usado en las pruebas: `4941`.

La especificación [openapi.yaml](openapi.yaml) describe el contrato observado.
Las respuestas completas y sus metadatos están en
`fixtures/typo3-v12/`. Los encabezados guardados fueron reducidos a los que
afectan el contrato HTTP; no se conservaron cookies.

## Método de captura

La etiqueta de TYPO3 12 no arrancó sin cambios con las dependencias instaladas
en 2026. Para poder observar la API se hicieron correcciones mínimas **solo en
el worktree aislado**, nunca en la rama de actualización:

- se declararon públicos los manejadores que `cundd/rest` obtiene por su
  identificador de servicio;
- se sustituyó la inyección mediante anotaciones eliminadas por inyección en el
  constructor;
- se adaptó la llamada al `Bootstrap` de Extbase a la firma de TYPO3 12;
- se inicializaron correctamente los `ObjectStorage` del modelo;
- se sustituyó el antiguo `ObjectManager` y se hizo que las acciones REST
  devolvieran una respuesta PSR-7.

Estas adaptaciones permiten ejecutar el código legado, pero no cambian la
lógica de negocio ni corrigen deliberadamente sus rutas o formatos. Por eso las
capturas representan el comportamiento histórico recuperable, no el estado
actual de TYPO3 13.

La captura puede repetirse así, desde la raíz del proyecto que esté ejecutando
la versión legada:

```bash
docs/api-contract/scripts/capture-v12-contract.sh \
  https://unal-typo3-ddev.ddev.site \
  docs/api-contract/fixtures/typo3-v12 \
  537 \
  4941
```

Las operaciones que intentarían actualizar el contador de visitas solo se
incluyen al definir `CAPTURE_VISIT_UID`. Antes de repetirlas debe utilizarse una
instantánea desechable de la base de datos.

## Matriz del comportamiento observado

| Operación | Ruta amigable | Método | Resultado observado |
|---|---|---:|---|
| Listado inicial | `/rest/noticias` | GET | 200, objeto paginado |
| Página del listado | `/rest/noticias/page/{page}` | GET | 200, objeto paginado |
| Detalle | `/rest/noticias/show/{uid}` | GET | 501, acción legada vacía |
| Relacionadas | `/rest/noticias/search` | POST | 200, arreglo; usa `size` |
| Exportación por tipo | `/rest/noticias/all/{type}/{page}` | GET | 200 para `new`, `image`, `video` y `audio` |
| Autocompletado | `/rest/noticias/autocomplete/{search}` | GET | 200, arreglo de títulos |
| Eliminadas desde ayer | `/rest/noticias/deleted` | GET | 200, arreglo de identificadores |
| Editadas desde ayer | `/rest/noticias/edited` | GET | 200, arreglo de noticias |
| Registrar visita | `/rest/visitas/update` | POST | 501, plugin no registrado |
| Lectura del contador | `/rest/visitas/update` | GET | 403, JSON |
| Preflight CORS | `/rest/noticias` | OPTIONS | 404, JSON |

Los alias canónicos de Cundd también existían:

- `/rest/unal-unal_news-unalNews`;
- `/rest/unal-unal_news-visitCounter/update`.

La respuesta del listado canónico fue idéntica, byte por byte, a la del alias
`/rest/noticias`.

## Estructuras que deben protegerse

El listado devuelve un objeto con `info` y `results`. `info` contiene `count`,
`pages`, `next` y `prev`. Cada noticia del listado contiene:

`id`, `title`, `alternativeTitle`, `teaser`, `date`, `imagen`, `video`,
`duration`, `vistas`, `url`, `domain` y `categories`.

La operación `search` devuelve directamente un arreglo con la misma forma de
noticia. El parámetro histórico se llama `size`; pese al nombre del endpoint,
la implementación legada no recibe un texto de búsqueda, sino que recupera
esa cantidad de registros relacionados.

`autocomplete` devuelve objetos con una sola propiedad, `title`.

La exportación `all/new` añade `recordDate`, `media` y `recordCategory`. La
exportación `all/image` utiliza otra forma destinada al buscador de
convergencia, con `id` textual, `id_new`, `product`, `baseUrl` y `file`.

## Fallos históricos que no constituyen compatibilidad deseada

Los siguientes resultados se conservaron como evidencia, pero deben corregirse
en la API nativa:

1. `show/{uid}` devuelve 501 tanto para un registro existente como para uno
   inexistente porque `showRestAction()` está vacía. La API nueva debe devolver
   200 para un registro existente y 404 para uno inexistente.
2. El contador devuelve 501 porque el plugin `Visitorcounter` nunca fue
   registrado. Las mediciones antes y después de las solicitudes fueron
   idénticas (`news-counter=0`, sin filas de visitas), por lo que no hubo
   mutaciones. La API nueva debe validar un identificador positivo, registrar
   la visita y responder 404 cuando la noticia no exista.
3. Los enlaces `next` y `prev` contienen una doble barra y apuntan a
   `/television/rest/noticias`, ruta que respondió 404. Deben generarse desde
   la ruta real solicitada.
4. `OPTIONS` respondió 404 aunque se enviaban encabezados CORS. La API nueva
   debe responder 204 a la solicitud previa.
5. Un tipo desconocido en `all/{type}/{page}` produjo un error HTML 500. La API
   nueva debe devolver un error JSON controlado (preferiblemente 404 o 400).
6. `all/video` devolvió ceros en vez de objetos de medios. Esto es un defecto de
   serialización y no una forma que deba adoptarse como modelo de dominio.
7. El nombre histórico `mesagge` está mal escrito. Puede mantenerse
   temporalmente para consumidores conocidos y retirarse después de una
   deprecación; no debe propagarse a interfaces nuevas sin necesidad.

## Criterio para la refactorización en TYPO3 13

El middleware de TYPO3 13 debe limitarse a interpretar la solicitud y construir
la respuesta PSR-7. La consulta y transformación de los datos debe vivir en un
servicio que no arranque Extbase desde el middleware ni dependa del contexto
frontend almacenado en caché.

Antes de aceptar la refactorización se deben volver a ejecutar las capturas
contra TYPO3 13 y comparar:

- rutas amigables y alias canónicos;
- códigos HTTP y `Content-Type`;
- claves, tipos y anidamiento de las respuestas exitosas;
- paginación y URLs generadas;
- validación de entradas y errores JSON;
- encabezados CORS;
- efecto real y único del registro de visitas.

Las diferencias correspondientes a los siete fallos históricos anteriores son
correcciones intencionales; cualquier otra diferencia requiere revisión.
