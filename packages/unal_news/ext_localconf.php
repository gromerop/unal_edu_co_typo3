<?php

defined('TYPO3') || die();

(static function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'UnalNews',
            'Vistasrest',
            [
                \UNAL\UnalNews\Controller\UnalNewsController::class => 'listRest, searchRest, showRest, mostViewed, allRest, deletedRest, editedRest, autocompleteRest'
            ],
            // non-cacheable actions
            [
                \UNAL\UnalNews\Controller\UnalNewsController::class => '',
                \UNAL\UnalNews\Controller\VisitCounterController::class => 'update'
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
    $iconRegistry->registerIcon(
            'unal_news-module-unalnewsreporter',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:unal_news/Resources/Public/Icons/user_mod_unalnewsreporter.svg']
    );
})();
