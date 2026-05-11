<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$extras = dirname($root);
$strict = in_array('--strict', $argv, true);
$json = in_array('--json', $argv, true);
$releaseGate = in_array('--release-gate', $argv, true);

$consumers = ['sArticles', 'dIssues', 'sLang', 'sSeo', 'sSettings', 'dDocs'];
$allowlistConfig = require __DIR__ . '/consumer-drift-allowlist.php';
$releaseConfig = $allowlistConfig['_releaseGate'] ?? [];
$allowlist = array_filter(
    $allowlistConfig,
    static fn (string $key): bool => !str_starts_with($key, '_'),
    ARRAY_FILTER_USE_KEY
);
$releaseConsumers = array_values(array_filter(
    $releaseConfig['scanned_consumers'] ?? ['sSeo', 'sLang', 'sSettings'],
    static fn (string $consumer): bool => in_array($consumer, $consumers, true)
));
$consumersToScan = $releaseGate ? $releaseConsumers : $consumers;

$rules = [
    'inline-style' => [
        'extensions' => ['php', 'blade.php'],
        'pattern' => '/<style\b/i',
        'message' => 'Inline <style> block. Promote common styles to evo-ui or add a scoped follow-up.',
    ],
    'inline-script' => [
        'extensions' => ['php', 'blade.php'],
        'pattern' => '/<script\b(?![^>]*\bsrc=)/i',
        'message' => 'Inline <script> block. Promote common behavior to evo-ui runtime or document a bridge.',
    ],
    'cdn-asset' => [
        'extensions' => ['php', 'blade.php', 'js', 'css'],
        'pattern' => '/\b(?:unpkg|jsdelivr|cdnjs|googleapis|gstatic)\b/i',
        'message' => 'Remote CDN asset. Manager UI assets should be local and package-owned.',
    ],
    'legacy-manager-asset' => [
        'extensions' => ['php', 'blade.php', 'js', 'css'],
        'pattern' => '/\b(?:styles\.min\.css|tabpane\.js|main\.js|jquery(?:\.min)?\.js|bootstrap(?:\.min)?\.(?:js|css)|roboto(?:\.css)?)\b/i',
        'message' => 'Legacy manager asset marker. Full evo-ui screens should not load legacy UI bundles.',
    ],
    'local-evo-ui-style' => [
        'extensions' => ['php', 'blade.php', 'css'],
        'pattern' => '/\.(?:[a-z0-9_-]+-)?evo-ui-(?:btn|nav-tab|field|form|modal|table|badge|chip|row-action)\b/i',
        'message' => 'Consumer styles an evo-ui atom. Shared visual primitives belong in evo-ui.',
    ],
];

function drift_files(string $path): array
{
    if (!is_dir($path)) {
        return [];
    }

    $skip = ['.git', 'vendor', 'node_modules', 'database', 'storage', 'demo', 'docs', 'old_docs', 'tests', 'scripts'];
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        $absolute = $file->getPathname();
        $relative = ltrim(str_replace($path, '', $absolute), DIRECTORY_SEPARATOR);
        $relative = str_replace(DIRECTORY_SEPARATOR, '/', $relative);

        foreach ($skip as $segment) {
            if ($relative === $segment || str_starts_with($relative, $segment . '/')) {
                continue 2;
            }
        }

        if (preg_match('/\.(?:php|blade\.php|js|css)$/', $relative)) {
            $files[$relative] = $absolute;
        }
    }

    ksort($files);

    return $files;
}

function drift_matches_extension(string $file, array $extensions): bool
{
    foreach ($extensions as $extension) {
        if (str_ends_with($file, '.' . $extension)) {
            return true;
        }
    }

    return false;
}

function drift_allowance(array $allowlist, string $consumer, string $file, string $rule): ?string
{
    $rules = $allowlist[$consumer][$file] ?? [];

    foreach ($rules as $key => $value) {
        if (is_int($key) && ($value === $rule || $value === '*')) {
            return 'Allowlisted in tests/consumer-drift-allowlist.php.';
        }

        if (($key === $rule || $key === '*') && is_string($value)) {
            return $value;
        }
    }

    return null;
}

$findings = [];

foreach ($consumersToScan as $consumer) {
    $path = $extras . '/' . $consumer;

    foreach (drift_files($path) as $relative => $absolute) {
        $contents = (string) file_get_contents($absolute);

        foreach ($rules as $rule => $definition) {
            if (!drift_matches_extension($relative, $definition['extensions'])) {
                continue;
            }

            if (!preg_match($definition['pattern'], $contents, $match, PREG_OFFSET_CAPTURE)) {
                continue;
            }

            $line = substr_count(substr($contents, 0, (int) $match[0][1]), "\n") + 1;
            $allowance = drift_allowance($allowlist, $consumer, $relative, $rule);
            $findings[] = [
                'consumer' => $consumer,
                'file' => $relative,
                'line' => $line,
                'rule' => $rule,
                'allowed' => $allowance !== null,
                'allowance' => $allowance,
                'message' => $definition['message'],
            ];
        }
    }
}

$active = array_values(array_filter($findings, static fn (array $finding): bool => !$finding['allowed']));

if ($json) {
    echo json_encode([
        'strict' => $strict,
        'release_gate' => $releaseGate,
        'release_modules' => $releaseConfig['modules'] ?? [],
        'findings' => $findings,
        'active' => $active,
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
} elseif ($releaseGate) {
    echo 'Four-module release gate: evo-ui, sSeo, sLang, sSettings' . PHP_EOL;
    echo 'Consumer drift findings: ' . count($findings) . ' total, ' . count($active) . ' active blockers' . PHP_EOL;

    foreach ($releaseConfig['modules'] ?? ['evo-ui', 'sSeo', 'sLang', 'sSettings'] as $module) {
        if ($module === 'evo-ui') {
            echo '- [evo-ui] package gate: run ' . implode(', ', $releaseConfig['package_checks']['evo-ui'] ?? ['composer test']) . PHP_EOL;
            continue;
        }

        $moduleActive = array_values(array_filter(
            $active,
            static fn (array $finding): bool => $finding['consumer'] === $module
        ));
        $moduleAllowed = array_values(array_filter(
            $findings,
            static fn (array $finding): bool => $finding['consumer'] === $module && $finding['allowed']
        ));

        echo sprintf(
            '- [%s] %s (%d allowed adapter%s)',
            $module,
            $moduleActive === [] ? 'green' : count($moduleActive) . ' blocker(s)',
            count($moduleAllowed),
            count($moduleAllowed) === 1 ? '' : 's'
        ) . PHP_EOL;

        foreach ($moduleActive as $finding) {
            echo sprintf(
                '  - %s:%d %s - %s',
                $finding['file'],
                $finding['line'],
                $finding['rule'],
                $finding['message']
            ) . PHP_EOL;
        }
    }
} else {
    echo 'Consumer drift findings: ' . count($findings) . ' total, ' . count($active) . ' active' . PHP_EOL;

    foreach ($active as $finding) {
        echo sprintf(
            '- [%s] %s:%d %s - %s',
            $finding['consumer'],
            $finding['file'],
            $finding['line'],
            $finding['rule'],
            $finding['message']
        ) . PHP_EOL;
    }

    if (!$strict && $active !== []) {
        echo 'Report mode only. Use --strict after consumer cleanup or allowlisting.' . PHP_EOL;
    }
}

if (($strict || $releaseGate) && $active !== []) {
    exit(1);
}
