# De acuerdo con el artículo 10 de la Constitución Política, "El castellano es 
# el idioma oficial de Colombia. Las lenguas y dialectos de los grupos étnicos 
# son también oficiales en sus territorios. La enseñanza que se imparta en las 
# comunidades con tradiciones lingüísticas propias será bilingüe."
#
# Por lo anterior, el idioma predeterminado (uid 0) debe ser el español 
# y todas las páginas deben tener una versión en este idioma.
# 
# En atención a la iniciativa de la Vicerrectoría General, se incluyen las 
# lenguas de las comunidades Wayúu (wayuunaiki) y Nasa (nasa yuwe).

config {
	uniqueLinkVars = 1
	linkVars = L
	sys_language_uid = 0
	sys_language_overlay = 1
	sys_language_mode = content_fallback
	language = es
	locale_all = es_ES.UTF-8
	htmlTag_langKey = es-CO
	htmlTag.attributes.lang = es
#	htmlTag_setParams = lang="es" dir="ltr" class="no-js"
}
page.headerData {
	20 = TEXT
	20.value = <meta http-equiv="Content-Language" content="es"/>
}


# 1: Inglés (English)
[globalVar = GP:L = 1]
	config {
		sys_language_uid = 1
		language = en
		locale_all = en_US.UTF-8
#		htmlTag_setParams = lang="en" dir="ltr" class="no-js"
		htmlTag.attributes.lang = en
	}
	page.headerData.20.value = <meta http-equiv="Content-Language" content="en"/>
[end]

# 2: Portugués (Portugues)
[globalVar = GP:L = 2]
	config {
		sys_language_uid = 2
		language = pt
		locale_all = pt_BR.UTF-8
		htmlTag.attributes.lang = pt
#		htmlTag_setParams = lang="pt" dir="ltr" class="no-js"
	}
	page.headerData.20.value = <meta http-equiv="Content-Language" content="pt"/>
[end]

# 3: Francés (Français)
[globalVar = GP:L = 3]
	config {
		sys_language_uid = 3
		language = fr
		locale_all = fr_FR.UTF-8
		htmlTag.attributes.lang = fr
#		htmlTag_setParams = lang="fr" dir="ltr" class="no-js"
	}
	page.headerData.20.value = <meta http-equiv="Content-Language" content="fr"/>
[end]

# 4: Alemán (Deutsch)
[globalVar = GP:L = 4]
	config {
		sys_language_uid = 4
		language = de
		locale_all = de_DE.UTF-8
		htmlTag.attributes.lang = de
#		htmlTag_setParams = lang="de" dir="ltr" class="no-js"
	}
	page.headerData.20.value = <meta http-equiv="Content-Language" content="de"/>
[end]

# 5: Italiano (Italiano)
[globalVar = GP:L = 5]
	config {
		sys_language_uid = 5
		language = it
		locale_all = it_IT.UTF-8
		htmlTag.attributes.lang = it
#		htmlTag_setParams = lang="it" dir="ltr" class="no-js"
	}
	page.headerData.20.value = <meta http-equiv="Content-Language" content="it"/>
[end]

# 6: Lengua Wayúu (wayuunaiki)
[globalVar = GP:L = 6]
	config {
		sys_language_uid = 6
		language = guc
		locale_all = guc_CO.UTF-8
		htmlTag.attributes.lang = guc
	}
	page.headerData.20.value = <meta http-equiv="Content-Language" content="guc"/>
[end]

# 7: Lengua Nasa (nasa yuwe)
[globalVar = GP:L = 7]
	config {
		sys_language_uid = 7
		language = pbb
		locale_all = pbb_CO.UTF-8
		htmlTag.attributes.lang = pbb
	}
	page.headerData.20.value = <meta http-equiv="Content-Language" content="pbb"/>
[end]
