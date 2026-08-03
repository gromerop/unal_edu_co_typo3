<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_unalsocialmediadirectory_domain_model_dependencia'] = array(
	'ctrl' => $TCA['tx_unalsocialmediadirectory_domain_model_dependencia']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'nombre, descripcion, sede, facultad, cuentas, otras_cuentas',
	),
	'types' => array(
		'1' => array('showitem' => 'nombre, descripcion, sede, facultad, cuentas, otras_cuentas,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_unalsocialmediadirectory_domain_model_dependencia',
				'foreign_table_where' => 'AND tx_unalsocialmediadirectory_domain_model_dependencia.pid=###CURRENT_PID### AND tx_unalsocialmediadirectory_domain_model_dependencia.sys_language_uid IN (-1,0)',
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
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_dependencia.nombre',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'descripcion' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_dependencia.descripcion',
			'config' => array(
				'type' => 'text',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'facultad' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_dependencia.facultad',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_unalsocialmediadirectory_domain_model_facultad',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'cuentas' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_dependencia.cuentas',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_unalsocialmediadirectory_domain_model_cuenta',
				'foreign_field' => 'dependencia',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'otras_cuentas' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_dependencia.otras_cuentas',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_unalsocialmediadirectory_domain_model_cuenta',
				'foreign_field' => 'dependencia3',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'sede' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_dependencia.sede',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_unalsocialmediadirectory_domain_model_sede',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
	),
);

?>
