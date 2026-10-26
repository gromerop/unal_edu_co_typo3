<?php
$unalbase = 'unal_base';
defined('TYPO3') || die();

call_user_func(
    function($unalbase)
	{

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'UNAL.UnalBase',
            'Arboldependencias',
            [
                'Dependencia' => 'listarArbol'
            ],
            // non-cacheable actions
            [
                'Dependencia' => 'listarArbol'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'UNAL.UnalBase',
            'Busquedadependencias',
            [
                'Dependencia' => 'buscar'
            ],
            // non-cacheable actions
            [
                'Dependencia' => 'buscar'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'UNAL.UnalBase',
            'Solicituddependencias',
            [
                'SolicitudDependencia' => 'new, create'
            ],
            // non-cacheable actions
            [
                'SolicitudDependencia' => 'new, create'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'UNAL.UnalBase',
            'Busquedadependenciasporid',
            [
                'Dependencia' => 'buscarPorId'
            ],
            // non-cacheable actions
            [
                'Dependencia' => 'buscarPorId'
            ]
        );

	// wizards
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
		'mod {
			wizards.newContentElement.wizardItems.plugins {
				elements {
					arboldependencias {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($unalbase) . 'Resources/Public/Icons/user_plugin_arboldependencias.svg
						title = LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unal_base_domain_model_arboldependencias
						description = LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unal_base_domain_model_arboldependencias.description
						tt_content_defValues {
							CType = list
							list_type = unalbase_arboldependencias
						}
					}
					busquedadependencias {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($unalbase) . 'Resources/Public/Icons/user_plugin_busquedadependencias.svg
						title = LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unal_base_domain_model_busquedadependencias
						description = LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unal_base_domain_model_busquedadependencias.description
						tt_content_defValues {
							CType = list
							list_type = unalbase_busquedadependencias
						}
					}
					solicituddependencias {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($unalbase) . 'Resources/Public/Icons/user_plugin_solicituddependencias.svg
						title = LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unal_base_domain_model_solicituddependencias
						description = LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unal_base_domain_model_solicituddependencias.description
						tt_content_defValues {
							CType = list
							list_type = unalbase_solicituddependencias
						}
					}
					busquedadependenciasporid {
						icon = ' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($unalbase) . 'Resources/Public/Icons/user_plugin_busquedadependenciasporid.svg
						title = LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unal_base_domain_model_busquedadependenciasporid
						description = LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unal_base_domain_model_busquedadependenciasporid.description
						tt_content_defValues {
							CType = list
							list_type = unalbase_busquedadependenciasporid
						}
					}
				}
				show = *
			}
	   }'
	);
    },
    'unal_base'
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
