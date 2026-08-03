<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
$_EXTKEY = "unal_social_media_directory";
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'UNAL.' . $_EXTKEY,
	'Unsmd',
	array(
		'Medio' => 'search, list',
		'Dependencia' => 'list,new,create,confirm,default',
		'Eid'=>'facultades',
	),
	// non-cacheable actions
	array(
		'Dependencia' => 'new,create',
	)
);

$TYPO3_CONF_VARS['FE']['eID_include']['unsmd'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('unal_social_media_directory').'Classes/Controller/EidController.php';


?>
