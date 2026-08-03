<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_unalnews_domain_model_visitcounter',
        'label' => 'quantity',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'searchFields' => '',
        'iconfile' => 'EXT:unal_news/Resources/Public/Icons/tx_unalnews_domain_model_visitcounter.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, quantity, fecha_registro',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, quantity, fecha_registro'],
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
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_unalnews_domain_model_visitcounter',
                'foreign_table_where' => 'AND {#tx_unalnews_domain_model_visitcounter}.{#pid}=###CURRENT_PID### AND {#tx_unalnews_domain_model_visitcounter}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
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

        'quantity' => [
            'exclude' => true,
            'label' => 'LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_unalnews_domain_model_visitcounter.quantity',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int,required'
            ]
        ],
        'fecha_registro' => [
            'exclude' => true,
            'label' => 'LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_unalnews_domain_model_visitcounter.fecha_registro',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 7,
                'eval' => 'date,required',
                'default' => time()
            ],
        ],
    
        'unalnews' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
    ],
];
