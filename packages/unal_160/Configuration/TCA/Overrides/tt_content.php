<?php
 defined('TYPO3') or die();
 \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem('tt_content', 'CType', ['label' => 'Año 160: meses temáticos', 'value' => 'unal160_year', 'icon' => 'content-carousel']);
 $GLOBALS['TCA']['tt_content']['types']['unal160_year'] = [
 'showitem'=>'--div--;General,--palette--;;general,header,--div--;Acceso,--palette--;;hidden,--palette--;;access'
 ];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem('tt_content', 'CType', ['label' => 'UNAL 160: carrusel de fotografías', 'value' => 'unal160_images', 'icon' => 'content-image']);
$GLOBALS['TCA']['tt_content']['types']['unal160_images'] = [
    'showitem'=>'--div--;General,--palette--;;general,header,image,--div--;Acceso,--palette--;;hidden,--palette--;;access'
];

// Mantener seleccionable el diseño usado por el carrusel anterior.
$hasCarouselLayout = false;
foreach ($GLOBALS['TCA']['tt_content']['columns']['layout']['config']['items'] ?? [] as $item) {
    if ((string)($item['value'] ?? $item[1] ?? '') === '16001') { $hasCarouselLayout = true; break; }
}
if (!$hasCarouselLayout) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'tt_content', 'layout', ['label' => 'UNAL 160: carrusel de fotografías', 'value' => 16001]
    );
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem('tt_content', 'CType', ['label' => 'UNAL 160: Historias que inspiran', 'value' => 'unal160_stories', 'icon' => 'content-carousel']);
$GLOBALS['TCA']['tt_content']['types']['unal160_stories'] = ['showitem'=>'--div--;General,--palette--;;general,header,pi_flexform,--div--;Acceso,--palette--;;hidden,--palette--;;access'];
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('*', 'FILE:EXT:unal_160/Configuration/FlexForms/Stories.xml', 'unal160_stories');
