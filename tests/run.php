<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$passed = 0;
$failed = 0;
$currentGroup = 'general';

function evo_ui_group(string $name, Closure $tests): void
{
    global $currentGroup;

    $previous = $currentGroup;
    $currentGroup = $name;

    echo "GROUP {$name}\n";
    $tests();

    $currentGroup = $previous;
}

function evo_ui_test(string $name, Closure $test): void
{
    global $passed, $failed, $currentGroup;

    try {
        $test();
        $passed++;
        echo "PASS [{$currentGroup}] {$name}\n";
    } catch (Throwable $exception) {
        $failed++;
        echo "FAIL [{$currentGroup}] {$name}\n";
        echo '  ' . $exception->getMessage() . "\n";
    }
}

function evo_ui_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function evo_ui_assert_same(mixed $expected, mixed $actual, string $message): void
{
    if ($expected !== $actual) {
        throw new RuntimeException($message . ' Expected: ' . var_export($expected, true) . ' Actual: ' . var_export($actual, true));
    }
}

function evo_ui_assert_contains(string $needle, string $haystack, string $message): void
{
    evo_ui_assert(str_contains($haystack, $needle), $message);
}

function evo_ui_assert_not_contains(string $needle, string $haystack, string $message): void
{
    evo_ui_assert(!str_contains($haystack, $needle), $message);
}

function evo_ui_path(string $path): string
{
    global $root;

    return $root . '/' . ltrim($path, '/');
}

function evo_ui_read(string $path): string
{
    $absolute = evo_ui_path($path);
    evo_ui_assert(is_file($absolute), 'Expected file to exist: ' . $path);

    return (string) file_get_contents($absolute);
}

function evo_ui_config(string $path): array
{
    $absolute = evo_ui_path($path);
    evo_ui_assert(is_file($absolute), 'Expected config file to exist: ' . $path);

    $config = require $absolute;
    evo_ui_assert(is_array($config), 'Config must return an array: ' . $path);

    return $config;
}

