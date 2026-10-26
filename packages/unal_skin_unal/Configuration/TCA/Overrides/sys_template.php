<?php
defined('TYPO3') || die();

call_user_func(function()
{
    /**
     * Temporary variables
     */
    $extensionKey = 'unal_skin_unal';

    /**
     * Default TypoScript for UnalSkinUnal
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'Unal skin unal'
    );
});
