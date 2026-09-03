<?php
defined('TYPO3') || die();

call_user_func(static function() {

    // --- Registro de tablas de dominio ---
    $tables = [
        'tx_unalsocialmedia_domain_model_sede',
        'tx_unalsocialmedia_domain_model_facultad',
        'tx_unalsocialmedia_domain_model_dependencia',
        'tx_unalsocialmedia_domain_model_cuenta',
        'tx_unalsocialmedia_domain_model_medio',
        'tx_unalsocialmedia_domain_model_responsable',
    ];

    foreach ($tables as $table) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            $table,
            'EXT:unal_social_media/Resources/Private/Language/locallang_csh_' . $table . '.xlf'
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages($table);
    }
});
