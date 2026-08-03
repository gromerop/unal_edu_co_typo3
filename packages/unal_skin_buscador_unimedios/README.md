# Unal skin buscador unimedios
Hook para alimentar el servidor de Elasticsearch con las "news", para Typo3 v.9.5.

## Instalación

### Composer
En el archivo **composer.json**, dentro del apartado "*repositories*" agregar el objeto:
```json
{
    "type": "package",
    "package": {
        "name": "jnoguerab/unal_skin_buscador_unimedios",
        "type": "typo3-cms-extension",
        "version": "1.0.0",
        "source": {
            "url": "http://168.176.236.13:8081/jnoguerab/unal_skin_buscador_unimedios.git",
            "type": "git"
        }
    }        
}
```
### Descarga del GitLab
Ubicarse en la ruta (desde la consola): 
```
/u01/htdocs/<PROYECTO>/typo3conf/ext/
```
Y escribir el comando:
```
$ git clone http://168.176.236.13:8081/jnoguerab/unal_skin_buscador_unimedios.git
```

### Agregar la ruta de las clases en el PSR-4 (*composer.json*)
En el archivo **composer.json**, dentro del apartado "*psr-4*" agregar lo siguiente:
```json
"UNAL\\UnalSkinBuscadorUnimedios\\":"/u01/htdocs/<PROYECTO>/typo3conf/ext/unal_skin_buscador_unimedios/Classes",
```

### Habilitar la extensión desde el Backend de Typo3
Iniciar sesión con un usuario administrador en el backend de Typo3 y dirigirse a la opción:
> `Admin tools` &#8594; `Extensions`

Activar la extensión:
> `unal_skin_buscador_unimedios`

## Configuración
Desde el backend de Typo3 y dirigirse a la opción: 
> `Admin tools` &#8594; `Settings` &#8594; `Extension Configuration` &#8594; `unal_skin_buscador_unimedios`

y agregar las configuraciones necesarias.

### Configuración - News Record
- **Detail pageUid of news:** Hace referencia al `uid` de la página creada para mostrar el detalle de las *news*.

### Configuración - Elasticsearch Configuration
- **Elasticsearch Domain:** Hace referencia al dominio donde se encuentra el servidor de elasticsearch, se debe colocar sin el "`\`" al final de la url.
- **Elasticsearch Port:** Hace referencia al puerto que esta habilitado el servidor de elasticsearch para conectarse.
- **Elasticsearch User:** Hace referencia al nombre de usuario habilitado, con los permisos necesarios para realizar un CRUD en los *índices* y los *documentos* de elasticsearch.
- **Elasticsearch Password:** Hace referencia la contraseña del usuario habilitado en elasticsearch.

### Configuración - Elasticsearch Indexes
- **Elasticsearch 'New' Index:** Hace referencia al *índice* creado para el proyecto, por ejemplo para el proyecto de Agencia UNAL se creó el inice *agencia_unal*, se recomienda mantener la misma estructura en el nombre del índice, es decir, "_proyecto_**_unal**".
- **Elasticsearch 'Image' Index:** Hace referencia al *índice* creado para almacenar todos registros de las imágenes de las *news*, el valor por defecto es: **image_unal**.
- **Elasticsearch 'Video' Index:** Hace referencia al *índice* creado para almacenar todos registros de los videos de las *news*, el valor por defecto es: **video_unal**.
- **Elasticsearch 'Audio' Index:** Hace referencia al *índice* creado para almacenar todos registros de los audios de las *news*, el valor por defecto es: **audio_unal**.