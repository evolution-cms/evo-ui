<?php

namespace EvoUI\Livewire;

use EvoUI\EvoUI;
use EvoUI\Support\ConfigFormService;
use EvoUI\Support\Permissions;
use EvoUI\Support\ResourceFormService;
use EvoUI\Support\ResourceLayoutResolver;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Component;

/**
 * Livewire invokes public form actions from Blade/runtime.
 *
 * @noinspection PhpUnused
 */
class Form extends Component
{
    public string $preset = 'site_content';

    #[Url(as: 'record', history: true, except: 0)]
    public int $recordId = 0;

    #[Url(as: 'locale', history: true, except: '')]
    public string $locale = '';

    /** @var array<string, mixed> */
    public array $data = [];
    /** @var array<string, mixed> */
    public array $cleanData = [];
    public bool $dirty = false;
    public bool $saved = false;

    public function mount(string $preset = 'site_content', int $recordId = 0, string $locale = ''): void
    {
        $this->preset = $preset;
        $this->recordId = $recordId;
        $this->locale = $locale;
        $this->fillData();
    }

    public function resetForm(): void
    {
        $this->resetErrorBag();
        $this->saved = false;
        $this->fillData();
        $this->dispatch('evo-ui:form.reset', preset: $this->preset, recordId: $this->recordId, locale: $this->locale);
    }

    public function save(): void
    {
        $this->authorizeSave();
        $this->saved = false;
        $this->validate($this->rules(), [], $this->validationAttributes());
        $this->dispatch('evo-ui:form.saving', preset: $this->preset, recordId: $this->recordId, locale: $this->locale);

        if ($this->sourceType() === 'config') {
            $this->saveConfig();
        } else {
            $this->saveModel();
        }

        $this->saved = true;
        $this->rememberCleanData();
        $this->dirty = false;
        $this->dispatch('evo-ui:form.saved', preset: $this->preset, recordId: $this->recordId, locale: $this->locale);
    }

    public function updatedData(mixed $value = null, ?string $key = null): void
    {
        $this->saved = false;
        $this->dirty = $this->dataSnapshot($this->data) !== $this->dataSnapshot($this->cleanData);
    }

    public function render(): View
    {
        /** @var View $view */
        $view = view('evo::livewire.form', [
            'controller' => $this,
            'config' => $this->formConfig(),
            'tabs' => $this->tabs(),
            'sections' => $this->sections(),
            'actions' => $this->actions(),
            'saved' => $this->saved,
            'dirty' => $this->dirty,
        ]);

        return $view;
    }

    /**
     * @param array<string, mixed> $field
     * @return array<int, array{value: mixed, label: mixed}>
     */
    public function fieldOptions(array $field): array
    {
        if (!empty($field['options'])) {
            return collect($field['options'])
                ->map(fn ($option) => [
                    'value' => $option['value'],
                    'label' => __($option['label'] ?? $option['value']),
                ])
                ->values()
                ->all();
        }

        $source = $field['options_source'] ?? [];
        $type = $source['type'] ?? 'model';

        if ($type === 'config_csv') {
            return $this->csvOptions((string) ($source['key'] ?? ''), (string) ($source['fallback'] ?? ''));
        }

        if ($type === 'rich_text_editors') {
            return $this->richTextEditorOptions($source);
        }

        $model = $source['model'] ?? null;

        if (!$model) {
            return [];
        }

        $value = $source['value'] ?? 'id';
        $label = $source['label'] ?? 'name';
        $query = $model::query()->select([$value, $label]);

        foreach (($source['order_by'] ?? [[$label, 'asc']]) as $order) {
            $query->orderBy($order[0], $order[1] ?? 'asc');
        }

        return $query->get()
            ->map(fn ($row) => ['value' => $row->{$value}, 'label' => (string) $row->{$label}])
            ->values()
            ->all();
    }

