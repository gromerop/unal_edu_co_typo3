
plugin.tx_unalbase_arboldependencias {
  view {
    templateRootPaths.0 = EXT:unal_base/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_unalbase_arboldependencias.view.templateRootPath}
    partialRootPaths.0 = EXT:unal_base/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_unalbase_arboldependencias.view.partialRootPath}
    layoutRootPaths.0 = EXT:unal_base/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_unalbase_arboldependencias.view.layoutRootPath}
  }
  persistence {
    storagePid = {$plugin.tx_unalbase_arboldependencias.persistence.storagePid}
    #recursive = 1
  }
  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
}

plugin.tx_unalbase_busquedadependencias {
  view {
    templateRootPaths.0 = EXT:unal_base/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_unalbase_busquedadependencias.view.templateRootPath}
    partialRootPaths.0 = EXT:unal_base/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_unalbase_busquedadependencias.view.partialRootPath}
    layoutRootPaths.0 = EXT:unal_base/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_unalbase_busquedadependencias.view.layoutRootPath}
  }
  persistence {
    storagePid = {$plugin.tx_unalbase_busquedadependencias.persistence.storagePid}
    #recursive = 1
  }
  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
}

plugin.tx_unalbase_solicituddependencias {
  view {
    templateRootPaths.0 = EXT:unal_base/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_unalbase_solicituddependencias.view.templateRootPath}
    partialRootPaths.0 = EXT:unal_base/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_unalbase_solicituddependencias.view.partialRootPath}
    layoutRootPaths.0 = EXT:unal_base/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_unalbase_solicituddependencias.view.layoutRootPath}
  }
  persistence {
    storagePid = {$plugin.tx_unalbase_solicituddependencias.persistence.storagePid}
    #recursive = 1
  }
  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
}

plugin.tx_unalbase_busquedadependenciasporid {
  view {
    templateRootPaths.0 = EXT:unal_base/Resources/Private/Templates/
    templateRootPaths.1 = {$plugin.tx_unalbase_busquedadependenciasporid.view.templateRootPath}
    partialRootPaths.0 = EXT:unal_base/Resources/Private/Partials/
    partialRootPaths.1 = {$plugin.tx_unalbase_busquedadependenciasporid.view.partialRootPath}
    layoutRootPaths.0 = EXT:unal_base/Resources/Private/Layouts/
    layoutRootPaths.1 = {$plugin.tx_unalbase_busquedadependenciasporid.view.layoutRootPath}
  }
  persistence {
    storagePid = {$plugin.tx_unalbase_busquedadependenciasporid.persistence.storagePid}
    #recursive = 1
  }
  features {
    #skipDefaultArguments = 1
  }
  mvc {
    #callDefaultActionIfActionCantBeResolved = 1
  }
}

plugin.tx_unalbase._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-unal-base table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-unal-base table th {
        font-weight:bold;
    }

    .tx-unal-base table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

page {
	includeCSS {
		unal_su1_jqueryui = EXT:unal_base/Resources/Public/css/jquery-ui.css
		unal_su1_jqueryui.excludeFromConcatenation = 1
		unal_su1_jqueryuistructure = EXT:unal_base/Resources/Public/css/jquery-ui.structure.css
		unal_su1_jqueryuistructure.excludeFromConcatenation = 1
	}
}

# Vista para el buscador de dependencias por nombre
tx_unalbase_buscarDependencias = PAGE
tx_unalbase_buscarDependencias {
	typeNum = 121
	config {
		disableAllHeaderCode = 1
		xhtml_cleaning = 0
		admPanel = 0
		additionalHeaders = Content-type: text/plain
		no_cache = 1
		debug = 0
	}
	10 = USER
	10 {
		userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
		extensionName = UnalBase
		pluginName = Busquedadependencias
		vendorName = UNAL
		controller = Dependencia
		switchableControllerActions {
			Dependencia {
				1 = buscar
			}
		}
		view < plugin.tx_unalbase_busquedadependencias.view
		persistence < plugin.tx_unalbase_busquedadependencias.persistence
		settings < plugin.tx_unalbase_busquedadependencias.settings
	}
}

# Vista para el buscador de dependencias por id
tx_unalbase_buscarDependenciasPorId = PAGE
tx_unalbase_buscarDependenciasPorId {
	typeNum = 122
	config {
		disableAllHeaderCode = 1
		xhtml_cleaning = 0
		admPanel = 0
		additionalHeaders = Content-type: text/plain
		no_cache = 1
		debug = 0
	}
	10 = USER
	10 {
		userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
		extensionName = UnalBase
		pluginName = Busquedadependenciasporid
		vendorName = UNAL
		controller = Dependencia
		switchableControllerActions {
			Dependencia {
				1 = buscarPorId
			}
		}
		view < plugin.tx_unalbase_busquedadependenciasporid.view
		persistence < plugin.tx_unalbase_busquedadependenciasporid.persistence
		settings < plugin.tx_unalbase_busquedadependenciasporid.settings
	}
}