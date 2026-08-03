<?php

/**
 * Extension Manager/Repository config file for ext "unal_skin_unal".
 */
$EM_CONF[$_EXTKEY] = [
    'title' => 'UNAL - Plantilla para el sitio principal',
    'description' => 'Plantilla para el sitio principal de la Universidad Nacional de Colombia.',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'typo3' => '10.2.0-10.4.99',
            'fluid_styled_content' => '10.2.0-10.4.99',
            'rte_ckeditor' => '10.2.0-10.4.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Unal\\UnalSkinUnal\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Andrea Daza',
    'author_email' => 'adazav@unal.edu.co',
    'author_company' => 'UNAL',
    'version' => '1.0.0',
];