    /**
     * @param array<string, mixed> $source
     * @return array<int, array{value: string, label: mixed}>
     */
    protected function richTextEditorOptions(array $source): array
    {
        $registered = evo()->invokeEvent('OnRichTextEditorRegister');
        $editors = collect(is_array($registered) ? $registered : [])
            ->flatten()
            ->filter(fn ($editor) => is_string($editor) && trim($editor) !== '')
            ->map(fn (string $editor) => trim($editor))
            ->unique()
            ->values();

        if (($source['include_system'] ?? true) === true) {
            $editors->prepend((string) ($source['system_value'] ?? 'system'));
        }

        return $editors
            ->map(fn (string $editor) => [
                'value' => $editor,
                'label' => $editor === (string) ($source['system_value'] ?? 'system')
                    ? __($source['system_label'] ?? 'evo::global.default')
                    : $editor,
            ])
            ->values()
            ->all();
    }

    /** @param array<string, mixed> $field */
    public function fieldDisplay(array $field): string
    {
        $value = data_get($this->data, $field['name']);

        if (($field['display'] ?? null) === 'resource_parent') {
            return $this->resourceParentLabel((int) $value);
        }

        return is_scalar($value) ? (string) $value : '';
    }

    public function setResourceParent(string $field, int $id, string $label = ''): void
    {
        if (!$this->canSetResourceParent($field)) {
            throw new AuthorizationException('This action is unauthorized.');
        }

        if ($this->parentWouldCreateLoop($id)) {
            $this->addError('data.' . $field, __('evo::global.resource_parent_invalid'));
            $this->dispatch('evo-ui:resource-parent.rejected', field: $field, id: $id, reason: 'loop');
            return;
        }

        data_set($this->data, $field, max(0, $id));
        $this->saved = false;
        $this->resetErrorBag('data.' . $field);
        $this->dispatch('evo-ui:resource-parent.selected', field: $field, id: $id, label: $label);
    }

    public function addConfigMapItem(string $fieldName): void
    {
        $field = $this->fieldDefinition($fieldName);

        if (($field['type'] ?? null) !== 'config-map') {
            return;
        }

        $items = array_values((array) data_get($this->data, $fieldName, []));
        $keyField = (string) ($field['key_field'] ?? '_key');
        $labelField = (string) ($field['label_field'] ?? 'name');
        $defaults = (array) ($field['default_item'] ?? []);
        $existingKeys = collect($items)
            ->map(fn ($item) => (string) data_get($item, $keyField, ''))
            ->filter()
            ->all();
        $baseKey = (string) ($defaults[$keyField] ?? ($field['new_key'] ?? 'type'));
        $key = $this->uniqueConfigMapKey($baseKey, array_values($existingKeys));

        $defaults[$keyField] = $key;
        if (!isset($defaults[$labelField])) {
            $defaults[$labelField] = Str::headline($key);
        }

        $items[] = $defaults;
        data_set($this->data, $fieldName, $items);
        $this->updatedData();
    }

    public function removeConfigMapItem(string $fieldName, int $index): void
    {
        $field = $this->fieldDefinition($fieldName);

        if (($field['type'] ?? null) !== 'config-map') {
            return;
        }

        $items = array_values((array) data_get($this->data, $fieldName, []));

        if (!isset($items[$index]) || $this->configMapDeleteBlocked($field, $items[$index], $index)) {
            return;
        }

        unset($items[$index]);
        data_set($this->data, $fieldName, array_values($items));
        $this->updatedData();
    }

    /**
     * @param array<string, mixed> $field
     * @param array<string, mixed> $item
     */
    public function configMapDeleteBlocked(array $field, array $item, int $index = 0): bool
    {
        $keyField = (string) ($field['key_field'] ?? '_key');
        $key = (string) data_get($item, $keyField, '');
        $protectedKeys = array_map('strval', (array) ($field['protected_keys'] ?? []));

        if ($index === 0 && ($field['protect_first'] ?? false)) {
            return true;
        }

        if ($key !== '' && in_array($key, $protectedKeys, true)) {
            return true;
        }

        return $this->configMapUsageCount($field, $item) > 0;
    }

