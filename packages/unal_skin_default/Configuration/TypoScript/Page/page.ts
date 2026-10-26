# Se crea y se configura el sitio
page = PAGE
page {
	typeNum = 0
	shortcutIcon = EXT:unal_skin_default/Resources/Public/images/favicon.ico
	includeCSS {
		// usd_reset = {$tx_unalskindefault.filepaths.css}/reset.css
		// usd_bootstrap = {$tx_unalskindefault.filepaths.css}/bootstrap.min.css
		// usd_bootstrap-theme = {$tx_unalskindefault.filepaths.css}/bootstrap-theme.min.css
		// usd_unal = {$tx_unalskindefault.filepaths.css}/unal.css
		// usd_base = {$tx_unalskindefault.filepaths.css}/base.css
		// usd_tablet = {$tx_unalskindefault.filepaths.css}/tablet.css
		// usd_phone = {$tx_unalskindefault.filepaths.css}/phone.css
		// usd_small = {$tx_unalskindefault.filepaths.css}/small.css
		// usd_printer = {$tx_unalskindefault.filepaths.css}/printer.css
		// serviciosUnimedios = {$tx_unalskindefault.filepaths.css}/servicesUnimedios.css
		// usd_frontend = {$tx_unalskindefault.filepaths.css}/frontend.css
		node_bootstrap2 = EXT:unal_skin_default/Resources/Public/Build/bootstrap.css
		usd_accesibilidad = {$tx_unalskindefault.filepaths.css}/accesibilidad.css
		usd_frontend = EXT:unal_skin_default/Resources/Public/Build/frontend.css
		buscador = {$tx_unalskindefault.filepaths.css}/buscador.css
		node_bootstrap = {$tx_unalskindefault.filepaths.pub}/open-iconic/font/css/open-iconic-bootstrap.min.css
	}
	includeJS {
		vendor = EXT:unal_skin_default/Resources/Public/Build/vendor.js
		unal = {$tx_unalskindefault.filepaths.js}/unal.js
		buscador = {$tx_unalskindefault.filepaths.js}/buscador.js
		accesibilidad = {$tx_unalskindefault.filepaths.js}/accesibilidad.js
		// servicesUnimedios = {$tx_unalskindefault.filepaths.js}/servicesUnimedios.js
	}
	meta {
		description =
		description.override.field = description
		author =
		author.override.field = author
		keywords =
		keywords.override.field = keywords
		robots.value = all
		revisit-after = 1 hour
		copyright =
		distribution = all
		viewport = width=device-width, initial-scale=1, minimum-scale=0.5, maximum-scale=2.5, user-scalable=yes
		expires = 1
	}
	headerData {
		10 = TEXT
		10 {
			field = title
			noTrimWrap = |<title>|{$tx_unalskindefault.parameters.titleComplement}: Universidad Nacional de Colombia</title>|
		}
	}
}
