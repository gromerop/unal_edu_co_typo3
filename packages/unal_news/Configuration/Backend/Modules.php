<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

return [
    'unalnewsreporter' => [
        'parent' => 'web',
        'position' => ['after' => 'web_info'],
        'access' => 'user,group',
        'workspaces' => 'live',
        'iconIdentifier' => 'unal_news-module-unalnewsreporter',
        'labels' => 'LLL:EXT:unal_news/Resources/Private/Language/locallang_unalnewsreporter.xlf',
        'extensionName' => 'UnalNews',
        'controllerActions' => [
            \UNAL\UnalNews\Controller\VisitCounterController::class => [
                'selectorReport',
                'generateReport',
            ],
        ],
    ],
];