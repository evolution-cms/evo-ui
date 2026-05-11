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
        evo_ui_assert_same('php tests/consumer-drift.php', $composer['scripts']['drift'] ?? null, 'Composer drift script must run the consumer drift checker.');
        evo_ui_assert_same('php tests/consumer-drift.php --release-gate', $composer['scripts']['release-gate'] ?? null, 'Composer release-gate script must run the four-module drift gate.');
        evo_ui_assert(in_array('src/Livewire/Foundation/bootstrap.php', $composer['autoload']['files'] ?? [], true), 'Livewire foundation bootstrap must be autoloaded.');
        evo_ui_assert(isset($composer['autoload']['psr-4']['EvoUI\\']), 'EvoUI namespace must be registered.');
    });

    evo_ui_test('service provider does not register a manager module', function (): void {
        $provider = evo_ui_read('src/EvoUIServiceProvider.php');

        evo_ui_assert_not_contains('registerRoutingModule', $provider, 'evo-ui must not register a routing module.');
        evo_ui_assert_not_contains('registerModule(', $provider, 'evo-ui must not register a manager module.');
        evo_ui_assert_contains("Livewire::component('evo-ui.table'", $provider, 'Table Livewire component must be registered.');
        evo_ui_assert_contains("Livewire::component('evo-ui.form'", $provider, 'Form Livewire component must be registered.');
        evo_ui_assert_contains("Livewire::component('evo-ui.module-table'", $provider, 'Module table Livewire component must be registered.');
        evo_ui_assert_contains("Livewire::component('evo-ui.issue-workspace'", $provider, 'Issue workspace Livewire component must be registered.');
    });
});

