# Integración en el portal TYPO3 13

Esta copia se integra mediante el paquete Composer `unal/unal-160`, con TYPO3
13.4, News 13 y PHP 8.2 o superior (según las restricciones del proyecto).
El código original de producción no se modifica.

Se conservan los CType `unal160_year`, `unal160_images` y `unal160_stories`,
el layout 16001 y los identificadores editoriales existentes. No se añaden tablas.
Se actualizan el formulario FlexForm, los elementos TCA y la API de caché de página.
La vigencia de las consultas queda limitada a 300 segundos y, para la agenda,
al próximo refresco de Circular si ocurre antes.

Incluir el template estático «UNAL 160: meses temáticos» después de Fluid Styled
Content. Mantener Bootstrap 5 del sitio y evitar cargar Splide o inicializadores
por duplicado. Composer instala el paquete desde `packages/unal_160`.

Validación pendiente en el laboratorio: página del aniversario con la copia de
producción, categorías y carpeta 531, imágenes, noticias, agenda Circular,
ventanas de video, caché y navegación móvil/teclado. Esta integración no ejecuta
migraciones de base de datos ni publica el portal.

Esta versión del paquete es para TYPO3 13; la etapa temporal de TYPO3 12 requiere
una variante con sus dependencias y API compatibles.

---

## Documentación histórica de la versión de producción

Lo siguiente describe la versión original de TYPO3 11; sus instrucciones de
instalación y compatibilidad no sustituyen las indicaciones anteriores.

# Año 160: meses temáticos

Paquete inicial para TYPO3 11.5.41, News 11.4.3 y Splide incluido.
No está instalado ni verificado en una instancia TYPO3: requiere validación en
el sitio de prueba antes de publicar. No modifica el sitio desde esta carpeta.

## Instalación

1. Copiar la carpeta unal_160 a typo3conf/ext/unal_160 en instalaciones clásicas.
   En Composer, registrar este directorio como repositorio path e instalar
   unal/unal-160. El paquete incluye el mapeo PSR-4.
2. Activar la extensión y limpiar la caché de TYPO3, incluida la de DI.
3. Incluir el template estático «UNAL 160: meses temáticos» en la plantilla raíz,
   después de Fluid Styled Content.
4. Crear un elemento de contenido y seleccionar el tipo
   «Año 160: meses temáticos». Puede ubicarse dentro de bootstrap-grids.
   El título de la sección se edita en el campo encabezado o por separado.
5. Splide está incluido: biblioteca y ambos inicializadores se cargan juntos
   en carousels.bundle.js, evitando que un inicializador se ejecute antes de Splide.
   Quitar las inclusiones antiguas de Splide CSS/JS y de image-carousel.js/CSS
   en la plantilla de esta página. No cargar year.js por separado.
6. La base de datos no requiere tablas ni columnas nuevas.

## Datos

Consulta noticias en 531 y todos sus descendientes visibles. Respeta restricciones
frontend de ocultación, borrado, fechas de publicación y grupos de acceso.
La versión inicial consulta el idioma predeterminado y registros de todos los
idiomas (-1); no implementa traducciones ni fallback multilingüe. Está preparada
para la página en español actual.

Cada noticia debe tener asignadas explícitamente categoría 63, un mes 70–81 y
un tipo 66–69. Las categorías 64 y 65 organizan el árbol, no son filtros.
Las noticias se ordenan por datetime DESC y, en empate, UID DESC.
Las carpetas ocultas o restringidas no se recorren; poner las subcarpetas editoriales
visibles. El procesador no impone límite de resultados ni pagina las tarjetas:
si el volumen crece mucho, añadir paginación/carga progresiva antes de desplegar.

La primera imagen marcada para vista previa se usa en la tarjeta; si no hay una
marcada se usa la primera imagen. Sin imagen se muestra una superficie de reserva.
Se aceptan externalurl http/https válidos; sin URL no se genera enlace.
Los destinos se abren en la misma pestaña. El título y enlace quedan debajo de la
imagen. No se usa el modal de YouTube para estas tarjetas.

