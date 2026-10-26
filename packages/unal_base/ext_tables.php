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

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalbase_domain_model_dependencia', 'EXT:unal_base/Resources/Private/Language/locallang_csh_tx_unalbase_domain_model_dependencia.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalbase_domain_model_dependencia');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalbase_domain_model_oficina', 'EXT:unal_base/Resources/Private/Language/locallang_csh_tx_unalbase_domain_model_oficina.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalbase_domain_model_oficina');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalbase_domain_model_solicituddependencia', 'EXT:unal_base/Resources/Private/Language/locallang_csh_tx_unalbase_domain_model_solicituddependencia.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalbase_domain_model_solicituddependencia');
})();