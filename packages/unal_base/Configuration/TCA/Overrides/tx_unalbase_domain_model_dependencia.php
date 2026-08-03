<?php
defined('TYPO3_MODE') or die();

// Se modifica la configuración de la dependencia superior
$GLOBALS['TCA']['tx_unalbase_domain_model_dependencia']['columns']['id_superior']['config'] = [
	'type' => 'select',
	'foreign_table' => 'tx_unalbase_domain_model_dependencia',
	'foreign_table_where' => ' ORDER BY nombre ASC',
	'renderType' => 'selectTree',
	'size' => 10,
	'items' => array(
		array('--- Nodo raíz ---', 0, 'EXT:unal_base/Resources/Public/Icons/tx_unalbase_domain_model_dependencia.gif')
	),
	'treeConfig' => array(
		'expandAll' => true,
		'parentField' => 'id_superior',
		'rootUid' => 0,
		'appearance' => array(
			'width' => 500,
			'nonSelectableLevels' => "0"
		)
	),
	'minitems' => 1,
	'maxitems' => 1
];