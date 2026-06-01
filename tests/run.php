<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$passed = 0;
$failed = 0;
$assertions = 0;
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
    global $assertions;

    $assertions++;

    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function evo_ui_assert_same(mixed $expected, mixed $actual, string $message): void
{
    global $assertions;

    $assertions++;

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

function evo_ui_assert_order(string $first, string $second, string $haystack, string $message): void
{
    $firstPosition = strpos($haystack, $first);
    $secondPosition = strpos($haystack, $second);

    evo_ui_assert($firstPosition !== false, $message . ' Missing first marker: ' . $first);
    evo_ui_assert($secondPosition !== false, $message . ' Missing second marker: ' . $second);
    evo_ui_assert($firstPosition < $secondPosition, $message . ' First marker must appear before second marker.');
}

function evo_ui_css_block(string $selector, string $css): string
{
    $start = strpos($css, $selector . ' {');
    evo_ui_assert($start !== false, 'Expected CSS selector to exist: ' . $selector);
    $start = is_int($start) ? $start : 0;

    $end = strpos($css, "\n}", $start);
    evo_ui_assert($end !== false, 'Expected CSS selector block to close: ' . $selector);
    $end = is_int($end) ? $end : $start;

    return substr($css, $start, $end - $start + 2);
}

function evo_ui_assert_no_inline_blade_conditionals_in_opening_tags(string $path): void
{
    $contents = evo_ui_read($path);
    preg_match_all('/<[A-Za-z][^>]*@(?:if|unless|isset|empty|switch|foreach|for|while)\b[^>]*>/s', $contents, $matches);

    evo_ui_assert($matches[0] === [], 'Blade conditionals must not be inside opening tags in ' . $path . ': ' . implode(' | ', $matches[0]));
}

function evo_ui_exit_code(int $failed): int
{
    return $failed > 0 ? 1 : 0;
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

/** @return array<string, mixed> */
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

    evo_ui_test('Livewire foundation bootstrap provides testing concern shims', function () use ($root): void {
        require_once $root . '/src/Livewire/Foundation/bootstrap.php';

        evo_ui_assert(trait_exists('Illuminate\\Foundation\\Testing\\Concerns\\InteractsWithExceptionHandling', false), 'Livewire testing exception-handling concern shim must be aliased.');
        evo_ui_assert(trait_exists('Illuminate\\Foundation\\Testing\\Concerns\\MakesHttpRequests', false), 'Livewire testing request concern shim must be aliased.');
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

evo_ui_group('documentation', function (): void {
    evo_ui_test('localized dDocs guides follow the package documentation contract', function (): void {
        $readme = evo_ui_read('docs/README.md');

        foreach (['en', 'uk', 'de', 'fr', 'pl'] as $language) {
            foreach (['README.md', 'user-guide.md', 'developer-guide.md', 'frontend-guide.md', 'configuration.md', 'reference.md', 'troubleshooting.md', 'documentation-standards.md', 'components/action-buttons.md', 'components/table.md', 'components/form.md'] as $file) {
                evo_ui_assert(is_file(evo_ui_path('docs/' . $language . '/' . $file)), 'dDocs localized guide missing: ' . $language . '/' . $file);
            }

            $localized = evo_ui_read('docs/' . $language . '/README.md');
            foreach (['user-guide.md', 'developer-guide.md', 'frontend-guide.md', 'configuration.md', 'reference.md', 'troubleshooting.md', 'documentation-standards.md', 'components/action-buttons.md', 'components/table.md', 'components/form.md'] as $guide) {
                evo_ui_assert_contains('(' . $guide . ')', $localized, 'Localized README must link to ' . $guide . ' for ' . $language . '.');
            }
        }

        foreach (['en/guide/README.md', 'en/components/README.md', 'en/components/dnd/README.md', 'en/components/table/README.md', 'en/components/table/contract.md', 'en/components/table/action-buttons.md', 'en/components/table/filters.md', 'en/components/table/search.md', 'en/components/table/sorting.md', 'en/components/table/reorder.md', 'en/components/table/pagination.md', 'en/contracts/README.md', 'en/reports/README.md'] as $file) {
            evo_ui_assert(is_file(evo_ui_path('docs/' . $file)), 'Structured docs folder README missing: ' . $file);
        }

        evo_ui_assert(!is_file(evo_ui_path('docs/en/components.md')), 'Root docs must not keep flat components.md after folder split.');
        evo_ui_assert(!is_file(evo_ui_path('docs/forms.md')), 'Root docs must not keep flat forms.md after folder split.');
        evo_ui_assert(!is_dir(evo_ui_path('docs/components')), 'Root docs must not keep canonical components folder.');
        evo_ui_assert(!is_dir(evo_ui_path('docs/guide')), 'Root docs must not keep canonical guide folder.');
        evo_ui_assert(!is_dir(evo_ui_path('docs/contracts')), 'Root docs must not keep canonical contracts folder.');
        evo_ui_assert(!is_dir(evo_ui_path('docs/reports')), 'Root docs must not keep canonical reports folder.');
        evo_ui_assert(!is_dir(evo_ui_path('docs/ua')), 'Documentation must use docs/uk only; ua is a legacy input alias.');
        evo_ui_assert_contains('Canonical implementation docs are English-first', $readme, 'Root README must explain English-first docs.');
        evo_ui_assert_contains('Legacy Evolution manager value `ua` is an input', $readme, 'Root README must document ua as an input alias only.');
        evo_ui_assert_contains('[English Guide](en/guide/README.md)', $readme, 'Root README must link to English Guide folder.');
        evo_ui_assert_contains('[English Components](en/components/README.md)', $readme, 'Root README must link to English Components folder.');
        evo_ui_assert_contains('[English Contracts](en/contracts/README.md)', $readme, 'Root README must link to English Contracts folder.');
        evo_ui_assert_contains('[English Reports](en/reports/README.md)', $readme, 'Root README must link to English Reports folder.');

        evo_ui_assert_contains('## Анатомія форми', evo_ui_read('docs/uk/components/form.md'), 'Ukrainian form guide must be localized, not a thin English link.');
        evo_ui_assert_contains('## Стандартні типи', evo_ui_read('docs/uk/components/action-buttons.md'), 'Ukrainian action button guide must be localized.');
        evo_ui_assert_contains('## Aufbau', evo_ui_read('docs/de/components/form.md'), 'German form guide must be localized.');
        evo_ui_assert_contains('## Anatomie', evo_ui_read('docs/fr/components/form.md'), 'French form guide must be localized.');
        evo_ui_assert_contains('## Anatomia', evo_ui_read('docs/pl/components/form.md'), 'Polish form guide must be localized.');

        $developer = evo_ui_read('docs/en/developer-guide.md');
        $frontend = evo_ui_read('docs/en/frontend-guide.md');
        evo_ui_assert_contains('```blade', $developer, 'Developer guide must use fenced Blade examples.');
        evo_ui_assert_contains('```php', $developer, 'Developer guide must use fenced PHP examples.');
        evo_ui_assert_contains('```bash', $developer, 'Developer guide must use fenced Bash examples.');
        evo_ui_assert_contains('```css', $frontend, 'Frontend guide must use fenced CSS examples.');
        evo_ui_assert_contains('dDocs intentionally uses a documentation workspace', evo_ui_read('docs/en/user-guide.md'), 'User guide must document the dDocs no-top-tabs exception.');
        evo_ui_assert_contains('EvoUIServiceProvider', evo_ui_read('docs/en/reference.md'), 'Reference must document EvoUIServiceProvider.');
        evo_ui_assert_contains('ConvertEmptyStringsToNull', evo_ui_read('docs/en/reference.md'), 'Reference must document Livewire foundation middleware shims.');
        evo_ui_assert_contains('docs/ua', evo_ui_read('docs/en/documentation-standards.md'), 'Documentation standards must ban docs/ua.');
        evo_ui_assert_contains('## Blade Attribute Safety', evo_ui_read('docs/en/documentation-standards.md'), 'Documentation standards must include Blade attribute safety rules.');
        evo_ui_assert_contains('Do not put Blade control-flow directives inside an HTML opening tag', evo_ui_read('docs/en/documentation-standards.md'), 'Blade attribute safety must forbid inline control-flow directives.');
        evo_ui_assert_contains('new \Illuminate\View\ComponentAttributeBag', evo_ui_read('docs/en/documentation-standards.md'), 'Blade attribute safety must document attribute bags.');
    });

    evo_ui_test('component catalogue freezes WebUI layer ownership and primitive rules', function (): void {
        $docs = evo_ui_read('docs/en/components/README.md');
        $audit = evo_ui_read('docs/en/reports/component-completion-audit.md');
        $readme = evo_ui_read('docs/README.md');
        $actions = evo_ui_read('docs/en/components/action-buttons.md');
        $tableOverview = evo_ui_read('docs/en/components/table/README.md');
        $tableContract = evo_ui_read('docs/en/components/table/contract.md');
        $tableActions = evo_ui_read('docs/en/components/table/action-buttons.md');
        $tableFilters = evo_ui_read('docs/en/components/table/filters.md');
        $tableSearch = evo_ui_read('docs/en/components/table/search.md');
        $tableSorting = evo_ui_read('docs/en/components/table/sorting.md');
        $tableReorder = evo_ui_read('docs/en/components/table/reorder.md');
        $tablePagination = evo_ui_read('docs/en/components/table/pagination.md');
        $table = implode("\n", [$tableOverview, $tableContract, $tableActions, $tableFilters, $tableSearch, $tableSorting, $tableReorder, $tablePagination]);
        $form = evo_ui_read('docs/en/components/form.md');
        $forms = evo_ui_read('docs/en/components/form-fields.md');
        $modal = evo_ui_read('docs/en/components/modal.md');
        $choices = evo_ui_read('docs/en/components/choices-option-lists.md');
        $inlineCreate = evo_ui_read('docs/en/components/inline-create-edit.md');
        $dashboardCards = evo_ui_read('docs/en/components/dashboard-cards.md');
        $designTokens = evo_ui_read('docs/en/components/design-tokens.md');
        $dnd = evo_ui_read('docs/en/components/dnd/reorder-contract.md');
        $dndGuide = evo_ui_read('docs/en/components/dnd/implementation-guide.md');
        $lessons = evo_ui_read('docs/en/guide/implementation-lessons.md');
        $consumerAdoption = evo_ui_read('docs/en/guide/consumer-adoption-checklist.md');
        $ddocsTree = evo_ui_read('docs/en/guide/ddocs-tree-viewer-notes.md');

        foreach ([
            '# Components And UI Kit' => 'Component catalogue must be the canonical UI-kit guide.',
            '## Layer Ownership' => 'Layer ownership rules must be documented.',
            '`evo-ui` owns:' => 'evo-ui ownership must be explicit.',
            'The consuming module owns:' => 'Consumer ownership must be explicit.',
            '## Component Inventory' => 'Component inventory must exist.',
            '## Buttons' => 'Button contract must be documented.',
            '[Action Buttons](action-buttons.md)' => 'Component catalogue must link to action button guide.',
            'A Save button should look the' => 'Save button standard must be explicit.',
            '## Row Actions' => 'Row action contract must be documented.',
            '## DnD And Reorder' => 'DnD/reorder contract must be documented.',
            'dnd/reorder-contract.md' => 'Component catalogue must link to the detailed DnD contract.',
            'dnd/implementation-guide.md' => 'Component catalogue must link to the DnD implementation guide.',
            '## Inline Create' => 'Inline create contract must be documented.',
            'data-evo-inline-create' => 'Inline create root marker must be documented.',
            'data-evo-inline-focus' => 'Inline create focus marker must be documented.',
            'data-evo-inline-create-bottom' => 'Inline create bottom action marker must be documented.',
            'evo-ui:inline-create.created' => 'Inline create event contract must be documented.',
            '## Module Tabs' => 'Module tab contract must be documented.',
            'x-evo::module-tab-shell' => 'Guarded module tab shell must be documented.',
            'pendingTab' => 'Consumers must be warned not to duplicate tab dirty-state internals.',
            'dDocs is a documented exception' => 'dDocs no-top-tabs exception must be documented.',
            '## Forms' => 'Form contract must be documented.',
            '[Form Component](form.md)' => 'Components docs must link to the form component guide.',
            'x-evo::settings-row' => 'Compact settings row primitive must be documented.',
            '`density`' => 'Compact form density must be documented.',
            '## Fields' => 'Field contract must be documented.',
            '## Tables And Lists' => 'Table/list contract must be documented.',
            '[Table](table/README.md)' => 'Components docs must link to the table component guide.',
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

        evo_ui_assert_contains('[Components And UI Kit](en/components/README.md)', $readme, 'Docs README must link to the canonical UI-kit guide.');
        evo_ui_assert_contains('[Action Buttons](en/components/action-buttons.md)', $readme, 'Docs README must link to the action button guide.');
        evo_ui_assert_contains('[Modal And Confirmation](en/components/modal.md)', $readme, 'Docs README must link to the modal guide.');
        evo_ui_assert_contains('[Table](en/components/table/README.md)', $readme, 'Docs README must link to the table component guide.');
        evo_ui_assert_contains('[Form Component](en/components/form.md)', $readme, 'Docs README must link to the form component guide.');
        evo_ui_assert_contains('[Choices And Option Lists](en/components/choices-option-lists.md)', $readme, 'Docs README must link to the choices guide.');
        evo_ui_assert_contains('[Inline Create And Inline Edit](en/components/inline-create-edit.md)', $readme, 'Docs README must link to the inline create guide.');
        evo_ui_assert_contains('[Dashboard Cards](en/components/dashboard-cards.md)', $readme, 'Docs README must link to the dashboard cards guide.');
        evo_ui_assert_contains('[Design Tokens And Visual System](en/components/design-tokens.md)', $readme, 'Docs README must link to the design tokens guide.');
        evo_ui_assert_contains('[Form Component](form.md)', $forms, 'Form catalogue must link back to the form component guide.');
        evo_ui_assert_contains('[EvoUI Implementation Lessons](en/guide/implementation-lessons.md)', $readme, 'Docs README must link to the implementation lessons guide.');
        evo_ui_assert_contains('[EvoUI Implementation Lessons](../guide/implementation-lessons.md)', $docs, 'Component catalogue must point agents to the implementation lessons.');
        evo_ui_assert_contains('[DnD And Reorder Contract](en/components/dnd/reorder-contract.md)', $readme, 'Docs README must link to the DnD reorder contract.');
        evo_ui_assert_contains('[DnD Implementation Guide](en/components/dnd/implementation-guide.md)', $readme, 'Docs README must link to the DnD implementation guide.');
        evo_ui_assert_contains('[Embedded Resource Contract](en/contracts/embedded-resource.md)', $readme, 'Docs README must link to the embedded resource contract.');
        evo_ui_assert_contains('[Editor Media Adapter Contract](en/contracts/editor-media-adapter.md)', $readme, 'Docs README must link to the editor/media adapter contract.');
        evo_ui_assert_contains('[Consumer Drift Guards](en/contracts/consumer-drift-guards.md)', $readme, 'Docs README must link to consumer drift guards.');
        evo_ui_assert_contains('[Component Completion Audit](en/reports/component-completion-audit.md)', $readme, 'Docs README must link to the component completion audit.');
        evo_ui_assert_contains('[Table Consumer Audit](en/reports/table-consumer-audit-2026-05-13.md)', $readme, 'Docs README must link to the table consumer audit.');
        evo_ui_assert_contains('[Primitive Coverage Matrix](en/reports/primitive-coverage-matrix-2026-05-13.md)', $readme, 'Docs README must link to the primitive coverage matrix.');
        evo_ui_assert_contains('[Consumer Adoption Checklist](en/guide/consumer-adoption-checklist.md)', $readme, 'Docs README must link to the consumer adoption checklist.');
        evo_ui_assert_contains('## Remaining Drift From Consumers', $audit, 'Component audit must summarize consumer drift.');
        evo_ui_assert_contains('dDocs remains a documented UX exception', $audit, 'Component audit must keep the dDocs no-top-tabs exception explicit.');

        foreach ([
            '# Modal And Confirmation' => 'Modal guide must exist.',
            '## Modal Types' => 'Modal guide must classify modal types.',
            '## Table Form Modal' => 'Modal guide must document table form modals.',
            '## Read-Only Action Modal' => 'Modal guide must document read-only action modals.',
            '## Delete Confirmation' => 'Modal guide must document delete confirmations.',
            '`sSettings`' => 'Modal guide must name sSettings drift pressure.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $modal, $message);
        }

        foreach ([
            '# Choices And Option Lists' => 'Choices guide must exist.',
            'x-evo::dnd-option-list' => 'Choices guide must document option-list component.',
            'x-evo::dnd-option-row' => 'Choices guide must document option-row component.',
            'value == label' => 'Choices guide must document value/label default behavior.',
            'sortOptionByUid' => 'Choices guide must document reorder method.',
            '`sSettings`' => 'Choices guide must name the sSettings donor.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $choices, $message);
        }

        foreach ([
            '# Inline Create And Inline Edit' => 'Inline create guide must exist.',
            'data-evo-inline-create' => 'Inline create guide must document root marker.',
            'data-evo-inline-focus' => 'Inline create guide must document focus marker.',
            'data-evo-inline-create-bottom' => 'Inline create guide must document bottom action marker.',
            'evo-ui:inline-create.created' => 'Inline create guide must document created event.',
            'createInlineRow' => 'Inline create guide must document table hook.',
            '`sLang`' => 'Inline create guide must name sLang donor.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $inlineCreate, $message);
        }

        foreach ([
            '# Dashboard Cards' => 'Dashboard cards guide must exist.',
            'x-evo::dashboard-card' => 'Dashboard cards guide must document card component.',
            'span="6"' => 'Dashboard cards guide must document half-width spans.',
            'no redundant border below dashboard cards' => 'Dashboard cards guide must forbid redundant border.',
            '`sSeo`' => 'Dashboard cards guide must name the sSeo donor.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $dashboardCards, $message);
        }

        foreach ([
            '# Design Tokens And Visual System' => 'Design token guide must exist.',
            '## Token Layers' => 'Design token guide must document token layers.',
            '## Allowed Consumer CSS' => 'Design token guide must document consumer CSS boundary.',
            'Do not define a second palette' => 'Design token guide must forbid second palettes.',
            '`sTask`' => 'Design token guide must name sTask drift pressure.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $designTokens, $message);
        }

        foreach ([
            '# Consumer Adoption Checklist' => 'Consumer adoption checklist must exist.',
            '## Primitive Selection' => 'Consumer adoption checklist must document primitive selection.',
            '## Donor Modules' => 'Consumer adoption checklist must document donors.',
            '`sArticles`' => 'Consumer adoption checklist must name sArticles.',
            '`sSeo`' => 'Consumer adoption checklist must name sSeo.',
            '`sSettings`' => 'Consumer adoption checklist must name sSettings.',
            '`dDocs`' => 'Consumer adoption checklist must name dDocs.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $consumerAdoption, $message);
        }

        foreach ([
            'dDocs is the documented no-top-tabs exception' => 'dDocs tree notes must freeze the exception.',
            '## Promotion Checklist' => 'dDocs tree notes must include a promotion checklist.',
            'tree/viewer behavior' => 'dDocs tree notes must describe tree/viewer promotion.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $ddocsTree, $message);
        }

        foreach ([
            '# Action Buttons' => 'Action button guide must exist.',
            '## Button Taxonomy' => 'Action button guide must document taxonomy.',
            'Form primary save' => 'Action button guide must document form save actions.',
            'Table toolbar action' => 'Action button guide must document table toolbar actions.',
            'Table control action' => 'Action button guide must document table control actions.',
            'Row action' => 'Action button guide must document row actions.',
            'Modal footer action' => 'Action button guide must document modal footer actions.',
            '## Form Save Action' => 'Action button guide must document form save flow.',
            '## Modal Apply Action' => 'Action button guide must document modal apply flow.',
            'evo::global.action_apply' => 'Action button guide must document local modal apply copy.',
            'evo::global.form_saved' => 'Action button guide must document saved button accessible state.',
            'Dirty form:' => 'Action button guide must document save feedback states.',
            'Clean form:' => 'Action button guide must document clean disabled state.',
            '## Table Toolbar Actions' => 'Action button guide must document table toolbar config.',
            '## Table Control Actions' => 'Action button guide must document controls placement.',
            '## Row Actions' => 'Action button guide must document row action config.',
            '## Modal Footer Actions' => 'Action button guide must document modal footer actions.',
            'Do not create module-local button classes' => 'Action button guide must forbid local button CSS.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $actions, $message);
        }

        foreach ([
            '# Table Component' => 'Table guide must exist.',
            '## Documentation Map' => 'Table guide must expose the table docs map.',
            '[Table Contract](contract.md)' => 'Table guide must link to the contract subpage.',
            '[Table Action Buttons](action-buttons.md)' => 'Table guide must link to table action buttons.',
            '[Table Filters](filters.md)' => 'Table guide must link to table filters.',
            '[Table Search](search.md)' => 'Table guide must link to table search.',
            '[Table Sorting](sorting.md)' => 'Table guide must link to table sorting.',
            '[Table Reorder](reorder.md)' => 'Table guide must link to table reorder.',
            '[Table Pagination](pagination.md)' => 'Table guide must link to table pagination.',
            '## Component Anatomy' => 'Table guide must describe the standard anatomy.',
            'Toolbar: title and primary actions on the left' => 'Table guide must freeze toolbar layout.',
            'Row action column' => 'Table guide must require final row actions.',
            'Double-click behavior' => 'Table guide must document double-click edit behavior.',
            'Pagination footer' => 'Table guide must document the shared footer.',
            '## Rendering Entry Points' => 'Table guide must document Blade/Livewire entrypoints.',
            '<x-evo::table.livewire' => 'Table guide must document the Blade component entrypoint.',
            '<livewire:evo-ui.module-table' => 'Table guide must document the direct Livewire entrypoint.',
            '## Minimal Preset' => 'Table guide must document preset shape.',
            '## Provider Contract' => 'Table guide must document provider ownership.',
            'public function rows(): array;' => 'Table guide must document rows provider hook.',
            'public function filterGroups(): array;' => 'Table guide must document filter options provider hook.',
            '## Columns' => 'Table guide must document columns.',
            '`position`' => 'Table guide must document position cell type.',
            '## Toolbar' => 'Table guide must document toolbar actions.',
            '## Filters' => 'Table guide must document filters.',
            '## Search' => 'Table guide must document search.',
            '## Sorting' => 'Table guide must document sorting.',
            '## Table View' => 'Table guide must document table view.',
            '## List View' => 'Table guide must document list parity.',
            '## Row Actions' => 'Table guide must document row actions.',
            '## Modal CRUD' => 'Table guide must document modal CRUD.',
            '## Inline Editing' => 'Table guide must document inline editing.',
            '## Reorder' => 'Table guide must document reorder.',
            '## State Persistence' => 'Table guide must document state persistence.',
            '## Canonical Consumer Patterns' => 'Table guide must document donor modules.',
            '`sArticles`' => 'Table guide must name sArticles donor.',
            '`sSeo`' => 'Table guide must name sSeo donor.',
            '`sLang`' => 'Table guide must name sLang donor.',
            '`dIssues`' => 'Table guide must name dIssues donor.',
            '`dGramm`' => 'Table guide must name dGramm donor.',
            '`sTask`' => 'Table guide must name sTask donor.',
            '`sSettings`' => 'Table guide must clarify sSettings boundary.',
            '## Anti-Patterns' => 'Table guide must document anti-patterns.',
            'Do not build a custom toolbar' => 'Table guide must forbid custom toolbar drift.',
            'Do not add a module-local pagination partial' => 'Table guide must forbid local pagination.',
            '## Review Checklist' => 'Table guide must include a review checklist.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $table, $message);
        }

        foreach ([
            '# Table Contract' => 'Table contract subpage must exist.',
            '## Ownership' => 'Table contract must document ownership.',
            '## Provider Contract' => 'Table contract must document provider hooks.',
            '## Row Shape' => 'Table contract must document rows.',
            '## Columns' => 'Table contract must document columns.',
            '## Table View' => 'Table contract must document table view.',
            '## List View' => 'Table contract must document list parity.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $tableContract, $message);
        }

        foreach ([
            '# Table Action Buttons' => 'Table action button subpage must exist.',
            '## Placement Map' => 'Table action buttons must define placement.',
            'Toolbar Actions' => 'Table action buttons must document toolbar actions.',
            'Control Lane Actions' => 'Table action buttons must document control-lane actions.',
            'Header Actions' => 'Table action buttons must document header actions.',
            'Inline Actions' => 'Table action buttons must document inline actions.',
            'Row Actions' => 'Table action buttons must document row actions.',
            '../action-buttons.md' => 'Table action buttons must link to the general button guide.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $tableActions, $message);
        }

        foreach ([
            '# Table Filters' => 'Table filter subpage must exist.',
            '## Multi-Select' => 'Table filters must document multi-select.',
            "`multi-select` is the default" => 'Table filters must document multi-select as default taxonomy filter.',
            '## Single Select' => 'Table filters must document select/radio dropdown.',
            "'type' => 'select'" => 'Table filters must show select config.',
            'radio options' => 'Table filters must describe radio option behavior.',
            '## Segmented' => 'Table filters must document segmented filters.',
            '## Toggle' => 'Table filters must document toggle filters.',
            '## Date Range' => 'Table filters must document date-range filters.',
            'public function filterGroups(): array' => 'Table filters must document option source hook.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $tableFilters, $message);
        }

        foreach ([
            '# Table Search' => 'Table search subpage must exist.',
            "'search' => [" => 'Table search must document search config.',
            "'state' => 'search'" => 'Table search must document search state.',
            'URL key `q`' => 'Table search must document the query key.',
            'Do not add a second search row' => 'Table search must forbid custom search rows.',
            'Provider Mapping' => 'Table search must document provider mapping.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $tableSearch, $message);
        }

        foreach ([
            '# Table Sorting' => 'Table sorting subpage must exist.',
            '`default_sort` must be a sortable column `key`' => 'Table sorting must freeze default sort key contract.',
            '`sort_field`' => 'Table sorting must document provider-safe sort fields.',
            '`wire_target` must include `setSort`' => 'Table sorting must document wire target.',
            'ModuleTable::syncConfigState()' => 'Table sorting must explain invalid default sort behavior.',
            'Do not:' => 'Table sorting must include anti-patterns.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $tableSorting, $message);
        }

        foreach ([
            '# Table Reorder' => 'Table reorder subpage must exist.',
            "'reorder' => [" => 'Table reorder must document reorder config.',
            "'sort' => 'position'" => 'Table reorder must document position sort.',
            'public function moveRow(int $id, string $direction): void' => 'Table reorder must document move provider.',
            'public function reorderRow(int $id, int $targetId, string $placement = \'before\'): void' => 'Table reorder must document reorder provider.',
            'sortTableRowByUid' => 'Table reorder must document shared DnD position mapping.',
            'position value is provider state, not visible UI' => 'Table reorder must forbid visible position chips.',
            '.evo-ui-reorder-rail--table' => 'Table reorder must document table rail class.',
            'Do not use table reorder for log/activity/history rows' => 'Table reorder must forbid non-positioned reorder.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $tableReorder, $message);
        }

        foreach ([
            '# Table Pagination' => 'Table pagination subpage must exist.',
            'per_page_options' => 'Table pagination must document per-page options.',
            'aria-current="page"' => 'Table pagination must document current-page accessibility.',
            'firstPage' => 'Table pagination must document first-page action.',
            'previousPage' => 'Table pagination must document previous-page action.',
            'nextPage' => 'Table pagination must document next-page action.',
            'goLastPage' => 'Table pagination must document last-page action.',
            'public function total(): int' => 'Table pagination must document provider total hook.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $tablePagination, $message);
        }

        $tableAudit = evo_ui_read('docs/en/reports/table-consumer-audit-2026-05-13.md');
        foreach ([
            '# Table Consumer Audit - 2026-05-13' => 'Table consumer audit must exist.',
            '`sArticles` | 8 | Good canonical donor' => 'Table audit must classify sArticles.',
            '`sSeo` | 2 | Good canonical donor' => 'Table audit must classify sSeo.',
            '`sLang` | 1 | Good after sort cleanup' => 'Table audit must classify sLang.',
            '`dIssues` | 5 row tables plus workspace | Good after wire target cleanup' => 'Table audit must classify dIssues.',
            '`dGramm` | 7 | Good after sorting cleanup' => 'Table audit must classify dGramm.',
            '`sTask` | 3 | Mostly good' => 'Table audit must classify sTask.',
            '`sSettings` | 0 tables | Not applicable' => 'Table audit must classify sSettings.',
            '`default_sort => key`' => 'Table audit must document sLang sorting cleanup.',
            'defaults to `last_update_at`' => 'Table audit must document dGramm sorting cleanup.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $tableAudit, $message);
        }

        foreach ([
            '# Form Component' => 'Form guide must exist.',
            '## Component Anatomy' => 'Form guide must describe the standard anatomy.',
            'Form surface' => 'Form guide must document the form surface.',
            'Action toolbar' => 'Form guide must document the action toolbar.',
            'data-evo-form' => 'Form guide must document the form root marker.',
            'data-evo-form-dirty' => 'Form guide must document dirty marker.',
            '## Rendering Entry Points' => 'Form guide must document rendering entrypoints.',
            '<livewire:evo-ui.form' => 'Form guide must document the Livewire entrypoint.',
            '## Minimal Preset' => 'Form guide must document preset shape.',
            '## Preset Keys' => 'Form guide must document preset keys.',
            '## Source Types' => 'Form guide must document source types.',
            '### Config Form' => 'Form guide must document config forms.',
            '### Model Form' => 'Form guide must document model forms.',
            '### Resource Form' => 'Form guide must document resource forms.',
            '## Layouts And Density' => 'Form guide must document layouts and density.',
            "'layout' => 'settings'" => 'Form guide must document the settings layout.',
            '`section_columns`' => 'Form guide must document section columns.',
            '## Tabs And Sections' => 'Form guide must document tabs and sections.',
            '## Actions' => 'Form guide must document actions.',
            "'type' => 'save'" => 'Form guide must document save actions.',
            '## Field Contract' => 'Form guide must document the field contract.',
            '## Field Types' => 'Form guide must document field types.',
            '`config-map`' => 'Form guide must document config-map.',
            '`resource-parent`' => 'Form guide must document resource-parent.',
            '`editor`' => 'Form guide must document editor fields.',
            '## Settings Row Primitive' => 'Form guide must document settings rows.',
            'x-evo::settings-row' => 'Form guide must document settings-row primitive.',
            '## Dirty State' => 'Form guide must document dirty state.',
            'evo-ui:form.saved' => 'Form guide must document saved event.',
            'EvoUI.form.waitForClean' => 'Form guide must document the tab guard bridge.',
            '## Validation And Save' => 'Form guide must document validation/save.',
            'save => false' => 'Form guide must document display-only fields.',
            '## Standalone Form And Modal Boundary' => 'Form guide must document modal boundary.',
            '## Canonical Consumer Patterns' => 'Form guide must document donor modules.',
            '`sArticles`' => 'Form guide must name sArticles donor.',
            '`sSeo`' => 'Form guide must name sSeo donor.',
            '`sLang`' => 'Form guide must name sLang boundary.',
            '`dIssues`' => 'Form guide must name dIssues donor.',
            '`dGramm`' => 'Form guide must name dGramm donor.',
            '`sSettings`' => 'Form guide must name sSettings boundary.',
            '`sTask`' => 'Form guide must name sTask donor.',
            '## Anti-Patterns' => 'Form guide must document anti-patterns.',
            'Do not create module-local Save buttons' => 'Form guide must forbid local save button drift.',
            'evo::global.action_apply' => 'Form guide must document staged modal apply behavior.',
            'parent form Save remains the only persistence action' => 'Form guide must separate modal apply from parent persistence.',
            '## Review Checklist' => 'Form guide must include a review checklist.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $form, $message);
        }

        foreach ([
            '# EvoUI Implementation Lessons' => 'Implementation lessons guide must exist.',
            '## Before Coding' => 'Implementation lessons must start with a coding checklist.',
            'x-evo::layout' => 'Implementation lessons must cover the manager layout.',
            'x-evo::module-tab-shell' => 'Implementation lessons must cover guarded tabs.',
            'evo-ui.module-table' => 'Implementation lessons must cover module tables.',
            'evo-ui.form' => 'Implementation lessons must cover forms.',
            'x-evo::dashboard-card' => 'Implementation lessons must cover dashboard cards.',
            'data-evo-dnd' => 'Implementation lessons must cover DnD primitives.',
            'data-evo-inline-create' => 'Implementation lessons must cover inline create primitives.',
            'data-evo-inline-create-bottom' => 'Implementation lessons must cover overflow bottom create actions.',
            'evo-ui:inline-create.created' => 'Implementation lessons must cover the inline create event.',
            'x-evo::modal' => 'Implementation lessons must cover modals.',
            'Embedded Resource Contract' => 'Implementation lessons must cover embedded resource exceptions.',
            'sTask and dGramm' => 'Implementation lessons must cover operational modules.',
            'task runner panel' => 'Implementation lessons must name task-runner surfaces.',
            'Blade-Safe Attributes' => 'Implementation lessons must cover safe Blade attribute rendering.',
            'ComponentAttributeBag' => 'Implementation lessons must show attribute bag usage.',
            'Anti-Custom Checklist' => 'Implementation lessons must include an anti-custom checklist.',
            'visible EvoUI backlog task' => 'Implementation lessons must require a visible task when a primitive is missing.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $lessons, $message);
        }

        foreach ([
            'sSettings Configure donor implementation' => 'DnD docs must name the donor implementation.',
            'data-evo-dnd' => 'DnD docs must define the shared root marker.',
            'data-evo-dnd-group' => 'DnD docs must define group markers.',
            'data-evo-dnd-item' => 'DnD docs must define item markers.',
            'data-evo-dnd-option-list' => 'DnD docs must define modal option-list markers.',
            'sortTabByUid(string $groupUid, int $position): void' => 'DnD docs must define group Livewire method shape.',
            'sortFieldByUid(string $itemUid, int $position, string $targetGroupUid): void' => 'DnD docs must define nested item Livewire method shape.',
            'native drag preview selection' => 'DnD docs must define EvoUI-owned native drag preview selection.',
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

    evo_ui_test('primitive coverage matrix has canonical documentation coverage', function (): void {
        $matrix = evo_ui_read('docs/en/reports/primitive-coverage-matrix-2026-05-13.md');
        $components = evo_ui_read('docs/en/components/README.md');
        $guide = evo_ui_read('docs/en/guide/README.md');

        foreach ([
            'Manager shell, layout, assets, theme bridge',
            'Action buttons and command taxonomy',
            'Table core',
            'Form core',
            'Choices and option lists',
            'Modal shell and confirmation',
            'Dashboard and cards',
            'Design tokens and visual system',
            'dDocs tree/viewer and markdown workspace',
        ] as $primitive) {
            evo_ui_assert_contains($primitive, $matrix, 'Primitive matrix missing primitive row: ' . $primitive);
        }

        foreach ([
            '[Modal And Confirmation](modal.md)',
            '[Choices And Option Lists](choices-option-lists.md)',
            '[Inline Create And Inline Edit](inline-create-edit.md)',
            '[Dashboard Cards](dashboard-cards.md)',
            '[Design Tokens And Visual System](design-tokens.md)',
        ] as $link) {
            evo_ui_assert_contains($link, $components, 'Component catalogue must link expanded guide: ' . $link);
        }

        evo_ui_assert_contains('[Consumer Adoption Checklist](consumer-adoption-checklist.md)', $guide, 'Guide index must link the consumer adoption checklist.');
        evo_ui_assert_contains('evo-ui-docs-049', $matrix, 'Translations must remain deferred to evo-ui-docs-049.');
    });

    evo_ui_test('module integration docs prescribe guarded tab shell', function (): void {
        $docs = evo_ui_read('docs/en/guide/module-integration.md');

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
        $docs = evo_ui_read('docs/en/contracts/embedded-resource.md');
        $components = evo_ui_read('docs/en/components/README.md');

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
            '[Embedded Resource Contract](../contracts/embedded-resource.md)',
            'data-evo-resource-embedded',
            'data-evo-ui-root',
        ] as $marker) {
            evo_ui_assert_contains($marker, $components, 'Components docs missing embedded resource marker: ' . $marker);
        }
    });

    evo_ui_test('editor media adapter contract freezes shared editor lifecycle', function (): void {
        $docs = evo_ui_read('docs/en/contracts/editor-media-adapter.md');
        $components = evo_ui_read('docs/en/components/README.md');

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

        evo_ui_assert_contains('[Editor Media Adapter Contract](../contracts/editor-media-adapter.md)', $components, 'Components docs must link to the editor/media contract.');
    });

    evo_ui_test('consumer drift guard docs describe report, strict and allowlist workflow', function (): void {
        $docs = evo_ui_read('docs/en/contracts/consumer-drift-guards.md');
        $testing = evo_ui_read('docs/en/guide/testing.md');
        $release = evo_ui_read('docs/en/guide/release-checklist.md');

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

    evo_ui_test('livewire assets use root routes instead of manager PATH_INFO', function (): void {
        $assets = evo_ui_read('src/Support/LivewireAssets.php');

        evo_ui_assert_contains("sitePath('livewire/livewire.js')", $assets, 'Livewire script URL must use the site front controller routes.');
        evo_ui_assert_contains("sitePath('livewire/update')", $assets, 'Livewire update URI must use the site front controller routes.');
        evo_ui_assert_not_contains("'/index.php/'", $assets, 'Livewire manager assets must not rely on PATH_INFO after manager/index.php.');
    });

    evo_ui_test('provider publishes runtime assets through Evolution symlinks', function (): void {
        $provider = evo_ui_read('src/EvoUIServiceProvider.php');

        evo_ui_assert_contains("'symlink:' . \$this->root . '/resources/css/evo-ui.css'", $provider, 'EvoUI CSS must be published through the symlink-aware vendor:publish mechanism.');
        evo_ui_assert_contains("'symlink:' . \$this->root . '/resources/js/evo-ui.js'", $provider, 'EvoUI JS must be published through the symlink-aware vendor:publish mechanism.');
        evo_ui_assert_contains("config/evo-ui.php' => config_path('evo-ui.php', true)", $provider, 'Config publishing must remain copy-based.');
        evo_ui_assert_contains('$this->ensureRuntimeAssetsArePublished();', $provider, 'Provider must self-publish runtime assets when EvoUI is installed as a dependency.');
        evo_ui_assert_contains('protected function ensureRuntimeAsset(string $source, string $target): void', $provider, 'Provider must own an idempotent runtime asset publisher.');
        evo_ui_assert_contains('@symlink($source, $target)', $provider, 'Runtime asset publisher should prefer symlinks for local package updates.');
        evo_ui_assert_contains('@copy($source, $target)', $provider, 'Runtime asset publisher must fall back to copying on restricted filesystems.');
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
            'window.EvoUI.initDnd = initDnd',
            'window.EvoUI.initInlineCreate = initInlineCreate',
            'window.EvoUI.focusInlineCreateItem = focusInlineCreateItem',
            'window.EvoUI.initIssueKanban = initIssueKanban',
            'window.EvoUI.syncRichEditors = syncRichEditors',
            'window.EvoUI.browseMediaField = browseMediaField',
            'window.EvoUI.theme = {',
        ] as $marker) {
            evo_ui_assert_contains($marker, $js, 'Missing public EvoUI JS marker: ' . $marker);
        }
    });

    evo_ui_test('javascript bridges wheel scrolling inside embedded manager frames', function (): void {
        $js = evo_ui_read('resources/js/evo-ui.js');

        foreach ([
            'function registerEmbeddedManagerWheelBridge()',
            'function handleEmbeddedManagerWheel(event)',
            "document.addEventListener('wheel', handleEmbeddedManagerWheel",
            'passive: false',
            'window.self === window.top',
            'document.scrollingElement',
            'hasScrollableWheelTarget(event.target, deltaY)',
            'scroller.scrollTop = next',
        ] as $marker) {
            evo_ui_assert_contains($marker, $js, 'Missing embedded manager wheel bridge marker: ' . $marker);
        }
    });

    evo_ui_test('inline create runtime exposes focus and overflow contracts', function (): void {
        $js = evo_ui_read('resources/js/evo-ui.js');
        $css = evo_ui_read('resources/css/evo-ui.css');

        foreach ([
            'function initInlineCreate(rootElement)' => 'Runtime must expose inline-create initializer.',
            'function handleInlineCreateCreated(detail)' => 'Runtime must handle inline-create events.',
            'function focusInlineCreateItem(item)' => 'Runtime must focus newly created items.',
            "target.querySelectorAll('[data-evo-inline-create]').forEach(initInlineCreate)" => 'Runtime init must discover inline-create roots.',
            "window.addEventListener('evo-ui:inline-create.created'" => 'Runtime must listen for the shared inline-create event.',
            'data-evo-inline-created' => 'Runtime must find newly created items by marker.',
            'data-evo-inline-create-id' => 'Runtime must find newly created items by id marker.',
            'data-evo-inline-focus' => 'Runtime must find primary focus targets.',
            'data-evo-inline-create-bottom' => 'Runtime must toggle bottom create actions.',
            'is-evo-inline-create-overflowing' => 'Runtime must expose overflowing root state.',
            "dispatch('inline-create.focused'" => 'Runtime must emit focused event after focus.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $js, $message);
        }

        foreach ([
            '.evo-ui-inline-create',
            '.evo-ui-inline-create-bottom',
            '[data-evo-inline-create-bottom]',
            '.is-evo-inline-created',
            '@keyframes evo-ui-inline-created',
        ] as $marker) {
            evo_ui_assert_contains($marker, $css, 'Missing inline-create CSS marker: ' . $marker);
        }
    });

    evo_ui_test('form save action keeps stable visual width while exposing saved feedback', function (): void {
        $form = evo_ui_read('views/components/form.blade.php');
        $actions = evo_ui_read('docs/en/components/action-buttons.md');

        evo_ui_assert_contains('savedFeedback: @js($saved)', $form, 'Form must keep a local saved-feedback state.');
        evo_ui_assert_contains('savedFeedbackTimer', $form, 'Form saved feedback must auto-reset through a timer.');
        evo_ui_assert_contains("this.savedFeedback = true;", $form, 'Form saved handler must enable saved feedback.');
        evo_ui_assert_contains("this.savedFeedback = false;", $form, 'Form dirty handler must clear saved feedback.');
        evo_ui_assert_contains("x-bind:title=\"savedFeedback ? @js(__('evo::global.form_saved'))", $form, 'Save button must expose saved feedback through title.');
        evo_ui_assert_contains("x-bind:aria-label=\"savedFeedback ? @js(__('evo::global.form_saved'))", $form, 'Save button must expose saved feedback through aria-label.');
        evo_ui_assert_contains('x-bind:disabled="!dirty || savedFeedback"', $form, 'Save button must be disabled while clean or showing saved feedback.');
        evo_ui_assert_contains("x-bind:class=\"{ 'is-disabled': !dirty || savedFeedback, 'is-saved': savedFeedback }\"", $form, 'Save button must expose a saved visual state without custom markup.');
        evo_ui_assert_contains('<x-evo::icon :name="$action[\'icon\'] ?? \'check\'" class="evo-ui-btn__icon" x-show="!savedFeedback" />', $form, 'Save button must show the normal icon before save.');
        evo_ui_assert_contains('<x-evo::icon name="circle-check" class="evo-ui-btn__icon" x-show="savedFeedback" x-cloak />', $form, 'Save button must switch icon after save.');
        evo_ui_assert_contains('<span class="evo-ui-btn__label">@lang($action[\'label\'] ?? \'evo::global.action_save\')</span>', $form, 'Save button label must remain action_save so button width does not jump.');
        evo_ui_assert_not_contains('<span class="evo-ui-btn__label">@lang(\'evo::global.form_saved\')</span>', $form, 'Saved feedback must not replace the visible label and resize the button.');
        evo_ui_assert_not_contains('x-text="savedFeedback', $form, 'Saved feedback must not use dynamic text that changes the button width.');
        evo_ui_assert_contains('the visible label stays on `evo::global.action_save`', $actions, 'Action button docs must freeze the non-jumping save label rule.');
    });

    evo_ui_test('settings rows and listbox selects preserve shared manager geometry', function (): void {
        $css = evo_ui_read('resources/css/evo-ui.css');
        $row = evo_ui_read('views/components/settings-row.blade.php');
        $settingsBlock = evo_ui_css_block('.evo-ui-settings-row', $css);
        $metaBlock = evo_ui_css_block('.evo-ui-settings-row__meta', $css);
        $usageBlock = evo_ui_css_block('.evo-ui-settings-row__usage', $css);
        $listboxBlock = evo_ui_css_block('select.evo-ui-input.evo-ui-select--listbox:not([multiple])', $css);

        evo_ui_assert_contains('data-evo-settings-row', $row, 'Settings row component must expose a stable row marker.');
        evo_ui_assert_contains('evo-ui-settings-row__meta', $row, 'Settings row must keep labels in the meta lane.');
        evo_ui_assert_contains('evo-ui-settings-row__control', $row, 'Settings row must keep controls in the control lane.');
        evo_ui_assert_contains('grid-template-columns: minmax(260px, 340px) minmax(0, 1fr);', $settingsBlock, 'Settings rows must give labels enough width for long setting names and usage snippets.');
        evo_ui_assert_contains('gap: 14px;', $settingsBlock, 'Settings rows must keep a compact but readable label/control gap.');
        evo_ui_assert_contains('align-items: start;', $settingsBlock, 'Settings rows must top-align tall controls.');
        evo_ui_assert_contains('justify-items: end;', $metaBlock, 'Settings row labels must stay right-aligned.');
        evo_ui_assert_contains('text-align: right;', $metaBlock, 'Settings row meta lane must align text to the control edge.');
        evo_ui_assert_contains('overflow-wrap: anywhere;', $usageBlock, 'Settings usage code must wrap instead of being clipped.');
        evo_ui_assert_contains('white-space: normal;', $usageBlock, 'Settings usage code must not force a single clipped line.');
        evo_ui_assert_not_contains('overflow: hidden;', $usageBlock, 'Settings usage code must not hide long evo config snippets.');
        evo_ui_assert_not_contains('text-overflow: ellipsis;', $usageBlock, 'Settings usage code must not silently truncate long evo config snippets.');
        evo_ui_assert_contains('height: 150px;', $listboxBlock, 'Single-select listbox must override the generic select height.');
        evo_ui_assert_contains('min-height: 150px;', $listboxBlock, 'Single-select listbox must keep a stable listbox height.');
        evo_ui_assert_contains('line-height: normal;', $listboxBlock, 'Single-select listbox must not inherit compact single-select line height.');
        evo_ui_assert_order('select.evo-ui-input:not([multiple]) {', 'select.evo-ui-input.evo-ui-select--listbox:not([multiple]) {', $css, 'Listbox override must come after the generic single-select rule.');
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
            '--evo-ui-chip-max-inline-size:',
            '--evo-ui-chip-compact-max-inline-size:',
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

    evo_ui_test('css exposes compact badge and chip sizing contract', function (): void {
        $css = evo_ui_read('resources/css/evo-ui.css');
        $docs = evo_ui_read('docs/en/components/design-tokens.md');

        foreach ([
            '.evo-ui-chip,' => 'Neutral chip primitive must exist.',
            '.evo-ui-badge--compact' => 'Compact badge modifier must exist.',
            '.evo-ui-chip--wide' => 'Wide chip modifier must exist.',
            '.evo-ui-badge--wide' => 'Wide badge modifier must exist.',
            '.evo-ui-chip--full' => 'Full-width chip escape hatch must exist.',
            'max-inline-size: min(100%, var(--evo-ui-chip-compact-max-inline-size));' => 'Compact chips must clamp to the shared compact token.',
            'text-overflow: ellipsis;' => 'Compact chips must avoid layout-breaking overflow.',
            'white-space: nowrap;' => 'Compact chips must remain one-line labels.',
            '.evo-ui-badge--compact > span' => 'Badge text must own ellipsis when compact.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $css, $message);
        }

        foreach ([
            '## Compact Badges And Chips' => 'Design token docs must document compact badges and chips.',
            '--evo-ui-chip-max-inline-size' => 'Design token docs must document the wide chip token.',
            '--evo-ui-chip-compact-max-inline-size' => 'Design token docs must document the compact chip token.',
            'expose the full dynamic value with a native `title` attribute' => 'Design token docs must require full-value title when truncation is possible.',
            'Listbox (Single-Select)' => 'Design token docs must include a long field-type chip example.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $docs, $message);
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
            "'handleDraggable' => true" => 'Reorder rail must default to a draggable handle for existing row consumers.',
            '@if($handleDraggable) draggable="true" @endif' => 'Reorder rail must omit the draggable attribute when the parent row is the native drag source.',
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
            '.evo-ui-dnd-floating-preview',
            '.evo-ui-dnd-floating-preview--transparent',
            '.evo-ui-dnd-floating-preview--table',
            'opacity: 0.78;',
            '.evo-ui-dnd-placeholder',
            '.evo-ui-dnd-placeholder__table-inner',
            '.evo-ui-table-row--dnd.is-dragging',
            '.evo-ui-list-item--dnd.is-dragging',
            'opacity: 0.88;',
            '[data-evo-dnd-placeholder]',
            '.evo-ui-dnd-handle',
            '.evo-ui-dnd-actions',
            '.evo-ui-row-actions--compact',
            'display: inline-flex;',
            'width: fit-content;',
            '.evo-ui-dnd-key',
            'color-mix(in oklch, var(--evo-ui-info) 68%, var(--evo-ui-muted))',
            '.evo-ui-dnd-badge',
            'border-radius: 999px;',
            '.evo-ui-builder-summary',
            '.evo-ui-builder-chip',
            '.evo-ui-builder-modal',
        ] as $marker) {
            evo_ui_assert_contains($marker, $css, 'Missing builder CSS marker: ' . $marker);
        }
    });

    evo_ui_test('native dnd runtime exposes nested reorder contract', function (): void {
        $js = evo_ui_read('resources/js/evo-ui.js');
        $css = evo_ui_read('resources/css/evo-ui.css');

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
            'var handleTargetRow = handle && rootElement.contains(handle) ? armHandle(handle) : null;' => 'Runtime must recover the dragged row from the handle during dragstart.',
            'handleRow = handleTargetRow;' => 'Runtime must arm handle dragging even when pointerdown was missed by the browser.',
            'function armHandle(handle)' => 'Runtime must centralize handle arming so native drag starts only from handles.',
            "function ownerDndRoot(target)" => 'Runtime must detect the nearest DnD owner for nested modal lists.',
            "if (!handle || !rootElement.contains(handle) || !belongsToRoot(handle))" => 'Runtime must not arm handles owned by a nested DnD root.',
            "if (!belongsToRoot(row))" => 'Runtime must ignore drag starts from rows owned by nested DnD roots.',
            "var optionRoot = rootElement.matches && rootElement.matches(selectors.optionList);" => 'Runtime must detect modal option-list roots before pointer handlers run.',
            "if (optionRoot)" => 'Modal option-list roots must bypass main-row native arming and use the option pointer path.',
            'var optionPointerDrag = null;' => 'Runtime must keep one pointer-owned state path for modal option-list dragging.',
            'function startOptionPointerDrag(event, handle)' => 'Modal option-list roots must use one pointer-owned path instead of racing native DnD.',
            'function createOptionPointerPreview(row, event)' => 'Pointer-owned modal option DnD must render a visible floating preview.',
            "preview.classList.add('evo-ui-dnd-floating-preview')" => 'Pointer-owned modal option DnD must use the shared floating preview class.',
            'function updateOptionPointerPreview(event)' => 'Pointer-owned modal option DnD must move the floating preview with the pointer.',
            'removeOptionPointerPreview();' => 'Pointer-owned modal option DnD must clean up the floating preview on finish/cancel.',
            'document.elementFromPoint(event.clientX, event.clientY)' => 'Pointer-owned modal option DnD must resolve the live row under the cursor.',
            "rootElement.addEventListener('dragstart'" => 'Native DnD remains available for main rows.',
            "event.preventDefault();" => 'Option roots must explicitly suppress native dragstart when pointer mode owns the list.',
            'function isStateOwnedOption(type)' => 'Runtime must distinguish Alpine-owned option lists from DOM-owned reorder lists.',
            'function moveStateOwnedOptionTarget(event)' => 'Runtime must calculate option drop positions for Alpine-owned option lists.',
            'function positionFromPlaceholder(container, type)' => 'Runtime must share placeholder position calculation across DOM-owned and state-owned lists.',
            'function createPlaceholder(type, row)' => 'Runtime must create context-aware placeholders for div and table rows.',
            'evo-ui-dnd-placeholder__table-inner' => 'Runtime must render valid table-row placeholders inside tbody lists.',
            "if (isStateOwnedOption(type))" => 'Runtime must bypass DOM commit for state-owned modal options.',
            "if (!optionRoot && handleRow && handleRow.matches(selectors.optionRow))" => 'Runtime must not re-enable native draggable for pointer-owned modal option rows.',
            "if (!optionRoot) {" => 'Runtime must only arm native draggable handles outside pointer-owned modal option lists.',
            "if (type === 'option' && row !== handleRow)" => 'Runtime must detect option-row handle arming races during native dragstart.',
            'handleRow = row;' => 'Runtime must recover option row dragstart when the browser starts native drag before the handle is armed.',
            'selection.removeAllRanges();' => 'Runtime must clear accidental text selection when native drag starts from a handle.',
            "'is-drag-over', 'is-drop-target'" => 'Runtime cleanup must reset root-level drag-over classes.',
            "rootElement.addEventListener('selectstart'" => 'Runtime must prevent text selection from shared drag handles.',
            'dispatch(\'dnd.option.changed\', {uid: uid, position: target.position}, rootElement);' => 'Runtime must let Alpine-owned option lists reorder from state instead of direct DOM moves.',
            'dispatch(\'dnd-option-changed\', {uid: uid, position: target.position}, rootElement);' => 'Runtime must also emit an Alpine-safe option-list reorder event without dot modifiers.',
            'application/x-evo-dnd' => 'Runtime must use the shared dataTransfer payload type.',
            'function createNativeDragImage(row)' => 'Runtime must centralize native drag preview selection.',
            'function createTransparentNativeDragImage()' => 'Runtime must use a transparent native image for table rows so the placeholder is the only visible marker.',
            'function createTableDragPreview(row, event)' => 'Runtime must render an EvoUI-owned visible table row preview instead of relying on the browser ghost.',
            'function updateTableDragPreview(event)' => 'Runtime must keep the table row preview under the pointer during native DnD.',
            'removeTableDragPreview();' => 'Runtime must clean up the table row preview after drag end or drop.',
            'return createTransparentNativeDragImage();' => 'Runtime table row DnD must not render a second native row preview.',
            'return row;' => 'Runtime non-table DnD must keep the native row preview so row styling stays intact.',
            'event.dataTransfer.setDragImage' => 'Runtime must register a native drag preview.',
            "placeholder.setAttribute('data-evo-dnd-placeholder-height', String(height));" => 'Runtime must cache placeholder height before hidden table rows leave layout.',
            "target.style.height = height + 'px';" => 'Runtime must keep table placeholder inner height flush with the source row.',
            'data-evo-dnd-placeholder' => 'Runtime must create a physical placeholder marker.',
            'sortGroupByUid' => 'Runtime must default to the group reorder method contract.',
            'sortItemByUid' => 'Runtime must default to the item reorder method contract.',
            "markDndDirty(rootElement, 'dnd-group');" => 'Runtime must mark group reorders dirty before Livewire redraw.',
            "markDndDirty(rootElement, 'dnd-item');" => 'Runtime must mark item reorders dirty before Livewire redraw.',
            "markDndDirty(rootElement, 'dnd-option');" => 'Runtime must mark option reorders dirty before Livewire redraw.',
            "dispatch('form-dirty'" => 'Runtime must emit an Alpine-safe form dirty event alias for DnD changes.',
            "dispatch('dnd.changed'" => 'Runtime must emit a shared DnD change event.',
            "dispatch('dnd.option.changed'" => 'Runtime must emit option-list changes when no Livewire option method is configured.',
            "dispatch('dnd-option-changed'" => 'Runtime must emit the Alpine-safe option-list event alias.',
            'data-evo-form-dirty' => 'Runtime must integrate with guarded form dirty-state markers.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $js, $message);
        }

        evo_ui_assert_contains('.evo-ui-table-row--dnd.is-drag-hidden {' . PHP_EOL . '    display: none;', $css, 'Dragged table rows must leave the layout so there is no empty duplicate row beside the placeholder.');

        evo_ui_assert_not_contains('pointerOptionDrag', $js, 'Runtime must not keep the old duplicate pointer-drag state name beside optionPointerDrag.');
        evo_ui_assert_not_contains('startStateOwnedOptionPointerDrag', $js, 'Runtime must not keep the old state-owned pointer fallback beside startOptionPointerDrag.');
        evo_ui_assert_not_contains("markDndDirty(rootElement, 'dnd');", $js, 'Runtime must not emit a duplicate generic dirty event from dndCall.');

        foreach (['ssettings', 'sSettingsNativeDnd', '__sSettingsOptionDrag'] as $marker) {
            evo_ui_assert_not_contains($marker, $js, 'Generic DnD runtime must not depend on sSettings markers: ' . $marker);
        }
    });

    evo_ui_test('table and list dnd previews keep one visible drag surface and one placeholder', function (): void {
        $js = evo_ui_read('resources/js/evo-ui.js');
        $css = evo_ui_read('resources/css/evo-ui.css');
        $tablePlaceholderBlock = evo_ui_css_block('.evo-ui-dnd-placeholder__table-inner', $css);
        $tablePreviewBlock = evo_ui_css_block('.evo-ui-dnd-floating-preview--table', $css);
        $tableDragHiddenBlock = evo_ui_css_block('.evo-ui-table-row--dnd.is-drag-hidden', $css);

        foreach ([
            'function createTransparentNativeDragImage()' => 'Table DnD must suppress the browser ghost with a transparent native image.',
            'function createTableDragPreview(row, event)' => 'Table DnD must render an EvoUI-owned floating table preview.',
            'function updateTableDragPreview(event)' => 'Table DnD must move the floating table preview under the pointer.',
            'function removeTableDragPreview()' => 'Table DnD must remove the floating table preview after drop/cancel.',
            "row.tagName && row.tagName.toLowerCase() === 'tr'" => 'Runtime must special-case table rows during native DnD.',
            'tableDragPreview = createTableDragPreview(row, event);' => 'Runtime must create a visible table preview for table rows.',
            'updateTableDragPreview(event);' => 'Runtime must update the visible table preview while dragging.',
            'removeTableDragPreview();' => 'Runtime cleanup must always remove the table preview.',
            'return createTransparentNativeDragImage();' => 'Table rows must not rely on a second browser-rendered drag ghost.',
            'return row;' => 'List/card rows must keep their normal native preview path.',
            "clone.classList.remove('is-dragging', 'is-drag-hidden', 'is-drag-over', 'is-drop-target');" => 'Preview clone must not inherit hidden/dragging state.',
            'stripReactivePreviewAttributes(clone);' => 'Preview clone must not carry Livewire/Alpine attributes.',
            'cell.style.width = Math.max(1, Math.round(source.getBoundingClientRect().width)) + \'px\';' => 'Preview clone must preserve source cell widths.',
            'td.colSpan = Math.max(1, row.children ? row.children.length : 1);' => 'Table placeholder must span the real table width.',
            "placeholder.setAttribute('data-evo-dnd-placeholder-height', String(height));" => 'Placeholder must cache source row height.',
            "target.style.height = height + 'px';" => 'Placeholder inner surface must match source row height.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $js, $message);
        }

        evo_ui_assert_contains('border: 1px dashed', $tablePlaceholderBlock, 'Table placeholder must render as a visible dashed drop slot.');
        evo_ui_assert_contains('background: color-mix', $tablePlaceholderBlock, 'Table placeholder must have a visible surface.');
        evo_ui_assert_contains('opacity: 0.78;', $tablePreviewBlock, 'Table floating preview must stay translucent enough to see the drop slot.');
        evo_ui_assert_contains('table-layout: fixed;', $tablePreviewBlock, 'Table floating preview must preserve column geometry.');
        evo_ui_assert_contains('display: none;', $tableDragHiddenBlock, 'Dragged table row must leave layout so an empty duplicate row is not visible.');
        evo_ui_assert_contains('.evo-ui-list-item--dnd.is-drag-hidden {' . PHP_EOL . '    position: absolute !important;', $css, 'Dragged list item must stay available for native preview without occupying the list flow.');
        evo_ui_assert_order('function createTransparentNativeDragImage()', 'function createTableDragPreview(row, event)', $js, 'Transparent native image helper must be defined before table preview helper.');
        evo_ui_assert_order('removeTableDragPreview();', 'removeNativeDragImage();', $js, 'Cleanup must remove the custom table preview before the transparent native image.');
    });

    evo_ui_test('modal option-list dnd primitive exposes reusable Blade contract', function (): void {
        $list = evo_ui_read('views/components/dnd-option-list.blade.php');
        $row = evo_ui_read('views/components/dnd-option-row.blade.php');
        $docs = evo_ui_read('docs/en/components/dnd/reorder-contract.md');
        $components = evo_ui_read('docs/en/components/README.md');
        $css = evo_ui_read('resources/css/evo-ui.css');
        $onboarding = evo_ui_read('views/components/onboarding-hero.blade.php');

        foreach ([
            'data-evo-dnd' => 'Option list must initialize the shared DnD runtime.',
            'data-evo-dnd-option-list' => 'Option list must expose the shared option-list marker.',
            'data-evo-dnd-option-method' => 'Option list must expose the optional Livewire sort method.',
            'window.EvoUI?.initDnd?.($el)' => 'Option list must reinitialize through the public DnD API.',
            'evo-ui-dnd-option-list__header' => 'Option list must render an optional compact header.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $list, $message);
        }

        foreach (['x-on:dragstart.stop', 'x-on:dragover.stop', 'x-on:drop.stop', 'x-on:dragend.stop'] as $marker) {
            evo_ui_assert_not_contains($marker, $list, 'Option list must let EvoUI runtime own modal drag events without Alpine stop handlers: ' . $marker);
        }

        foreach ([
            'data-evo-dnd-option-row' => 'Option row must expose the shared row marker.',
            'data-evo-dnd-uid' => 'Option row must expose stable local UID metadata.',
            '$rowAttributes' => 'Option row must build explicit shared DnD metadata.',
            "\$attributes->except('draggable')" => 'Option row must own its draggable contract instead of allowing arbitrary consumer overrides.',
            "'draggable' => false" => 'Option row must default away from native HTML5 DnD because modal options use pointer-owned sorting.',
            ':handle-draggable="false"' => 'Option row handles must not start a parallel native drag path.',
            'x-evo::reorder-rail' => 'Option row must use the shared reorder rail.',
            '<x-evo::reorder-rail' => 'Option row must use the shared reorder rail with EvoUI-owned pointer dragging.',
            'wire:model.live="{{ $valueName }}"' => 'Option row must render a value input binding.',
            'wire:model.live="{{ $labelName }}"' => 'Option row must render a label input binding.',
            'data-evo-dnd-option-value' => 'Option row must expose value field marker.',
            'data-evo-dnd-option-label' => 'Option row must expose label field marker.',
            'wire:click="{{ $addAfter }}"' => 'Option row must support add-after actions.',
            'wire:click="{{ $delete }}"' => 'Option row must support delete actions.',
            'evo-ui-dnd-actions evo-ui-row-actions evo-ui-row-actions--compact' => 'Option row must use compact shared actions.',
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

        evo_ui_assert_contains('.evo-ui-drag-handle *,' . PHP_EOL . '.evo-ui-dnd-handle * {' . PHP_EOL . '    pointer-events: none;', $css, 'Drag handle icons must not steal native drag targets.');
        evo_ui_assert_contains('-webkit-user-drag: element;', $css, 'Shared drag handles must preserve Safari native drag behaviour.');

        evo_ui_assert_contains('.evo-ui-modal__body {' . PHP_EOL . '    min-height: 0;' . PHP_EOL . '    padding: 4px 14px 14px;', $css, 'Modal body spacing must stay compact after onboarding modal refactor.');
        evo_ui_assert_contains('.evo-ui-onboarding-hero--modal {' . PHP_EOL . '    padding: 16px 18px;', $css, 'Modal onboarding cards must use compact modal padding.');
        evo_ui_assert_contains('new \Illuminate\View\ComponentAttributeBag', $onboarding, 'Onboarding hero actions must build conditional attributes before the opening tag.');
        evo_ui_assert_not_contains('@if($primaryAction !== \'\') wire:click', $onboarding, 'Onboarding hero must not render conditional attributes inline inside a button opening tag.');
    });
});

evo_ui_group('state', function (): void {
    evo_ui_test('guarded module tab shell owns dirty navigation prompt', function (): void {
        $shell = evo_ui_read('views/components/module-tab-shell.blade.php');

        foreach ([
            'data-evo-module-tab-shell' => 'Module tab shell must expose a stable root marker.',
            'data-evo-module-tab-model' => 'Module tab shell must expose the bound Livewire model marker.',
            '$wire.entangle(@js($model)).live' => 'Module tab shell must entangle the active tab with Livewire.',
            'setActiveModuleTab(tab)' => 'Module tab shell must explicitly sync tab changes back to Livewire.',
            'this.$wire.set(@js($model), tab);' => 'Module tab shell must force a Livewire update when switching tabs.',
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

    evo_ui_test('module table supports provider row actions', function (): void {
        $moduleTable = evo_ui_read('src/Livewire/ModuleTable.php');
        $actions = evo_ui_read('views/components/table/module/actions.blade.php');
        $list = evo_ui_read('views/components/table/module/list.blade.php');

        evo_ui_assert_contains('public function runRowAction', $moduleTable, 'ModuleTable must expose a Livewire row action handler.');
        evo_ui_assert_contains('$this->rowActions()', $moduleTable, 'ModuleTable row actions must be validated against configured row actions.');
        evo_ui_assert_contains("\$action['provider']", $moduleTable, 'ModuleTable row actions must call configured provider methods.');
        evo_ui_assert_contains('disabled_field', $actions, 'Table row actions must support row-driven disabled state.');
        evo_ui_assert_contains('@disabled($disabled)', $actions, 'Table row actions must render disabled state on buttons.');
        evo_ui_assert_contains('disabled_field', $list, 'List row actions must support row-driven disabled state.');
        evo_ui_assert_contains('@disabled($disabled)', $list, 'List row actions must render disabled state on buttons.');
        evo_ui_assert_contains('$withActionKey', $list, 'List row actions must support action-key arguments like table rows.');
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
        $js = evo_ui_read('resources/js/evo-ui.js');

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
        evo_ui_assert_contains('$viewKey', $moduleTableView, 'Module table view branches must use stable keyed roots.');
        evo_ui_assert_contains('$viewKey', $genericTable, 'Generic table view branches must use stable keyed roots.');
        evo_ui_assert_contains("'data-evo-table-view' => \$viewMode", $moduleTableView, 'Module table surface must expose the active view for diagnostics and contracts.');
        evo_ui_assert_contains('data-evo-table-view="{{ $viewMode }}"', $genericTable, 'Generic table surface must expose the active view for diagnostics and contracts.');
        evo_ui_assert_contains('wire:key="{{ $viewKey }}-toolbar-{{ $viewMode }}"', $moduleTableView, 'Module table toolbar must be keyed by view mode to avoid Livewire morph drift.');
        evo_ui_assert_contains('wire:key="{{ $viewKey }}-toolbar-{{ $viewMode }}"', $genericTable, 'Generic table toolbar must be keyed by view mode to avoid Livewire morph drift.');
        evo_ui_assert_contains('wire:key="{{ $viewKey }}-content-{{ $viewMode }}"', $moduleTableView, 'Module table content must be keyed by view mode to force table/list replacement.');
        evo_ui_assert_contains('wire:key="{{ $viewKey }}-content-{{ $viewMode }}"', $genericTable, 'Generic table content must be keyed by view mode to force table/list replacement.');
        evo_ui_assert_contains('data-evo-table-view-content="{{ $viewMode }}"', $moduleTableView, 'Module table content must expose the active view marker.');
        evo_ui_assert_contains('data-evo-table-view-content="{{ $viewMode }}"', $genericTable, 'Generic table content must expose the active view marker.');
        evo_ui_assert_contains('wire:key="{{ $viewKey }}-list"', $moduleTableView, 'Module table list branch must be keyed for Livewire replacement.');
        evo_ui_assert_contains('wire:key="{{ $viewKey }}-table"', $moduleTableView, 'Module table table branch must be keyed for Livewire replacement.');
        evo_ui_assert_contains('wire:key="{{ $viewKey }}-table"', $genericTable, 'Generic table table branch must be keyed for Livewire replacement.');
        evo_ui_assert_contains("data_get(\$row, 'wire_key', 'row-' . data_get(\$row, 'id')) . '-table'", $moduleTableView, 'Module table row keys must be isolated from list row keys.');
        evo_ui_assert_contains('wire:click="setSort', $header, 'Header cells must expose sorting.');
        evo_ui_assert_contains("'q', 'page', 'sort', 'dir', 'f', 'view'", $moduleTable, 'URL query keys must include shareable table state.');
        evo_ui_assert_not_contains("'q', 'page', 'sort', 'dir', 'perPage', 'f', 'view'", $moduleTable, 'Per-page preference must not be persisted in the URL state.');
        evo_ui_assert_contains('$this->dispatchClientState();', $moduleTable, 'Per-page updates must dispatch client state.');
        evo_ui_assert_contains("'urlDefaults' => \$this->urlDefaultState()", $moduleTable, 'Module table payload must expose URL defaults.');
        evo_ui_assert_contains('data-evo-table-url-defaults', $moduleTableView, 'Module table surface must expose URL defaults for client cleanup.');
        evo_ui_assert_contains('cleanDefaultTableUrlState(surface)', $js, 'Module table JavaScript must remove default URL table state.');
        evo_ui_assert_contains('protected function urlDefaultState(): array', $moduleTable, 'Module table must expose URL default state.');
        evo_ui_assert_contains("\$keys = ['q', 'page', 'sort', 'dir', 'f', 'view']", $moduleTable, 'URL state detection must not treat perPage as shareable table state.');
        evo_ui_assert_not_contains("#[Url(as: 'perPage'", $moduleTable, 'Per-page preference must not be written into the URL.');
        evo_ui_assert_contains('data-evo-table-per-page-cookie', $moduleTableView, 'Module table surface must expose a cookie key for first-render per-page preferences.');
        evo_ui_assert_contains('syncTablePerPagePreference(surface)', $js, 'Module table JavaScript must sync per-page preferences before responsive view checks.');
        evo_ui_assert_contains('evo-ui.table.per-page.', $js, 'Module table JavaScript must keep per-page preferences in localStorage.');
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
        evo_ui_assert_not_contains('evo-ui-position-control__value evo-ui-dnd-badge', $cell, 'Table position cells must not show persisted position values as visible chips.');
        evo_ui_assert_not_contains('evo-ui-position-control__value evo-ui-dnd-badge', $list, 'List position controls must not show persisted position values as visible chips.');
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
        $table = evo_ui_read('views/components/table/module.blade.php');
        $list = evo_ui_read('views/components/table/module/list.blade.php');
        $pagination = evo_ui_read('views/components/table/pagination.blade.php');
        $modal = evo_ui_read('views/components/table/module/form-modal.blade.php');
        $modalField = evo_ui_read('views/components/table/module/modal-field.blade.php');
        $deleteModal = evo_ui_read('views/components/table/module/delete-modal.blade.php');
        $cell = evo_ui_read('views/components/table/module/cell.blade.php');

        foreach (['openCreateModal', 'openEditModal', 'saveModal', 'deleteConfirmed', 'moveRow', 'reorderRow', 'sortTableRowByUid'] as $method) {
            evo_ui_assert_contains('function ' . $method, $moduleTable, 'ModuleTable must expose method: ' . $method);
        }

        evo_ui_assert_contains('deleteErrorMessage', $moduleTable, 'Delete guard failures must be stored for rendering.');
        evo_ui_assert_contains('deleteErrorMessage', $deleteModal, 'Delete modal must render delete guard failures.');
        evo_ui_assert_contains('data-evo-delete-confirm-action', $deleteModal, 'Livewire delete modal must align the destructive action with the shared confirm footer contract.');
        evo_ui_assert_contains('new \Illuminate\View\ComponentAttributeBag', $table, 'Table rows must build conditional attributes before the opening tag.');
        evo_ui_assert_contains('data-evo-modal-dblclick', $table, 'Table rows must expose modal double-click through merged attributes.');
        evo_ui_assert_contains('data-evo-modal-action', $table, 'Table rows must support action-modal double-click for read-only detail views.');
        evo_ui_assert_contains('new \Illuminate\View\ComponentAttributeBag', $list, 'List rows must build conditional attributes before the opening tag.');
        evo_ui_assert_contains('data-evo-modal-dblclick', $list, 'List rows must expose modal double-click through merged attributes.');
        evo_ui_assert_contains('data-evo-modal-action', $list, 'List rows must support action-modal double-click for read-only detail views.');
        evo_ui_assert_contains('@if($isCurrent)', $pagination, 'Pagination must branch on the whole current-page button instead of an inline attribute.');
        evo_ui_assert_contains('aria-current="page"', $pagination, 'Pagination must render aria-current only on the active page button.');
        evo_ui_assert_not_contains('@if($isCurrent) aria-current="page" @endif', $pagination, 'Pagination must not render conditional attributes inline inside a button opening tag.');
        foreach ([
            'views/components/table/module.blade.php',
            'views/components/table/module/list.blade.php',
            'views/components/table/pagination.blade.php',
            'views/livewire/module-table.blade.php',
            'views/livewire/table.blade.php',
            'views/components/onboarding-hero.blade.php',
        ] as $view) {
            evo_ui_assert_no_inline_blade_conditionals_in_opening_tags($view);
        }
        evo_ui_assert_contains('$showSubmit', $modal, 'Modal form must support read-only/action detail modals without a submit button.');
        evo_ui_assert_contains('x-on:submit.prevent', $modal, 'Read-only modal submit must be prevented without saving.');
        evo_ui_assert_contains('EvoUI.syncRichEditors($el, $wire).then(() => $wire.saveModal())', $modal, 'Modal submit must sync rich editors before saving.');
        evo_ui_assert_contains('$type === \'static\'', $modalField, 'Modal fields must support top-level static read-only fields.');
        evo_ui_assert_contains('$type === \'code\'', $modalField, 'Modal fields must support top-level code/log fields.');
        evo_ui_assert_contains('$type === \'badge\'', $modalField, 'Modal fields must support top-level badge fields.');
        evo_ui_assert_contains("in_array(\$type, ['color', 'color-picker'], true)", $modalField, 'Modal fields must support color picker fields.');
        evo_ui_assert_contains('$type === \'choices\'', $modalField, 'Modal fields must support choices fields.');
        evo_ui_assert_contains('$type === \'builder\'', $modalField, 'Modal fields must support builder fields.');
        evo_ui_assert_contains('x-evo::reorder-rail', $cell, 'Position cells must use the shared reorder rail.');
        evo_ui_assert_contains('move-up="moveRow', $cell, 'Position cells must expose moveRow up controls.');
        evo_ui_assert_contains('move-down="moveRow', $cell, 'Position cells must expose moveRow down controls.');
        evo_ui_assert_contains('evo-ui-reorder-rail--table', $cell, 'Position cells must use the table rail visual modifier.');
        evo_ui_assert_contains('data-evo-dnd', $table, 'Reorderable module tables must initialize the shared DnD root.');
        evo_ui_assert_contains('data-evo-dnd-item-method', $table, 'Reorderable module tables must map drops to the table sort method.');
        evo_ui_assert_contains('sortTableRowByUid', $table, 'Reorderable module tables must call the table row DnD mapper.');
        evo_ui_assert_contains('data-evo-dnd-list', $table, 'Table rows must live inside a shared DnD list.');
        evo_ui_assert_contains('data-evo-dnd-item', $table, 'Table rows must expose shared DnD item markers.');
        evo_ui_assert_contains('data-evo-dnd-uid', $table, 'Table rows must expose stable row ids for DnD.');
        evo_ui_assert_contains('draggable', $table, 'Table rows must opt into native DnD.');
        evo_ui_assert_contains('data-evo-dnd-list', $list, 'List rows must live inside a shared DnD list.');
        evo_ui_assert_contains('data-evo-dnd-item', $list, 'List rows must expose shared DnD item markers.');
        evo_ui_assert_contains('data-evo-dnd-uid', $list, 'List rows must expose stable row ids for DnD.');
        evo_ui_assert_contains('draggable', $list, 'List rows must opt into native DnD.');
        evo_ui_assert_contains("\$this->provider()->rows(\$this->page, \$this->perPage)", $moduleTable, 'Table DnD mapper must resolve visible rows before calling the provider reorder hook.');
        evo_ui_assert_contains("\$this->reorderRow(\$id, \$targetId, \$placement)", $moduleTable, 'Table DnD mapper must reuse the provider reorderRow contract.');
    });

    evo_ui_test('module table table/list switch and reorder markers stay isolated', function (): void {
        $moduleTable = evo_ui_read('views/components/table/module.blade.php');
        $list = evo_ui_read('views/components/table/module/list.blade.php');
        $toolbar = evo_ui_read('views/components/table/module/toolbar.blade.php');
        $cell = evo_ui_read('views/components/table/module/cell.blade.php');

        foreach ([
            'wire:key="{{ $viewKey }}-toolbar-{{ $viewMode }}"' => 'Toolbar must be keyed by view mode so search and view buttons do not disappear after switching.',
            'wire:key="{{ $viewKey }}-content-{{ $viewMode }}"' => 'Content root must be keyed by view mode so table/list branches replace cleanly.',
            'wire:key="{{ $viewKey }}-table"' => 'Table branch must have a dedicated key.',
            'wire:key="{{ $viewKey }}-list"' => 'List branch must have a dedicated key.',
            "'data-evo-table-view' => \$viewMode" => 'Table surface must expose the active view mode.',
            'data-evo-table-view-content="{{ $viewMode }}"' => 'Table content must expose the active view mode.',
            "'data-evo-dnd-item-method' => 'sortTableRowByUid'" => 'Reorderable table and list views must use the same table row UID sort method.',
            "'data-evo-dnd-list' => true" => 'Table body/list root must expose a shared DnD list marker.',
            "'data-evo-dnd-item' => true" => 'Rows must expose shared DnD item markers.',
            "'data-evo-dnd-uid' => (string) \$rowId" => 'Rows must expose stable DnD UIDs.',
            "'data-evo-table-row' => (string) \$rowId" => 'Rows must expose table diagnostics markers.',
            "'class' => 'evo-ui-table-row--dnd'" => 'Table rows must use the shared table DnD visual class.',
        ] as $marker => $message) {
            evo_ui_assert_contains($marker, $moduleTable . "\n" . $list, $message);
        }

        evo_ui_assert_contains("wire:click=\"switchView('table')\"", $toolbar, 'Toolbar must provide table view switching.');
        evo_ui_assert_contains("wire:click=\"switchView('list')\"", $toolbar, 'Toolbar must provide list view switching.');
        evo_ui_assert_contains('wire:model.live.debounce.300ms="{{ $searchState }}"', $toolbar, 'Toolbar search must stay bound after view switching.');
        evo_ui_assert_contains('evo-ui-list-item--dnd', $list, 'List view rows must use the shared list DnD visual class.');
        evo_ui_assert_contains("\$type === 'position'", $cell, 'Position cells must render the shared reorder rail.');
        evo_ui_assert_contains('evo-ui-sr-only', $cell, 'Position values must be screen-reader-only so the visual UI does not show an extra numeric position field.');
        evo_ui_assert_not_contains('data-evo-dnd-placeholder', $moduleTable, 'Module table Blade must not render a static placeholder row; runtime owns the placeholder.');
        evo_ui_assert_not_contains('data-evo-dnd-placeholder', $list, 'Module list Blade must not render a static placeholder row; runtime owns the placeholder.');
        evo_ui_assert_not_contains('evo-ui-dnd-placeholder', $moduleTable, 'Module table Blade must not render static placeholder CSS classes.');
        evo_ui_assert_not_contains('evo-ui-dnd-placeholder', $list, 'Module list Blade must not render static placeholder CSS classes.');
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
        $docs = evo_ui_read('docs/en/components/form-fields.md');

        foreach ([
            "'evo-ui-form-surface--density-' . \$density" => 'Form surface must expose a density class.',
            'evo-ui-form-surface--layout-' => 'Form surface must expose a layout class.',
            "'evo-ui-form-surface--heading-hidden'" => 'Form surface must expose hidden-heading state.',
            ":name=\"\$action['icon'] ?? 'check'\"" => 'Default Save icon must be check.',
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
            'grid-template-columns: minmax(260px, 340px) minmax(0, 1fr)' => 'Settings rows must keep usage labels readable while controls remain close.',
            'gap: 14px;' => 'Settings rows must keep a controlled label/control gap.',
            '.evo-ui-settings-row__meta' => 'CSS must style settings row metadata.',
            '.evo-ui-settings-row:has(.evo-ui-select--listbox, .evo-ui-select--multiple, .evo-ui-textarea, textarea) .evo-ui-settings-row__meta' => 'Tall settings controls must top-align their labels.',
            '.evo-ui-settings-row__usage' => 'CSS must style settings usage code.',
            'overflow-wrap: anywhere;' => 'Settings usage code must wrap instead of clipping long config keys.',
            '.evo-ui-settings-divider' => 'CSS must style divider rows.',
            'select.evo-ui-input option' => 'CSS must style native select options as far as the browser allows.',
            'select.evo-ui-input.evo-ui-select--listbox:not([multiple])' => 'Listbox selects must override compact single-select height.',
            'select.evo-ui-select--listbox option:checked' => 'CSS must style selected listbox options as far as the browser allows.',
            'select.evo-ui-select--multiple option:checked' => 'CSS must style selected multi-listbox options as far as the browser allows.',
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
        evo_ui_assert_contains('savedFeedback', $formView, 'Form saves must use in-button saved feedback state.');
        evo_ui_assert_contains('x-bind:aria-label="savedFeedback ? @js(__(\'evo::global.form_saved\'))', $formView, 'Form save button must expose the saved state through accessible text.');
        evo_ui_assert_contains('name="circle-check"', $formView, 'Form save button must switch icon for saved feedback.');
        evo_ui_assert_contains('<span class="evo-ui-btn__label">@lang($action[\'label\'] ?? \'evo::global.action_save\')</span>', $formView, 'Form save button visible label must stay stable to avoid width shifts.');
        evo_ui_assert_not_contains('x-text="savedFeedback ?', $formView, 'Form save button must not change visible text during saved feedback.');
        evo_ui_assert_contains("x-bind:disabled=\"!dirty || savedFeedback\"", $formView, 'Form save button must disable while clean or showing saved feedback.');
        evo_ui_assert_not_contains('evo-ui-save-toast', $formView, 'Form saved feedback must not render a floating toast.');
        evo_ui_assert_not_contains('evo-ui-alert evo-ui-alert--success" role="status"', $formView, 'Form saved feedback must not render as a wide inline alert.');
        evo_ui_assert_contains('section_columns', $formView, 'Form component must support independent section columns.');
        evo_ui_assert_contains('evo-ui-form-column-layout', $formView, 'Form component must render a column layout wrapper.');
        evo_ui_assert_contains('evo-ui-form-section--span-', $sectionView, 'Shared form section partial must preserve span classes.');
        evo_ui_assert_not_contains('.evo-ui-save-toast', $css, 'Form save feedback must not rely on floating toast CSS.');
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
            "\$type === 'multi-select'" => 'Multi-select field contract must be rendered.',
            "\$itemType === 'multi-select'" => 'Config-map child fields must support compact multi-select controls.',
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
        evo_ui_assert_contains('normalizeLegacyEditorInlineScript', $js, 'Runtime must normalize repeated legacy rich editor inline scripts.');
        evo_ui_assert_contains('typeof $2 !== "undefined" && $2 && typeof $2 === "object"', $js, 'Runtime must refresh TinyMCE config selector before repeated init calls.');
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
            "'multi-checkbox', 'multi-select' => \$this->castMultiValue(\$field, \$value)," => 'Form must cast multi-select values before save.',
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

if (evo_ui_exit_code($failed) !== 0) {
    echo "FAIL {$failed} tests / {$assertions} assertions\n";
    exit(1);
}

echo "OK {$passed} tests / {$assertions} assertions\n";
