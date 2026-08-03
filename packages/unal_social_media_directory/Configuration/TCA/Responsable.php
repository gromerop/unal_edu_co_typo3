<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_unalsocialmediadirectory_domain_model_responsable'] = array(
	'ctrl' => $TCA['tx_unalsocialmediadirectory_domain_model_responsable']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, nombre, apellidos, celular, telefono, extension, email1, email2, cargo',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, nombre, apellidos, telefono, extension, email1, email2, cargo,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_unalsocialmediadirectory_domain_model_responsable',
				'foreign_table_where' => 'AND tx_unalsocialmediadirectory_domain_model_responsable.pid=###CURRENT_PID### AND tx_unalsocialmediadirectory_domain_model_responsable.sys_language_uid IN (-1,0)',
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
		'nombre' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_responsable.nombre',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'apellidos' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_responsable.apellidos',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'telefono' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_responsable.telefono',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'celular' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_responsable.telefono',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'extension' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_responsable.extension',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'email1' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_responsable.email1',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,lower,nospace'
			),
		),
		'email2' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_responsable.email2',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required,lower,nospace'
			),
		),
		'cargo' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_responsable.cargo',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
	),
);

?>
