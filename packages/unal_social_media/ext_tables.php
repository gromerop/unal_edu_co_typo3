<?php
defined('TYPO3_MODE') || die();
call_user_func(static function() {
    $extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase('unal_social_media');
    $pluginSignature = strtolower($extensionName) . '_unsmd';
    $TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:unal_social_media/Configuration/FlexForms/flexform_fe.xml');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalsocialmedia_domain_model_sede', 'EXT:unal_social_media/Resources/Private/Language/locallang_csh_tx_unalsocialmedia_domain_model_sede.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalsocialmedia_domain_model_sede');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalsocialmedia_domain_model_facultad', 'EXT:unal_social_media/Resources/Private/Language/locallang_csh_tx_unalsocialmedia_domain_model_facultad.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalsocialmedia_domain_model_facultad');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalsocialmedia_domain_model_dependencia', 'EXT:unal_social_media/Resources/Private/Language/locallang_csh_tx_unalsocialmedia_domain_model_dependencia.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalsocialmedia_domain_model_dependencia');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalsocialmedia_domain_model_cuenta', 'EXT:unal_social_media/Resources/Private/Language/locallang_csh_tx_unalsocialmedia_domain_model_cuenta.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalsocialmedia_domain_model_cuenta');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalsocialmedia_domain_model_medio', 'EXT:unal_social_media/Resources/Private/Language/locallang_csh_tx_unalsocialmedia_domain_model_medio.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalsocialmedia_domain_model_medio');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalsocialmedia_domain_model_responsable', 'EXT:unal_social_media/Resources/Private/Language/locallang_csh_tx_unalsocialmedia_domain_model_responsable.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalsocialmedia_domain_model_responsable');
});
