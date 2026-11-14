<?php

declare(strict_types=1);

// Exercise the real ModuleTable mount/actions without a CMS, database or session.
namespace Livewire {
    class Component {}
}

namespace EvoUI\Livewire {
    function session(): object { return $GLOBALS['responsiveSessionStore']; }
    function request(): object
    {
        return new class {
            public function query(string $key): mixed { return $GLOBALS['requestedView'] ?? null; }
        };
    }
}

namespace {
    require dirname(__DIR__) . '/src/Support/ResponsiveTableView.php';
    require dirname(__DIR__) . '/src/Livewire/ModuleTable.php';

    use EvoUI\Support\ResponsiveTableView;
    use EvoUI\Livewire\ModuleTable;

    class EvoSessionProxy {}
    class ResponsiveSessionStore {
        public array $data = [];
        public function put(string $key, mixed $value): void {
            $target =& $this->data;
            foreach (explode('.', $key) as $part) $target =& $target[$part];
            $target = $value;
        }
        public function get(string $key): mixed {
            $target = $this->data;
            foreach (explode('.', $key) as $part) {
                if (!is_array($target) || !array_key_exists($part, $target)) return null;
                $target = $target[$part];
            }
            return $target;
        }
    }
    $responsiveSessionStore = new ResponsiveSessionStore();
    $checks = 0;
    function same(mixed $expected, mixed $actual, string $message): void {
        $GLOBALS['checks']++;
        if ($expected !== $actual) throw new RuntimeException($message . ': ' . var_export($actual, true));
    }

    foreach ([
        [617, ['table', 'list'], 1200, 'list'],
        [1199, ['table', 'list'], 1200, 'list'],
        [1200, ['table', 'list'], 1200, 'table'],
        [1280, ['table', 'list'], 1200, 'table'],
        ['617', ['table', 'list'], 1200, 'list'],
        [800, ['table', 'list'], 768, 'table'],
        [617, ['table'], 1200, null],
        [617, ['list'], 1200, null],
        [617, ['table', 'list'], 0, null],
    ] as [$width, $views, $breakpoint, $expected]) {
        same($expected, ResponsiveTableView::initialView($width, $views, $breakpoint), 'Width/config decision');
    }
    foreach ([null, false, true, [], ['width' => 617], 0, -1, 100001, 617.5, '617px', 'NaN', ''] as $invalid) {
        same(null, ResponsiveTableView::initialView($invalid, ['table', 'list']), 'Invalid hints must be ignored');
    }

    class ResponsiveTestTable extends ModuleTable {
        public array $stored = [];
        public array $saved = [];
        public int $breakpoint = 1200;
        public string $testStorageKey = 'evo-ui.module-table.test';
        public function storageKey(): string { return $this->testStorageKey; }
        public function save(): void { $this->persistServerState(); }
        protected function syncConfigState(): void {}
        protected function fillDefaultFilters(): void {}
        protected function tableViews(): array { return ['table', 'list']; }
        protected function tableConfig(?string $key = null, mixed $default = null): mixed {
            return $key === 'responsive_list' ? $this->breakpoint : $default;
        }
        protected function restoreSessionState(): void {
            if ($this->stored !== [] && ($GLOBALS['requestedView'] ?? null) === null) $this->restoreTableState($this->stored);
        }
        protected function dispatchClientState(): void { $this->saved = $this->persistedState(); }
    }
    function mounted(mixed $width, array $stored = [], mixed $requested = null): ResponsiveTestTable {
        $GLOBALS['requestedView'] = $requested;
        $table = new ResponsiveTestTable();
        $table->stored = $stored;
        if (in_array($requested, ['table', 'list'], true)) $table->viewMode = $requested;
        $table->mount('test.items', ['module' => 'responsive-test', 'responsive_width' => $width]);
        return $table;
    }

    $table = mounted(617);
    same('list', $table->viewMode, 'Narrow first render');
    same('auto', $table->viewOrigin, 'Initial list is automatic');
    same('table', mounted(1280)->viewMode, 'Wide first render');
    same('table', mounted(null)->viewMode, 'Existing consumers without a hint');
    same('table', mounted(617, [], 'table')->viewMode, 'Explicit URL table wins over narrow hint');
    same('manual', mounted(1280, [], 'list')->viewOrigin, 'Explicit URL list is manual');
    same('list', mounted(1280, [], 'list')->viewMode, 'Explicit list survives wide hint');
    same('list', mounted(617, [], ['table'])->viewMode, 'Malformed URL view does not become a preference');
    same('table', mounted(617, ['view' => 'table', 'view_origin' => 'manual'])->viewMode, 'Stored manual table wins');
    same('list', mounted(1280, ['view' => 'list', 'view_origin' => 'manual'])->viewMode, 'Stored manual list wins');
    same('list', mounted(1280, ['view' => 'list'])->viewMode, 'Legacy saved choice is preserved');
    same('table', mounted(1280, ['view' => 'list', 'view_origin' => 'auto'])->viewMode, 'Automatic list may adapt back to wide');
    same('list', mounted(617, ['view' => 'table', 'view_origin' => 'auto'])->viewMode, 'Automatic table may adapt to narrow');

    $table = mounted(617);
    $table->switchView('list');
    same('manual', $table->viewOrigin, 'Selecting the existing automatic view makes it explicit');
    same('manual', $table->saved['view_origin'], 'Origin is persisted with view');
    $table->switchView('table', true);
    same('list', $table->viewMode, 'Automatic calls cannot override a manual choice');
    $table->switchView('table');
    same('table', $table->viewMode, 'Manual table remains selectable in narrow mode');
    same('manual', $table->viewOrigin, 'Manual table remains explicit');
    $table = mounted(617);
    $table->switchView('table', true);
    same('table', $table->viewMode, 'Resize can restore automatic table');
    same('auto', $table->viewOrigin, 'Resize stays automatic');
    same('auto', $table->saved['view_origin'], 'Automatic origin survives remount');
    $_SESSION = [];
    $responsiveSessionStore->put('evo-ui.other-table', ['view' => 'list']);
    $table->save();
    same($table->persistedState(), $_SESSION['evo-ui']['module-table']['test'], 'CMS native mirror keeps the persisted table state');
    same(['view' => 'list'], $_SESSION['evo-ui']['other-table'], 'Mirroring preserves sibling table state');
    foreach (array_keys($responsiveSessionStore->data) as $namespace) {
        if (!array_key_exists($namespace, $_SESSION)) unset($responsiveSessionStore->data[$namespace]);
    }
    same($table->persistedState(), $responsiveSessionStore->get($table->storageKey()), 'State survives CMS missing-native-key cleanup');
    $table->testStorageKey = 'vendor.custom-items';
    $table->save();
    same($table->persistedState(), $_SESSION['vendor']['custom-items'], 'Custom storage namespaces are mirrored');
    echo "$checks responsive table PHP checks passed\n";
}
