<?php

defined('TYPO3') || die();

(static function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'UnalSocialMedia',
            'Filter',
            [
                \UNAL\UnalSocialMedia\Controller\MedioController::class => 'search, list',
            ],
            // non-cacheable actions
            [
                \UNAL\UnalSocialMedia\Controller\MedioController::class => 'search, list',
            ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'UnalSocialMedia',
            'List',
            [
                \UNAL\UnalSocialMedia\Controller\DependenciaController::class => 'list'
            ],
            // non-cacheable actions
            [
                \UNAL\UnalSocialMedia\Controller\DependenciaController::class => 'list'
            ]
    );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
            'unal_social_media-plugin-filter',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:unal_social_media/Resources/Public/Icons/user_plugin_filter.svg']
    );
    $iconRegistry->registerIcon(
            'unal_social_media-plugin-list',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:unal_social_media/Resources/Public/Icons/user_plugin_list.svg']
    );
})();
