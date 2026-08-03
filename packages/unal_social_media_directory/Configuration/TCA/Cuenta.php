<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_unalsocialmediadirectory_domain_model_cuenta'] = array(
	'ctrl' => $TCA['tx_unalsocialmediadirectory_domain_model_cuenta']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, nombre_cuenta, tipo, url, medios, responsable',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, nombre_cuenta, tipo, url, medios, responsable,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_unalsocialmediadirectory_domain_model_cuenta',
				'foreign_table_where' => 'AND tx_unalsocialmediadirectory_domain_model_cuenta.pid=###CURRENT_PID### AND tx_unalsocialmediadirectory_domain_model_cuenta.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'nombre_cuenta' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_cuenta.nombre_cuenta',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'tipo' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_cuenta.tipo',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'url' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_cuenta.url',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'medios' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_cuenta.medios',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_unalsocialmediadirectory_domain_model_medio',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'responsable' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_cuenta.responsable',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_unalsocialmediadirectory_domain_model_responsable',
				'MM' => 'tx_unalsocialmediadirectory_cuenta_responsable_mm',
				'max_size' => 10,
				'size'=>3,
				'maxitems' => 9999,
				'minitems' => 1,
				'multiple' => 0,
				'autoSizeMax' => 30,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					 'suggest' => array(
                                'type' => 'suggest',
                        ),
				),
			),
		),
		'dependencia' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);

?>
