<?php
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
        new \B13\Container\Tca\ContainerConfiguration(
            'b13-2cols-with-header-container', // CType
            '2 Column Container With Header', // label
            'Container with 2 columns and header', // description
            [
                [
                    ['name' => 'header', 'colPos' => 200, 'colspan' => 2, 'allowed' => ['CType' => 'header, textmedia']]
                ],
                [
                    ['name' => 'left side', 'colPos' => 201],
                    ['name' => 'right side', 'colPos' => 202]
                ]
            ] // grid configuration
        )
    )
    // set an optional icon configuration
    ->setIcon('EXT:container/Resources/Public/Icons/container-2col.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
        new \B13\Container\Tca\ContainerConfiguration(
            'b13-3cols', // CType
            '3 Columns', // label
            'Container with 3 columns', // description
            [
                [
                    ['name' => 'first column', 'colPos' => 201],
                    ['name' => 'second column', 'colPos' => 202],
                    ['name' => 'third column', 'colPos' => 203]
                ]
            ] // grid configuration
        )
    )
    // set an optional icon configuration
    ->setIcon('EXT:unal_skin_unal/Resources/Public/Icons/container-3col.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
        new \B13\Container\Tca\ContainerConfiguration(
            'b13-4cols', // CType
            '4 Columns', // label
            'Container with 4 columns', // description
            [
                [
                    ['name' => 'first column', 'colPos' => 201],
                    ['name' => 'second column', 'colPos' => 202],
                    ['name' => 'third column', 'colPos' => 203],
                    ['name' => 'fourth column', 'colPos' => 204]
                ]
            ] // grid configuration
        )
    )
    // set an optional icon configuration
    ->setIcon('EXT:container/Resources/Public/Icons/container-4col.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
        new \B13\Container\Tca\ContainerConfiguration(
            'b13-5cols', // CType
            '5 Columns', // label
            'Container with 5 columns', // description
            [
                [
                    ['name' => 'first column', 'colPos' => 201],
                    ['name' => 'second column', 'colPos' => 202],
                    ['name' => 'third column', 'colPos' => 203],
                    ['name' => 'fourth column', 'colPos' => 204],
                    ['name' => 'fifth column', 'colPos' => 205]
                ]
            ] // grid configuration
        )
    )
    // set an optional icon configuration
    ->setIcon('EXT:container/Resources/Public/Icons/container-5col.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
        new \B13\Container\Tca\ContainerConfiguration(
            'b13-6cols', // CType
            '6 Columns', // label
            'Container with 6 columns', // description
            [
                [
                    ['name' => 'first column', 'colPos' => 201],
                    ['name' => 'second column', 'colPos' => 202],
                    ['name' => 'third column', 'colPos' => 203],
                    ['name' => 'fourth column', 'colPos' => 204],
                    ['name' => 'fifth column', 'colPos' => 205],
                    ['name' => 'sixth column', 'colPos' => 206]
                ]
            ] // grid configuration
        )
    )
    // set an optional icon configuration
    ->setIcon('EXT:container/Resources/Public/Icons/container-6col.svg')
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\B13\Container\Tca\Registry::class)->configureContainer(
    (
        new \B13\Container\Tca\ContainerConfiguration(
            'b13-7cols', // CType
            '7 Columns', // label
            'Container with 7 columns', // description
            [
                [
                    ['name' => 'first column', 'colPos' => 201],
                    ['name' => 'second column', 'colPos' => 202],
                    ['name' => 'third column', 'colPos' => 203],
                    ['name' => 'fourth column', 'colPos' => 204],
                    ['name' => 'fifth column', 'colPos' => 205],
                    ['name' => 'sixth column', 'colPos' => 206],
                    ['name' => 'seventh column', 'colPos' => 207]
                ]
            ] // grid configuration
        )
    )
    // set an optional icon configuration
    ->setIcon('EXT:unal_skin_unal/Resources/Public/Icons/container-7col.svg')
);