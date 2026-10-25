<?php
defined('TYPO3') or die();
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '@import "EXT:unal_160/Configuration/PageTSconfig/NewContentElement.tsconfig"'
);

$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['unal160_circular'] = [
    'frontend' => \TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class,
    'backend' => \TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class,
    'groups' => ['pages'],
];
