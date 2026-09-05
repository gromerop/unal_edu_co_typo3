<?php

declare(strict_types=1);

use UNAL\UnalNews\Middleware\NewsApiMiddleware;

return [
    'frontend' => [
        'unal/unal-news/api' => [
            'target' => NewsApiMiddleware::class,
            'after' => [
                'typo3/cms-frontend/authentication',
            ],
            'before' => [
                'typo3/cms-frontend/page-resolver',
            ],
        ],
    ],
];
