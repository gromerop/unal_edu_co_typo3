<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('unal_skin_buscador_unimedios', 'Configuration/TypoScript', 'Buscador Unimedios');

    }
);
