# Create a Fluid Template
page.10 = FLUIDTEMPLATE
page.10 {
	# Set the Template Pathes
	partialRootPaths {
		1 = {$tx_unalskindefault.filepaths.pri}/Partials/
	}
	layoutRootPaths {
		1 = {$tx_unalskindefault.filepaths.pri}/Layouts/
	}
	variables {
		unalsd_currentLang = TEXT
		unalsd_currentLang.value = {$tx_unalskindefault.parameters.currentLang}
		unalsd_langMenu = HMENU
		unalsd_langMenu {
			special = language
			special.value = {$tx_unalskindefault.parameters.languageCodes}
			special.normalWhenNoLanguage = 0
			1 = TMENU
			1 {
				# Item normal
				NO {
					stdWrap.cObject = TEXT
					stdWrap.cObject.value = {$tx_unalskindefault.parameters.languageId}
					allWrap = <li> | </li>
				}
				# Item activo
#				ACT = 1
#				ACT.doNotShowLink = 1
				# Item normal (cuando no existe una versión traducida de la página)
				USERDEF1 = 1
				USERDEF1.doNotShowLink = 1
				# Item activo (cuando no existe una versión traducida de la página)
				USERDEF2 = 1
				USERDEF2.doNotShowLink = 1
			}
		}
		unalsd_facebook = TEXT
		unalsd_facebook.value = {$tx_unalskindefault.parameters.socialLinks.facebook}
		unalsd_twitter = TEXT
		unalsd_twitter.value = {$tx_unalskindefault.parameters.socialLinks.twitter}
		unalsd_rss = TEXT
		unalsd_rss.value = {$tx_unalskindefault.parameters.socialLinks.rss}
		unalsd_instagram = TEXT
		unalsd_instagram.value = {$tx_unalskindefault.parameters.socialLinks.instagram}
		unalsd_youtube = TEXT
		unalsd_youtube.value = {$tx_unalskindefault.parameters.socialLinks.youtube}
		unalsd_aspirantes = TEXT
		unalsd_aspirantes.value = {$tx_unalskindefault.parameters.profiles.aspirantes}
		unalsd_estudiantes = TEXT
		unalsd_estudiantes.value = {$tx_unalskindefault.parameters.profiles.estudiantes}
		unalsd_egresados = TEXT
		unalsd_egresados.value = {$tx_unalskindefault.parameters.profiles.egresados}
		unalsd_docentes = TEXT
		unalsd_docentes.value = {$tx_unalskindefault.parameters.profiles.docentes}
		unalsd_administrativos = TEXT
		unalsd_administrativos.value = {$tx_unalskindefault.parameters.profiles.administrativos}
		unalsd_subdomain_local = TEXT
		unalsd_subdomain_local.value = {$tx_unalskindefault.parameters.showSearchLocal}
		unalsd_subdomain = TEXT
		unalsd_subdomain.data = getEnv:HTTP_HOST
		unalsd_servicesMenu < lib.servicesMenu
		unalsd_url = TEXT
		unalsd_url.value = {$tx_unalskindefault.parameters.url}
		unalsd_showFinder = TEXT
		unalsd_showFinder.value = {$tx_unalskindefault.parameters.showFinder}
		unalsd_showCampusMenu = TEXT
		unalsd_showCampusMenu.value = {$tx_unalskindefault.parameters.showCampusMenu}
		unalsd_contenido < styles.content.get
		unalsd_sitemapLinkUid = TEXT
		unalsd_sitemapLinkUid.value = {$tx_unalskindefault.parameters.sitemapLinkUid}
		unalsd_faqLinkUid = TEXT
		unalsd_faqLinkUid.value = {$tx_unalskindefault.parameters.faqLinkUid}
		unalsd_contactLinkUid = TEXT
		unalsd_contactLinkUid.value = {$tx_unalskindefault.parameters.contactLinkUid}
		unalsd_surveyLinkUid = TEXT
		unalsd_surveyLinkUid.value = {$tx_unalskindefault.parameters.surveyLinkUid}
		unalsd_glosaryLinkUid = TEXT
		unalsd_glosaryLinkUid.value = {$tx_unalskindefault.parameters.glosaryLinkUid}
		unalsd_contactAddress = TEXT
		unalsd_contactAddress.value = {$tx_unalskindefault.parameters.contact.address}
		unalsd_contactBuilding = TEXT
		unalsd_contactBuilding.value = {$tx_unalskindefault.parameters.contact.building}
		unalsd_contactCity = TEXT
		unalsd_contactCity.value = {$tx_unalskindefault.parameters.contact.city}
		unalsd_contactPhone = TEXT
		unalsd_contactPhone.value = {$tx_unalskindefault.parameters.contact.phone}
		unalsd_contactEmailAccount = TEXT
		unalsd_contactEmailAccount.value = {$tx_unalskindefault.parameters.contact.emailAccount}
		unalsd_aboutLinkUid = TEXT
		unalsd_aboutLinkUid.value = {$tx_unalskindefault.parameters.aboutLinkUid}
		unalsd_lastUpdateDate = TEXT
		unalsd_lastUpdateDate {
			data = page:SYS_LASTCHANGED
			if.isTrue.data = page:SYS_LASTCHANGED
			date >
			strftime = %d/%m/%Y
			data = register:SYS_LASTCHANGED
			if >
		}

		unalsd_showSocialMediaLinks = TEXT
		unalsd_showSocialMediaLinks.value = {$tx_unalskindefault.parameters.showSocialMediaLinks}

		unalsm_facebook = TEXT
		unalsm_facebook.value = {$tx_unalskindefault.parameters.socialMediaLinks.facebook}
		unalsm_instagram = TEXT
		unalsm_instagram.value = {$tx_unalskindefault.parameters.socialMediaLinks.instagram}
		unalsm_twitter = TEXT
		unalsm_twitter.value = {$tx_unalskindefault.parameters.socialMediaLinks.twitter}
		unalsm_youtube = TEXT
		unalsm_youtube.value = {$tx_unalskindefault.parameters.socialMediaLinks.youtube}
		unalsm_tiktok = TEXT
		unalsm_tiktok.value = {$tx_unalskindefault.parameters.socialMediaLinks.tiktok}
		unalsm_telegram = TEXT
		unalsm_telegram.value = {$tx_unalskindefault.parameters.socialMediaLinks.telegram}


		unalsd_copyright = TEXT
		unalsd_copyright.value = {$tx_unalskindefault.parameters.link.copyright}

		#Agencia
		unalum_agencia_image       = TEXT
		unalum_agencia_image.value = {$tx_unalskindefault.parameters.unimedios.agencia.image}
		unalum_agencia_title       = TEXT
		unalum_agencia_title.value = {$tx_unalskindefault.parameters.unimedios.agencia.title}
		unalum_agencia_url         = TEXT
		unalum_agencia_url.value   = {$tx_unalskindefault.parameters.unimedios.agencia.url}

		#Periodico
		unalum_periodico_image       = TEXT
		unalum_periodico_image.value = {$tx_unalskindefault.parameters.unimedios.periodico.image}
		unalum_periodico_title       = TEXT
		unalum_periodico_title.value = {$tx_unalskindefault.parameters.unimedios.periodico.title}
		unalum_periodico_url         = TEXT
		unalum_periodico_url.value   = {$tx_unalskindefault.parameters.unimedios.periodico.url}

		#Televisión
		unalum_television_image       = TEXT
		unalum_television_image.value = {$tx_unalskindefault.parameters.unimedios.television.image}
		unalum_television_title       = TEXT
		unalum_television_title.value = {$tx_unalskindefault.parameters.unimedios.television.title}
		unalum_television_url         = TEXT
		unalum_television_url.value   = {$tx_unalskindefault.parameters.unimedios.television.url}

		#Radio
		unalum_radio_image       = TEXT
		unalum_radio_image.value = {$tx_unalskindefault.parameters.unimedios.radio.image}
		unalum_radio_title       = TEXT
		unalum_radio_title.value = {$tx_unalskindefault.parameters.unimedios.radio.title}
		unalum_radio_url         = TEXT
		unalum_radio_url.value   = {$tx_unalskindefault.parameters.unimedios.radio.url}

		#Podcast
		unalum_podcast_image       = TEXT
		unalum_podcast_image.value = {$tx_unalskindefault.parameters.unimedios.podcast.image}
		unalum_podcast_title       = TEXT
		unalum_podcast_title.value = {$tx_unalskindefault.parameters.unimedios.podcast.title}
		unalum_podcast_url         = TEXT
		unalum_podcast_url.value   = {$tx_unalskindefault.parameters.unimedios.podcast.url}

		#Circular
		unalum_circular_image       = TEXT
		unalum_circular_image.value = {$tx_unalskindefault.parameters.unimedios.circular.image}
		unalum_circular_title       = TEXT
		unalum_circular_title.value = {$tx_unalskindefault.parameters.unimedios.circular.title}
		unalum_circular_url         = TEXT
		unalum_circular_url.value   = {$tx_unalskindefault.parameters.unimedios.circular.url}

		#Orgullo
		unalum_orgullo_image       = TEXT
		unalum_orgullo_image.value = {$tx_unalskindefault.parameters.unimedios.orgullo.image}
		unalum_orgullo_title       = TEXT
		unalum_orgullo_title.value = {$tx_unalskindefault.parameters.unimedios.orgullo.title}
		unalum_orgullo_url         = TEXT
		unalum_orgullo_url.value   = {$tx_unalskindefault.parameters.unimedios.orgullo.url}

		#Metacampus
		unalum_metacampus_image       = TEXT
		unalum_metacampus_image.value = {$tx_unalskindefault.parameters.unimedios.metacampus.image}
		unalum_metacampus_title       = TEXT
		unalum_metacampus_title.value = {$tx_unalskindefault.parameters.unimedios.metacampus.title}
		unalum_metacampus_url         = TEXT
		unalum_metacampus_url.value   = {$tx_unalskindefault.parameters.unimedios.metacampus.url}

		#Debates
		unalum_debates_image       = TEXT
		unalum_debates_image.value = {$tx_unalskindefault.parameters.unimedios.debates.image}
		unalum_debates_title       = TEXT
		unalum_debates_title.value = {$tx_unalskindefault.parameters.unimedios.debates.title}
		unalum_debates_url         = TEXT
		unalum_debates_url.value   = {$tx_unalskindefault.parameters.unimedios.debates.url}

		#Tienda
		unalum_tienda_image       = TEXT
		unalum_tienda_image.value = {$tx_unalskindefault.parameters.unimedios.tienda.image}
		unalum_tienda_title       = TEXT
		unalum_tienda_title.value = {$tx_unalskindefault.parameters.unimedios.tienda.title}
		unalum_tienda_url         = TEXT
		unalum_tienda_url.value   = {$tx_unalskindefault.parameters.unimedios.tienda.url}

		#Identidad
		unalum_identidad_image       = TEXT
		unalum_identidad_image.value = {$tx_unalskindefault.parameters.unimedios.identidad.image}
		unalum_identidad_title       = TEXT
		unalum_identidad_title.value = {$tx_unalskindefault.parameters.unimedios.identidad.title}
		unalum_identidad_url         = TEXT
		unalum_identidad_url.value   = {$tx_unalskindefault.parameters.unimedios.identidad.url}

		#Solicitudes
		unalum_solicitudes_image       = TEXT
		unalum_solicitudes_image.value = {$tx_unalskindefault.parameters.unimedios.solicitudes.image}
		unalum_solicitudes_title       = TEXT
		unalum_solicitudes_title.value = {$tx_unalskindefault.parameters.unimedios.solicitudes.title}
		unalum_solicitudes_url         = TEXT
		unalum_solicitudes_url.value   = {$tx_unalskindefault.parameters.unimedios.solicitudes.url}

		#Unimedios
		unalum_unimedios_image       = TEXT
		unalum_unimedios_image.value = {$tx_unalskindefault.parameters.unimedios.unimedios.image}
		unalum_unimedios_title       = TEXT
		unalum_unimedios_title.value = {$tx_unalskindefault.parameters.unimedios.unimedios.title}
		unalum_unimedios_url         = TEXT
		unalum_unimedios_url.value   = {$tx_unalskindefault.parameters.unimedios.unimedios.url}


		#Pestaña de Servicios

		unalse_url_local = TEXT
		unalse_url_local.data = site:base

		#correo electrónico
		unalse_correo_image       = TEXT
		unalse_correo_image.value = {$tx_unalskindefault.parameters.servicios.correo.image}
		unalse_correo_title       = TEXT
		unalse_correo_title.value = {$tx_unalskindefault.parameters.servicios.correo.title}
		unalse_correo_url         = TEXT
		unalse_correo_url.value   = {$tx_unalskindefault.parameters.servicios.correo.url}
		unalse_correo_islocal       = TEXT
		unalse_correo_islocal.value = {$tx_unalskindefault.parameters.servicios.correo.islocal}

		#DINARA - SIA
		unalse_dninfoa_image       = TEXT
		unalse_dninfoa_image.value = {$tx_unalskindefault.parameters.servicios.dninfoa.image}
		unalse_dninfoa_title       = TEXT
		unalse_dninfoa_title.value = {$tx_unalskindefault.parameters.servicios.dninfoa.title}
		unalse_dninfoa_url         = TEXT
		unalse_dninfoa_url.value   = {$tx_unalskindefault.parameters.servicios.dninfoa.url}
		unalse_dninfoa_islocal       = TEXT
		unalse_dninfoa_islocal.value = {$tx_unalskindefault.parameters.servicios.dninfoa.islocal}

		#servicios investigación
		unalse_serviciosInvestigacion_image       = TEXT
		unalse_serviciosInvestigacion_image.value = {$tx_unalskindefault.parameters.servicios.serviciosInvestigacion.image}
		unalse_serviciosInvestigacion_title       = TEXT
		unalse_serviciosInvestigacion_title.value = {$tx_unalskindefault.parameters.servicios.serviciosInvestigacion.title}
		unalse_serviciosInvestigacion_url         = TEXT
		unalse_serviciosInvestigacion_url.value   = {$tx_unalskindefault.parameters.servicios.serviciosInvestigacion.url}
		unalse_serviciosInvestigacion_islocal       = TEXT
		unalse_serviciosInvestigacion_islocal.value = {$tx_unalskindefault.parameters.servicios.serviciosInvestigacion.islocal}
		
		#Convocatorias
		unalse_convocatorias_image       = TEXT
		unalse_convocatorias_image.value = {$tx_unalskindefault.parameters.servicios.convocatorias.image}
		unalse_convocatorias_title       = TEXT
		unalse_convocatorias_title.value = {$tx_unalskindefault.parameters.servicios.convocatorias.title}
		unalse_convocatorias_url         = TEXT
		unalse_convocatorias_url.value   = {$tx_unalskindefault.parameters.servicios.convocatorias.url}
		unalse_convocatorias_islocal       = TEXT
		unalse_convocatorias_islocal.value = {$tx_unalskindefault.parameters.servicios.convocatorias.islocal}
		
		#Identidad UNAL
		unalse_identidad_image       = TEXT
		unalse_identidad_image.value = {$tx_unalskindefault.parameters.servicios.identidad.image}
		unalse_identidad_title       = TEXT
		unalse_identidad_title.value = {$tx_unalskindefault.parameters.servicios.identidad.title}
		unalse_identidad_url         = TEXT
		unalse_identidad_url.value   = {$tx_unalskindefault.parameters.servicios.identidad.url}
		unalse_identidad_islocal       = TEXT
		unalse_identidad_islocal.value = {$tx_unalskindefault.parameters.servicios.identidad.islocal}

		#Portal contratación
		unalse_portal_image       = TEXT
		unalse_portal_image.value = {$tx_unalskindefault.parameters.servicios.portalContratacion.image}
		unalse_portal_title       = TEXT
		unalse_portal_title.value = {$tx_unalskindefault.parameters.servicios.portalContratacion.title}
		unalse_portal_url         = TEXT
		unalse_portal_url.value   = {$tx_unalskindefault.parameters.servicios.portalContratacion.url}
		unalse_portal_islocal       = TEXT
		unalse_portal_islocal.value = {$tx_unalskindefault.parameters.servicios.portalContratacion.islocal}

		#Bibliotecas
		unalse_bibliotecas_image       = TEXT
		unalse_bibliotecas_image.value = {$tx_unalskindefault.parameters.servicios.bibliotecas.image}
		unalse_bibliotecas_title       = TEXT
		unalse_bibliotecas_title.value = {$tx_unalskindefault.parameters.servicios.bibliotecas.title}
		unalse_bibliotecas_url         = TEXT
		unalse_bibliotecas_url.value   = {$tx_unalskindefault.parameters.servicios.bibliotecas.url}
		unalse_bibliotecas_islocal       = TEXT
		unalse_bibliotecas_islocal.value = {$tx_unalskindefault.parameters.servicios.bibliotecas.islocal}

		#Registro y matricula
		unalse_registro_image       = TEXT
		unalse_registro_image.value = {$tx_unalskindefault.parameters.servicios.registro.image}
		unalse_registro_title       = TEXT
		unalse_registro_title.value = {$tx_unalskindefault.parameters.servicios.registro.title}
		unalse_registro_url         = TEXT
		unalse_registro_url.value   = {$tx_unalskindefault.parameters.servicios.registro.url}
		unalse_registro_islocal       = TEXT
		unalse_registro_islocal.value = {$tx_unalskindefault.parameters.servicios.registro.islocal}

		#Bienestar
		unalse_bienestar_image       = TEXT
		unalse_bienestar_image.value = {$tx_unalskindefault.parameters.servicios.bienestar.image}
		unalse_bienestar_title       = TEXT
		unalse_bienestar_title.value = {$tx_unalskindefault.parameters.servicios.bienestar.title}
		unalse_bienestar_url         = TEXT
		unalse_bienestar_url.value   = {$tx_unalskindefault.parameters.servicios.bienestar.url}
		unalse_bienestar_islocal       = TEXT
		unalse_bienestar_islocal.value = {$tx_unalskindefault.parameters.servicios.bienestar.islocal}

		#Museos
		unalse_museos_image       = TEXT
		unalse_museos_image.value = {$tx_unalskindefault.parameters.servicios.museos.image}
		unalse_museos_title       = TEXT
		unalse_museos_title.value = {$tx_unalskindefault.parameters.servicios.museos.title}
		unalse_museos_url         = TEXT
		unalse_museos_url.value   = {$tx_unalskindefault.parameters.servicios.museos.url}
		unalse_museos_islocal       = TEXT
		unalse_museos_islocal.value = {$tx_unalskindefault.parameters.servicios.museos.islocal}

		#Editorial
		unalse_editorial_image       = TEXT
		unalse_editorial_image.value = {$tx_unalskindefault.parameters.servicios.editorial.image}
		unalse_editorial_title       = TEXT
		unalse_editorial_title.value = {$tx_unalskindefault.parameters.servicios.editorial.title}
		unalse_editorial_url         = TEXT
		unalse_editorial_url.value   = {$tx_unalskindefault.parameters.servicios.editorial.url}
		unalse_editorial_islocal       = TEXT
		unalse_editorial_islocal.value = {$tx_unalskindefault.parameters.servicios.editorial.islocal}

		#Regimen
		unalse_regimen_image       = TEXT
		unalse_regimen_image.value = {$tx_unalskindefault.parameters.servicios.regimen.image}
		unalse_regimen_title       = TEXT
		unalse_regimen_title.value = {$tx_unalskindefault.parameters.servicios.regimen.title}
		unalse_regimen_url         = TEXT
		unalse_regimen_url.value   = {$tx_unalskindefault.parameters.servicios.regimen.url}
		unalse_regimen_islocal       = TEXT
		unalse_regimen_islocal.value = {$tx_unalskindefault.parameters.servicios.regimen.islocal}

		#Portal para niños
		unalse_portalNinos_image       = TEXT
		unalse_portalNinos_image.value = {$tx_unalskindefault.parameters.servicios.portalNinos.image}
		unalse_portalNinos_title       = TEXT
		unalse_portalNinos_title.value = {$tx_unalskindefault.parameters.servicios.portalNinos.title}
		unalse_portalNinos_url         = TEXT
		unalse_portalNinos_url.value   = {$tx_unalskindefault.parameters.servicios.portalNinos.url}
		unalse_portalNinos_islocal       = TEXT
		unalse_portalNinos_islocal.value = {$tx_unalskindefault.parameters.servicios.portalNinos.islocal}
		

	} # end Variables
	# Assign the Template files with the Fluid Backend-Template
	file.stdWrap.cObject = CASE
	file.stdWrap.cObject {
		key.data = levelfield:-1, backend_layout_next_level, slide
		key.override.field = backend_layout
		# Set the default Template, our 3 column Template
		default = TEXT
		default.value = {$tx_unalskindefault.filepaths.pri}/Templates/Page.html
	}
}
