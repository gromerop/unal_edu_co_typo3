config {
	doctype = html5  
	htmlTag_setParams = none
	// Manejo de navegadores IE
	htmlTag_stdWrap {
		setContentToCurrent = 1
		cObject = COA
		cObject {
			10 = LOAD_REGISTER
			10 {
				newLine.char = 10
				tagEnd {
					current = 1
					split.max = 2
					split.token = <html
					split.returnKey = 1
				}
			}
			20 = TEXT
			20.value = <!--[if lt IE 7]> <html class="ie6 oldie"{register:tagEnd} <![endif]-->
			20.wrap = |{register:newLine}
			20.insertData = 1
			30 < .20
			30.value = <!--[if IE 7]> <html class="ie7 oldie"{register:tagEnd} <![endif]-->
			40 < .20
			40.value = <!--[if IE 8]> <html class="ie8 oldie"{register:tagEnd} <![endif]-->
			50 < .20
			50.value = <!--[if gt IE 8]> <!--><html class="ie9"{register:tagEnd} <!--<![endif]-->
			90 = RESTORE_REGISTER
		}
	}

	// Codificación de caracteres
	renderCharset = utf-8
	metaCharset = utf-8

	// Configuración de cache
	cache_period = 1
	sendCacheHeaders = 1

	// Link settings
	absRefPrefix = auto
	prefixLocalAnchors = all

	// Remueve targets de los enlaces
	intTarget =
	extTarget = _blank

	// Búsqueda indizada
	index_enable = 1
	index_externals = 1

	// Limpieza de código
	disablePrefixComment = 1

	// Mover CSS y JS predeterminados a archivo externo
	removeDefaultJS = 1
	inlineStyle2TempFile = 1

	// Comentario en la etiqueta <head>
	headerComment (
	=============================================================================
	=== PLANTILLA DESARROLLADA POR LA OFICINA DE MEDIOS DIGITALES - UNIMEDIOS ===
	=============================================================================
	)
	// Habilita RealURL
	tx_realurl_enable = 1
	# Se remueve el título de la página. En page.headerData se modifica el valor del título.
	noPageTitle = 1
}