    /**
     * @param array<string, mixed> $field
     * @param array<string, mixed> $item
     */
    public function configMapUsageCount(array $field, array $item): int
    {
        $guard = (array) ($field['delete_guard'] ?? []);
        $table = (string) ($guard['table'] ?? '');
        $column = (string) ($guard['column'] ?? '');
        $keyField = (string) ($field['key_field'] ?? '_key');
        $key = (string) data_get($item, $keyField, '');

        if ($table === '' || $column === '' || $key === '') {
            return 0;
        }

        return (int) DB::table($table)->where($column, $key)->count();
    }

    /** @param array<string, mixed> $action */
    public function actionUrl(array $action): string
    {
        $url = (string) ($action['url'] ?? '#');

        return str_replace('{id}', (string) $this->recordId, $url);
    }

    /** @param array<string, mixed> $config */
    public function formTitle(array $config): string
    {
        $field = $config['title_field'] ?? null;

        if ($field) {
            $value = data_get($this->data, $field);

            if (is_scalar($value) && (string) $value !== '') {
                return (string) $value;
            }
        }

        return (string) __($config['title'] ?? 'evo::global.form');
    }

    /** @param array<string, mixed> $config */
    public function formMeta(array $config): string
    {
        $field = $config['meta_field'] ?? null;
        $value = $field ? data_get($this->data, $field, $this->recordId) : ($config['meta'] ?? null);

        return $value ? '(' . $value . ')' : '';
    }

    public function currentRecordId(): int
    {
        if ($this->sourceType() !== 'model') {
            return $this->recordId;
        }

        $config = $this->formConfig();
        $model = $this->resourceForms()->modelInstance($config, $this->recordId);

        return (int) $model->getAttribute($this->resourceForms()->sourceKey($config));
    }

    /** @param array<string, mixed> $field */
    public function customFieldView(array $field): ?string
    {
        $view = app(EvoUI::class)->formFieldView($field);

        return $view && app('view')->exists($view) ? $view : null;
    }

    protected function fillData(): void
    {
        $this->data = [];

        if ($this->sourceType() === 'config') {
            $this->fillConfigData();
            $this->rememberCleanData();
            return;
        }

        $this->fillModelData();
        $this->rememberCleanData();
    }

    protected function fillModelData(): void
    {
        $this->data = $this->resourceForms()->fill(
            $this->formConfig(),
            $this->fields(),
            $this->recordId,
            $this->locale,
            fn (array $field, mixed $value) => $this->valueForDisplay($field, $value)
        );
    }

    protected function fillConfigData(): void
    {
        $this->data = $this->configForms()->fill($this->formConfig(), $this->fields());

        foreach ($this->fields() as $field) {
            data_set($this->data, $field['name'], $this->valueForDisplay($field, data_get($this->data, $field['name'])));
        }
    }

    protected function saveModel(): void
    {
        $this->recordId = $this->resourceForms()->save(
            $this->formConfig(),
            $this->fields(),
            $this->data,
            $this->recordId,
            $this->locale,
            fn (array $field, mixed $value) => $this->castValue($field, $value)
        );

        if (data_get($this->data, '_syncsite') && function_exists('evo')) {
            evo()->clearCache('full');
        }
    }

    protected function saveConfig(): void
    {
        $this->configForms()->save(
            $this->formConfig(),
            $this->fields(),
            $this->data,
            fn (array $field, mixed $value) => $this->castValue($field, $value)
        );
    }

    protected function sourceType(): string
    {
        return (string) $this->formConfig('source.type', 'model');
    }

    /** @return array<int, array<string, mixed>> */
    protected function fields(): array
    {
        $fields = [];

        foreach ((array) $this->formConfig('sections', []) as $section) {
            foreach ((array) data_get($section, 'fields', []) as $field) {
                if (!is_array($field) || !$this->fieldIsEnabled($field) || !$this->allowed($field)) {
                    continue;
                }

                $fields[] = $field;
            }
        }

        return $fields;
    }

