<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$passed = 0;
$failed = 0;

function evo_ui_test(string $name, Closure $test): void
{
    global $passed, $failed;

    try {
        $test();
        $passed++;
        echo "PASS {$name}\n";
    } catch (Throwable $exception) {
        $failed++;
        echo "FAIL {$name}\n";
        echo '  ' . $exception->getMessage() . "\n";
    }
}

function evo_ui_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

evo_ui_test('composer package is a technical library', function () use ($root): void {
    $composer = json_decode((string) file_get_contents($root . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);

    evo_ui_assert(($composer['name'] ?? null) === 'evolution-cms/evo-ui', 'Composer package name must be evolution-cms/evo-ui.');
    evo_ui_assert(($composer['type'] ?? null) === 'library', 'evo-ui must not register as an Evolution CMS module package.');
    evo_ui_assert(in_array('src/Livewire/Foundation/bootstrap.php', $composer['autoload']['files'] ?? [], true), 'Livewire foundation bootstrap must be autoloaded.');
    evo_ui_assert(isset($composer['autoload']['psr-4']['EvoUI\\']), 'EvoUI namespace must be registered.');
});

evo_ui_test('service provider does not register a manager module', function () use ($root): void {
    $provider = (string) file_get_contents($root . '/src/EvoUIServiceProvider.php');

    evo_ui_assert(!str_contains($provider, 'registerRoutingModule'), 'evo-ui must not register a routing module.');
    evo_ui_assert(!str_contains($provider, 'registerModule('), 'evo-ui must not register a manager module.');
    evo_ui_assert(str_contains($provider, "Livewire::component('evo-ui.table'"), 'Table Livewire component must be registered.');
    evo_ui_assert(str_contains($provider, "Livewire::component('evo-ui.form'"), 'Form Livewire component must be registered.');
    evo_ui_assert(str_contains($provider, "Livewire::component('evo-ui.module-table'"), 'Module table Livewire component must be registered.');
    evo_ui_assert(str_contains($provider, "Livewire::component('evo-ui.issue-workspace'"), 'Issue workspace Livewire component must be registered.');
});

evo_ui_test('assets and themes use the evo-ui namespace', function () use ($root): void {
    $config = require $root . '/config/evo-ui.php';

    evo_ui_assert(($config['assets']['path'] ?? null) === 'assets/modules/evo-ui', 'Published asset path must be assets/modules/evo-ui.');
    evo_ui_assert(($config['theme']['themes'] ?? []) === ['evolight', 'evolightness', 'evodark', 'evodarkness'], 'Only current Evo manager themes must be declared.');
});

evo_ui_test('table and issue workspace persist state in manager session', function () use ($root): void {
    $moduleTable = (string) file_get_contents($root . '/src/Livewire/ModuleTable.php');
    $issueWorkspace = (string) file_get_contents($root . '/src/Livewire/IssueWorkspace.php');

    evo_ui_assert(str_contains($moduleTable, 'session()->get($this->storageKey())'), 'ModuleTable must restore state from the manager session.');
    evo_ui_assert(str_contains($moduleTable, 'session()->put($this->storageKey(), $this->persistedState())'), 'ModuleTable must persist state to the manager session.');
    evo_ui_assert(str_contains($issueWorkspace, 'session()->get($this->storageKey())'), 'IssueWorkspace must restore state from the manager session.');
    evo_ui_assert(str_contains($issueWorkspace, 'session()->put($this->storageKey(), $this->persistedState())'), 'IssueWorkspace must persist state to the manager session.');
});

if ($failed > 0) {
    exit(1);
}

echo "OK {$passed} tests\n";
