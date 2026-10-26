<?php
defined('TYPO3') || die();

call_user_func(
    function()
    {

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('unal_skin_buscador_unimedios', 'Configuration/TypoScript', 'Buscador Unimedios');

    }
);