    /** @return array<int, array<string, mixed>> */
    protected function sections(): array
    {
        return collect($this->formConfig('sections', []))
            ->map(function (array $section) {
                $section['fields'] = collect($section['fields'] ?? [])
                    ->filter(fn ($field) => $this->fieldIsEnabled($field))
                    ->filter(fn ($field) => $this->allowed($field))
                    ->values()
                    ->all();

                return $section;
            })
            ->filter(fn ($section) => $this->allowed($section))
            ->filter(fn ($section) => $section['fields'] !== [])
            ->values()
            ->all();
    }

    /** @return array<int, array<string, mixed>> */
    protected function tabs(): array
    {
        $sections = collect($this->sections())->pluck('tab')->filter()->unique()->all();

        return collect($this->formConfig('tabs', []))
            ->filter(fn ($tab) => $this->allowed($tab))
            ->filter(fn ($tab) => $sections === [] || in_array($tab['name'] ?? '', $sections, true))
            ->values()
            ->all();
    }

    /** @return array<int, array<string, mixed>> */
    protected function actions(): array
    {
        return collect($this->formConfig('actions', []))
            ->filter(fn ($action) => $this->allowed($action))
            ->values()
            ->all();
    }

    /** @param array<string, mixed> $definition */
    protected function allowed(array $definition): bool
    {
        return app(Permissions::class)->allows($definition);
    }

    protected function authorizeSave(): void
    {
        $definition = $this->formConfig('save', []);

        if (!$definition) {
            $definition = collect($this->formConfig('actions', []))
                ->first(fn ($action) => ($action['type'] ?? null) === 'save') ?? [];
        }

        if (!$this->allowed($definition)) {
            throw new AuthorizationException('This action is unauthorized.');
        }
    }

    /** @param array<string, mixed> $field */
    protected function fieldIsEnabled(array $field): bool
    {
        if ($this->isTvField($field)) {
            $enabledTvs = $this->formConfig('enabled_tvs', []);
            $tvName = data_get($field, 'storage.name');

            return $enabledTvs === [] || in_array($tvName, $enabledTvs, true) || in_array($field['name'] ?? '', $enabledTvs, true);
        }

        $enabled = $this->formConfig('enabled_fields', []);

        return $enabled === [] || in_array($field['name'] ?? '', $enabled, true);
    }

    /** @return array<string, mixed> */
    protected function rules(): array
    {
        return collect($this->fields())
            ->filter(fn ($field) => !empty($field['rules']))
            ->filter(fn ($field) => ($field['save'] ?? true) !== false)
            ->mapWithKeys(fn ($field) => ['data.' . $field['name'] => $field['rules']])
            ->all();
    }

    /** @return array<string, string> */
    protected function validationAttributes(): array
    {
        return collect($this->fields())
            ->mapWithKeys(fn ($field) => ['data.' . $field['name'] => __($field['label'] ?? $field['name'])])
            ->all();
    }

    /** @param array<string, mixed> $field */
    protected function castValue(array $field, mixed $value): mixed
    {
        if (($field['invert'] ?? false) === true) {
            $value = !$value;
        }

        return match ($field['type'] ?? 'text') {
            'checkbox' => (bool) $value,
            'config-map' => $this->castConfigMapValue($field, $value),
            'csv' => $this->castCsvValue($value),
            'datetime' => $this->castDateTimeValue($value),
            'multi-checkbox', 'multi-select' => $this->castMultiValue($field, $value),
            'number' => is_numeric($value) ? (int) $value : 0,
            'radio' => $this->castSelectValue($field, $value),
            'resource-parent' => max(0, (int) $value),
            'select' => $this->castSelectValue($field, $value),
            default => is_string($value) ? trim($value) : $value,
        };
    }

    /** @param array<string, mixed> $field */
    protected function castSelectValue(array $field, mixed $value): mixed
    {
        $rules = Arr::wrap($field['rules'] ?? []);

        return in_array('integer', $rules, true) ? (int) $value : (string) $value;
    }

    /**
     * @param array<string, mixed> $field
     * @return array<int, string>
     */
    protected function castMultiValue(array $field, mixed $value): array
    {
        $allowed = collect($this->fieldOptions($field))
            ->pluck('value')
            ->map(fn ($item) => (string) $item)
            ->all();

        return collect((array) $value)
            ->map(fn ($item) => (string) $item)
            ->filter(fn ($item) => in_array($item, $allowed, true))
            ->unique()
            ->values()
            ->all();
    }

