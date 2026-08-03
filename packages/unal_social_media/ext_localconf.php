<?php
defined('TYPO3_MODE') || die();

call_user_func(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'UnalSocialMedia',
        'Unsmd',
        [
            \Unal\UnalSocialMedia\Controller\MedioController::class => 'search, list',
            \Unal\UnalSocialMedia\Controller\DependenciaController::class => 'list'
        ],
        // non-cacheable actions
        [
            \Unal\UnalSocialMedia\Controller\DependenciaController::class => '',
            \Unal\UnalSocialMedia\Controller\CuentaController::class => '',
            \Unal\UnalSocialMedia\Controller\MedioController::class => '',
            \Unal\UnalSocialMedia\Controller\ResponsableController::class => ''
        ]
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    unsmd {
                        iconIdentifier = unal_social_media-plugin-unsmd
                        title = LLL:EXT:unal_social_media/Resources/Private/Language/locallang_db.xlf:tx_unal_social_media_unsmd.name
                        description = LLL:EXT:unal_social_media/Resources/Private/Language/locallang_db.xlf:tx_unal_social_media_unsmd.description
                        tt_content_defValues {
                            CType = list
                            list_type = unalsocialmedia_unsmd
                        }
                    }
                }
                show = *
            }
       }'
    );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'unal_social_media-plugin-unsmd',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:unal_social_media/Resources/Public/Icons/user_plugin_unsmd.svg']
    );
});
