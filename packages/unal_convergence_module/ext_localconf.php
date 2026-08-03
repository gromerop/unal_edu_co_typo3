<?php
defined('TYPO3_MODE') || die();

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'UNAL.UnalConvergenceModule',
            'Content',
            array(
                'Content' => 'list',
            ),
            array()
        );

        /***************
        * Hooks
        */

        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem'][] =
        \UNAL\UnalConvergenceModule\Hooks\PreviewRenderer::class;

        
        /***************
         * PageTS / wizards
         */
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:unal_convergence_module/Configuration/TsConfig/Page/All.tsconfig">');


        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        $iconRegistry->registerIcon(
            'unal_convergence_module-plugin-content',
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:unal_convergence_module/Resources/Public/Icons/Extension_icon.svg']
        );

    }
);