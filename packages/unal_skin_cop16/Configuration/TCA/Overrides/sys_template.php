<?php
defined('TYPO3') or die();

call_user_func(function()
{
   $extensionKey = 'unal_skin_cop16';

   /**
    * Default TypoScript
    */
   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
      $extensionKey,
      'Configuration/TypoScript',
      'UNAL - COP16'
   );
});
