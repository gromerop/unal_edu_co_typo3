<?php

/**
 * Extension Manager/Repository config file for ext "unal_convergence_module".
 */
$EM_CONF[$_EXTKEY] = [
    'title' => 'UNAL Convergence Module',
    'description' => 'Es el modulo de convergencia para mostrar todos los contenidos de los productos de Unimedios que convergen en el Buscador',
    'category' => 'extension',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99'
        ],
        'conflicts' => [],
    ],
    'autoload' => [
        'psr-4' => [
            'UNAL\\UnalConvergenceModule\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Fernando Noguera',
    'author_email' => 'jnoguerab@unal.edu.co',
    'author_company' => 'Universidad Nacional de Colombia',
    'version' => '1.0.0',
];
