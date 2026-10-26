<?php
defined('TYPO3') || die();

if (!isset($GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['type'])) {
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    $GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumnstx_unalnews_tx_news_domain_model_news = [];
    $tempColumnstx_unalnews_tx_news_domain_model_news[$GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['type']] = [
        'exclude' => true,
        'label'   => 'LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_unalnews.tx_extbase_type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['',''],
                ['UnalNews','Tx_UnalNews_UnalNews']
            ],
            'default' => 'Tx_UnalNews_UnalNews',
            'size' => 1,
            'maxitems' => 1,
        ]
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news', $tempColumnstx_unalnews_tx_news_domain_model_news);
}

// \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
//     'tx_news_domain_model_news',
//     $GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['type'],
//     '',
//     'after:' . $GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['label']
// );

$tmp_unal_news_columns = [

    'identificator' => [
        'exclude' => true,
        'label' => 'LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_unalnews_domain_model_unalnews.identificator',
        'config' => [
            'type' => 'input',
            'size' => 30,
            'eval' => 'trim'
        ],
    ],

    'counter' => [
        'exclude' => true,
        'label' => 'LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_unalnews_domain_model_unalnews.counter',
        'config' => [
            'type' => 'input',
            'size' => 4,
            'eval' => 'int',
            'readOnly' =>1
        ]
    ],

    'city' => [
        'exclude' => true,
        'label' => 'LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_unalnews_domain_model_unalnews.city',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => array(
                array('- City -', 0),
            ),
            'foreign_table' => 'tx_unalnews_domain_model_city',
            'default' => 0,
            'minitems' => 0,
            'maxitems' => 1,
        ],
        
    ],
    
    'visitor_counter' => [
        'exclude' => true,
        'label' => 'LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_unalnews_domain_model_unalnews.visitor_counter',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_unalnews_domain_model_visitcounter',
            'foreign_field' => 'unalnews',
            'maxitems' => 9999,
            'appearance' => [
                'collapseAll' => 1,
                'levelLinksPosition' => 'top',
                'showSynchronizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ],
        ],

    ],


];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news',$tmp_unal_news_columns);

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['tx_news_domain_model_news']['types']['0']['showitem'])) {
    $GLOBALS['TCA']['tx_news_domain_model_news']['types']['Tx_UnalNews_UnalNews']['showitem'] = $GLOBALS['TCA']['tx_news_domain_model_news']['types']['0']['showitem'];
} elseif(is_array($GLOBALS['TCA']['tx_news_domain_model_news']['types'])) {
    // use first entry in types array
    $tx_news_domain_model_news_type_definition = reset($GLOBALS['TCA']['tx_news_domain_model_news']['types']);
    $GLOBALS['TCA']['tx_news_domain_model_news']['types']['Tx_UnalNews_UnalNews']['showitem'] = $tx_news_domain_model_news_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['tx_news_domain_model_news']['types']['Tx_UnalNews_UnalNews']['showitem'] = '';
}
$GLOBALS['TCA']['tx_news_domain_model_news']['types']['Tx_UnalNews_UnalNews']['showitem'] .= ',--div--;LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_unalnews_domain_model_unalnews,';
$GLOBALS['TCA']['tx_news_domain_model_news']['types']['Tx_UnalNews_UnalNews']['showitem'] .= 'identificator, counter, city, visitor_counter';

$GLOBALS['TCA']['tx_news_domain_model_news']['columns'][$GLOBALS['TCA']['tx_news_domain_model_news']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:unal_news/Resources/Private/Language/locallang_db.xlf:tx_news_domain_model_news.tx_extbase_type.Tx_UnalNews_UnalNews','Tx_UnalNews_UnalNews'];