    /** @return array<int, string> */
    protected function castCsvValue(mixed $value): array
    {
        return collect(is_array($value) ? $value : explode(',', (string) $value))
            ->map(fn ($item) => trim((string) $item))
            ->filter(fn ($item) => $item !== '')
            ->unique()
            ->values()
            ->all();
    }

    protected function castDateTimeValue(mixed $value): int
    {
        if (!$value) {
            return 0;
        }

        $timestamp = strtotime((string) $value);

        return $timestamp ? (int) $timestamp : 0;
    }

    /** @param array<string, mixed> $field */
    protected function valueForDisplay(array $field, mixed $value): mixed
    {
        if (($field['invert'] ?? false) === true) {
            return !$value;
        }

        if (($field['type'] ?? null) === 'datetime') {
            return $value ? date('Y-m-d\TH:i', (int) $value) : '';
        }

        if (in_array(($field['type'] ?? null), ['multi-checkbox', 'multi-select'], true) && is_string($value)) {
            return collect(explode('||', $value))
                ->map(fn ($item) => trim($item))
                ->filter()
                ->values()
                ->all();
        }

        if (($field['type'] ?? null) === 'csv' && is_array($value)) {
            return collect($value)
                ->map(fn ($item) => trim((string) $item))
                ->filter(fn ($item) => $item !== '')
                ->implode(', ');
        }

        if (($field['type'] ?? null) === 'config-map') {
            return $this->configMapForDisplay($field, $value);
        }

        return $value;
    }

    /**
     * @param array<string, mixed> $field
     * @return array<int, array<string, mixed>>
     */
    protected function configMapForDisplay(array $field, mixed $value): array
    {
        $keyField = (string) ($field['key_field'] ?? '_key');

        return collect((array) $value)
            ->map(function ($item, $key) use ($keyField) {
                $item = is_array($item) ? $item : [];
                $item[$keyField] = (string) ($item[$keyField] ?? $key);

                return $item;
            })
            ->values()
            ->all();
    }

    /**
     * @param array<string, mixed> $field
     * @return array<string, array<string, mixed>>
     */
    protected function castConfigMapValue(array $field, mixed $value): array
    {
        $keyField = (string) ($field['key_field'] ?? '_key');
        $fallbackPrefix = (string) ($field['new_key'] ?? 'type');
        $items = [];

        foreach (array_values((array) $value) as $index => $item) {
            if (!is_array($item)) {
                continue;
            }

            $key = $this->normalizeConfigMapKey((string) data_get($item, $keyField, ''));
            if ($key === '') {
                $key = $this->uniqueConfigMapKey($fallbackPrefix, array_keys($items));
            }

            $key = $this->uniqueConfigMapKey($key, array_keys($items));
            unset($item[$keyField]);

            $items[$key] = $this->normalizeConfigMapItem($field, $item);
        }

        return $items;
    }

    /**
     * @param array<string, mixed> $field
     * @param array<string, mixed> $item
     * @return array<string, mixed>
     */
    protected function normalizeConfigMapItem(array $field, array $item): array
    {
        $fields = collect((array) ($field['fields'] ?? []))
            ->filter(fn ($child) => is_array($child) && !empty($child['name']))
            ->all();

        if ($fields === []) {
            return $item;
        }

        $out = [];

        foreach ($fields as $child) {
            $name = (string) $child['name'];
            $out[$name] = $this->castValue($child, data_get($item, $name, $child['default'] ?? null));
        }

        return $out;
    }

    protected function normalizeConfigMapKey(string $key): string
    {
        $key = Str::slug($key, '_');

        return preg_replace('/[^a-z0-9_]/', '', strtolower($key)) ?: '';
    }

    /** @param list<string>|array<string, mixed> $existing */
    protected function uniqueConfigMapKey(string $key, array $existing): string
    {
        $base = $this->normalizeConfigMapKey($key) ?: 'type';
        $candidate = $base;
        $i = 2;

        while (in_array($candidate, $existing, true)) {
            $candidate = $base . '_' . $i;
            $i++;
        }

        return $candidate;
    }

