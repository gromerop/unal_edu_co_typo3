<?php
return [
    'ctrl' => [
        'security' => ['ignorePageTypeRestriction' => true],
        'title'	=> 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_solicituddependencia',
        'label' => 'solicitante',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'sortby' => 'sorting',
		'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
		'searchFields' => 'solicitante,nombre_dependencia,id_superior,justificacion,archivo,fecha_respuesta,id_dependencia_creada',
        'iconfile' => 'EXT:unal_base/Resources/Public/Icons/tx_unalbase_domain_model_solicituddependencia.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, solicitante, nombre_dependencia, id_superior, justificacion, archivo, fecha_respuesta, id_dependencia_creada',
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, solicitante, nombre_dependencia, id_superior, justificacion, archivo, fecha_respuesta, id_dependencia_creada, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
		'sys_language_uid' => [
			'exclude' => true,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'special' => 'languages',
				'items' => [
					[
						'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
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
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_unalbase_domain_model_solicituddependencia',
                'foreign_table_where' => 'AND tx_unalbase_domain_model_solicituddependencia.pid=###CURRENT_PID### AND tx_unalbase_domain_model_solicituddependencia.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
		't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
		'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
		'starttime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ]
        ],
        'endtime' => [
            'exclude' => true,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ]
            ],
        ],
        'solicitante' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_solicituddependencia.solicitante',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int,required'
			]
	    ],
	    'nombre_dependencia' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_solicituddependencia.nombre_dependencia',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim,required'
			],
	    ],
	    'id_superior' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_solicituddependencia.id_superior',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int,required'
			]
	    ],
	    'justificacion' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_solicituddependencia.justificacion',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim,required',
			],
	        'defaultExtras' => 'richtext:rte_transform[mode=ts_css]'
	    ],
	    'archivo' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_solicituddependencia.archivo',
	        'config' => [
				'type' => 'file',
				'appearance' => [
					'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:media.addFileReference',
				],
				'maxitems' => 1,
			],
	    ],
	    'fecha_respuesta' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_solicituddependencia.fecha_respuesta',
	        'config' => [
			    'dbType' => 'datetime',
			    'type' => 'input',
			    'size' => 12,
			    'eval' => 'datetime',
			    'default' => '0000-00-00 00:00:00'
			],
	    ],
	    'id_dependencia_creada' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_solicituddependencia.id_dependencia_creada',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int'
			]
	    ],
    ],
];
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