Agenda está reservada conceptualmente, pero no aparece ni consulta Circular.
Los 12 meses siempre aparecen: sin contenido están deshabilitados. El primer mes
con contenido queda seleccionado; dentro de él, la primera pestaña no vacía.
Los carruseles de noticias muestran 3 tarjetas en escritorio, 2 en tablet y 1 en
móvil. Cada uno se inicia cuando su panel es visible. No hay reproducción automática.
La navegación secundaria admite flechas izquierda/derecha, Inicio y Fin.

Los textos e ilustraciones suministrados están en YearProcessor.php. Se conservó
literalmente «Acciones de cierre (eventos nacional)» para septiembre.

## Validación necesaria en el sitio de prueba

- Crear noticias de prueba con las 3 categorías y datetime distintos en 531 y
  dos niveles de subcarpetas; comprobar orden y presencia.
- Confirmar que noticias sin categoría 63, ocultas, futuras o vencidas no aparecen.
- Probar tipos vacíos y meses completamente vacíos, además de una sección sin noticias.
- Verificar imagen, URL externa y tarjeta sin URL/imagen.
- Recorrer los 12 meses y todos los tipos, con teclado y en móvil; comprobar
  carruseles tras cambiar repetidamente de pestaña.
- Comprobar la actualización de caché al editar noticias y relaciones de categorías.

Verificaciones locales realizadas: sintaxis de JavaScript, integridad de las
12 configuraciones y estructura de plantillas. No hay PHP ni TYPO3 instalados en
este entorno, por lo que la sintaxis PHP y el renderizado Fluid no están confirmados
por ejecución. Revisar esos dos puntos al instalar; la compatibilidad declarada
es el objetivo de implementación, no una certificación de ejecución.

## Carrusel de cinco fotografías integrado

Crear el contenido «UNAL 160: carrusel de fotografías», seleccionar las imágenes
en el campo Imágenes y ordenarlas allí. Conserva el comportamiento anterior:
5 en escritorio grande, 3 hasta 1199 px, 2 hasta 767 px y 1 hasta 575 px;
sin espacios y con avance automático que se detiene al arrastrar o pulsar flechas.

Para migrar el contenido actual, registrar primero el nuevo tipo. Cambiar su
Tipo a «UNAL 160: carrusel de fotografías» y comprobar que las relaciones de
Imágenes se conservan antes de guardar. Si el componente anterior usaba otro
campo de archivos, seleccionar esas imágenes en el nuevo campo Imágenes.
No eliminar el contenido anterior hasta comprobar la nueva vista.

Si se conserva temporalmente la plantilla anterior y sus referencias
carouselImages, el bundle también inicia cualquier elemento data-image-carousel.
Retirar siempre sus scripts anteriores para evitar inicializaciones duplicadas.
No se ha modificado la página publicada ni se han cambiado sus registros.

El archivo carousels.bundle.js se construye concatenando, en este orden:
Resources/Public/Vendor/splide/splide.min.js,
Resources/Public/JavaScript/image-carousel.js y
Resources/Public/JavaScript/year.js, separados por salto de línea y punto y coma.
Regenerarlo cada vez que cambie uno de esos archivos. Se conserva la cabecera
original de Splide en los archivos incluidos; verificar su licencia junto con
los demás recursos de terceros antes de distribuir el paquete fuera del sitio.

Validación adicional: comprobar ambos componentes juntos, que Splide se descargue
una sola vez y que no existan errores de biblioteca ausente en la consola.

## Ilustraciones incluidas en la extensión

Las doce ilustraciones originales se incluyen en Resources/Public/Images/Months/.
Fluid genera las URLs mediante f:uri.resource con extensionName Unal160, por lo
que no dependen de /archivos/user_upload/160 ni de una instalación en una ruta fija.
Se copiaron los SVG de Pagina160/12 meses tematicos agenda sin alterar su contenido.
Los originales locales y los archivos publicados existentes se conservan: solo
retirar estos últimos cuando se confirme que ninguna otra sección los utiliza.

## Flechas del diseñador

