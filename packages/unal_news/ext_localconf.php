<?php

defined('TYPO3') || die();

(static function () {
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

    $iconRegistry->registerIcon(
            'unal_news-module-unalnewsreporter',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:unal_news/Resources/Public/Icons/user_mod_unalnewsreporter.svg']
    );
})();
