<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'UNAL 160: meses temáticos',
    'description' => 'Pestañas y carruseles de noticias',
    'category' => 'fe',
    'state' => 'stable',
    'author' => 'UNAL',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'news' => '13.0.0-13.99.99',
            'fluid_styled_content' => '13.4.0-13.4.99',
        ],
    ],
];