    /** @return array<string, mixed> */
    protected function fieldDefinition(string $fieldName): array
    {
        return collect($this->fields())
            ->first(fn ($field) => ($field['name'] ?? null) === $fieldName) ?? [];
    }

    protected function rememberCleanData(): void
    {
        $this->cleanData = $this->data;
        $this->dirty = false;
    }

    /** @param array<string, mixed> $data */
    protected function dataSnapshot(array $data): string
    {
        $snapshot = json_encode($this->normalizeSnapshotData($data), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return is_string($snapshot) ? $snapshot : '';
    }

    protected function normalizeSnapshotData(mixed $value): mixed
    {
        if (is_array($value)) {
            ksort($value);

            return array_map(fn ($item) => $this->normalizeSnapshotData($item), $value);
        }

        return $value;
    }

    /** @param array<string, mixed> $field */
    protected function isTvField(array $field): bool
    {
        return data_get($field, 'storage.type') === 'tv';
    }

    /** @return array<int, array{value: string, label: string}> */
    protected function csvOptions(string $key, string $fallback): array
    {
        $value = function_exists('evo') ? evo()->getConfig($key, $fallback) : $fallback;

        return collect(explode(',', (string) $value))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->map(fn ($item) => ['value' => $item, 'label' => $item])
            ->values()
            ->all();
    }

    protected function resourceParentLabel(int $id): string
    {
        if ($id <= 0) {
            $site = function_exists('evo') ? evo()->getConfig('site_name', 'My Evolution Site') : 'My Evolution Site';

            return '0 (' . $site . ')';
        }

        $model = (string) $this->formConfig('source.model');
        $resource = $model::query()->select(['id', 'pagetitle'])->find($id);

        return $resource ? "{$resource->id} ({$resource->pagetitle})" : (string) $id;
    }

    protected function canSetResourceParent(string $fieldName): bool
    {
        return collect($this->fields())->contains(fn ($field) => ($field['name'] ?? null) === $fieldName
            && ($field['type'] ?? null) === 'resource-parent'
            && ($field['save'] ?? true) !== false);
    }

    protected function parentWouldCreateLoop(int $parentId): bool
    {
        $recordId = $this->currentRecordId();

        if ($parentId <= 0 || $recordId <= 0) {
            return false;
        }

        if ($parentId === $recordId) {
            return true;
        }

        $model = (string) $this->formConfig('source.model');

        if (!$model || !class_exists($model)) {
            return false;
        }

        $visited = [];
        $current = $model::query()->select(['id', 'parent'])->find($parentId);

        while ($current) {
            $currentId = (int) $current->id;

            if ($currentId === $recordId) {
                return true;
            }

            if (isset($visited[$currentId])) {
                return true;
            }

            $visited[$currentId] = true;
            $nextParent = (int) $current->parent;

            if ($nextParent <= 0) {
                break;
            }

            $current = $model::query()->select(['id', 'parent'])->find($nextParent);
        }

        return false;
    }

    protected function resourceForms(): ResourceFormService
    {
        return app(ResourceFormService::class);
    }

    protected function configForms(): ConfigFormService
    {
        return app(ConfigFormService::class);
    }

    protected function formConfig(?string $key = null, mixed $default = null): mixed
    {
        $config = $this->resolvedFormConfig();

        return $key ? data_get($config, $key, $default) : $config;
    }

    protected function rawFormConfig(?string $key = null, mixed $default = null): mixed
    {
        $config = config('evo-ui.forms.' . $this->preset, []);

        return $key ? data_get($config, $key, $default) : $config;
    }

    /** @return array<string, mixed> */
    protected function resolvedFormConfig(): array
    {
        $config = $this->rawFormConfig();

        if (($config['source']['type'] ?? 'model') !== 'model') {
            return $config;
        }

        return app(ResourceLayoutResolver::class)->resolve(
            $config,
            $this->resourceForms()->modelInstance($config, $this->recordId)
        );
    }
}
