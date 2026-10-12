<?php
// No CMS bootstrap, database or external services.
require_once dirname(__DIR__) . '/src/Support/DescriptionHtml.php';
use EvoUI\Support\DescriptionHtml;
$cases = [
    ['Звичайний текст', 'Звичайний текст'],
    ['<a href="?a=91">Групи</a>', '<a href="?a=91">Групи</a>'],
    ['<strong>Bold</strong><br><em>Italic</em>', '<strong>Bold</strong><br><em>Italic</em>'],
    ['<a href="https://example.test" onclick="alert(1)">Link</a>', '<a href="https://example.test">Link</a>'],
    ['<a href="javascript:alert(1)">Link</a>', 'Link'],
    ['<a href="java&#x09;script:alert(1)">Link</a>', 'Link'],
    ['<a href="data:text/html,test">Link</a>', 'Link'],
    ['<script>alert(1)</script><img src=x onerror=alert(1)>Text', 'Text'],
    ['<svg><script>alert(1)</script></svg>Text', 'Text'],
    ['<span style="color:red">Text &amp; more</span>', 'Text &amp; more'],
    ['<a href="?a=91&amp;page=2">Link</a>', '<a href="?a=91&amp;page=2">Link</a>'],
];
foreach ($cases as [$input, $expected]) {
    if (DescriptionHtml::render($input) !== $expected) {
        throw new RuntimeException('Description HTML regression: ' . $input);
    }
}
echo count($cases) . " description HTML checks passed\n";
