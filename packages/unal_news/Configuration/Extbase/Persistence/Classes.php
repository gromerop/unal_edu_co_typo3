<?php
declare(strict_types = 1);

return [
    \GeorgRinger\News\Domain\Model\News::class => [
        'subclasses' => [
            'Tx_UnalNews_UnalNews' => UNAL\UnalNews\Domain\Model\UnalNews::class
        ]
    ],
    UNAL\UnalNews\Domain\Model\UnalNews::class => [
        'tableName' => 'tx_news_domain_model_news',
        'recordType' => 'Tx_UnalNews_UnalNews',
    ],
];

  
  
  