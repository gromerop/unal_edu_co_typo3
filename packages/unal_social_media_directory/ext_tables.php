<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
$_EXTKEY = "unal_social_media_directory";
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Unsmd',
	'UNAL Social Media Directory'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'UNAL Social Media Directory');

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_unsmd';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/flexform_fe.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalsocialmediadirectory_domain_model_sede', 'EXT:unal_social_media_directory/Resources/Private/Language/locallang_csh_tx_unalsocialmediadirectory_domain_model_sede.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalsocialmediadirectory_domain_model_sede');
$TCA['tx_unalsocialmediadirectory_domain_model_sede'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_sede',
		'label' => 'nombre',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',

		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'nombre,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Sede.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/Public/Icons/tx_unalsocialmediadirectory_domain_model_sede.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalsocialmediadirectory_domain_model_facultad', 'EXT:unal_social_media_directory/Resources/Private/Language/locallang_csh_tx_unalsocialmediadirectory_domain_model_facultad.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalsocialmediadirectory_domain_model_facultad');
$TCA['tx_unalsocialmediadirectory_domain_model_facultad'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_facultad',
		'label' => 'nombre',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',

		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'nombre,sede,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Facultad.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/Public/Icons/tx_unalsocialmediadirectory_domain_model_facultad.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalsocialmediadirectory_domain_model_medio', 'EXT:unal_social_media_directory/Resources/Private/Language/locallang_csh_tx_unalsocialmediadirectory_domain_model_medio.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalsocialmediadirectory_domain_model_medio');
$TCA['tx_unalsocialmediadirectory_domain_model_medio'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_medio',
		'label' => 'nombre',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',

		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'nombre,icono,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Medio.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/Public/Icons/tx_unalsocialmediadirectory_domain_model_medio.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalsocialmediadirectory_domain_model_responsable', 'EXT:unal_social_media_directory/Resources/Private/Language/locallang_csh_tx_unalsocialmediadirectory_domain_model_responsable.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalsocialmediadirectory_domain_model_responsable');
$TCA['tx_unalsocialmediadirectory_domain_model_responsable'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_responsable',
		'label' => 'nombre',
		'label_alt' => 'apellidos',
		'label_alt_force'=>true,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'nombre,apellidos,telefono,extension,email1,email2,celular,cargo,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Responsable.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/Public/Icons/tx_unalsocialmediadirectory_domain_model_responsable.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalsocialmediadirectory_domain_model_dependencia', 'EXT:unal_social_media_directory/Resources/Private/Language/locallang_csh_tx_unalsocialmediadirectory_domain_model_dependencia.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalsocialmediadirectory_domain_model_dependencia');
$TCA['tx_unalsocialmediadirectory_domain_model_dependencia'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_dependencia',
		'label' => 'nombre',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',

		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'nombre,descripcion,facultad,cuentas,sede,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Dependencia.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/Public/Icons/tx_unalsocialmediadirectory_domain_model_dependencia.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_unalsocialmediadirectory_domain_model_cuenta', 'EXT:unal_social_media_directory/Resources/Private/Language/locallang_csh_tx_unalsocialmediadirectory_domain_model_cuenta.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_unalsocialmediadirectory_domain_model_cuenta');
$TCA['tx_unalsocialmediadirectory_domain_model_cuenta'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:unal_social_media_directory/Resources/Private/Language/locallang_db.xlf:tx_unalsocialmediadirectory_domain_model_cuenta',
		'label' => 'nombre_cuenta',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',

		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'nombre_cuenta,tipo,url,medios,responsable,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Cuenta.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Resources/Public/Icons/tx_unalsocialmediadirectory_domain_model_cuenta.gif'
	),
);

?>
