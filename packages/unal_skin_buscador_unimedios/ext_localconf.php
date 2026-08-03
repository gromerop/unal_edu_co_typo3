<?php
defined('TYPO3_MODE') or die();

$boot = function () {

    //Hooks
    // 'New', 'Update' and 'Delete' data handler for news records
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass']['unal_skin_buscador_unimedios'] =
        \UNAL\UnalSkinBuscadorUnimedios\Hooks\DataHandler::class;
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['unal_skin_buscador_unimedios'] =
        \UNAL\UnalSkinBuscadorUnimedios\Hooks\DataHandler::class;

};

$boot();
unset($boot);