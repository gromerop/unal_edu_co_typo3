<?php
defined('TYPO3') || die();

/***************
 * Add default RTE configuration
 */
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['unal_skin_unal'] = 'EXT:unal_skin_unal/Configuration/RTE/Default.yaml';
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['default'] = 'EXT:unal_skin_unal/Configuration/RTE/Default.yaml';

$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:news/Resources/Private/Language/locallang.xlf'][] = 'EXT:unal_skin_unal/Resources/Private/Language/news/locallang.xlf';

/***************
 * PageTS
 */
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:unal_skin_unal/Configuration/TsConfig/Page/All.tsconfig">');

