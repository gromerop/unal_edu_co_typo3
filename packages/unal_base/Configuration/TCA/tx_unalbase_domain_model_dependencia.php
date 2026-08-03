<?php
return [
    'ctrl' => [
        'title'	=> 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia',
        'label' => 'nombre',
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
		'searchFields' => 'nombre,id_superior,email,ocultar_en_papeleria,direccion,edificio_piso,ciudad,telefono,codigo,acto_admin,excepcion,poner_nombre_en_encabezado,txt_jerarquia,ocultar',
        'iconfile' => 'EXT:unal_base/Resources/Public/Icons/tx_unalbase_domain_model_dependencia.gif'
    ],
    'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, nombre, id_superior, email, ocultar_en_papeleria, direccion, edificio_piso, ciudad, telefono, codigo, acto_admin, excepcion, poner_nombre_en_encabezado, txt_jerarquia, ocultar',
    ],
    'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, nombre, id_superior, email, ocultar_en_papeleria, direccion, edificio_piso, ciudad, telefono, codigo, acto_admin, excepcion, poner_nombre_en_encabezado, txt_jerarquia, ocultar, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_unalbase_domain_model_dependencia',
                'foreign_table_where' => 'AND tx_unalbase_domain_model_dependencia.pid=###CURRENT_PID### AND tx_unalbase_domain_model_dependencia.sys_language_uid IN (-1,0)',
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
        'nombre' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.nombre',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'id_superior' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.id_superior',
	        'config' => [
			    'type' => 'input',
			    'size' => 4,
			    'eval' => 'int'
			]
	    ],
	    'email' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.email',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ocultar_en_papeleria' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.ocultar_en_papeleria',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'direccion' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.direccion',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'edificio_piso' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.edificio_piso',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'ciudad' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.ciudad',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'telefono' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.telefono',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'codigo' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.codigo',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'acto_admin' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.acto_admin',
	        'config' => [
			    'type' => 'input',
			    'size' => 30,
			    'eval' => 'trim'
			],
	    ],
	    'excepcion' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.excepcion',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'poner_nombre_en_encabezado' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.poner_nombre_en_encabezado',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
	    'txt_jerarquia' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.txt_jerarquia',
	        'config' => [
			    'type' => 'text',
			    'cols' => 40,
			    'rows' => 15,
			    'eval' => 'trim'
			]
	    ],
	    'ocultar' => [
	        'exclude' => true,
	        'label' => 'LLL:EXT:unal_base/Resources/Private/Language/locallang_db.xlf:tx_unalbase_domain_model_dependencia.ocultar',
	        'config' => [
			    'type' => 'check',
			    'items' => [
			        '1' => [
			            '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
			        ]
			    ],
			    'default' => 0
			]
	    ],
    ],
];
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder