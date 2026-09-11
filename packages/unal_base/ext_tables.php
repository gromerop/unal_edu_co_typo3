<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'UnalBase',
        'Arboldependencias',
        'Árbol de dependencias'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'UnalBase',
        'Busquedadependencias',
        'Búsqueda de dependencias'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'UnalBase',
        'Solicituddependencias',
        'Solicitud de dependencias'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'UnalBase',
        'Busquedadependenciasporid',
        'Búsqueda de dependencias por Id'
    );
    
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('unal_base', 'Configuration/TypoScript', 'Extensión base - Universidad Nacional de Colombia');

})();
