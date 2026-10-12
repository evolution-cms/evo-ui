<?php
// Locale consistency checks do not bootstrap the CMS or contact external services.
$root = dirname(__DIR__);
$uk = require $root . '/lang/uk/global.php';
foreach (['en', 'de', 'fr', 'pl', 'ru'] as $locale) {
    $dictionary = require $root . '/lang/' . $locale . '/global.php';
    if (array_diff_key($uk, $dictionary) || array_diff_key($dictionary, $uk)) {
        throw new RuntimeException('Dictionary key mismatch: ' . $locale);
    }
    foreach ($uk as $key => $value) {
        if (!is_string($dictionary[$key]) || trim($dictionary[$key]) === '') {
            throw new RuntimeException('Empty translation: ' . $locale . ':' . $key);
        }
        preg_match_all('/:[A-Za-z_][A-Za-z0-9_]*/', $value, $reference);
        preg_match_all('/:[A-Za-z_][A-Za-z0-9_]*/', $dictionary[$key], $translated);
        sort($reference[0]);
        sort($translated[0]);
        if ($reference[0] !== $translated[0]) {
            throw new RuntimeException('Interpolation mismatch: ' . $locale . ':' . $key);
        }
    }
    if ($locale === 'ru' && $dictionary !== $uk) {
        throw new RuntimeException('Russian dictionary must use Ukrainian fallback.');
    }
}
foreach (['en', 'uk', 'de', 'fr', 'pl'] as $locale) {
    $guide = file_get_contents($root . '/docs/' . $locale . '/developer-guide.md');
    foreach (['<x-slot:navigationAside>', 'DescriptionHtml::render($description)', '2048'] as $marker) {
        if (!str_contains($guide, $marker)) {
            throw new RuntimeException('Missing localized API documentation: ' . $locale . ':' . $marker);
        }
    }
}
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root . '/docs/uk', FilesystemIterator::SKIP_DOTS));
foreach ($iterator as $file) {
    if ($file->getExtension() !== 'md') { continue; }
    $relative = substr($file->getPathname(), strlen($root . '/docs/uk/'));
    $fallbackPath = $root . '/docs/ru/' . $relative;
    $fallback = file_get_contents($fallbackPath);
    if (!preg_match('/\]\(([^)]+)\)/', $fallback, $link)
        || realpath(dirname($fallbackPath) . '/' . $link[1]) !== realpath($file->getPathname())) {
        throw new RuntimeException('Invalid Ukrainian documentation fallback: ' . $relative);
    }
}
$readme = file_get_contents($root . '/README.md');
preg_match_all('/\]\(([^)]+)\)/', $readme, $links);
foreach ($links[1] as $link) {
    if (!str_contains($link, '://') && !str_starts_with($link, '#') && !file_exists($root . '/' . $link)) {
        throw new RuntimeException('Broken README link: ' . $link);
    }
}
echo 'Localization consistency passed: six locales, ' . count($uk) . " keys each, documentation and README links\n";