Los SVG izqsalmon.svg y dersalmon.svg están en Resources/Public/Images/Arrows/.
carousel-arrows.css los aplica al carrusel de fotografías, al selector de meses
y a los carruseles de noticias. Conserva los botones nativos, sus etiquetas,
el teclado y su estado deshabilitado. No depende de las rutas de user_upload.
Los SVG se copiaron de Pagina160/12 meses tematicos agenda, sin modificaciones.
Tras actualizar la extensión, limpiar caché de TYPO3 y del navegador. Verificar
los tres carruseles, el estado deshabilitado y el foco de teclado en el sitio.

## Compatibilidad con el contenido anterior (c3904)

La plantilla estática también configura CType=image y layout=16001 para usar
ImageCarousel y el procesador carouselImages. Las relaciones del campo image
se conservan. No hace falta cambiar el tipo de contenido de c3904 ni volver a
seleccionar sus fotografías. Los demás diseños de Imagen usan la plantilla Image.
Incluir este estático después de Fluid Styled Content y de cualquier configuración
que sobrescriba tt_content.image. Si el sitio tenía una plantilla base de Imagen
diferente de Image, conservarla en templateName.cObject.default.value.

Actualizar la extensión y limpiar cachés. La galería debe producir un elemento
data-image-carousel con diez slides y pasar a is-initialized. Splide ya viene
dentro de carousels.bundle.js; no añadir otra inclusión de splide.min.js.

## Corrección de templateName en TYPO3 11.5

La selección por layout usa templateName.cObject = CASE. No asignar CASE
directamente a templateName: es una propiedad string/stdWrap, no un cObject.
Esta corrección reemplaza el bloque de compatibilidad del paquete anterior.
Si persiste un 503, consultar el registro TYPO3 (typo3temp/var/log/) para obtener
la excepción exacta, sin activar la visualización pública de errores.

## Asistente de nuevo contenido

La extensión registra la pestaña UNAL 160 en el asistente mediante PageTSconfig
cargado desde ext_localconf.php. Incluye los dos tipos de contenido. Después de
actualizar, limpiar cachés y recargar el backend. También pueden seleccionarse
desde el campo Tipo al editar un contenido existente. Si el usuario no es
administrador, revisar que su grupo permita los CType unal160_year y
unal160_images y que no haya restricciones PageTSconfig que los eliminen.

## Agenda de Circular (octubre de 2026–septiembre de 2027)

Consulta en el servidor `https://circular.unal.edu.co/?circular_api=events&category=38&month=AAAA-MM`, incluyendo todas las páginas del JSON. Agenda solo se agrega tras recibir eventos; un mes que solo tenga Agenda queda habilitado. Se mantiene el orden cronológico ascendente del API. Las noticias conservan datetime descendente. Cada tarjeta presenta nombre, sesiones y lugar; el API actual no proporciona imágenes ni enlaces individuales.

Caché TYPO3 `unal160_circular`: respuestas válidas, incluso vacías, frescas durante 900 segundos; última respuesta válida disponible hasta 86400 segundos si falla Circular. Reintento después de 60 segundos. El HTML usa el menor tiempo entre su vigencia normal y la próxima actualización de eventos. No hay consultas desde el navegador ni requisito CORS. Límite global de consulta de 8 segundos por render y 3 segundos por petición; un fallo o límite de tiempo conserva el último resultado completo, nunca guarda una página parcial. Sin resultado anterior, Agenda se omite hasta que se logre consultar.

Instalación: reemplazar la extensión, regenerar autoload si la instalación lo requiere, limpiar todos los cachés y revisar el analizador de base de datos para crear las tablas del nuevo caché. El servidor de UNAL debe poder conectar por HTTPS a Circular. Para forzar actualización, limpiar el caché de páginas (el caché nuevo pertenece al grupo pages).

Validación pendiente en TYPO3 11.5: este entorno no tiene PHP ni una instalación TYPO3. La URL pública rechazó la conexión desde la herramienta de navegación; el consumidor se implementó contra el contrato del API disponible en la carpeta circular-api. Comprobar un mes con eventos, otro vacío, un mes con solo Agenda y la actualización tras limpiar cachés.

### Tarjetas «Para que te agendes»

