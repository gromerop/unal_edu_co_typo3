<?php
defined('TYPO3_MODE') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'UnalSocialMedia',
    'Unsmd',
    'UNAL Social Media Directory'
);

/**
 * Include Flexform
 */
// Unsmd
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['unalsocialmedia_unsmd'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    'unalsocialmedia_unsmd',
    'FILE:EXT:unal_social_media/Configuration/FlexForms/flexform_fe.xml'
);


