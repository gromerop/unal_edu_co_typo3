<?php
defined('TYPO3') or die();

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][\TYPO3\CMS\Core\DataHandling\DataHandler::class]['processCmdmapClass'][] =
\UNAL\UnalSkinBuscadorUnimedios\Hooks\DataHandler::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][\TYPO3\CMS\Core\DataHandling\DataHandler::class]['processDatamapClass'][] =
\UNAL\UnalSkinBuscadorUnimedios\Hooks\DataHandler::class;