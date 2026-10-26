# Idioma predeterminado: Español
tx_unalskindefault.parameters {
    breadcrumbPosition = Está en:
    currentLang = Español [ES]

    languageCodes = auto
    languageId = es || en || guc || pbb
}

[siteLanguage("languageId") == 1]
    tx_unalskindefault.parameters.breadcrumbPosition = You are in:
    tx_unalskindefault.parameters.currentLang = en
[END]

[siteLanguage("languageId") == 2]
    tx_unalskindefault.parameters.breadcrumbPosition = Está en:
    tx_unalskindefault.parameters.currentLang = Wayuunaiki
[END]

[siteLanguage("languageId") == 3]
    tx_unalskindefault.parameters.breadcrumbPosition = Está en:
    tx_unalskindefault.parameters.currentLang = Nasa yuwe
[END]
