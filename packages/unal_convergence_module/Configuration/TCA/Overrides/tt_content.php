<?php
defined('TYPO3_MODE') or die();

/**
 * Add plugin configuration
 */
$pluginSignature = 'unalconvergencemodule_content';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

// add flexform
TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:unal_convergence_module/Configuration/FlexForms/content.xml'
);
