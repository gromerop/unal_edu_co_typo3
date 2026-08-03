<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:unal_social_media/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmedia_domain_model_dependencia',
        'label' => 'nombre',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'nombre',
        'iconfile' => 'EXT:unal_social_media/Resources/Public/Icons/tx_unalsocialmedia_domain_model_dependencia.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, nombre, facultad, cuentas, sede, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_unalsocialmedia_domain_model_dependencia',
                'foreign_table_where' => 'AND {#tx_unalsocialmedia_domain_model_dependencia}.{#pid}=###CURRENT_PID### AND {#tx_unalsocialmedia_domain_model_dependencia}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'nombre' => [
            'exclude' => true,
            'label' => 'LLL:EXT:unal_social_media/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmedia_domain_model_dependencia.nombre',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'facultad' => [
            'exclude' => true,
            'label' => 'LLL:EXT:unal_social_media/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmedia_domain_model_dependencia.facultad',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_unalsocialmedia_domain_model_facultad',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],
            
        ],
        'cuentas' => [
            'exclude' => true,
            'label' => 'LLL:EXT:unal_social_media/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmedia_domain_model_dependencia.cuentas',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_unalsocialmedia_domain_model_cuenta',
                'foreign_field' => 'dependencia',
                'maxitems' => 9999,
                'appearance' => [
                    'collapseAll' => 0,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],

        ],
        'sede' => [
            'exclude' => true,
            'label' => 'LLL:EXT:unal_social_media/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmedia_domain_model_dependencia.sede',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_unalsocialmedia_domain_model_sede',
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
            ],
            
        ],
    
    ],
];
