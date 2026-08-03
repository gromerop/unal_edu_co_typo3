<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'UNAL.UnalNews',
            'Vistasrest',
            [
                'UnalNews' => 'listRest, searchRest, showRest, mostViewed, allRest, deletedRest, editedRest, autocompleteRest'
            ],
            // non-cacheable actions
            [
                'UnalNews' => '',
                'VisitCounter' => 'update, ',
                'City' => 'create, update, delete'
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'UNAL.UnalNews',
            'Visitorcounter',
            [
                'VisitCounter' => 'edit, update'
            ],
            // non-cacheable actions
            [
                'UnalNews' => '',
                'VisitCounter' => 'update, ',
                'City' => 'create, update, delete'
            ]
        );

        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod {
                wizards.newContentElement.wizardItems.plugins {
                    elements {
                        vistasrest {
                            iconIdentifier = unal_news-plugin-vistasrest
                            title = LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_unal_news_vistasrest.name
                            description = LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_unal_news_vistasrest.description
                            tt_content_defValues {
                                CType = list
                                list_type = unalnews_vistasrest
                            }
                        }
                        visitorcounter {
                            iconIdentifier = unal_news-plugin-visitorcounter
                            title = LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_unal_news_visitorcounter.name
                            description = LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_unal_news_visitorcounter.description
                            tt_content_defValues {
                                CType = list
                                list_type = unalnews_visitorcounter
                            }
                        }
                    }
                    show = *
                }
           }'
        );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
			$iconRegistry->registerIcon(
				'unal_news-plugin-vistasrest',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:unal_news/Resources/Public/Icons/user_plugin_vistasrest.svg']
			);
		
			$iconRegistry->registerIcon(
				'unal_news-plugin-visitorcounter',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:unal_news/Resources/Public/Icons/user_plugin_visitorcounter.svg']
			);
		
    }
);