Las tarjetas no muestran logo ni espacio de imagen. Las sesiones se resumen con el inicio más antiguo y el final más reciente en hora de Bogotá: DD/MM/AAAA - DD/MM/AAAA. Si ambas fechas coinciden, se muestra DD/MM/AAAA HH:mm, con la hora del primer inicio. El enlace Ver más usa el campo url del evento y comparte la estructura y los estilos de las noticias. La clave de caché cambia a events_v2 para no reutilizar tarjetas con la estructura anterior.

## Noticias normales en modal de texto

Tipo News (type=0): Ver más abre el título y bodytext en un modal Bootstrap 5, amplio y con desplazamiento interno; a pantalla completa en móviles pequeños. El texto se procesa con lib.parseFunc_RTE para conservar el formato y resolver enlaces del editor. Tipo External Page: conserva el enlace externalurl. La selección funciona en todas las categorías y meses. Agenda conserva su enlace a Circular.

Para el comunicado: crear News en la carpeta 531 o descendientes, asignar Aniversario 160 (63), el mes y Prensa (66), escribir el comunicado en el editor de texto. Las tarjetas no muestran imágenes. El detalle incorpora bodytext, teaser, elementos de contenido, medios configurados para el detalle, archivos y enlaces relacionados, autor y fecha de publicación.

Se requiere el CSS y JavaScript Bootstrap 5 ya presentes en la página. No se carga otra copia. El modal de texto es independiente del modal de video y se mueve a body al abrir para evitar secciones ocultas o contenedores transformados. Sustituir extensión y limpiar cachés; sin tablas adicionales. Prueba en TYPO3 pendiente: revisar formato RTE y enlaces, reapertura con otra noticia, cierre y retorno del foco, móvil y videos existentes.

### Detalle ampliado

YearProcessor recupera objetos News a través de su repositorio para resolver relaciones y permisos de EXT:news. El partial NewsModalDetail procesa bodytext/teaser con parseFunc_RTE, medios de mediaNonPreviews mediante f:media, falRelatedFiles y relatedLinks. Los elementos de contenido usan nonNestedContentElementIdList y RECORDS con el renderizado tt_content del sitio. Se omiten nodos anidados ya renderizados por sus contenedores. Las tarjetas conservan su espacio de fondo y no muestran fotos en ninguna pestaña.

Comprobar en TYPO3: noticia con texto, autor, datetime, imagen habilitada para detalle, audio/video, archivo, enlace y elementos de contenido; revisar también una noticia sin relaciones. Los elementos que requieren inicialización JavaScript propia al insertarse en el DOM (por ejemplo un plugin interactivo) pueden requerir adaptar ese inicializador al modal; el contenido estándar se renderiza en el servidor. La ejecución real de Extbase/Fluid aún requiere validación en el sitio.

## Historias que inspiran (categoría 82)

Nuevo CType `unal160_stories`, disponible en el asistente UNAL 160. Incluye
FlexForm con UID de categoría (82 por defecto) y carpeta de noticias (531 por
defecto), recorriendo sus descendientes visibles. No añade columnas ni tablas.
La consulta está orientada al español: idioma predeterminado y todos los idiomas
(-1), como el componente de meses; no implementa traducciones ni fallback.

Crear una noticia de tipo enlace externo por historia, asignar categoría 82,
fecha de publicación (datetime), título, URL externa y una imagen en Medios.
Se usa exclusivamente el primer archivo de Medios, respetando el orden editorial
y sin priorizar la marca de vista previa. Ese primer archivo debe ser una imagen;
si es un video u otro formato, se conserva el fondo sin buscar otro archivo. El título identifica la tarjeta; sin imagen conserva el fondo,
y sin URL HTTP/HTTPS válida se presenta sin enlace.

Orden: datetime DESC y UID DESC. Se excluyen fechas datetime futuras y se respetan
las restricciones frontend (ocultación, borrado, inicio/fin y grupos). La primera
historia aparece cuadrada a la izquierda y no se repite en el carrusel. Las
secundarias aparecen a la derecha en escritorio y debajo en móvil. Se conservan
dos imágenes visibles y avance de dos en dos, sin reproducción
automática; la última pareja puede tener un solo elemento. Con dos o menos
historias anteriores no muestra flechas ni arrastre. No hay límite de noticias;
revisar carga/paginación si el archivo crece significativamente.

