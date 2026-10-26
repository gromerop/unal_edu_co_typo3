<?php
defined('TYPO3') || die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'UnalSocialMedia',
    'Filter',
    'Filtro para búsqueda de dependencias y redes sociales'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'UnalSocialMedia',
    'List',
    'Listado de dependencias y redes sociales'
);