evo_ui_group('package', function () use ($root): void {
    evo_ui_test('composer package is a technical library', function () use ($root): void {
        $composer = json_decode((string) file_get_contents($root . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);

        evo_ui_assert_same('evolution-cms/evo-ui', $composer['name'] ?? null, 'Composer package name must be evolution-cms/evo-ui.');
        evo_ui_assert_same('library', $composer['type'] ?? null, 'evo-ui must not register as an Evolution CMS module package.');
        evo_ui_assert(in_array('src/Livewire/Foundation/bootstrap.php', $composer['autoload']['files'] ?? [], true), 'Livewire foundation bootstrap must be autoloaded.');
        evo_ui_assert(isset($composer['autoload']['psr-4']['EvoUI\\']), 'EvoUI namespace must be registered.');
    });

    evo_ui_test('service provider does not register a manager module', function (): void {
        $provider = evo_ui_read('src/EvoUIServiceProvider.php');

        evo_ui_assert_not_contains('registerRoutingModule', $provider, 'evo-ui must not register a routing module.');
        evo_ui_assert_not_contains('registerModule(', $provider, 'evo-ui must not register a manager module.');
        evo_ui_assert_contains('use Livewire\\LivewireServiceProvider;', $provider, 'Livewire provider must be imported.');
        evo_ui_assert_contains('$this->registerLivewireProvider();', $provider, 'Livewire provider must be registered before EvoUI bridges Livewire.');
        evo_ui_assert_contains('$this->app->register(LivewireServiceProvider::class);', $provider, 'EvoUI must register Livewire as its runtime dependency.');
        evo_ui_assert_contains("Livewire::component('evo-ui.table'", $provider, 'Table Livewire component must be registered.');
        evo_ui_assert_contains("Livewire::component('evo-ui.form'", $provider, 'Form Livewire component must be registered.');
        evo_ui_assert_contains("Livewire::component('evo-ui.module-table'", $provider, 'Module table Livewire component must be registered.');
        evo_ui_assert_contains("Livewire::component('evo-ui.issue-workspace'", $provider, 'Issue workspace Livewire component must be registered.');
    });
});

evo_ui_group('assets', function (): void {
    evo_ui_test('assets and themes use the evo-ui namespace', function (): void {
        $config = evo_ui_config('config/evo-ui.php');

        evo_ui_assert_same('assets/modules/evo-ui', $config['assets']['path'] ?? null, 'Published asset path must be assets/modules/evo-ui.');
        evo_ui_assert_same(['evolight', 'evolightness', 'evodark', 'evodarkness'], $config['theme']['themes'] ?? [], 'Only current Evo manager themes must be declared.');
    });

    evo_ui_test('manager layout exposes evo-ui shell and theme markers', function (): void {
        $layout = evo_ui_read('views/layouts/manager.blade.php');

        evo_ui_assert_contains('@include(\'evo::partials.assets\')', $layout, 'Manager layout must include evo-ui assets.');
        evo_ui_assert_contains('data-evo-ui-root', $layout, 'Manager layout must expose the evo-ui root marker.');
        evo_ui_assert_contains('data-theme="{{ $theme }}"', $layout, 'Manager layout must expose the current manager theme.');
        evo_ui_assert_contains('data-theme-mode="{{ $themeMode }}"', $layout, 'Manager layout must expose the current manager theme mode.');
        evo_ui_assert_contains('meta name="color-scheme"', $layout, 'Manager layout must set color-scheme metadata.');
    });

    evo_ui_test('asset partial loads local package assets and configures EvoUI', function (): void {
        $assets = evo_ui_read('views/partials/assets.blade.php');

        evo_ui_assert_contains('evo-ui.css?v=', $assets, 'Asset partial must load local evo-ui CSS.');
        evo_ui_assert_contains('evo-ui.js?v=', $assets, 'Asset partial must load local evo-ui JS.');
        evo_ui_assert_contains('window.EvoUI = window.EvoUI || {};', $assets, 'Asset partial must initialize the EvoUI global.');
        evo_ui_assert_contains('window.EvoUI.config = Object.assign', $assets, 'Asset partial must expose EvoUI runtime config.');
        evo_ui_assert_contains('@livewireStyles', $assets, 'Asset partial must include Livewire styles when available.');
        evo_ui_assert_contains('LivewireAssets::scripts()', $assets, 'Asset partial must include Livewire scripts through the manager-safe shim.');
    });

    evo_ui_test('evo-ui-owned layout and asset partial do not load legacy manager bundles', function (): void {
        $surface = strtolower(evo_ui_read('views/layouts/manager.blade.php') . "\n" . evo_ui_read('views/partials/assets.blade.php'));

        foreach (['styles.min.css', 'bootstrap', 'jquery', 'main.js', 'tabpane.js', 'roboto', 'cdn'] as $legacy) {
            evo_ui_assert_not_contains($legacy, $surface, 'evo-ui shell must not load legacy manager asset: ' . $legacy);
        }
    });

    evo_ui_test('javascript exposes stable public EvoUI API markers', function (): void {
        $js = evo_ui_read('resources/js/evo-ui.js');

        foreach ([
            'window.EvoUI.init = init',
            'window.EvoUI.dispatch = dispatch',
            'window.EvoUI.form = {',
            'window.EvoUI.multiFilter = multiFilter',
            'window.EvoUI.dateRangeFilter = dateRangeFilter',
            'window.EvoUI.initIssueKanban = initIssueKanban',
            'window.EvoUI.syncRichEditors = syncRichEditors',
            'window.EvoUI.browseMediaField = browseMediaField',
            'window.EvoUI.theme = {',
        ] as $marker) {
            evo_ui_assert_contains($marker, $js, 'Missing public EvoUI JS marker: ' . $marker);
        }
    });
});

evo_ui_group('design-tokens', function (): void {
    evo_ui_test('css defines canonical manager themes and OKLCH palette tokens', function (): void {
        $css = evo_ui_read('resources/css/evo-ui.css');

        foreach ([
            '[data-theme="evolight"]' => 'CSS must support the evolight manager theme.',
            '[data-theme="evolightness"]' => 'CSS must support the evolightness manager theme.',
            '[data-theme="evodark"]' => 'CSS must support the evodark manager theme.',
            '[data-theme="evodarkness"]' => 'CSS must support the evodarkness manager theme.',
            'color-scheme: light;' => 'Light themes must set light color-scheme.',
            'color-scheme: dark;' => 'Dark themes must set dark color-scheme.',
            '--color-primary: oklch' => 'Primary palette must use OKLCH tokens.',
            '--color-success: oklch' => 'Success palette must use OKLCH tokens.',
            '--color-warning: oklch' => 'Warning palette must use OKLCH tokens.',
            '--color-error: oklch' => 'Error palette must use OKLCH tokens.',
            'color-mix(in oklch' => 'Derived colors must use OKLCH color mixing.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $css, $message);
        }
    });

    evo_ui_test('css exposes shared evo-ui semantic tokens', function (): void {
        $css = evo_ui_read('resources/css/evo-ui.css');

        foreach ([
            '--evo-ui-bg: var(--color-base-100);',
            '--evo-ui-surface: var(--color-base-200);',
            '--evo-ui-border: var(--color-base-300);',
            '--evo-ui-text: var(--color-base-content);',
            '--evo-ui-surface-soft:',
            '--evo-ui-surface-raised:',
            '--evo-ui-border-soft:',
            '--evo-ui-control-bg:',
            '--evo-ui-row-hover:',
            '--evo-ui-row-selected:',
            '--evo-ui-chip-bg:',
            '--evo-ui-shadow-soft:',
            '--evo-ui-radius: var(--radius-box);',
            '--evo-ui-radius-sm:',
            '--evo-ui-placeholder:',
        ] as $marker) {
            evo_ui_assert_contains($marker, $css, 'Missing shared semantic CSS token: ' . $marker);
        }
    });

    evo_ui_test('css fixes dynamic badge and issue chip color contracts', function (): void {
        $css = evo_ui_read('resources/css/evo-ui.css');

        foreach ([
            '.evo-ui-badge--dynamic' => 'Dynamic badges must have a shared class.',
            'var(--evo-ui-badge-color)' => 'Dynamic badges must use the badge color custom property.',
            '--evo-issue-chip: var(--evo-ui-primary);' => 'Issue cards must define a default chip custom property.',
            'color: var(--evo-issue-chip);' => 'Issue chips must use dynamic chip colors.',
            'background: color-mix(in oklch, var(--evo-issue-chip)' => 'Issue chips must derive backgrounds from dynamic chip colors.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $css, $message);
        }
    });

    evo_ui_test('css styles color picker field primitives', function (): void {
        $css = evo_ui_read('resources/css/evo-ui.css');

        foreach ([
            '.evo-ui-color-field',
            '.evo-ui-color-field__picker',
            '.evo-ui-color-field__input',
            '.evo-ui-color-field__swatch',
            '--evo-ui-color-field-value',
        ] as $marker) {
            evo_ui_assert_contains($marker, $css, 'Missing color field CSS marker: ' . $marker);
        }
    });

    evo_ui_test('css styles issue cards, list cards and compact manager typography', function (): void {
        $css = evo_ui_read('resources/css/evo-ui.css');

        foreach ([
            'font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;',
            'font-size: 14px;',
            '--evo-ui-issue-page-title-font-size: 20px;',
            '--evo-ui-issue-title-font-size: 14px;',
            '--evo-ui-issue-list-title-font-size: 13px;',
            '--evo-ui-issue-body-font-size: 12px;',
            '.evo-ui-issue-card',
            '.evo-ui-issue-list-item',
            '.evo-ui-list-item',
            '.evo-ui-table--compact',
            '.evo-ui-list-item--compact',
        ] as $marker) {
            evo_ui_assert_contains($marker, $css, 'Missing visual/typography contract marker: ' . $marker);
        }
    });
});

evo_ui_group('state', function (): void {
    evo_ui_test('table and issue workspace persist state in manager session', function (): void {
        $moduleTable = evo_ui_read('src/Livewire/ModuleTable.php');
        $issueWorkspace = evo_ui_read('src/Livewire/IssueWorkspace.php');

        evo_ui_assert_contains('session()->get($this->storageKey())', $moduleTable, 'ModuleTable must restore state from the manager session.');
        evo_ui_assert_contains('session()->put($this->storageKey(), $this->persistedState())', $moduleTable, 'ModuleTable must persist state to the manager session.');
        evo_ui_assert_contains('session()->get($this->storageKey())', $issueWorkspace, 'IssueWorkspace must restore state from the manager session.');
        evo_ui_assert_contains('session()->put($this->storageKey(), $this->persistedState())', $issueWorkspace, 'IssueWorkspace must persist state to the manager session.');
    });
});

evo_ui_group('module-table', function (): void {
    evo_ui_test('module table supports column header actions', function (): void {
        $moduleTable = evo_ui_read('src/Livewire/ModuleTable.php');
        $headerCell = evo_ui_read('views/components/table/header-cell.blade.php');
        $css = evo_ui_read('resources/css/evo-ui.css');

        evo_ui_assert_contains('public function runHeaderAction', $moduleTable, 'ModuleTable must expose a Livewire header action handler.');
        evo_ui_assert_contains("\$column['header_actions']", $moduleTable, 'ModuleTable must validate actions from the column header_actions contract.');
        evo_ui_assert_contains('runHeaderAction(@js($columnKey), @js($actionKey))', $headerCell, 'Header cell must call runHeaderAction with the column and action keys.');
        evo_ui_assert_contains("'evo-ui-btn'", $headerCell, 'Header actions must reuse the standard evo-ui button atom.');
        evo_ui_assert_contains("'evo-ui-btn--icon'", $headerCell, 'Header actions must reuse the standard evo-ui icon button atom.');
        evo_ui_assert_contains('class="evo-ui-btn__icon"', $headerCell, 'Header action icons must use the standard evo-ui button icon class.');
        evo_ui_assert_contains('grid-template-columns: minmax(0, 1fr) auto;', $css, 'Header action groups must align with the inline edit action lane.');
        evo_ui_assert_contains('width: min(calc(100% - 9px), 371px);', $css, 'Header action groups must align icon centers with inline edit actions.');
        evo_ui_assert_contains('margin-left: 9px;', $css, 'Header action groups must start at the same inset as inline edit controls.');
        evo_ui_assert_contains('justify-content: flex-end;', $css, 'Header action buttons must sit on the right edge of the shared action lane.');
        evo_ui_assert_not_contains('.evo-ui-table-header__action {', $css, 'Header actions must not define custom icon button sizing.');
        evo_ui_assert_not_contains(".evo-ui-table-header {\n    display: inline-flex;\n    align-items: center;\n    gap: 6px;\n    width: max-content;", $css, 'Header action groups must not rely on custom max-content sizing.');
    });

    evo_ui_test('module table exposes filtering, sorting, pagination and view state methods', function (): void {
        $moduleTable = evo_ui_read('src/Livewire/ModuleTable.php');
        $toolbar = evo_ui_read('views/components/table/module/toolbar.blade.php');
        $pagination = evo_ui_read('views/components/table/pagination.blade.php');
        $header = evo_ui_read('views/components/table/header-cell.blade.php');

        foreach (['applyMultiFilter', 'applySelectFilter', 'applyDateRangeFilter', 'setSort', 'switchView'] as $method) {
            evo_ui_assert_contains('function ' . $method, $moduleTable, 'ModuleTable must expose method: ' . $method);
        }

        evo_ui_assert_contains('wire:model.live="perPage"', $pagination, 'Pagination must bind per-page state.');
        evo_ui_assert_contains("wire:click=\"switchView('table')\"", $toolbar, 'Toolbar must expose table view switching.');
        evo_ui_assert_contains("wire:click=\"switchView('list')\"", $toolbar, 'Toolbar must expose list view switching.');
        evo_ui_assert_contains('wire:click="setSort', $header, 'Header cells must expose sorting.');
        evo_ui_assert_contains("'q', 'page', 'sort', 'dir', 'perPage', 'f', 'view'", $moduleTable, 'URL query keys must include table state.');
    });

    evo_ui_test('module table renders typed cells and list parity markers', function (): void {
        $cell = evo_ui_read('views/components/table/module/cell.blade.php');
        $list = evo_ui_read('views/components/table/module/list.blade.php');

        foreach (["'link'", "'image'", "'chips'", "'badge'", "'icon'", "'position'"] as $type) {
            evo_ui_assert_contains($type, $cell, 'Module table cell must support type marker: ' . $type);
        }

        evo_ui_assert_contains('evo-ui-table-cell--', $cell, 'Module table cells must expose type-based cell classes, including date/text fallback types.');
        evo_ui_assert_contains('evo-ui-list-item', $list, 'List view must render evo-ui list items.');
        evo_ui_assert_contains('evo-ui-table-link', $list, 'List view must reuse table link atoms.');
        evo_ui_assert_contains('evo-ui-position-control', $list, 'List view must support position controls.');
    });

    evo_ui_test('module table supports inline editing and provider hooks', function (): void {
        $moduleTable = evo_ui_read('src/Livewire/ModuleTable.php');
        $inline = evo_ui_read('views/components/table/module/inline-edit.blade.php');

        evo_ui_assert_contains('createInlineRow', $moduleTable, 'ModuleTable must call the inline create provider.');
        evo_ui_assert_contains('updateInlineField', $moduleTable, 'ModuleTable must call the inline save provider.');
        evo_ui_assert_contains('inlineEditableColumn', $moduleTable, 'ModuleTable must validate editable columns.');
        evo_ui_assert_contains('evo-ui-inline-edit', $inline, 'Inline edit view must render the shared inline edit class.');
        evo_ui_assert_contains('updateInlineField(', $inline, 'Inline edit view must save through updateInlineField.');
    });

    evo_ui_test('module table supports modal CRUD, delete guard and reorder contracts', function (): void {
        $moduleTable = evo_ui_read('src/Livewire/ModuleTable.php');
        $modal = evo_ui_read('views/components/table/module/form-modal.blade.php');
        $modalField = evo_ui_read('views/components/table/module/modal-field.blade.php');
        $deleteModal = evo_ui_read('views/components/table/module/delete-modal.blade.php');
        $cell = evo_ui_read('views/components/table/module/cell.blade.php');

        foreach (['openCreateModal', 'openEditModal', 'saveModal', 'deleteConfirmed', 'moveRow', 'reorderRow'] as $method) {
            evo_ui_assert_contains('function ' . $method, $moduleTable, 'ModuleTable must expose method: ' . $method);
        }

        evo_ui_assert_contains('deleteErrorMessage', $moduleTable, 'Delete guard failures must be stored for rendering.');
        evo_ui_assert_contains('deleteErrorMessage', $deleteModal, 'Delete modal must render delete guard failures.');
        evo_ui_assert_contains('data-evo-delete-confirm-action', $deleteModal, 'Livewire delete modal must align the destructive action with the shared confirm footer contract.');
        evo_ui_assert_contains('EvoUI.syncRichEditors($el, $wire).then(() => $wire.saveModal())', $modal, 'Modal submit must sync rich editors before saving.');
        evo_ui_assert_contains("in_array(\$type, ['color', 'color-picker'], true)", $modalField, 'Modal fields must support color picker fields.');
        evo_ui_assert_contains('$type === \'choices\'', $modalField, 'Modal fields must support choices fields.');
        evo_ui_assert_contains('$type === \'builder\'', $modalField, 'Modal fields must support builder fields.');
        evo_ui_assert_contains('wire:click.stop="moveRow', $cell, 'Position cells must expose moveRow controls.');
    });
});

evo_ui_group('issue-workspace', function (): void {
    evo_ui_test('issue workspace provider interface exposes generic data and action contract', function (): void {
        $provider = evo_ui_read('src/Contracts/IssueWorkspaceProvider.php');

        foreach ([
            'projects',
            'categories',
            'statuses',
            'assignees',
            'metrics',
            'issueList',
            'listRows',
            'kanbanLanes',
            'issuePreview',
            'issueDetail',
            'comments',
            'sortKanbanLanes',
            'assignIssueToMe',
            'assignIssue',
            'unassignIssue',
            'replyIssue',
            'replyAndCloseIssue',
            'closeIssue',
            'reopenIssue',
            'diagnostics',
        ] as $method) {
            evo_ui_assert_contains('function ' . $method, $provider, 'IssueWorkspaceProvider must expose method: ' . $method);
        }
    });

    evo_ui_test('issue workspace component owns filters, display state and persistence', function (): void {
        $workspace = evo_ui_read('src/Livewire/IssueWorkspace.php');

        foreach ([
            "'category_ids' => []" => 'Workspace must support category multi-filter state.',
            "'status_ids' => []" => 'Workspace must support status multi-filter state.',
            "'phase_ids' => []" => 'Workspace must support phase multi-filter state.',
            "'priority_ids' => []" => 'Workspace must support priority multi-filter state.',
            "'assignee_ids' => []" => 'Workspace must support assignee multi-filter state.',
            "'archive' => 'active'" => 'Workspace must support archive filter state.',
            "'display' => 'kanban'" => 'Workspace must default to kanban display.',
            'public function applyMultiFilter' => 'Workspace must expose multi-filter action.',
            'public function switchDisplay' => 'Workspace must expose display switching.',
            'public function setArchive' => 'Workspace must expose archive switching.',
            'public function persistedState' => 'Workspace must expose persisted state.',
            'session()->get($this->storageKey())' => 'Workspace must restore manager session state.',
            'session()->put($this->storageKey(), $this->persistedState())' => 'Workspace must persist manager session state.',
            'protected function dispatchClientState' => 'Workspace must centralize client/server state updates.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $workspace, $message);
        }
    });

    evo_ui_test('issue workspace renders list and kanban markers', function (): void {
        $view = evo_ui_read('views/livewire/issue-workspace.blade.php');
        $js = evo_ui_read('resources/js/evo-ui.js');

        foreach ([
            'class="evo-ui-issue-workspace"' => 'Workspace must render a shared root class.',
            'data-evo-issue-workspace' => 'Workspace must render a root data marker.',
            'data-evo-issue-display' => 'Workspace must expose current display state.',
            "wire:click=\"switchDisplay('{{ \$value }}')\"" => 'Workspace toolbar must switch display modes.',
            'data-evo-issue-kanban' => 'Kanban view must expose the board marker.',
            'data-evo-issue-lane' => 'Kanban view must expose lane markers.',
            'data-evo-issue-card' => 'Kanban view must expose card markers.',
            'data-evo-issue-count' => 'Kanban view must expose lane count markers.',
            'evo-ui-issue-list-item' => 'List view must render list item markers.',
            'data-evo-issue-split' => 'List view must render split layout marker.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $view, $message);
        }

        evo_ui_assert_contains('function initIssueKanban', $js, 'Runtime must initialize issue kanban drag/drop.');
        evo_ui_assert_contains('window.EvoUI.initIssueKanban = initIssueKanban', $js, 'Runtime must expose issue kanban initializer.');
        evo_ui_assert_contains('issueKanbanLanePayload', $js, 'Runtime must build provider sorting payload.');
    });

    evo_ui_test('issue workspace supports comments, replies and issue body editor sync', function (): void {
        $workspace = evo_ui_read('src/Livewire/IssueWorkspace.php');
        $view = evo_ui_read('views/livewire/issue-workspace.blade.php');

        foreach ([
            'public function replyToComment' => 'Workspace must support selecting a parent comment for replies.',
            'public function cancelReplyToComment' => 'Workspace must support cancelling reply context.',
            'public function replyIssue' => 'Workspace must expose reply action.',
            'public function replyAndCloseIssue' => 'Workspace must expose reply-and-close action.',
            'public function startIssueBodyEdit' => 'Workspace must expose issue body editing.',
            'public function saveIssueBody' => 'Workspace must expose issue body save action.',
            'replyEditorHtml' => 'Workspace must render configured reply editor HTML.',
            'issueBodyEditorHtml' => 'Workspace must render configured issue body editor HTML.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $workspace, $message);
        }

        foreach ([
            'class="evo-ui-issue-comment"' => 'Workspace must render comment items.',
            'evo-ui-issue-comment__reply' => 'Workspace must expose reply-to-comment buttons.',
            'class="evo-ui-issue-reply"' => 'Workspace must render reply form.',
            'data-evo-rich-editor-model="replyBody"' => 'Reply editor must sync through rich editor model marker.',
            'EvoUI.syncRichEditors($el, $wire).then(() => $wire.replyIssue())' => 'Reply submit must sync rich editors.',
            'replyAndCloseIssue' => 'Reply form must expose reply-and-close flow.',
            'evo-ui-issue-body-editor' => 'Issue detail must render body editor form.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $view, $message);
        }
    });

    evo_ui_test('issue workspace supports assignment, archive and parent-child markers', function (): void {
        $workspace = evo_ui_read('src/Livewire/IssueWorkspace.php');
        $view = evo_ui_read('views/livewire/issue-workspace.blade.php');

        foreach ([
            'public function assignIssueToMe' => 'Workspace must expose assign-to-me action.',
            'public function assignIssue' => 'Workspace must expose assign action.',
            'public function unassignIssue' => 'Workspace must expose unassign action.',
            'public function createChildIssue' => 'Workspace must expose child issue creation action.',
            'public function archiveStatusIssues' => 'Workspace must expose bulk archive action.',
            'method_exists($provider, \'createChildIssue\')' => 'Child issue creation must remain optional provider-owned behavior.',
            'method_exists($provider, \'archiveStatusIssues\')' => 'Bulk archive must remain optional provider-owned behavior.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $workspace, $message);
        }

        foreach ([
            'wire:click="assignIssue({{ $assignmentId }})"' => 'Assignment menu must call assignIssue.',
            'wire:click="assignIssueToMe"' => 'Assignment menu must support assign-to-me.',
            'wire:click="unassignIssue"' => 'Assignment menu must support unassign.',
            'wire:click="createChildIssue"' => 'Detail views must support child issue creation.',
            'wire:click="archiveStatusIssues' => 'Kanban lane actions must support bulk archive.',
            'evo-ui-issue-parent' => 'Detail views must render parent issue markers.',
            'evo-ui-issue-subtasks' => 'Detail views must render child issue markers.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $view, $message);
        }
    });

    evo_ui_test('issue workspace fixes kanban drag/drop sorting contract', function (): void {
        $workspace = evo_ui_read('src/Livewire/IssueWorkspace.php');
        $js = evo_ui_read('resources/js/evo-ui.js');
        $view = evo_ui_read('views/livewire/issue-workspace.blade.php');

        evo_ui_assert_contains('public function sortKanbanLanes(array $lanes): void', $workspace, 'Workspace must expose kanban sorting action.');
        evo_ui_assert_contains('$provider->sortKanbanLanes($normalized);', $workspace, 'Workspace must delegate sorting to the provider.');
        evo_ui_assert_contains('data-issue-id', $view, 'Cards must expose sortable issue ids.');
        evo_ui_assert_contains('data-status-id', $view, 'Lanes must expose status ids.');
        evo_ui_assert_contains('draggable="true"', $view, 'Cards must opt into browser drag/drop.');
        evo_ui_assert_contains("component.call('sortKanbanLanes', issueKanbanLanePayload(board))", $js, 'Runtime must send normalized lane payload to Livewire.');
        evo_ui_assert_contains('issueKanbanSyncLane', $js, 'Runtime must keep lane count/empty state in sync.');
    });
});

evo_ui_group('forms', function (): void {
    evo_ui_test('config forms support csv list fields', function (): void {
        $form = evo_ui_read('src/Livewire/Form.php');

        evo_ui_assert_contains("'csv' => \$this->castCsvValue(\$value),", $form, 'Form must cast csv fields before config persistence.');
        evo_ui_assert_contains('protected function castCsvValue(mixed $value): array', $form, 'Form must expose a csv casting helper.');
        evo_ui_assert_contains("(\$field['type'] ?? null) === 'csv' && is_array(\$value)", $form, 'Form must render array config values as comma-separated text.');
    });

    evo_ui_test('config forms do not persist display-only fields', function (): void {
        $service = evo_ui_read('src/Support/ConfigFormService.php');

        evo_ui_assert_contains("(\$field['save'] ?? true) === false", $service, 'Config forms must skip save=false fields before writing config files.');
    });

    evo_ui_test('forms expose dirty-state and resource-parent events', function (): void {
        $form = evo_ui_read('src/Livewire/Form.php');
        $js = evo_ui_read('resources/js/evo-ui.js');
        $field = evo_ui_read('views/components/form/field.blade.php');

        evo_ui_assert_contains('public bool $dirty = false;', $form, 'Form component must expose dirty state.');
        evo_ui_assert_contains('public function updatedData', $form, 'Form component must recalculate dirty state after field updates.');
        evo_ui_assert_contains('dataSnapshot($this->data)', $form, 'Form dirty state must compare normalized snapshots.');
        evo_ui_assert_contains("dispatch('evo-ui:form.saving'", $form, 'Form component must dispatch saving events.');
        evo_ui_assert_contains("dispatch('evo-ui:form.saved'", $form, 'Form component must dispatch saved events.');
        evo_ui_assert_contains("dispatch('evo-ui:form.reset'", $form, 'Form component must dispatch reset events.');
        evo_ui_assert_contains("dispatch('evo-ui:resource-parent.rejected'", $form, 'Resource parent loop guards must dispatch rejected events.');
        evo_ui_assert_contains("dispatch('evo-ui:resource-parent.selected'", $form, 'Resource parent selections must dispatch selected events.');
        evo_ui_assert_contains('data-evo-form-dirty', $js, 'Runtime must expose a dirty-state marker for forms.');
        evo_ui_assert_contains('data-evo-resource-parent', $field, 'Resource parent fields must render a shared picker root marker.');
        evo_ui_assert_contains('data-evo-resource-parent-input', $field, 'Resource parent fields must expose the hidden value input marker.');
        evo_ui_assert_contains('data-evo-resource-parent-trigger', $field, 'Resource parent fields must expose the picker trigger marker.');
    });

    evo_ui_test('form field view supports catalogue field markers', function (): void {
        $field = evo_ui_read('views/components/form/field.blade.php');

        foreach ([
            'customFieldView($field)' => 'Custom fields must resolve through the controller.',
            "in_array(\$type, ['color', 'color-picker'], true)" => 'Form fields must support color-picker aliases.',
            'evo-ui-color-field__picker' => 'Color fields must render a native color picker.',
            'evo-ui-color-field__input' => 'Color fields must render a hex text input.',
            "\$type === 'resource-parent'" => 'Resource parent field contract must be rendered.',
            "\$type === 'multi-checkbox'" => 'Multi-checkbox field contract must be rendered.',
            "\$type === 'config-map'" => 'Config-map field contract must be rendered.',
            'addConfigMapItem' => 'Config-map fields must expose add behavior.',
            'removeConfigMapItem' => 'Config-map fields must expose delete behavior.',
            "'datetime' => 'datetime-local'" => 'Datetime fields must render as datetime-local inputs.',
            "\$hintText = !empty(\$field['hint']) ? __(\$field['hint']) : '';" => 'Form fields must normalize visible hint text.',
            "@if(\$hintText !== '')" => 'Form fields must render hints for all field types, including checkboxes.',
            "field['hint_html']" => 'Form fields must support trusted HTML hints for package translations.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $field, $message);
        }

        evo_ui_assert_not_contains("&& \$type !== 'checkbox'", $field, 'Checkbox fields must not suppress visible hints.');
    });

    evo_ui_test('modal fields support choices, media, editor, builder and color contracts', function (): void {
        $modalField = evo_ui_read('views/components/table/module/modal-field.blade.php');
        $modal = evo_ui_read('views/components/table/module/form-modal.blade.php');
        $js = evo_ui_read('resources/js/evo-ui.js');

        foreach ([
            "\$type === 'choices'" => 'Modal fields must support choices fields.',
            'class="evo-ui-choices"' => 'Modal choices fields must render the shared choices control.',
            "\$type === 'image'" => 'Modal fields must support image fields.',
            "\$nestedType === 'image' || \$nestedType === 'file'" => 'Modal builder nested fields must support file fields.',
            "\$type === 'editor'" => 'Modal fields must support editor fields.',
            "\$type === 'builder'" => 'Modal fields must support builder fields.',
            "in_array(\$type, ['color', 'color-picker'], true)" => 'Modal fields must support color-picker aliases.',
            'data-evo-rich-editor-model' => 'Editor fields must expose the Livewire model marker.',
            '$modalNotices' => 'Modal form must support configured notice blocks.',
            'evo-ui-modal__notices' => 'Modal notices must render in a dedicated container.',
            'placeholder="{{ $placeholder }}"' => 'Top-level modal fields must render configured placeholders.',
            'EvoUI.browseImageField' => 'Image fields must open through the shared media bridge.',
            'EvoUI.browseMediaField' => 'File fields must open through the shared media bridge.',
            'EvoUI.syncRichEditors($el, $wire).then(() => $wire.saveModal())' => 'Modal submit must sync editors before save.',
        ] as $marker => $message) {
            $haystack = in_array($marker, [
                '$modalNotices',
                'evo-ui-modal__notices',
                'EvoUI.syncRichEditors($el, $wire).then(() => $wire.saveModal())',
            ], true) ? $modal : $modalField;

            evo_ui_assert_contains($marker, $haystack, $message);
        }

        evo_ui_assert_contains('window.EvoUI.syncRichEditors = syncRichEditors', $js, 'Runtime must expose rich editor sync.');
        evo_ui_assert_contains('window.EvoUI.browseMediaField = browseMediaField', $js, 'Runtime must expose file media picker bridge.');
        evo_ui_assert_contains('window.EvoUI.browseImageField = function (inputId)', $js, 'Runtime must expose image picker bridge.');
    });

    evo_ui_test('custom field registry resolves view, name and type overrides', function (): void {
        $evoUi = evo_ui_read('src/EvoUI.php');
        $form = evo_ui_read('src/Livewire/Form.php');

        evo_ui_assert_contains('public function registerFormField', $evoUi, 'EvoUI must expose custom form field registration.');
        evo_ui_assert_contains('public function formFieldView', $evoUi, 'EvoUI must expose custom form field view resolution.');
        evo_ui_assert_contains("\$field['view'] ?? null", $evoUi, 'Custom fields must be able to specify a direct view.');
        evo_ui_assert_contains('$this->formFields[$name]', $evoUi, 'Custom field views must resolve by field name.');
        evo_ui_assert_contains('$this->formFields[$type]', $evoUi, 'Custom field views must resolve by field type.');
        evo_ui_assert_contains('public function customFieldView(array $field): ?string', $form, 'Form controller must expose custom view lookup to Blade.');
        evo_ui_assert_contains('app(EvoUI::class)->formFieldView($field)', $form, 'Form controller must delegate custom view lookup to EvoUI.');
    });

    evo_ui_test('form casting covers config-map, csv, datetime and resource parent values', function (): void {
        $form = evo_ui_read('src/Livewire/Form.php');

        foreach ([
            "'config-map' => \$this->castConfigMapValue(\$field, \$value)," => 'Form must cast config-map values before save.',
            "'csv' => \$this->castCsvValue(\$value)," => 'Form must cast CSV values before save.',
            "'datetime' => \$this->castDateTimeValue(\$value)," => 'Form must cast datetime values before save.',
            "'resource-parent' => max(0, (int) \$value)," => 'Form must normalize resource parent ids before save.',
            'protected function castConfigMapValue(array $field, mixed $value): array' => 'Form must expose config-map casting helper.',
            'protected function castCsvValue(mixed $value): array' => 'Form must expose CSV casting helper.',
            'protected function castDateTimeValue(mixed $value): int' => 'Form must expose datetime casting helper.',
            'protected function normalizeConfigMapItem' => 'Config-map values must normalize child fields.',
            'protected function uniqueConfigMapKey' => 'Config-map add behavior must avoid duplicate keys.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $form, $message);
        }
    });
});

if ($failed > 0) {
    exit(1);
}

echo "OK {$passed} tests\n";
