# Logos de contenido HTML en instalaciones Composer

El volcado reciente de producción conserva referencias como
`/typo3conf/ext/unal_skin_unal/Resources/Public/Images/logo-rectoria.svg`
en `tt_content.bodytext`. Los cambios previos de plantillas Fluid, páginas de
error y constantes TypoScript no transforman estos registros de la base.

## Asistente

Identificador: `unalHtmlLogoResourcesMigration`.
Clase: `UNAL\UnalSkinUnal\Updates\HtmlLogoResourcesMigration`.

Usa la configuración de servicios existente de unal_skin_unal y el atributo
UpgradeWizard de TYPO3 12. No añade tablas ni modifica dependencias de Composer.

Procesa únicamente `CType=html` y el atributo `src` de imágenes correspondientes
a cuatro nombres: logo-rectoria.svg, logo-agencia-unal.svg,
logo-periodico-unal.svg y logo-circular-unal.svg. Reconoce rutas antiguas de la
extensión y rutas `_assets` con identificador hexadecimal de 32 caracteres.
No cambia enlaces, encabezados, estados, relaciones de archivos ni otros recursos.
Se incluyen registros eliminados y ocultos para conservar su utilidad al restaurar
contenido histórico.

Las rutas de destino se calculan con TYPO3 desde los recursos de la extensión;
no se fija un hash manual. Antes de modificar datos se comprueba la existencia
de los originales y de los recursos publicados por Composer. La ejecución es
transaccional y se revierte si detecta cambios concurrentes en el HTML.

Implementa RepeatableInterface y compara el resultado antes de escribir. Si cambia
la publicación de assets entre entornos, puede volver a ejecutarse para actualizar
las rutas reconocidas. Si el asistente no aparece tras cambiar de versión, revisar
la lista incluyendo los ya ejecutados según la herramienta CLI instalada.

## Procedimiento para el laboratorio

1. Conservar un respaldo completo y verificado de la base local.
2. Instalar las dependencias y publicar los assets con `composer install`.
3. Limpiar las cachés de TYPO3 para descubrir el nuevo asistente:

   ```sh
   TYPO3_CONTEXT=Development vendor/bin/typo3 cache:flush
   TYPO3_CONTEXT=Development vendor/bin/typo3 upgrade:list
   ```

4. Revisar la cantidad indicada en la descripción. En el volcado de prueba de
   octubre de 2026 se identificaron 20 registros: 12 no eliminados y 8 eliminados.
   La cantidad es una referencia de ese volcado, no una condición del código.
5. Ejecutar solamente este asistente:

   ```sh
   TYPO3_CONTEXT=Development vendor/bin/typo3 upgrade:run unalHtmlLogoResourcesMigration
   TYPO3_CONTEXT=Development vendor/bin/typo3 cache:flush
   ```

6. Recargar el portal y comprobar los cuatro logos, tanto en la portada como
   en las otras páginas que reutilizan esos contenidos. Revisar que las URLs de
   las imágenes respondan 200 y que el asistente no proponga más cambios.

La reversión se realiza a partir del respaldo anterior. No ejecutar en producción
sin el procedimiento de cambio y respaldo correspondiente. Esta incorporación
registra el mecanismo; no ejecuta ninguna migración de base de datos.

## Validación antes de incorporar

Sintaxis comprobada con PHP 8.2. Pruebas de transformación y repetición cubren
rutas antiguas, rutas publicadas de un entorno anterior, conservación de enlaces,
archivos editoriales y recursos de otras extensiones. La ejecución sobre los
20 registros y la comprobación visual quedan pendientes en la VM.