evo_ui_group('documentation', function (): void {
    evo_ui_test('localized dDocs guides follow the package documentation contract', function (): void {
        $readme = evo_ui_read('docs/README.md');

        foreach (['en', 'uk', 'ua', 'de', 'fr', 'pl'] as $language) {
            foreach (['README.md', 'user-guide.md', 'developer-guide.md', 'frontend-guide.md'] as $file) {
                evo_ui_assert(is_file(evo_ui_path('docs/' . $language . '/' . $file)), 'dDocs localized guide missing: ' . $language . '/' . $file);
            }

            $localized = evo_ui_read('docs/' . $language . '/README.md');
            foreach (['user-guide.md', 'developer-guide.md', 'frontend-guide.md'] as $guide) {
                evo_ui_assert_contains('(' . $guide . ')', $localized, 'Localized README must link to ' . $guide . ' for ' . $language . '.');
            }
        }

        foreach (['README.md', 'user-guide.md', 'developer-guide.md', 'frontend-guide.md'] as $file) {
            evo_ui_assert_contains('`' . $file . '`', $readme, 'Root README must describe dDocs file: ' . $file);
        }

        $developer = evo_ui_read('docs/en/developer-guide.md');
        $frontend = evo_ui_read('docs/en/frontend-guide.md');
        evo_ui_assert_contains('```blade', $developer, 'Developer guide must use fenced Blade examples.');
        evo_ui_assert_contains('```php', $developer, 'Developer guide must use fenced PHP examples.');
        evo_ui_assert_contains('```bash', $developer, 'Developer guide must use fenced Bash examples.');
        evo_ui_assert_contains('```css', $frontend, 'Frontend guide must use fenced CSS examples.');
        evo_ui_assert_contains('dDocs intentionally uses a documentation workspace', evo_ui_read('docs/en/user-guide.md'), 'User guide must document the dDocs no-top-tabs exception.');
    });

    evo_ui_test('component catalogue freezes WebUI layer ownership and primitive rules', function (): void {
        $docs = evo_ui_read('docs/components.md');
        $audit = evo_ui_read('docs/component-completion-audit.md');
        $readme = evo_ui_read('docs/README.md');
        $dnd = evo_ui_read('docs/dnd-reorder-contract.md');
        $dndGuide = evo_ui_read('docs/dnd-implementation-guide.md');

        foreach ([
            '# Components And UI Kit' => 'Component catalogue must be the canonical UI-kit guide.',
            '## Layer Ownership' => 'Layer ownership rules must be documented.',
            '`evo-ui` owns:' => 'evo-ui ownership must be explicit.',
            'The consuming module owns:' => 'Consumer ownership must be explicit.',
            '## Component Inventory' => 'Component inventory must exist.',
            '## Buttons' => 'Button contract must be documented.',
            'A Save button should look the' => 'Save button standard must be explicit.',
            '## Row Actions' => 'Row action contract must be documented.',
            '## DnD And Reorder' => 'DnD/reorder contract must be documented.',
            'dnd-reorder-contract.md' => 'Component catalogue must link to the detailed DnD contract.',
            'dnd-implementation-guide.md' => 'Component catalogue must link to the DnD implementation guide.',
            '## Module Tabs' => 'Module tab contract must be documented.',
            'x-evo::module-tab-shell' => 'Guarded module tab shell must be documented.',
            'pendingTab' => 'Consumers must be warned not to duplicate tab dirty-state internals.',
            'dDocs is a documented exception' => 'dDocs no-top-tabs exception must be documented.',
            '## Forms' => 'Form contract must be documented.',
            'x-evo::settings-row' => 'Compact settings row primitive must be documented.',
            '`density`' => 'Compact form density must be documented.',
            '## Fields' => 'Field contract must be documented.',
            '## Tables And Lists' => 'Table/list contract must be documented.',
            '## Modals' => 'Modal contract must be documented.',
            '## Dashboard Cards' => 'Dashboard card primitive must be documented.',
            'x-evo::dashboard-card' => 'Dashboard card component must be documented.',
            'span="6"' => 'Dashboard half-width span must be documented.',
            '## Builders And Reorder' => 'Builder/reorder contract must be documented.',
            'x-evo::builder' => 'Builder primitive must be documented.',
            '## Editor And Media Helpers' => 'Runtime helper contract must be documented.',
            '## Embedded Resource Screens' => 'Embedded resource boundary must be documented.',
            '## Anti-Drift Rules' => 'Anti-drift rules must be documented.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $docs, $message);
        }

        foreach ([
            'Bootstrap/CDN/jQuery/legacy manager assets',
            'duplicated Save button markup',
            'temporary scoped bridge code with a visible follow-up task',
        ] as $marker) {
            evo_ui_assert_contains($marker, $docs, 'Anti-drift guide missing marker: ' . $marker);
        }

        evo_ui_assert_contains('[Components And UI Kit](components.md)', $readme, 'Docs README must link to the canonical UI-kit guide.');
        evo_ui_assert_contains('[DnD And Reorder Contract](dnd-reorder-contract.md)', $readme, 'Docs README must link to the DnD reorder contract.');
        evo_ui_assert_contains('[DnD Implementation Guide](dnd-implementation-guide.md)', $readme, 'Docs README must link to the DnD implementation guide.');
        evo_ui_assert_contains('[Embedded Resource Contract](embedded-resource-contract.md)', $readme, 'Docs README must link to the embedded resource contract.');
        evo_ui_assert_contains('[Editor Media Adapter Contract](editor-media-adapter-contract.md)', $readme, 'Docs README must link to the editor/media adapter contract.');
        evo_ui_assert_contains('[Consumer Drift Guards](consumer-drift-guards.md)', $readme, 'Docs README must link to consumer drift guards.');
        evo_ui_assert_contains('[Component Completion Audit](component-completion-audit.md)', $readme, 'Docs README must link to the component completion audit.');
        evo_ui_assert_contains('## Remaining Drift From Consumers', $audit, 'Component audit must summarize consumer drift.');
        evo_ui_assert_contains('dDocs remains a documented UX exception', $audit, 'Component audit must keep the dDocs no-top-tabs exception explicit.');

        foreach ([
            'sSettings Configure donor implementation' => 'DnD docs must name the donor implementation.',
            'data-evo-dnd' => 'DnD docs must define the shared root marker.',
            'data-evo-dnd-group' => 'DnD docs must define group markers.',
            'data-evo-dnd-item' => 'DnD docs must define item markers.',
            'data-evo-dnd-option-list' => 'DnD docs must define modal option-list markers.',
            'sortTabByUid(string $groupUid, int $position): void' => 'DnD docs must define group Livewire method shape.',
            'sortFieldByUid(string $itemUid, int $position, string $targetGroupUid): void' => 'DnD docs must define nested item Livewire method shape.',
            'real row for `setDragImage`' => 'DnD docs must require real-row drag previews.',
            'physical placeholder' => 'DnD docs must require physical placeholders.',
            'structural dirty event' => 'DnD docs must define dirty-state integration.',
            'must stay within their current panel width on mobile' => 'DnD docs must document mobile overflow constraints.',
            'Table rows that support provider reorder hooks' => 'DnD docs must cover table reorder standard.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $dnd, $message);
        }

        foreach ([
            '# DnD Implementation Guide' => 'DnD guide must exist.',
            '## Decision Table' => 'DnD guide must include a decision table.',
            '## Nested Groups' => 'DnD guide must document nested groups.',
            'sortTabByUid' => 'DnD guide must document group method mapping.',
            'sortFieldByUid' => 'DnD guide must document item method mapping.',
            'x-evo::dnd-option-list' => 'DnD guide must document modal option-list primitive.',
            'x-evo::dnd-option-row' => 'DnD guide must document modal option-row primitive.',
            'ModuleTable renders the shared table rail' => 'DnD guide must document table reorder adoption.',
            'evo-ui:form.dirty' => 'DnD guide must document dirty-state integration.',
            'Do not create module-local CSS or JavaScript' => 'DnD guide must include anti-drift rules.',
            'Adoption Checklist' => 'DnD guide must include an adoption checklist.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $dndGuide, $message);
        }
    });

    evo_ui_test('module integration docs prescribe guarded tab shell', function (): void {
        $docs = evo_ui_read('docs/module-integration.md');

        foreach ([
            '<x-evo::module-tab-shell :tabs="$tabs" model="activeTab">' => 'Manager shell example must use the guarded module tab shell.',
            'EvoUI.form.waitForClean' => 'Module integration docs must bind tab changes to the form clean-state bridge.',
            'should not duplicate `pendingTab`, `showUnsavedPrompt`, `saveAndSwitch`' => 'Consumers must not duplicate guarded tab internals.',
            'dDocs is the documented exception' => 'dDocs no-top-tabs exception must stay explicit.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $docs, $message);
        }
    });

    evo_ui_test('embedded resource contract freezes resource-tab exception', function (): void {
        $docs = evo_ui_read('docs/embedded-resource-contract.md');
        $components = evo_ui_read('docs/components.md');

        foreach ([
            '# Embedded Resource Contract' => 'Embedded resource contract must exist.',
            '`sLang` multilingual resource tabs' => 'Contract must name the sLang resource-tab consumer.',
            '`sSeo` resource/module SEO fields' => 'Contract must name the sSeo resource-tab consumer.',
            '`documentDirty`' => 'Contract must document the legacy dirty-state bridge.',
            '`tinymce`, `CodeMirror` and `myCodeMirrors`' => 'Contract must document legacy editor globals.',
            '## Allowed' => 'Contract must include an allowlist.',
            '## Forbidden' => 'Contract must include a denylist.',
            'must not:' => 'Contract must state forbidden behavior clearly.',
            'render `x-evo::layout`' => 'Embedded resource tabs must not render the full evo-ui layout.',
            'include `evo::partials.assets` as a full manager shell' => 'Embedded resource tabs must not include full shell assets.',
            'expose `data-evo-ui-root`' => 'Embedded resource tabs must not expose the full root marker.',
            'data-evo-resource-embedded' => 'Contract must define the explicit embedded resource marker.',
            'scoped bridge JavaScript' => 'Contract must keep resource bridge JS scoped.',
            'same payload names as before' => 'Contract must preserve resource submit payloads.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $docs, $message);
        }

        foreach ([
            '[Embedded Resource Contract](embedded-resource-contract.md)',
            'data-evo-resource-embedded',
            'data-evo-ui-root',
        ] as $marker) {
            evo_ui_assert_contains($marker, $components, 'Components docs missing embedded resource marker: ' . $marker);
        }
    });

    evo_ui_test('editor media adapter contract freezes shared editor lifecycle', function (): void {
        $docs = evo_ui_read('docs/editor-media-adapter-contract.md');
        $components = evo_ui_read('docs/components.md');

        foreach ([
            '# Editor Media Adapter Contract' => 'Editor/media contract must exist.',
            'window.EvoUI.initRichEditorField(root)' => 'Contract must document rich editor init.',
            'window.EvoUI.syncRichEditors(form, wire)' => 'Contract must document rich editor sync.',
            'window.EvoUI.clearRichEditors(form)' => 'Contract must document rich editor clearing.',
            'window.EvoUI.browseMediaField(inputId, mode)' => 'Contract must document media picker bridge.',
            'window.EvoUI.browseImageField(inputId)' => 'Contract must document image picker bridge.',
            'EvoUI\\Support\\RichTextEditor::html' => 'Contract must document server-side editor helper.',
            'data-evo-rich-editor' => 'Contract must document rich editor marker.',
            'data-evo-rich-editor-model' => 'Contract must document Livewire model marker.',
            'data-evo-media-bridge' => 'Contract must document media bridge marker.',
            '`dTuiEditor`' => 'Contract must name dTui editor support.',
            'Evolution/TinyMCE adapters' => 'Contract must name TinyMCE adapter support.',
            'CodeMirror and `window.myCodeMirrors`' => 'Contract must name CodeMirror boundary.',
            '`sSeo` Robots' => 'Contract must name the sSeo specialized code editor.',
            '`dDocs` owns its Markdown viewer/editor workspace' => 'Contract must name the dDocs workspace boundary.',
            'Do not bypass `EvoUI.syncRichEditors`' => 'Contract must forbid unsynced editor saves.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $docs, $message);
        }

        evo_ui_assert_contains('[Editor Media Adapter Contract](editor-media-adapter-contract.md)', $components, 'Components docs must link to the editor/media contract.');
    });

    evo_ui_test('consumer drift guard docs describe report, strict and allowlist workflow', function (): void {
        $docs = evo_ui_read('docs/consumer-drift-guards.md');
        $testing = evo_ui_read('docs/testing.md');
        $release = evo_ui_read('docs/release-checklist.md');

        foreach ([
            '# Consumer Drift Guards' => 'Consumer drift guard docs must exist.',
            'composer drift' => 'Docs must expose the report command.',
            'composer release-gate' => 'Docs must expose the four-module release gate command.',
            'php tests/consumer-drift.php --strict' => 'Docs must expose strict mode.',
            'php tests/consumer-drift.php --release-gate' => 'Docs must expose release gate mode.',
            'php tests/consumer-drift.php --json' => 'Docs must expose JSON output.',
            'tests/consumer-drift-allowlist.php' => 'Docs must explain the allowlist.',
            'inline `<style>` blocks' => 'Docs must flag inline style drift.',
            'inline `<script>` blocks' => 'Docs must flag inline script drift.',
            'remote CDN asset markers' => 'Docs must flag CDN drift.',
            'legacy manager asset markers' => 'Docs must flag legacy asset drift.',
            'Embedded Resource Contract' => 'Docs must reference embedded resource exceptions.',
            'Editor Media Adapter Contract' => 'Docs must reference editor/media exceptions.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $docs, $message);
        }

        evo_ui_assert_contains('composer drift', $testing, 'Testing matrix must include drift report command.');
        evo_ui_assert_contains('composer release-gate', $testing, 'Testing matrix must include release gate command.');
        evo_ui_assert_contains('composer drift', $release, 'Release checklist must include drift report review.');
        evo_ui_assert_contains('composer release-gate', $release, 'Release checklist must include release gate command.');
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
            'window.EvoUI.initBuilder = initBuilder',
            'window.EvoUI.builderPayload = evoBuilderPayload',
            'window.EvoUI.initIssueKanban = initIssueKanban',
            'window.EvoUI.syncRichEditors = syncRichEditors',
            'window.EvoUI.browseMediaField = browseMediaField',
            'window.EvoUI.theme = {',
        ] as $marker) {
            evo_ui_assert_contains($marker, $js, 'Missing public EvoUI JS marker: ' . $marker);
        }
    });
});

evo_ui_group('drift-guards', function (): void {
    evo_ui_test('consumer drift checker exposes report, strict and allowlist controls', function (): void {
        $script = evo_ui_read('tests/consumer-drift.php');
        $allowlist = evo_ui_read('tests/consumer-drift-allowlist.php');

        foreach ([
            "\$consumers = ['sArticles', 'dIssues', 'sLang', 'sSeo', 'sSettings', 'dDocs'];" => 'Drift checker must scan the known Extras consumers.',
            "\$strict = in_array('--strict', \$argv, true);" => 'Drift checker must support strict mode.',
            "\$json = in_array('--json', \$argv, true);" => 'Drift checker must support JSON output.',
            "\$releaseGate = in_array('--release-gate', \$argv, true);" => 'Drift checker must support release gate mode.',
            'Four-module release gate: evo-ui, sSeo, sLang, sSettings' => 'Drift checker must print a release summary.',
            "'inline-style'" => 'Drift checker must flag inline style blocks.',
            "'inline-script'" => 'Drift checker must flag inline script blocks.',
            "'cdn-asset'" => 'Drift checker must flag CDN assets.',
            "'legacy-manager-asset'" => 'Drift checker must flag legacy manager assets.',
            "'local-evo-ui-style'" => 'Drift checker must flag consumer styling of evo-ui atoms.',
            'consumer-drift-allowlist.php' => 'Drift checker must load the allowlist.',
            'Report mode only. Use --strict after consumer cleanup or allowlisting.' => 'Drift checker must explain report-mode behavior.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $script, $message);
        }

        evo_ui_assert_contains('return [', $allowlist, 'Allowlist must be a PHP array.');
        evo_ui_assert_contains("'_releaseGate'", $allowlist, 'Allowlist must define release gate metadata.');
        evo_ui_assert_contains("'modules' => ['evo-ui', 'sSeo', 'sLang', 'sSettings']", $allowlist, 'Allowlist must name the four release modules.');
        evo_ui_assert_contains('task-owned', $allowlist, 'Allowlist must document task ownership.');
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

evo_ui_group('builder', function (): void {
    evo_ui_test('builder primitives expose reorder, drag and Livewire markers', function (): void {
        $builder = evo_ui_read('views/components/builder.blade.php');
        $row = evo_ui_read('views/components/builder-row.blade.php');
        $rail = evo_ui_read('views/components/reorder-rail.blade.php');
        $js = evo_ui_read('resources/js/evo-ui.js');
        $css = evo_ui_read('resources/css/evo-ui.css');

        foreach ([
            'data-evo-builder' => 'Builder root must expose a stable runtime marker.',
            'data-evo-builder-type' => 'Builder root must expose type metadata.',
            'data-evo-builder-reorder-method' => 'Builder root must expose Livewire reorder method metadata.',
            'window.EvoUI?.initBuilder?.($el)' => 'Builder root must initialize the shared runtime.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $builder, $message);
        }

        foreach ([
            'data-evo-builder-row' => 'Builder row must expose a stable row marker.',
            'data-evo-builder-id' => 'Builder row must expose id metadata.',
            'data-evo-builder-row-type' => 'Builder row must expose type metadata.',
            'draggable' => 'Builder row must opt into native drag/drop.',
            'evo-ui-builder-summary' => 'Builder row must render the shared summary atom.',
            'evo-ui-builder-chip' => 'Builder row must render the shared chip atom.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $row, $message);
        }

        foreach ([
            'data-evo-reorder-rail' => 'Reorder rail must expose a stable marker.',
            'data-evo-drag-handle' => 'Reorder rail must expose the shared drag handle marker.',
            'data-evo-dnd-handle' => 'Reorder rail must expose the generic DnD handle marker.',
            'wire:click="{{ $moveUp }}"' => 'Reorder rail must support fallback move-up actions.',
            'wire:click="{{ $moveDown }}"' => 'Reorder rail must support fallback move-down actions.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $rail, $message);
        }

        foreach ([
            'function initBuilder(rootElement)' => 'Runtime must expose a generic builder initializer.',
            'function evoBuilderPayload(rootElement)' => 'Runtime must expose a normalized payload helper.',
            "target.querySelectorAll('[data-evo-builder]').forEach(initBuilder)" => 'Runtime init must discover builder roots.',
            "component.call(method, evoBuilderPayload(rootElement))" => 'Runtime must call the configured Livewire reorder method.',
            'data-evo-builder-placeholder' => 'Runtime must create a shared placeholder marker.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $js, $message);
        }

        foreach ([
            '.evo-ui-builder',
            '.evo-ui-builder-list',
            '.evo-ui-builder-row',
            '.evo-ui-builder-row.is-dragging',
            '.evo-ui-builder-placeholder',
            '.evo-ui-reorder-rail',
            '.evo-ui-drag-handle',
            '.evo-ui-dnd',
            '.evo-ui-dnd-list',
            '.evo-ui-dnd-row',
            '.evo-ui-dnd-group-row',
            '.evo-ui-dnd-option-row',
            '.evo-ui-dnd-placeholder',
            '[data-evo-dnd-placeholder]',
            '.evo-ui-dnd-handle',
            '.evo-ui-dnd-actions',
            '.evo-ui-row-actions--compact',
            '.evo-ui-dnd-key',
            '.evo-ui-dnd-badge',
            '.evo-ui-builder-summary',
            '.evo-ui-builder-chip',
            '.evo-ui-builder-modal',
        ] as $marker) {
            evo_ui_assert_contains($marker, $css, 'Missing builder CSS marker: ' . $marker);
        }
    });

    evo_ui_test('native dnd runtime exposes nested reorder contract', function (): void {
        $js = evo_ui_read('resources/js/evo-ui.js');

        foreach ([
            'function initDnd(rootElement)' => 'Runtime must expose a generic DnD initializer.',
            "target.querySelectorAll('[data-evo-dnd]').forEach(initDnd)" => 'Runtime init must discover DnD roots.',
            'window.EvoUI.initDnd = initDnd' => 'Runtime must expose initDnd for morph/manual reinit.',
            "group: dndSelector(rootElement, 'group', '[data-evo-dnd-group]')" => 'Runtime must define group markers.',
            "item: dndSelector(rootElement, 'item', '[data-evo-dnd-item]')" => 'Runtime must define item markers.',
            "list: dndSelector(rootElement, 'list', '[data-evo-dnd-list]')" => 'Runtime must define item list markers.',
            "optionList: dndSelector(rootElement, 'option-list', '[data-evo-dnd-option-list]')" => 'Runtime must define modal option-list markers.',
            "optionRow: dndSelector(rootElement, 'option-row', '[data-evo-dnd-option-row]')" => 'Runtime must define modal option row markers.',
            "handle: dndSelector(rootElement, 'handle', '[data-evo-dnd-handle]')" => 'Runtime must require shared handle markers.',
            'application/x-evo-dnd' => 'Runtime must use the shared dataTransfer payload type.',
            'event.dataTransfer.setDragImage' => 'Runtime must use the real row as native drag preview.',
            'data-evo-dnd-placeholder' => 'Runtime must create a physical placeholder marker.',
            'sortGroupByUid' => 'Runtime must default to the group reorder method contract.',
            'sortItemByUid' => 'Runtime must default to the item reorder method contract.',
            'markDndDirty(rootElement' => 'Runtime must mark structural changes as dirty.',
            "dispatch('dnd.changed'" => 'Runtime must emit a shared DnD change event.',
            "dispatch('dnd.option.changed'" => 'Runtime must emit option-list changes when no Livewire option method is configured.',
            'data-evo-form-dirty' => 'Runtime must integrate with guarded form dirty-state markers.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $js, $message);
        }

        foreach (['ssettings', 'sSettingsNativeDnd', '__sSettingsOptionDrag'] as $marker) {
            evo_ui_assert_not_contains($marker, $js, 'Generic DnD runtime must not depend on sSettings markers: ' . $marker);
        }
    });

    evo_ui_test('modal option-list dnd primitive exposes reusable Blade contract', function (): void {
        $list = evo_ui_read('views/components/dnd-option-list.blade.php');
        $row = evo_ui_read('views/components/dnd-option-row.blade.php');
        $docs = evo_ui_read('docs/dnd-reorder-contract.md');
        $components = evo_ui_read('docs/components.md');
        $css = evo_ui_read('resources/css/evo-ui.css');

        foreach ([
            'data-evo-dnd' => 'Option list must initialize the shared DnD runtime.',
            'data-evo-dnd-option-list' => 'Option list must expose the shared option-list marker.',
            'data-evo-dnd-option-method' => 'Option list must expose the optional Livewire sort method.',
            'window.EvoUI?.initDnd?.($el)' => 'Option list must reinitialize through the public DnD API.',
            'evo-ui-dnd-option-list__header' => 'Option list must render an optional compact header.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $list, $message);
        }

        foreach ([
            'data-evo-dnd-option-row' => 'Option row must expose the shared row marker.',
            'data-evo-dnd-uid' => 'Option row must expose stable local UID metadata.',
            'draggable' => 'Option row must opt into native drag/drop.',
            'x-evo::reorder-rail' => 'Option row must use the shared reorder rail.',
            'wire:model.live="{{ $valueName }}"' => 'Option row must render a value input binding.',
            'wire:model.live="{{ $labelName }}"' => 'Option row must render a label input binding.',
            'data-evo-dnd-option-value' => 'Option row must expose value field marker.',
            'data-evo-dnd-option-label' => 'Option row must expose label field marker.',
            'wire:click="{{ $addAfter }}"' => 'Option row must support add-after actions.',
            'wire:click="{{ $delete }}"' => 'Option row must support delete actions.',
            'evo-ui-dnd-actions evo-ui-row-actions--compact' => 'Option row must use compact shared actions.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $row, $message);
        }

        foreach ([
            'x-evo::dnd-option-list',
            'x-evo::dnd-option-row',
            'value/label inputs',
            'add-after action',
            'delete action',
        ] as $marker) {
            evo_ui_assert_contains($marker, $docs . $components, 'Option-list docs missing marker: ' . $marker);
        }

        foreach ([
            '.evo-ui-dnd-option-list__header',
            '.evo-ui-dnd-option-list__label',
            '.evo-ui-dnd-option-list__hint',
            '.evo-ui-dnd-option-row__fields',
        ] as $marker) {
            evo_ui_assert_contains($marker, $css, 'Missing option-list CSS marker: ' . $marker);
        }
    });
});

evo_ui_group('state', function (): void {
    evo_ui_test('guarded module tab shell owns dirty navigation prompt', function (): void {
        $shell = evo_ui_read('views/components/module-tab-shell.blade.php');

        foreach ([
            'data-evo-module-tab-shell' => 'Module tab shell must expose a stable root marker.',
            'data-evo-module-tab-model' => 'Module tab shell must expose the bound Livewire model marker.',
            '$wire.entangle(@js($model)).live' => 'Module tab shell must entangle the active tab with Livewire.',
            'requestModuleTab(tab)' => 'Module tab shell must centralize tab change requests.',
            'pendingTab' => 'Module tab shell must track deferred navigation.',
            'showUnsavedPrompt' => 'Module tab shell must own the unsaved prompt state.',
            'window.EvoUI.form.isDirty()' => 'Module tab shell must use the shared dirty-state detector.',
            "document.querySelector('[data-evo-form]')?.requestSubmit();" => 'Module tab shell must submit the active evo-ui form before switching.',
            'window.EvoUI.form.waitForClean' => 'Module tab shell must wait for the shared clean-state bridge.',
            'x-on:evo-ui:form.saved.window="afterSaved()"' => 'Module tab shell must listen for saved events.',
            'data-evo-module-tab-unsaved' => 'Module tab shell must expose the shared unsaved modal marker.',
            "evo::global.unsaved_changes_title" => 'Module tab shell must use shared translations for prompt title.',
            "evo::global.action_discard" => 'Module tab shell must use shared translations for discard.',
            "evo::global.action_save" => 'Module tab shell must use shared translations for save.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $shell, $message);
        }
    });

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

    evo_ui_test('module table supports provider toolbar actions in the controls lane', function (): void {
        $moduleTable = evo_ui_read('src/Livewire/ModuleTable.php');
        $toolbar = evo_ui_read('views/components/table/module/toolbar.blade.php');

        evo_ui_assert_contains('public function runTableAction', $moduleTable, 'ModuleTable must expose a Livewire toolbar action handler.');
        evo_ui_assert_contains("\$this->tableConfig('actions', [])", $moduleTable, 'ModuleTable toolbar actions must be validated against configured actions.');
        evo_ui_assert_contains("\$action['provider']", $moduleTable, 'ModuleTable toolbar actions must call configured provider methods.');
        evo_ui_assert_contains('runTableAction(@js($action[\'key\'] ?? \'\'))', $toolbar, 'Provider toolbar actions must call runTableAction without iframe reload.');
        evo_ui_assert_contains("\$controlActions", $toolbar, 'Module toolbar must support actions placed in the controls lane.');
        evo_ui_assert_contains("(string) (\$action['placement'] ?? '') === 'controls'", $toolbar, 'Module toolbar must route controls-placement actions next to search controls.');
    });

    evo_ui_test('module table exposes filtering, sorting, pagination and view state methods', function (): void {
        $moduleTable = evo_ui_read('src/Livewire/ModuleTable.php');
        $moduleTableView = evo_ui_read('views/components/table/module.blade.php');
        $genericTable = evo_ui_read('views/components/table.blade.php');
        $toolbar = evo_ui_read('views/components/table/module/toolbar.blade.php');
        $genericToolbar = evo_ui_read('views/components/table/toolbar.blade.php');
        $pagination = evo_ui_read('views/components/table/pagination.blade.php');
        $header = evo_ui_read('views/components/table/header-cell.blade.php');
        $css = evo_ui_read('resources/css/evo-ui.css');

        foreach (['applyMultiFilter', 'applySelectFilter', 'applyDateRangeFilter', 'setSort', 'switchView'] as $method) {
            evo_ui_assert_contains('function ' . $method, $moduleTable, 'ModuleTable must expose method: ' . $method);
        }

        evo_ui_assert_contains('wire:model.live="perPage"', $pagination, 'Pagination must bind per-page state.');
        evo_ui_assert_contains("\$title = isset(\$config['title'])", $toolbar, 'Module table toolbar must support a config title.');
        evo_ui_assert_contains('evo-ui-table-title', $toolbar, 'Module table toolbar must render the table title atom.');
        evo_ui_assert_contains('title_icon', $toolbar, 'Module table toolbar must support an optional title icon.');
        evo_ui_assert_contains("\$titleInTableHeader = (\$config['title_placement'] ?? null) === 'table_header'", $moduleTableView, 'Module table must support placing the title toolbar inside the table header surface.');
        evo_ui_assert_contains('evo-ui-table-wrap--with-toolbar', $moduleTableView, 'Module table must expose an attached toolbar wrapper state.');
        evo_ui_assert_contains('table-header', $moduleTableView, 'Module table must pass the table-header toolbar variant.');
        evo_ui_assert_contains("'tableHeader' => false", $toolbar, 'Module table toolbar must accept the table header variant.');
        evo_ui_assert_contains("\$title = isset(\$config['title'])", $genericToolbar, 'Generic table toolbar must support a config title.');
        evo_ui_assert_contains('evo-ui-table-title', $genericToolbar, 'Generic table toolbar must render the table title atom.');
        evo_ui_assert_contains("\$titleInTableHeader = (\$config['title_placement'] ?? null) === 'table_header'", $genericTable, 'Generic table must support placing the title toolbar inside the table header surface.');
        evo_ui_assert_contains('evo-ui-table-wrap--with-toolbar', $genericTable, 'Generic table must expose an attached toolbar wrapper state.');
        evo_ui_assert_contains('table-header', $genericTable, 'Generic table must pass the table-header toolbar variant.');
        evo_ui_assert_contains("'tableHeader' => false", $genericToolbar, 'Generic table toolbar must accept the table header variant.');
        evo_ui_assert_contains('.evo-ui-table-title', $css, 'Table title must have a shared evo-ui style.');
        evo_ui_assert_contains('.evo-ui-table-toolbar--table-header', $css, 'Attached table title toolbar must have shared evo-ui CSS.');
        evo_ui_assert_contains('.evo-ui-table-wrap--with-toolbar', $css, 'Attached table title toolbar must reuse the table surface frame.');
        evo_ui_assert_contains(".evo-ui .tab-content {\n    box-sizing: border-box;", $css, 'Module tab content must keep stable padding and sizing.');
        evo_ui_assert_contains(".evo-ui .evo-ui-tabs {\n    width: 100%;\n    min-height: 0;", $css, 'Module tab wrapper must not force viewport height and create false scrollbars.');
        evo_ui_assert_contains("min-height: 0;\n    padding: 18px 20px;", $css, 'Module tab content must not force viewport height and create false scrollbars.');
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
        evo_ui_assert_contains('evo-ui-position-control--rail', $list, 'List view position controls must use the shared rail variant.');
        evo_ui_assert_contains('evo-ui-reorder-rail--table', $list, 'List view position controls must use the shared table rail.');
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
        evo_ui_assert_contains('x-evo::reorder-rail', $cell, 'Position cells must use the shared reorder rail.');
        evo_ui_assert_contains('move-up="moveRow', $cell, 'Position cells must expose moveRow up controls.');
        evo_ui_assert_contains('move-down="moveRow', $cell, 'Position cells must expose moveRow down controls.');
        evo_ui_assert_contains('evo-ui-reorder-rail--table', $cell, 'Position cells must use the table rail visual modifier.');
        evo_ui_assert_contains('evo-ui-position-control__value evo-ui-dnd-badge', $cell, 'Position cells must render the value beside the shared rail.');
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

    evo_ui_test('issue workspace lets active filter badges bleed above icon buttons', function (): void {
        $view = evo_ui_read('views/livewire/issue-workspace.blade.php');
        $css = evo_ui_read('resources/css/evo-ui.css');

        evo_ui_assert_contains('evo-ui-filter-badge', $view, 'Workspace filter buttons must render active count badges.');

        foreach ([
            ".evo-ui-issue-workspace > .evo-ui-table-toolbar {\n    padding-top: 6px;\n    overflow: visible;\n}" => 'Workspace toolbar must reserve visible bleed space for filter badges.',
            ".evo-ui-filter-badge {\n    position: absolute;\n    top: -5px;\n    right: -5px;" => 'Filter badges must float above the icon button corner.',
            'box-shadow: 0 0 0 1px var(--evo-ui-border);' => 'Filter badges must keep the existing outlined bubble treatment.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $css, $message);
        }
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
    evo_ui_test('dashboard card primitives expose responsive span and table spacing contracts', function (): void {
        $dashboard = evo_ui_read('views/components/dashboard.blade.php');
        $card = evo_ui_read('views/components/dashboard-card.blade.php');
        $css = evo_ui_read('resources/css/evo-ui.css');

        foreach ([
            'data-evo-dashboard' => 'Dashboard root must expose a stable marker.',
            'evo-ui-dashboard__cards--divided' => 'Dashboard card groups must expose the standard divided spacing variant.',
            '<x-evo::dashboard-card' => 'Dashboard must render declarative card configs through the shared card component.',
            'data-evo-dashboard-body' => 'Dashboard must expose a body lane for following tables.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $dashboard, $message);
        }

        foreach ([
            'evo-ui-dashboard-card--span-' => 'Dashboard card must expose span classes.',
            'data-evo-dashboard-card-span' => 'Dashboard card must expose the selected span marker.',
            '$allowedSpans = [3, 4, 6, 8, 12]' => 'Dashboard card must clamp supported spans.',
            'evo-ui-dashboard-card__stats' => 'Dashboard card must render standard stat rows.',
            '<x-evo::badge :value="$badge" />' => 'Dashboard card must reuse shared badge rendering.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $card, $message);
        }

        foreach ([
            '.evo-ui-dashboard__cards {' => 'Dashboard card group CSS must exist.',
            '.evo-ui-dashboard__cards--divided {' => 'Dashboard divided spacing CSS must exist.',
            'padding-block-end: var(--evo-ui-space-4, 1rem);' => 'Dashboard card group must reserve standard spacing before body content.',
            '.evo-ui-dashboard-card--span-6 {' => 'Dashboard half-width span CSS must exist.',
            'flex: 0 1 calc(50% - (var(--evo-ui-dashboard-gap) * 0.5));' => 'Dashboard span-6 must be half width minus gap.',
            '.evo-ui-dashboard-card--span-3,' . PHP_EOL . '    .evo-ui-dashboard-card--span-4,' => 'Dashboard spans must collapse together on narrow screens.',
            'flex-basis: 100%;' => 'Dashboard spans must fall back to full width on narrow screens.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $css, $message);
        }

        evo_ui_assert_not_contains('border-block-end: 1px solid var(--evo-ui-border);', $css, 'Dashboard card divider must not add a redundant visible border.');
    });

    evo_ui_test('compact forms and settings rows expose shared visual primitives', function (): void {
        $form = evo_ui_read('views/components/form.blade.php');
        $row = evo_ui_read('views/components/settings-row.blade.php');
        $css = evo_ui_read('resources/css/evo-ui.css');
        $docs = evo_ui_read('docs/forms.md');

        foreach ([
            "'evo-ui-form-surface--density-' . \$density" => 'Form surface must expose a density class.',
            'evo-ui-form-surface--layout-' => 'Form surface must expose a layout class.',
            "'evo-ui-form-surface--heading-hidden'" => 'Form surface must expose hidden-heading state.',
            ":icon=\"\$action['icon'] ?? 'check'\"" => 'Default Save icon must be check.',
            ":tone=\"\$action['tone'] ?? 'primary'\"" => 'Default Save tone must be primary.',
            ":variant=\"\$action['variant'] ?? 'filled'\"" => 'Default Save variant must be filled.',
            ":icon-only=\"(bool) (\$action['icon_only'] ?? false)\"" => 'Default Save button must show its text label.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $form, $message);
        }

        foreach ([
            'data-evo-settings-row' => 'Settings row must expose a stable row marker.',
            'data-evo-settings-divider' => 'Settings row must expose a stable divider marker.',
            'evo-ui-settings-row__usage' => 'Settings row must render usage code.',
            'evo-ui-settings-row__description' => 'Settings row must render descriptions.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $row, $message);
        }

        foreach ([
            '.evo-ui-form-surface--density-compact' => 'CSS must style compact form density.',
            '.evo-ui-form-surface--layout-settings' => 'CSS must style shared settings form layout.',
            'grid-template-columns: minmax(8rem, 10rem) minmax(0, 1fr)' => 'Settings layout must expose compact label/control columns.',
            '.evo-ui-code-editor-field .CodeMirror' => 'CSS must style shared CodeMirror editor fields.',
            '--evo-ui-code-editor-min-height, 520px' => 'Code editor field must expose a standard useful height.',
            '.evo-ui-settings-values' => 'CSS must style settings values wrapper.',
            '.evo-ui-settings-row' => 'CSS must style settings rows.',
            '.evo-ui-settings-row__meta' => 'CSS must style settings row metadata.',
            '.evo-ui-settings-row__usage' => 'CSS must style settings usage code.',
            '.evo-ui-settings-divider' => 'CSS must style divider rows.',
            '.evo-ui-option-stack' => 'CSS must style shared option stacks.',
            '.evo-ui-media-field' => 'CSS must style media/file rows.',
            '.evo-ui-image-preview' => 'CSS must style image previews.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $css, $message);
        }

        foreach ([
            "'density' => 'compact'",
            "'layout' => 'settings'",
            'evo-ui-code-editor-field',
            'x-evo::settings-row',
            'right-aligned desktop labels',
            'mobile single-column fallback',
        ] as $marker) {
            evo_ui_assert_contains($marker, $docs, 'Forms docs missing compact settings marker: ' . $marker);
        }
    });

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

    evo_ui_test('horizontal form labels align toward their controls', function (): void {
        $css = evo_ui_read('resources/css/evo-ui.css');

        evo_ui_assert_contains('justify-content: flex-end;', $css, 'Form labels must align toward the field on horizontal layouts.');
        evo_ui_assert_contains('text-align: right;', $css, 'Form labels must right-align on horizontal layouts.');
        evo_ui_assert_contains('.evo-ui-field__label > span', $css, 'Nested label text must have its own alignment hook.');
        evo_ui_assert_contains('justify-items: end;', $css, 'Nested label text must align toward the field.');
        evo_ui_assert_contains('.evo-ui-field__label,' . PHP_EOL . '    .evo-ui-field--modal .evo-ui-field__label', $css, 'Stacked responsive labels must reset together.');
        evo_ui_assert_contains('justify-content: flex-start;' . PHP_EOL . '        text-align: left;', $css, 'Stacked responsive labels must return to natural left alignment.');
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
        $formView = evo_ui_read('views/components/form.blade.php');
        $sectionView = evo_ui_read('views/components/form/section.blade.php');
        $css = evo_ui_read('resources/css/evo-ui.css');
        evo_ui_assert_contains('showSavedToast', $formView, 'Form saves must use compact auto-dismiss toast state.');
        evo_ui_assert_contains('evo-ui-save-toast', $formView, 'Form saved feedback must render through shared toast markup.');
        evo_ui_assert_not_contains('evo-ui-alert evo-ui-alert--success" role="status"', $formView, 'Form saved feedback must not render as a wide inline alert.');
        evo_ui_assert_contains('section_columns', $formView, 'Form component must support independent section columns.');
        evo_ui_assert_contains('evo-ui-form-column-layout', $formView, 'Form component must render a column layout wrapper.');
        evo_ui_assert_contains('evo-ui-form-section--span-', $sectionView, 'Shared form section partial must preserve span classes.');
        evo_ui_assert_contains('.evo-ui-save-toast', $css, 'Shared save toast CSS must exist.');
        evo_ui_assert_contains('.evo-ui-form-column-layout', $css, 'Shared form column layout CSS must exist.');
        evo_ui_assert_contains('data-evo-form-dirty', $js, 'Runtime must expose a dirty-state marker for forms.');
        evo_ui_assert_contains('[data-evo-form-dirty="true"]:not([data-evo-form-saved="true"])', $js, 'Runtime dirty guard must ignore forms marked clean after a successful save.');
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
