<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'UNAL.UnalNews',
            'Vistasrest',
            'UNAL News vistas rest'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'UNAL.UnalNews',
            'Visitorcounter',
            'Adicionar visita'
        );

        if (TYPO3_MODE === 'BE') {

            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'UNAL.UnalNews',
                'web', // Make module a submodule of 'web'
                'unalnewsreporter', // Submodule key
                '', // Position
                [
                    'VisitCounter' => 'selectorReport, generateReport',
                    
                ],
                [
                    'access' => 'user,group',
                    'icon'   => 'EXT:unal_news/Resources/Public/Icons/user_mod_unalnewsreporter.svg',
                    'labels' => 'LLL:EXT:unal_news/Resources/Private/Language/locallang_unalnewsreporter.xlf',
                ]
            );

        }

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('unal_news', 'Configuration/TypoScript', 'UNAL News extension');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalnews_domain_model_visitcounter', 'EXT:unal_news/Resources/Private/Language/locallang_csh_tx_unalnews_domain_model_visitcounter.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalnews_domain_model_visitcounter');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalnews_domain_model_city', 'EXT:unal_news/Resources/Private/Language/locallang_csh_tx_unalnews_domain_model_city.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalnews_domain_model_city');

    }
);
