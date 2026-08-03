<?php
defined('TYPO3_MODE') || die();

call_user_func(
    function()
    {
        /**
         * Plugin
         */
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'UNAL.UnalConvergenceModule',
            'Content',
            'Modulo de convergencia',
            'EXT:unal_convergence_module/Resources/Public/Icons/Extension_icon.svg'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('unal_convergence_module', 'Configuration/TypoScript', 'Modulo de convergencia');


        /** 
         * Module
         */
        if (TYPO3_MODE === 'BE') {
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'UNAL.UnalConvergenceModule',
                'web',               // Main area
                'unalcvgtplbuilder', // Name of the module
                '',                  // Position of the module
                array(               // Allowed controller action combinations
                    'Content' => 'templateBuilder, templateContentBuilder, createTemplate, createContentTemplate, saveTemplate, updateTemplate, editTemplate, editContentTemplate, deleteTemplate, duplicateTemplate',
                ),
                array(          // Additional configuration
                    'access'    => 'user,group',
                    'icon'      => 'EXT:unal_convergence_module/Resources/Public/Icons/Extension_icon.svg',
                    'labels'    => 'LLL:EXT:unal_convergence_module/Resources/Private/Language/locallang_mod.xlf',
                )
            );
        }

    }
);