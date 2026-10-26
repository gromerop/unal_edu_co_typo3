<?php
defined('TYPO3') || die();

call_user_func(function()
{
    /**
     * Temporary variables
     */
    $extensionKey = 'unal_skin_unal';

    /**
     * Default PageTS for UnalSkinUnal
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerPageTSConfigFile(
        $extensionKey,
        'Configuration/TsConfig/Page/All.tsconfig',
        'Unal skin unal'
    );
});
