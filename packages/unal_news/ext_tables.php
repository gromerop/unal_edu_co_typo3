<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'UnalNews',
        'Vistasrest',
        'UNAL News vistas rest'
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'UnalNews',
        'Visitorcounter',
        'Adicionar visita'
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('unal_news', 'Configuration/TypoScript', 'UNAL News extension');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalnews_domain_model_visitcounter', 'EXT:unal_news/Resources/Private/Language/locallang_csh_tx_unalnews_domain_model_visitcounter.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalnews_domain_model_visitcounter');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalnews_domain_model_city', 'EXT:unal_news/Resources/Private/Language/locallang_csh_tx_unalnews_domain_model_city.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalnews_domain_model_city');
})();
