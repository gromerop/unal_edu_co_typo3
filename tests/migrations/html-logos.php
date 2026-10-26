<?php

declare(strict_types=1);

require dirname(__DIR__, 2) . '/vendor/autoload.php';
require_once dirname(__DIR__, 2) . '/packages/unal_skin_unal/Classes/Updates/HtmlLogoResourcesMigration.php';

$reflection = new ReflectionClass(UNAL\UnalSkinUnal\Updates\HtmlLogoResourcesMigration::class);
$wizard = $reflection->newInstanceWithoutConstructor();
$transform = $reflection->getMethod('migrateHtml');
$urls = [];
foreach (['rectoria', 'agencia-unal', 'periodico-unal', 'circular-unal'] as $name) {
    $file = 'logo-' . $name . '.svg';
    $urls[$file] = '/_assets/' . str_repeat('a', 32) . '/Images/' . $file;
}

$cases = [];
foreach ($urls as $file => $destination) {
    foreach (["'", '"'] as $quote) {
        $prefix = '<img class="img-fluid" alt="UNAL" src=' . $quote;
        $suffix = $quote . ' width="100">';
        $cases[] = [$prefix . '/typo3conf/ext/unal_skin_unal/Resources/Public/Images/' . $file . $suffix,
            $prefix . $destination . $suffix];
        $cases[] = [$prefix . '/_assets/' . str_repeat('b', 32) . '/Images/' . $file . $suffix,
            $prefix . $destination . $suffix];
    }
}
foreach ([
    '<a href="/typo3conf/ext/unal_skin_unal/Resources/Public/Images/logo-rectoria.svg">Enlace</a>',
    '<img src="/archivos/logo-rectoria.svg">',
    '<img src="/typo3conf/ext/otra/Resources/Public/Images/logo-rectoria.svg">',
    '<img src="/typo3conf/ext/unal_skin_unal/Resources/Public/Images/otra.svg">',
] as $unchanged) {
    $cases[] = [$unchanged, $unchanged];
}

foreach ($cases as $index => [$input, $expected]) {
    $actual = $transform->invoke($wizard, $input, $urls);
    if ($actual !== $expected) {
        throw new RuntimeException('Unexpected HTML transformation in case ' . $index);
    }
    if ($transform->invoke($wizard, $actual, $urls) !== $actual) {
        throw new RuntimeException('Migration is not idempotent in case ' . $index);
    }
}
printf("OK: %d transformations and idempotence checks; no database accessed.\n", count($cases));