YouTube (watch, youtu.be, shorts, live y embed) abre iframe youtube-nocookie.
Instagram (p, reel y tv) usa blockquote y el script oficial embed.js, cargado solo
al abrir una historia de esa plataforma. Mantiene la atribución de Instagram.
Solo publicaciones públicas con inserción permitida; no soporta Stories efímeras
ni perfiles como videos insertables. Siempre hay enlace directo al proveedor.
Otros destinos, incluidos enlaces de plataforma que no identifican un video o
publicación compatible, conservan su enlace en pestaña nueva. Si falta Bootstrap,
los enlaces de las tarjetas también abren su destino original. Cerrar el modal
retira el reproductor y devuelve el foco al activador.

### Actualización del sitio

1. Reemplazar la extensión y limpiar todos los cachés, incluido el de DI.
2. Mantener el template estático y Bootstrap 5 del sitio. No agregar otra copia
   de Splide, Bootstrap ni scripts de los componentes.
3. Insertar «UNAL 160: Historias que inspiran» en la columna actual y revisar
   categoría 82 y carpeta 531 (ajustar si las historias viven en otra carpeta).
   El encabezado puede gestionarse mediante el campo Encabezado.
4. Tras comprobar las historias, desactivar el contenido HTML del mosaico viejo.
   Retirar también su script de video y cualquier inclusión de VideoModalScript.html:
   stories.js reemplaza ese manejador y crea un único modal compartido
   `unal-historias-video` cuando se necesita. Conserva botones antiguos con
   data-youtube-id, data-bs-target="#unal-historias-video" y data-video-title.
   Puede reutilizar el modal antiguo si temporalmente se conserva su marcado,
   pero el script anterior debe retirarse para evitar manejadores duplicados.
5. Si existe una política CSP, permitir el reproductor youtube-nocookie.com y
   la inserción oficial de Instagram (script, frames y recursos requeridos por
   Instagram). Revisarlo con la política efectiva del sitio.

Las consultas agregan etiquetas de caché y limitan la vigencia de la página a
300 segundos como respaldo para publicaciones y cambios programados. Para ver
un cambio inmediatamente, limpiar el caché de la página.

El bundle ahora se genera concatenando, con salto de línea y punto y coma:
splide.min.js, image-carousel.js, year.js, news-modal.js y stories.js. No cargar
ninguno de esos inicializadores adicionalmente.

Validación local: XML del FlexForm, sintaxis de JavaScript y 13 casos de detección
de enlaces (YouTube, Instagram, destinos externos y dominios engañosos).
Pendiente en TYPO3 11.5/News 11.4: ejecución PHP y Fluid, relaciones de imágenes,
orden y permisos, caché, dos componentes en una página, carrusel con 0/1/2/3/5
historias anteriores, teclado/móvil, apertura/cierre de ambas plataformas,
publicación Instagram no insertable y botones de video de otras secciones.
Este entorno no tiene PHP ni una instancia TYPO3; no se ha publicado el cambio.

Las miniaturas de Historias muestran un tinte azul de forma predeterminada y
recuperan su color al pasar el puntero o recibir foco visible con teclado. El
título y el botón visual «Ver video» se alinean abajo a la derecha, sobre la
imagen. La tarjeta completa es el enlace, sin botones interactivos anidados.
La transición se desactiva cuando se solicita movimiento reducido.

Sin miniatura se muestra un fondo plano #1d1f40, sin la capa azul de las
fotografías. Se conservan el título y, cuando hay URL válida, «Ver video».

## Distribución lateral de Historias

En pantallas mayores de 767 px la historia principal queda a la izquierda y las
secundarias a la derecha, con dos tarjetas apiladas y navegación vertical por
pares. La altura se adapta a la principal mediante ResizeObserver (y resize
como respaldo). Las flechas quedan arriba y abajo. Hasta 767 px se conserva la
principal arriba y el carrusel horizontal debajo. Sin historias anteriores, la
principal ocupa todo el ancho. Actualizar Stories.html, stories.css y el bundle,
y limpiar cachés. Verificar en el sitio cambios de ancho, flechas, arrastre,
última pareja impar y apertura de modales. Datos y categoría 82 no cambian.
