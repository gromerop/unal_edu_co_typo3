<?php
$extKey = 'unal_base';
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'UNAL.UnalBase',
            'Arboldependencias',
            'Árbol de dependencias'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'UNAL.UnalBase',
            'Busquedadependencias',
            'Búsqueda de dependencias'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'UNAL.UnalBase',
            'Solicituddependencias',
            'Solicitud de dependencias'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'UNAL.UnalBase',
            'Busquedadependenciasporid',
            'Búsqueda de dependencias por Id'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($extKey, 'Configuration/TypoScript', 'Extensión base - Universidad Nacional de Colombia');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalbase_domain_model_dependencia', 'EXT:unal_base/Resources/Private/Language/locallang_csh_tx_unalbase_domain_model_dependencia.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalbase_domain_model_dependencia');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalbase_domain_model_oficina', 'EXT:unal_base/Resources/Private/Language/locallang_csh_tx_unalbase_domain_model_oficina.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalbase_domain_model_oficina');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalbase_domain_model_solicituddependencia', 'EXT:unal_base/Resources/Private/Language/locallang_csh_tx_unalbase_domain_model_solicituddependencia.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalbase_domain_model_solicituddependencia');

    },
    'unal_base'
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
