<?php

namespace EvoUI\Livewire;

use EvoUI\Contracts\ModuleTableProvider;
use EvoUI\Support\RichTextEditor;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Url;
use Livewire\Component;

class ModuleTable extends Component
{
    public string $preset = '';
    /** @var array<string, mixed> */
    public array $context = [];

    #[Url(as: 'q', history: true, except: '')]
    public string $search = '';

    #[Url(as: 'page', history: true, except: 1)]
    public int $page = 1;

    #[Url(as: 'sort', history: true, except: '')]
    public string $sort = '';

    #[Url(as: 'dir', history: true, except: 'asc')]
    public string $direction = 'asc';

    public int $perPage = 0;

    /** @var array<string, mixed> */
    #[Url(as: 'f', history: true, except: [])]
    public array $filterState = [];

    #[Url(as: 'view', history: true, except: 'table')]
    public string $viewMode = 'table';

    public ?int $selectedId = null;
    public bool $modalOpen = false;
    public string $modalMode = 'create';
    public ?int $modalRecordId = null;
    /** @var array<string, mixed> */
    public array $modalData = [];
    /** @var array<string, mixed> */
    public array $modalEditorSelections = [];
    public bool $modalAliasTouched = false;
    public bool $deleteModalOpen = false;
    public ?int $deleteRecordId = null;
    public string $deleteRecordName = '';
    public string $deleteErrorMessage = '';

    /** @param array<string, mixed> $context */
    public function mount(string $preset, array $context = []): void
    {
        $this->preset = $preset;
        $this->context = $context;
        $this->syncConfigState();
        $this->fillDefaultFilters();
        $this->restoreSessionState();
    }

    public function updated(string $name): void
    {
        if (in_array($name, ['search', 'perPage', 'filterState'], true)) {
            $this->resetPageState();
        }

        if (str_starts_with($name, 'modalData.')) {
            $this->syncModalDerivedFields(substr($name, strlen('modalData.')));
        }

        if (
            in_array($name, ['search', 'page', 'sort', 'direction', 'perPage', 'filterState', 'viewMode'], true)
            || str_starts_with($name, 'filterState.')
        ) {
            $this->dispatchClientState();
        }
    }

    public function updatedPerPage(): void
    {
        $this->syncConfigState();
        $this->resetPageState();
    }

    public function setFilter(string $state, string $value): void
    {
        $filter = $this->filterByState($state);

        if (!$filter) {
            return;
        }

        $allowed = collect($filter['options'] ?? [])->pluck('value')->map(fn ($item) => (string) $item)->all();
        $this->filterState[$state] = in_array($value, $allowed, true) ? $value : (string) ($filter['default'] ?? 'all');
        $this->resetPageState();
        $this->dispatchClientState();
    }

    public function switchView(string $viewMode): void
    {
        $next = in_array($viewMode, $this->tableViews(), true) ? $viewMode : 'table';

        if ($this->viewMode === $next) {
            return;
        }

        $this->viewMode = $next;
        $this->dispatchClientState();
    }

    public function setSort(string $key): void
    {
        $column = $this->sortableColumn($key);

        if (!$column) {
            return;
        }

        if ($this->sort === $key) {
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $key;
            $this->direction = (string) ($column['default_direction'] ?? 'asc');
        }

        $this->direction = $this->direction === 'desc' ? 'desc' : 'asc';
        $this->resetPageState();
        $this->dispatchClientState();
    }

    public function selectRow(int $id): void
    {
        $this->selectedId = $this->selectedId === $id ? null : $id;
    }

    public function openCreateModal(): void
    {
        if (!$this->modalEnabled()) {
            return;
        }

        $this->resetValidation();
        $this->modalMode = 'create';
        $this->modalRecordId = null;
        $this->modalAliasTouched = false;
        $this->modalData = $this->providerModalDefaults();
        $this->modalEditorSelections = [];
        $this->syncModalDerivedFields('');
        $this->modalOpen = true;
    }

    public function openEditModal(?int $id = null): void
    {
        if (!$this->modalEnabled()) {
            return;
        }

        $id = $id ?: $this->selectedId;

        if (!$id) {
            return;
        }

        $this->resetValidation();
        $this->modalMode = 'edit';
        $this->modalRecordId = $id;
        $this->modalAliasTouched = true;
        $this->selectedId = $id;
        $this->modalData = $this->providerModalData($id);
        $this->modalEditorSelections = [];
        $this->modalOpen = true;
    }

    public function openActionModal(string $actionKey, ?int $id = null): void
    {
        $action = $this->modalAction($actionKey);

        if (!$action) {
            return;
        }

        $id = $id ?: $this->selectedId;

        if (!$id) {
            return;
        }

        $this->resetValidation();
        $this->modalMode = $actionKey;
        $this->modalRecordId = $id;
        $this->modalAliasTouched = true;
        $this->selectedId = $id;
        $this->modalData = $this->providerModalData($id);
        $this->modalEditorSelections = [];
        $this->modalOpen = true;
    }

    public function closeModal(): void
    {
        $this->modalOpen = false;
        $this->modalData = [];
        $this->modalRecordId = null;
        $this->modalMode = 'create';
        $this->modalAliasTouched = false;
        $this->modalEditorSelections = [];
        $this->resetValidation();
    }

    public function openDeleteModal(?int $id = null): void
    {
        $id = $id ?: $this->selectedId;

        if (!$id) {
            return;
        }

        $this->selectedId = $id;
        $this->deleteRecordId = $id;
        $this->deleteRecordName = $this->providerDeleteName($id);
        $this->deleteErrorMessage = '';
        $this->deleteModalOpen = true;
    }

    public function closeDeleteModal(): void
    {
        $this->deleteModalOpen = false;
        $this->deleteRecordId = null;
        $this->deleteRecordName = '';
        $this->deleteErrorMessage = '';
    }

    public function deleteConfirmed(): void
    {
        if (!$this->deleteRecordId) {
            return;
        }

        $provider = $this->provider();
        $method = (string) $this->tableConfig('delete_provider', 'deleteRow');

        if (method_exists($provider, $method)) {
            $result = $this->callProvider($method, $this->deleteRecordId);

            if ($result === false || (is_string($result) && trim($result) !== '')) {
                $this->deleteErrorMessage = is_string($result) ? trim($result) : (string) __('evo::global.delete_guard_message');
                return;
            }
        }

        $this->selectedId = null;
        $this->closeDeleteModal();
        $this->page = min(max(1, $this->page), $this->lastPageNumber());
        $this->dispatchClientState();
    }

    public function saveModal(): void
    {
        if (!$this->modalEnabled()) {
            return;
        }

        $this->validate($this->modalRules(), [], $this->modalValidationAttributes());

        if (($method = $this->modalConfig('save_provider')) && method_exists($this->provider(), $method)) {
            $savedId = $this->callProvider((string) $method, $this->modalData, $this->modalRecordId, $this->modalMode);
        } else {
            $savedId = $this->provider()->saveModal($this->modalData, $this->modalRecordId, $this->modalMode);
        }

        $this->selectedId = $savedId ? (int) $savedId : $this->modalRecordId;
        $this->closeModal();
        $this->page = 1;
        $this->dispatchClientState();
    }

    public function saveModalAction(string $key): void
    {
        if (!$this->modalEnabled()) {
            return;
        }

        $action = collect($this->modalActions())->firstWhere('key', $key);

        if (!is_array($action)) {
            return;
        }

        foreach ((array) ($action['data'] ?? []) as $field => $value) {
            data_set($this->modalData, (string) $field, $value);
        }

        $this->validate($this->modalRules(), [], $this->modalValidationAttributes());
        $method = (string) ($action['save_provider'] ?? $this->modalConfig('save_provider', 'saveModal'));

        if (!method_exists($this->provider(), $method)) {
            return;
        }

        $savedId = $this->callProvider($method, $this->modalData, $this->modalRecordId, $this->modalMode, $action);
        $this->selectedId = $savedId ? (int) $savedId : $this->modalRecordId;
        $this->closeModal();
        $this->page = 1;
        $this->dispatchClientState();
    }

    public function addModalItem(string $field): void
    {
        $config = $this->modalRepeaterField($field);

        if (!$config) {
            return;
        }

        $items = array_values((array) data_get($this->modalData, $field, []));
        $items[] = (array) ($config['default_item'] ?? []);
        data_set($this->modalData, $field, $items);
    }

    public function removeModalItem(string $field, int $index): void
    {
        $config = $this->modalRepeaterField($field);

        if (!$config) {
            return;
        }

        $items = array_values((array) data_get($this->modalData, $field, []));

        if (!array_key_exists($index, $items)) {
            return;
        }

        array_splice($items, $index, 1);
        data_set($this->modalData, $field, $items);
    }

    public function moveModalItem(string $field, int $index, string $direction): void
    {
        $config = $this->modalRepeaterField($field);

        if (!$config) {
            return;
        }

        $items = array_values((array) data_get($this->modalData, $field, []));
        $target = $direction === 'down' ? $index + 1 : $index - 1;

        if (!array_key_exists($index, $items) || !array_key_exists($target, $items)) {
            return;
        }

        [$items[$index], $items[$target]] = [$items[$target], $items[$index]];
        data_set($this->modalData, $field, $items);
    }

    public function addModalBuilderBlock(string $field, string $type, ?int $afterIndex = null): void
    {
        $config = $this->modalBuilderField($field);

        if (!$config || $type === '') {
            return;
        }

        $block = collect($this->modalBuilderBlocks($config))->firstWhere('type', $type);

        if (!is_array($block)) {
            return;
        }

        $items = array_values((array) data_get($this->modalData, $field, []));
        $newItem = [
            'type' => $type,
            'data' => (array) ($block['defaults'] ?? []),
        ];

        $insertIndex = count($items);

        if ($afterIndex !== null && array_key_exists($afterIndex, $items)) {
            $insertIndex = $afterIndex + 1;
            array_splice($items, $afterIndex + 1, 0, [$newItem]);
        } else {
            $items[] = $newItem;
        }

        data_set($this->modalData, $field, $items);
        $this->dispatch('evo-ui:builder.block-added', preset: $this->preset, field: $field, index: $insertIndex);
    }

    public function removeModalBuilderBlock(string $field, int $index): void
    {
        $config = $this->modalBuilderField($field);

        if (!$config) {
            return;
        }

        $items = array_values((array) data_get($this->modalData, $field, []));

        if (!array_key_exists($index, $items)) {
            return;
        }

        array_splice($items, $index, 1);
        data_set($this->modalData, $field, $items);
    }

    public function moveModalBuilderBlock(string $field, int $index, string $direction): void
    {
        $config = $this->modalBuilderField($field);

        if (!$config) {
            return;
        }

        $items = array_values((array) data_get($this->modalData, $field, []));
        $target = $direction === 'down' ? $index + 1 : $index - 1;

        if (!array_key_exists($index, $items) || !array_key_exists($target, $items)) {
            return;
        }

        [$items[$index], $items[$target]] = [$items[$target], $items[$index]];
        data_set($this->modalData, $field, $items);
    }

    public function addModalBuilderItem(string $field, int $blockIndex, string $itemField, ?int $afterIndex = null): void
    {
        $nestedField = $this->modalBuilderNestedField($field, $blockIndex, $itemField);

        if (!$nestedField) {
            return;
        }

        $path = $field . '.' . $blockIndex . '.data.' . $itemField;
        $items = array_values((array) data_get($this->modalData, $path, []));
        $insertIndex = is_int($afterIndex) ? $afterIndex + 1 : count($items);

        array_splice($items, max(0, min($insertIndex, count($items))), 0, [$this->modalBuilderNestedDefaults($nestedField)]);

        data_set($this->modalData, $path, $items);
    }

    public function removeModalBuilderItem(string $field, int $blockIndex, string $itemField, int $index): void
    {
        $nestedField = $this->modalBuilderNestedField($field, $blockIndex, $itemField);

        if (!$nestedField) {
            return;
        }

        $path = $field . '.' . $blockIndex . '.data.' . $itemField;
        $items = array_values((array) data_get($this->modalData, $path, []));

        if (count($items) <= 1 || !array_key_exists($index, $items)) {
            return;
        }

        array_splice($items, $index, 1);
        data_set($this->modalData, $path, $items);
    }

    public function moveModalBuilderItem(string $field, int $blockIndex, string $itemField, int $index, string $direction): void
    {
        if (!$this->modalBuilderNestedField($field, $blockIndex, $itemField)) {
            return;
        }

        $path = $field . '.' . $blockIndex . '.data.' . $itemField;
        $items = array_values((array) data_get($this->modalData, $path, []));
        $target = $direction === 'down' ? $index + 1 : $index - 1;

        if (!array_key_exists($index, $items) || !array_key_exists($target, $items)) {
            return;
        }

        [$items[$index], $items[$target]] = [$items[$target], $items[$index]];
        data_set($this->modalData, $path, $items);
    }

    public function addModalChoice(string $field, string $value, bool $single = false): void
    {
        if ($field === '' || $value === '') {
            return;
        }

        if ($single) {
            data_set($this->modalData, $field, $value);

            return;
        }

        $values = collect((array) data_get($this->modalData, $field, []))
            ->map(fn ($item) => (string) $item)
            ->filter(fn ($item) => $item !== '')
            ->push($value)
            ->unique()
            ->values()
            ->all();

        data_set($this->modalData, $field, $values);
    }

    public function toggleModalChoice(string $field, string $value, bool $single = false, bool $clearable = true): void
    {
        if ($field === '' || $value === '') {
            return;
        }

        if ($single) {
            $current = (string) data_get($this->modalData, $field, '');

            if ($clearable && $current === $value) {
                data_set($this->modalData, $field, '');

                return;
            }

            data_set($this->modalData, $field, $value);

            return;
        }

        $values = collect((array) data_get($this->modalData, $field, []))
            ->map(fn ($item) => (string) $item)
            ->filter(fn ($item) => $item !== '')
            ->values();

        data_set(
            $this->modalData,
            $field,
            $values->contains($value)
                ? $values->reject(fn ($item) => $item === $value)->values()->all()
                : $values->push($value)->unique()->values()->all()
        );
    }

    public function removeModalChoice(string $field, string $value): void
    {
        if ($field === '') {
            return;
        }

        $current = data_get($this->modalData, $field, []);

        if (!is_array($current)) {
            data_set($this->modalData, $field, '');

            return;
        }

        $values = collect($current)
            ->map(fn ($item) => (string) $item)
            ->reject(fn ($item) => $item === (string) $value)
            ->values()
            ->all();

        data_set($this->modalData, $field, $values);
    }

    /** @param array<int, int|string> $values */
    public function applyMultiFilter(string $state, array $values): void
    {
        $filter = $this->filterByState($state);

        if (!$filter || ($filter['type'] ?? null) !== 'multi-select') {
            return;
        }

        $allowed = collect($this->optionsFor($state))->pluck('id')->map(fn ($id) => (int) $id)->all();
        $this->filterState[$state] = collect($values)
            ->map(fn ($id) => (int) $id)
            ->filter(fn ($id) => $id > 0 && ($allowed === [] || in_array($id, $allowed, true)))
            ->unique()
            ->sort()
            ->values()
            ->all();

        $this->resetPageState();
        $this->dispatchClientState();
    }

    public function applySelectFilter(string $state, string $value): void
    {
        $filter = $this->filterByState($state);

        if (!$filter || ($filter['type'] ?? null) !== 'select') {
            return;
        }

        $allowed = collect($this->optionsFor($state))->pluck('id')->map(fn ($id) => (string) $id)->all();
        $this->filterState[$state] = in_array($value, $allowed, true)
            ? $value
            : (string) ($filter['default'] ?? '');

        $this->resetPageState();
        $this->dispatchClientState();
    }

    public function applyDateRangeFilter(string $state, string $from = '', string $to = ''): void
    {
        $filter = $this->filterByState($state);

        if (!$filter || ($filter['type'] ?? null) !== 'date-range') {
            return;
        }

        $this->filterState[$state] = [
            'from' => $this->normalizeDateFilterValue($from),
            'to' => $this->normalizeDateFilterValue($to),
        ];

        $this->resetPageState();
        $this->dispatchClientState();
    }

    public function toggleFilter(string $state, int $id): void
    {
        if ($id < 1) {
            return;
        }

        $selected = collect((array) ($this->filterState[$state] ?? []))->map(fn ($value) => (int) $value);
        $this->filterState[$state] = $selected->contains($id)
            ? $selected->reject(fn ($value) => $value === $id)->values()->all()
            : $selected->push($id)->unique()->sort()->values()->all();

        $this->resetPageState();
        $this->dispatchClientState();
    }

    public function clearFilter(string $state): void
    {
        $filter = $this->filterByState($state);

        if (!$filter) {
            return;
        }

        $this->filterState[$state] = ($filter['type'] ?? null) === 'multi-select'
            ? []
            : ($filter['default'] ?? null);

        $this->resetPageState();
        $this->dispatchClientState();
    }

    public function togglePublished(int $id): void
    {
        $provider = $this->provider();

        if (method_exists($provider, 'togglePublished')) {
            $provider->togglePublished($id);
        }
    }

    public function duplicateRow(int $id): void
    {
        $provider = $this->provider();

        if (method_exists($provider, 'duplicate')) {
            $provider->duplicate($id);
        }
    }

    public function duplicateSelected(): void
    {
        if (!$this->selectedId) {
            return;
        }

        $this->duplicateRow($this->selectedId);
    }

    public function createInlineRow(): void
    {
        $provider = $this->provider();
        $method = (string) $this->tableConfig('inline.create_provider', 'createInlineRow');

        if (!method_exists($provider, $method)) {
            return;
        }

        $createdId = $this->callProvider($method);

        if ($createdId) {
            $this->selectedId = (int) $createdId;
            $this->page = 1;
            $this->dispatchClientState();
        }
    }

    public function runTableAction(string $actionKey): void
    {
        $actionKey = trim($actionKey);

        if ($actionKey === '') {
            return;
        }

        $action = collect((array) $this->tableConfig('actions', []))
            ->first(fn ($action) => is_array($action)
                && (string) ($action['key'] ?? '') === $actionKey
                && (string) ($action['type'] ?? 'link') === 'wire');

        if (!is_array($action)) {
            return;
        }

        $provider = $this->provider();
        $method = (string) ($action['provider'] ?? '');

        if ($method === '' || !method_exists($provider, $method)) {
            return;
        }

        $this->callProvider($method, $action, $this->selectedId);
        $this->page = 1;
        $this->dispatchClientState();
    }

    public function runRowAction(string $actionKey, ?int $id = null): void
    {
        $actionKey = trim($actionKey);
        $id = $id ?: $this->selectedId;

        if ($actionKey === '' || !$id) {
            return;
        }

        $action = collect($this->rowActions())
            ->first(fn (array $action) => (string) ($action['key'] ?? '') === $actionKey
                && (string) ($action['type'] ?? 'link') === 'wire');

        if (!is_array($action)) {
            return;
        }

        $provider = $this->provider();
        $method = (string) ($action['provider'] ?? '');

        if ($method === '' || !method_exists($provider, $method)) {
            return;
        }

        $this->callProvider($method, $id, $action);
        $this->selectedId = $id;
        $this->page = 1;
        $this->dispatchClientState();
    }

    public function updateInlineField(int $id, string $field, mixed $value): string
    {
        $column = $this->inlineEditableColumn($field);

        if (!$column || $id < 1) {
            return '';
        }

        $value = trim((string) $value);
        $rules = (array) ($column['rules'] ?? ['nullable', 'string', 'max:255']);

        Validator::make(
            ['value' => $value],
            ['value' => $rules],
            [],
            ['value' => __((string) ($column['label'] ?? $field))]
        )->validate();

        $provider = $this->provider();
        $method = (string) ($column['save_provider'] ?? $this->tableConfig('inline.save_provider', 'updateInlineField'));

        if (!method_exists($provider, $method)) {
            return $value;
        }

        $saved = $this->callProvider($method, $id, $field, $value, $column);
        $this->selectedId = $id;

        return (string) ($saved ?? $value);
    }

    public function runInlineFieldAction(int $id, string $field, string $actionKey): void
    {
        $column = $this->inlineEditableColumn($field);

        if (!$column || $id < 1 || trim($actionKey) === '') {
            return;
        }

        $action = collect((array) ($column['inline_actions'] ?? []))
            ->first(fn ($action) => is_array($action) && (string) ($action['key'] ?? '') === $actionKey);

        if (!is_array($action)) {
            return;
        }

        $provider = $this->provider();
        $method = (string) ($action['provider'] ?? $column['inline_action_provider'] ?? '');

        if ($method === '' || !method_exists($provider, $method)) {
            return;
        }

        $this->callProvider($method, $id, $field, $action, $column);
        $this->selectedId = $id;
    }

    public function runHeaderAction(string $field, string $actionKey): void
    {
        $field = trim($field);

        if ($field === '' || trim($actionKey) === '') {
            return;
        }

        $column = collect($this->columns())
            ->first(fn (array $column) => (string) ($column['key'] ?? '') === $field);

        if (!is_array($column)) {
            return;
        }

        $action = collect((array) ($column['header_actions'] ?? []))
            ->first(fn ($action) => is_array($action) && (string) ($action['key'] ?? '') === $actionKey);

        if (!is_array($action)) {
            return;
        }

        $provider = $this->provider();
        $method = (string) ($action['provider'] ?? $column['header_action_provider'] ?? '');

        if ($method === '' || !method_exists($provider, $method)) {
            return;
        }

        $this->callProvider($method, $field, $action, $column);
    }

    public function moveRow(int $id, string $direction): void
    {
        if (!$this->reorderEnabled() || $id < 1) {
            return;
        }

        $direction = $direction === 'down' ? 'down' : 'up';
        $provider = $this->provider();
        $method = (string) $this->tableConfig('reorder.move_provider', 'moveRow');

        if (!method_exists($provider, $method)) {
            return;
        }

        $this->callProvider($method, $id, $direction);
        $this->selectedId = $id;
        $this->useReorderSort();
        $this->dispatchClientState();
    }

    public function reorderRow(int $id, int $targetId, string $placement = 'before'): void
    {
        if (!$this->reorderEnabled() || $id < 1 || $targetId < 1 || $id === $targetId) {
            return;
        }

        $provider = $this->provider();
        $method = (string) $this->tableConfig('reorder.reorder_provider', 'reorderRow');

        if (!method_exists($provider, $method)) {
            return;
        }

        $this->callProvider($method, $id, $targetId, $placement === 'after' ? 'after' : 'before');
        $this->selectedId = $id;
        $this->useReorderSort();
        $this->dispatchClientState();
    }

    public function sortTableRowByUid(string $uid, int $position, string $targetGroupUid = ''): void
    {
        if (!$this->reorderEnabled()) {
            return;
        }

        $id = (int) $uid;

        if ($id < 1) {
            return;
        }

        $rowIds = collect($this->provider()->rows($this->page, $this->perPage))
            ->map(fn ($row) => (int) data_get($row, 'id'))
            ->filter(fn (int $rowId) => $rowId > 0 && $rowId !== $id)
            ->values()
            ->all();

        if ($rowIds === []) {
            return;
        }

        $position = max(0, min($position, count($rowIds)));
        $targetId = $position >= count($rowIds) ? (int) end($rowIds) : (int) $rowIds[$position];
        $placement = $position >= count($rowIds) ? 'after' : 'before';

        $this->reorderRow($id, $targetId, $placement);
    }

    public function firstPage(): void
    {
        $this->page = 1;
        $this->dispatchClientState();
    }

    public function previousPage(): void
    {
        $this->page = max(1, $this->page - 1);
        $this->dispatchClientState();
    }

    public function goToPage(int $page): void
    {
        $this->page = min(max(1, $page), $this->lastPageNumber());
        $this->dispatchClientState();
    }

    public function nextPage(): void
    {
        $this->page = min($this->page + 1, $this->lastPageNumber());
        $this->dispatchClientState();
    }

    public function goLastPage(): void
    {
        $this->page = $this->lastPageNumber();
        $this->dispatchClientState();
    }

    public function storageKey(): string
    {
        $configured = (string) $this->tableConfig('storage_key', '');

        if ($configured !== '') {
            return $configured;
        }

        $context = collect($this->context)
            ->only(['type', 'site', 'module'])
            ->filter(fn ($value) => is_scalar($value) && (string) $value !== '')
            ->all();

        return 'evo-ui.module-table.' . sha1($this->preset . '|' . json_encode($context));
    }

    /** @return array<string, mixed> */
    public function persistedState(): array
    {
        return [
            'search' => $this->search,
            'page' => $this->page,
            'perPage' => $this->perPage,
            'filters' => $this->filterState,
            'sort' => $this->sort,
            'direction' => $this->direction,
            'view' => $this->viewMode,
        ];
    }

    public function render(): View
    {
        $this->syncConfigState();
        $this->fillDefaultFilters();

        $provider = $this->provider();
        $total = $provider->total();
        $lastPage = max(1, (int) ceil($total / max(1, $this->perPage)));
        $this->page = min(max(1, $this->page), $lastPage);

        $filterGroups = $provider->filterGroups();

        /** @var View $view */
        $view = view('evo::livewire.module-table', [
            'controller' => $this,
            'config' => $this->visibleConfig(),
            'rows' => $provider->rows($this->page, $this->perPage),
            'filters' => $this->filters(),
            'filterOptions' => $this->filterOptions($filterGroups),
            'filterLabels' => $this->filterLabels($filterGroups),
            'page' => $this->page,
            'total' => $total,
            'lastPage' => $lastPage,
            'paginationItems' => $this->paginationItems($lastPage),
            'perPage' => $this->perPage,
            'perPageOptions' => $this->perPageOptions(),
            'storageKey' => $this->storageKey(),
            'perPageCookieName' => $this->perPageCookieName(),
            'viewMode' => $this->viewMode,
            'sort' => $this->sort,
            'direction' => $this->direction,
            'selectedId' => $this->selectedId,
        ]);

        return $view;
    }

    public function modalTitle(): string
    {
        $modalAction = $this->modalAction($this->modalMode);

        if (is_array($modalAction['modal'] ?? null) && ($modalAction['modal']['title'] ?? null) !== null) {
            return (string) __((string) $modalAction['modal']['title']);
        }

        $provider = $this->provider();

        if (method_exists($provider, 'modalTitle')) {
            $title = trim((string) $this->callProvider('modalTitle', $this->modalData, $this->modalRecordId, $this->modalMode));

            if ($title !== '') {
                return $title;
            }
        }

        $key = $this->modalMode === 'edit'
            ? $this->modalConfig('title_edit', $this->modalConfig('title', 'evo::global.form'))
            : $this->modalConfig('title_create', $this->modalConfig('title', 'evo::global.form'));

        return (string) __((string) $key);
    }

    public function modalSubmitLabel(): string
    {
        return (string) __((string) $this->modalConfig('submit_label', 'evo::global.action_save'));
    }

    /** @return array<int, array<string, mixed>> */
    public function modalHeaderMeta(): array
    {
        $provider = $this->provider();

        if (method_exists($provider, 'modalHeaderMeta')) {
            return collect((array) $this->callProvider('modalHeaderMeta', $this->modalData, $this->modalRecordId, $this->modalMode))
                ->filter(fn ($item) => is_array($item) && trim((string) ($item['value'] ?? '')) !== '')
                ->values()
                ->all();
        }

        return [];
    }

    /** @return array<string, mixed> */
    public function modalOptions(): array
    {
        $config = $this->modalConfig();
        $provider = $this->provider();

        if (method_exists($provider, 'modalOptions')) {
            return (array) $this->callProvider('modalOptions', $config, $this->modalData, $this->modalRecordId, $this->modalMode);
        }

        return $config;
    }

    /** @return array<int, array<string, mixed>> */
    public function modalActions(): array
    {
        return collect((array) $this->modalConfig('actions', []))
            ->filter(fn ($action) => is_array($action) && !empty($action['key']))
            ->filter(function (array $action) {
                $modes = $action['modes'] ?? $action['mode'] ?? null;

                if ($modes === null) {
                    return true;
                }

                return in_array($this->modalMode, (array) $modes, true);
            })
            ->map(function (array $action) {
                $action['key'] = (string) $action['key'];
                $action['label'] = __((string) ($action['label'] ?? ''));
                $action['icon'] = $action['icon'] ?? null;
                $action['tone'] = $action['tone'] ?? 'neutral';
                $action['variant'] = $action['variant'] ?? 'soft';

                return $action;
            })
            ->values()
            ->all();
    }

    /** @return array<int, array<string, mixed>> */
    public function modalFields(): array
    {
        $fields = collect((array) $this->modalConfig('fields', []))
            ->filter(fn ($field) => is_array($field) && !empty($field['name']))
            ->values()
            ->all();

        $provider = $this->provider();

        if (method_exists($provider, 'modalFields')) {
            return (array) $this->callProvider('modalFields', $fields, $this->modalData, $this->modalRecordId, $this->modalMode);
        }

        return $fields;
    }

    /** @param array<string, mixed> $field */
    public function modalEditorHtml(array $field, string $fieldId): string
    {
        $provider = $this->provider();
        $method = (string) ($field['editor_provider'] ?? 'modalEditorHtml');
        $field['editor'] = $this->modalEditorValue($field, $fieldId);

        if (method_exists($provider, $method)) {
            return (string) $this->callProvider($method, $fieldId, $field, $this->modalRecordId, $this->modalMode);
        }

        $height = (string) ($field['height'] ?? '420px');
        $editorOptions = array_replace(
            ['height' => $height],
            (array) ($field['editor_options'] ?? [])
        );

        return RichTextEditor::html(
            ids: $fieldId,
            height: $height,
            editor: (string) $field['editor'],
            options: [$fieldId => $editorOptions],
            contentType: (string) ($field['content_type'] ?? 'htmlmixed'),
            theme: (string) ($field['theme'] ?? ''),
        );
    }

    /**
     * @param array<string, mixed> $field
     * @return array<int, array<string, mixed>>
     */
    public function modalEditorOptions(array $field): array
    {
        if (($field['editor_switcher'] ?? true) === false) {
            return [];
        }

        $editors = $this->registeredRichTextEditors();
        $allowed = array_values(array_filter(array_map('strval', (array) ($field['editors'] ?? $editors))));

        if (($field['allow_no_editor'] ?? false) === true) {
            array_unshift($allowed, 'none');
        }

        $allowed = array_values(array_unique(array_filter($allowed, fn (string $editor) => $editor === 'none' || in_array($editor, $editors, true))));

        if (count($allowed) <= 1) {
            return [];
        }

        return collect($allowed)
            ->map(fn (string $editor) => [
                'value' => $editor,
                'label' => $editor === 'none' ? __('evo::global.none') : $editor,
            ])
            ->values()
            ->all();
    }

    /** @param array<string, mixed> $field */
    public function modalEditorValue(array $field, string $fieldId): string
    {
        $editors = $this->registeredRichTextEditors();
        $selected = (string) ($this->modalEditorSelections[$fieldId] ?? '');

        if ($selected !== '' && ($selected === 'none' || in_array($selected, $editors, true))) {
            return $selected;
        }

        $configured = (string) ($field['editor'] ?? evo()->getConfig('which_editor', ''));

        if ($configured !== '' && ($configured === 'none' || in_array($configured, $editors, true))) {
            return $configured;
        }

        return (string) ($editors[0] ?? $configured);
    }

    public function selectModalEditor(string $fieldId, string $editor): void
    {
        $allowed = $this->registeredRichTextEditors();
        $allowNone = collect($this->modalFields())
            ->contains(fn (array $field) => ($field['type'] ?? '') === 'editor' && ($field['allow_no_editor'] ?? false) === true);

        if ($allowNone) {
            $allowed[] = 'none';
        }

        if (!in_array($editor, array_values(array_unique($allowed)), true)) {
            return;
        }

        $this->modalEditorSelections[$fieldId] = $editor;
    }

    /** @return array<int, string> */
    public function registeredRichTextEditors(): array
    {
        return RichTextEditor::registered();
    }

    /**
     * @param array<string, mixed> $field
     * @return array<int, array<string, mixed>>
     */
    public function modalFieldOptions(array $field): array
    {
        $provider = $this->provider();
        $method = (string) ($field['options_provider'] ?? '');

        if ($method !== '' && method_exists($provider, $method)) {
            return collect((array) $this->callProvider($method, $field, $this->modalData, $this->modalRecordId, $this->modalMode))
                ->filter(fn ($option) => is_array($option) && array_key_exists('value', $option))
                ->map(fn ($option) => [
                    'value' => (string) ($option['value'] ?? ''),
                    'label' => __((string) ($option['label'] ?? $option['value'] ?? '')),
                    'icon' => $option['icon'] ?? null,
                    'tone' => $option['tone'] ?? null,
                ])
                ->values()
                ->all();
        }

        return collect((array) ($field['options'] ?? []))
            ->filter(fn ($option) => is_array($option) && array_key_exists('value', $option))
            ->map(fn ($option) => [
                'value' => (string) ($option['value'] ?? ''),
                'label' => __((string) ($option['label'] ?? $option['value'] ?? '')),
                'icon' => $option['icon'] ?? null,
                'tone' => $option['tone'] ?? null,
            ])
            ->values()
            ->all();
    }

    /**
     * @param array<string, mixed> $field
     * @return array<int, array<string, mixed>>
     */
    public function modalBuilderBlocks(array $field): array
    {
        $provider = $this->provider();
        $method = (string) ($field['blocks_provider'] ?? '');
        $blocks = [];

        if ($method !== '' && method_exists($provider, $method)) {
            $blocks = (array) $this->callProvider($method, $field, $this->modalData, $this->modalRecordId, $this->modalMode);
        } else {
            $blocks = (array) ($field['blocks'] ?? []);
        }

        return collect($blocks)
            ->filter(fn ($block) => is_array($block) && !empty($block['type']))
            ->map(function (array $block) {
                $block['type'] = (string) $block['type'];
                $block['label'] = __((string) ($block['label'] ?? $block['type']));
                $block['icon'] = (string) ($block['icon'] ?? 'file-text');
                $block['defaults'] = (array) ($block['defaults'] ?? []);
                $block['fields'] = collect((array) ($block['fields'] ?? []))
                    ->filter(fn ($field) => is_array($field) && !empty($field['name']))
                    ->values()
                    ->all();

                return $block;
            })
            ->values()
            ->all();
    }

    public function modalImageUrl(string $path): string
    {
        $path = trim($path);

        if ($path === '') {
            return '';
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }

        if (defined('EVO_SITE_URL')) {
            return EVO_SITE_URL . ltrim($path, '/');
        }

        return '/' . ltrim($path, '/');
    }

    /** @param array<string, mixed> $filter */
    public function filterValue(array $filter): mixed
    {
        $state = $filter['state'] ?? '';

        if ($state === '') {
            return null;
        }

        if (($filter['type'] ?? null) === 'multi-select') {
            return array_map('intval', (array) ($this->filterState[$state] ?? []));
        }

        return $this->filterState[$state] ?? ($filter['default'] ?? null);
    }

    /** @param array<string, mixed> $action */
    public function tableActionLabel(array $action): string
    {
        if (($method = $action['label_provider'] ?? null) && method_exists($this->provider(), $method)) {
            return (string) $this->provider()->{$method}($action);
        }

        return (string) __($action['label'] ?? '');
    }

    /** @param array<string, mixed> $action */
    public function tableActionHref(array $action, ?int $selectedId = null): ?string
    {
        if (($method = $action['href_provider'] ?? null) && method_exists($this->provider(), $method)) {
            return (string) $this->callProvider($method, $action, $selectedId);
        }

        return $action['href'] ?? null;
    }

    /**
     * @param array<string, mixed> $action
     * @return array<string, mixed>
     */
    public function tableActionAttributes(array $action, ?int $selectedId = null): array
    {
        if (($method = $action['attributes_provider'] ?? null) && method_exists($this->provider(), $method)) {
            return (array) $this->callProvider($method, $action, $selectedId);
        }

        return (array) ($action['attributes'] ?? []);
    }

    /**
     * @param array<string, mixed> $row
     * @param array<string, mixed> $column
     */
    public function cellDisplay(array $row, array $column): string
    {
        $key = $column['key'] ?? '';
        $type = $column['type'] ?? 'text';
        $value = data_get($row, $column['value'] ?? $key);

        if ($type === 'link') {
            return (string) data_get(is_array($value) ? $value : ['label' => $value], 'label', '');
        }

        if ($type === 'chips') {
            return collect((array) $value)
                ->filter()
                ->map(function ($item) {
                    if (is_array($item)) {
                        $label = data_get($item, 'label');

                        return is_scalar($label) ? (string) $label : '';
                    }

                    return is_scalar($item) ? (string) $item : '';
                })
                ->filter()
                ->implode(', ');
        }

        if ($type === 'image') {
            return '';
        }

        if ($type === 'icon') {
            return (string) data_get(is_array($value) ? $value : ['label' => $value], 'label', '');
        }

        if (is_array($value)) {
            $label = data_get($value, 'label');

            if (is_scalar($label)) {
                return (string) $label;
            }

            return collect($value)
                ->filter(fn ($item) => is_scalar($item))
                ->map(fn ($item) => (string) $item)
                ->implode(', ');
        }

        return (string) ($value ?? '');
    }

    /** @param array<string, mixed> $row */
    public function rowStateClasses(array $row): string
    {
        return collect((array) $this->tableConfig('row_states', []))
            ->filter(function ($state) use ($row) {
                if (!is_array($state)) {
                    return false;
                }

                $field = $state['field'] ?? null;

                if (!$field) {
                    return false;
                }

                $actual = data_get($row, $field);

                if (array_key_exists('value', $state)) {
                    return $actual == $state['value'];
                }

                return (bool) $actual;
            })
            ->map(fn ($state) => (string) ($state['class'] ?? 'is-dimmed'))
            ->filter()
            ->unique()
            ->implode(' ');
    }

    /** @return array<int, array<string, mixed>> */
    public function sortableColumns(): array
    {
        return collect($this->columns())
            ->filter(fn ($column) => ($column['sortable'] ?? false) && !empty($column['key']))
            ->values()
            ->all();
    }

    public function reorderEnabled(): bool
    {
        return (bool) $this->tableConfig('reorder.enabled', false);
    }

    /** @return ModuleTableProvider */
    protected function provider(): object
    {
        $class = $this->tableConfig('provider');

        if (!is_string($class) || $class === '') {
            throw new \RuntimeException('evo-ui module table provider is not configured.');
        }

        return app()->makeWith($class, [
            'context' => $this->context,
            'state' => $this->state(),
            'config' => $this->tableConfig(),
        ]);
    }

    protected function callProvider(string $method, mixed ...$arguments): mixed
    {
        $provider = $this->provider();
        $reflection = new \ReflectionMethod($provider, $method);

        return $provider->{$method}(...array_slice($arguments, 0, $reflection->getNumberOfParameters()));
    }

    /** @return array<string, mixed> */
    protected function state(): array
    {
        return [
            'search' => $this->search,
            'page' => $this->page,
            'filters' => $this->filterState,
            'sort' => $this->sort,
            'direction' => $this->direction,
            'view' => $this->viewMode,
        ];
    }

    protected function modalEnabled(): bool
    {
        return (bool) $this->modalConfig('enabled', false);
    }

    protected function modalConfig(?string $key = null, mixed $default = null): mixed
    {
        $config = (array) $this->tableConfig('modal', []);
        $action = $this->modalAction($this->modalMode);

        if ($action && isset($action['modal']) && is_array($action['modal'])) {
            $config = array_replace_recursive($config, $action['modal']);
        }

        return $key ? data_get($config, $key, $default) : $config;
    }

    /** @return array<string, mixed>|null */
    protected function modalAction(string $key): ?array
    {
        if ($key === '' || in_array($key, ['create', 'edit'], true)) {
            return null;
        }

        $actions = collect((array) $this->tableConfig('actions', []))
            ->merge((array) $this->tableConfig('row_actions', []));

        $action = $actions->first(fn ($action) => is_array($action)
            && (string) ($action['key'] ?? '') === $key
            && isset($action['modal'])
            && is_array($action['modal']));

        return is_array($action) ? $action : null;
    }

    /** @return array<string, mixed> */
    protected function modalRules(): array
    {
        $rules = [];

        foreach ($this->modalFields() as $field) {
            $name = (string) $field['name'];

            if (!empty($field['rules'])) {
                $rules['modalData.' . $name] = $field['rules'];
            }

            if (($field['type'] ?? null) !== 'repeater') {
                if (($field['type'] ?? null) !== 'builder') {
                    continue;
                }

                if (!empty($field['rules'])) {
                    $rules['modalData.' . $name] = $field['rules'];
                }

                foreach ($this->modalBuilderBlocks($field) as $block) {
                    foreach ((array) ($block['fields'] ?? []) as $blockField) {
                        if (empty($blockField['name'])) {
                            continue;
                        }

                        if (!empty($blockField['rules'])) {
                            $rules['modalData.' . $name . '.*.data.' . $blockField['name']] = $blockField['rules'];
                        }

                        if (($blockField['type'] ?? null) !== 'items') {
                            continue;
                        }

                        foreach ((array) ($blockField['fields'] ?? []) as $nestedField) {
                            if (empty($nestedField['name']) || empty($nestedField['rules'])) {
                                continue;
                            }

                            $rules['modalData.' . $name . '.*.data.' . $blockField['name'] . '.*.' . $nestedField['name']] = $nestedField['rules'];
                        }
                    }
                }

                continue;
            }

            foreach ((array) ($field['fields'] ?? []) as $itemField) {
                if (empty($itemField['name']) || empty($itemField['rules'])) {
                    continue;
                }

                $rules['modalData.' . $name . '.*.' . $itemField['name']] = $itemField['rules'];
            }
        }

        return $rules;
    }

    /** @return array<string, string> */
    protected function modalValidationAttributes(): array
    {
        $attributes = [];

        foreach ($this->modalFields() as $field) {
            $name = (string) $field['name'];
            $attributes['modalData.' . $name] = __($field['label'] ?? $name);

            if (($field['type'] ?? null) !== 'repeater') {
                if (($field['type'] ?? null) !== 'builder') {
                    continue;
                }

                foreach ($this->modalBuilderBlocks($field) as $block) {
                    foreach ((array) ($block['fields'] ?? []) as $blockField) {
                        if (empty($blockField['name'])) {
                            continue;
                        }

                        $attributes['modalData.' . $name . '.*.data.' . $blockField['name']] = __($blockField['label'] ?? $blockField['name']);

                        if (($blockField['type'] ?? null) !== 'items') {
                            continue;
                        }

                        foreach ((array) ($blockField['fields'] ?? []) as $nestedField) {
                            if (empty($nestedField['name'])) {
                                continue;
                            }

                            $attributes['modalData.' . $name . '.*.data.' . $blockField['name'] . '.*.' . $nestedField['name']] = __($nestedField['label'] ?? $nestedField['name']);
                        }
                    }
                }

                continue;
            }

            foreach ((array) ($field['fields'] ?? []) as $itemField) {
                if (empty($itemField['name'])) {
                    continue;
                }

                $attributes['modalData.' . $name . '.*.' . $itemField['name']] = __($itemField['label'] ?? $itemField['name']);
            }
        }

        return $attributes;
    }

    /** @return array<string, mixed> */
    protected function modalRepeaterField(string $field): array
    {
        return collect($this->modalFields())
            ->first(fn ($item) => ($item['type'] ?? null) === 'repeater' && (string) ($item['name'] ?? '') === $field) ?? [];
    }

    /** @return array<string, mixed> */
    protected function modalBuilderField(string $field): array
    {
        return collect($this->modalFields())
            ->first(fn ($item) => ($item['type'] ?? null) === 'builder' && (string) ($item['name'] ?? '') === $field) ?? [];
    }

    /** @return array<string, mixed> */
    protected function modalBuilderNestedField(string $field, int $blockIndex, string $itemField): array
    {
        $config = $this->modalBuilderField($field);
        $blockType = (string) data_get($this->modalData, $field . '.' . $blockIndex . '.type', '');

        if (!$config || $blockType === '' || $itemField === '') {
            return [];
        }

        $block = collect($this->modalBuilderBlocks($config))->firstWhere('type', $blockType);

        if (!is_array($block)) {
            return [];
        }

        return collect((array) ($block['fields'] ?? []))
            ->first(fn ($item) => ($item['type'] ?? null) === 'items' && (string) ($item['name'] ?? '') === $itemField) ?? [];
    }

    /**
     * @param array<string, mixed> $field
     * @return array<string, mixed>
     */
    protected function modalBuilderNestedDefaults(array $field): array
    {
        if (!empty($field['defaults']) && is_array($field['defaults'])) {
            return $field['defaults'];
        }

        return collect((array) ($field['fields'] ?? []))
            ->filter(fn ($item) => is_array($item) && !empty($item['name']))
            ->mapWithKeys(fn ($item) => [(string) $item['name'] => $item['default'] ?? ''])
            ->all();
    }

    /** @return array<string, mixed> */
    protected function providerModalDefaults(): array
    {
        $provider = $this->provider();
        $method = (string) $this->modalConfig('defaults_provider', 'modalDefaults');

        if (method_exists($provider, $method)) {
            return (array) $provider->{$method}();
        }

        return collect($this->modalFields())
            ->mapWithKeys(fn ($field) => [$field['name'] => $field['default'] ?? ''])
            ->all();
    }

    /** @return array<string, mixed> */
    protected function providerModalData(int $id): array
    {
        $provider = $this->provider();
        $method = (string) $this->modalConfig('data_provider', 'modalData');

        if (method_exists($provider, $method)) {
            return (array) $provider->{$method}($id);
        }

        return $this->providerModalDefaults();
    }

    protected function providerDeleteName(int $id): string
    {
        $provider = $this->provider();
        $method = (string) $this->tableConfig('delete_name_provider', 'deleteName');

        if (method_exists($provider, $method)) {
            return (string) $this->callProvider($method, $id);
        }

        return (string) $id;
    }

    protected function syncModalDerivedFields(string $changedField): void
    {
        if (!$this->modalOpen && $this->modalData === []) {
            return;
        }

        foreach ($this->modalFields() as $field) {
            if (($field['type'] ?? null) !== 'alias') {
                continue;
            }

            $name = (string) $field['name'];

            if ($changedField === $name) {
                $this->modalAliasTouched = true;
                continue;
            }

            if ($this->modalAliasTouched) {
                continue;
            }

            $source = collect((array) ($field['source'] ?? []))
                ->map(fn ($sourceField) => trim((string) data_get($this->modalData, $sourceField, '')))
                ->filter()
                ->implode(' ');

            if ($source === '') {
                continue;
            }

            data_set($this->modalData, $name, $this->generateModalAlias($source));
        }
    }

    protected function generateModalAlias(string $source): string
    {
        $provider = $this->provider();
        $method = (string) $this->modalConfig('alias_provider', 'modalAlias');

        if (method_exists($provider, $method)) {
            return (string) $provider->{$method}($source, $this->modalRecordId);
        }

        return str($source)->slug('-')->toString();
    }

    protected function tableConfig(?string $key = null, mixed $default = null): mixed
    {
        $config = config($this->preset . '.table', []);

        return $key ? data_get($config, $key, $default) : $config;
    }

    /** @return array<string, mixed> */
    protected function visibleConfig(): array
    {
        $config = $this->tableConfig();
        $config['columns'] = $this->columns();
        $config['filters'] = $this->filters();
        $config['row_actions'] = $this->rowActions();

        return $config;
    }

    /** @return array<int, array<string, mixed>> */
    protected function columns(): array
    {
        $columns = collect($this->tableConfig('columns', []))
            ->filter(fn ($column) => is_array($column) && !empty($column['key']))
            ->values()
            ->all();
        $provider = $this->provider();

        if (method_exists($provider, 'columns')) {
            return (array) $this->callProvider('columns', $columns);
        }

        return $columns;
    }

    /** @return array<int, array<string, mixed>> */
    protected function filters(): array
    {
        $filters = collect($this->tableConfig('filters', []))->values()->all();
        $provider = $this->provider();

        if (method_exists($provider, 'filters')) {
            return $provider->filters($filters);
        }

        return $filters;
    }

    /** @return array<int, array<string, mixed>> */
    protected function rowActions(): array
    {
        $actions = collect($this->tableConfig('row_actions', []))
            ->filter(fn ($action) => is_array($action) && !empty($action['key']))
            ->values()
            ->all();
        $provider = $this->provider();

        if (method_exists($provider, 'rowActions')) {
            return (array) $this->callProvider('rowActions', $actions);
        }

        return $actions;
    }

    /** @return array<string, mixed> */
    protected function filterByState(string $state): array
    {
        return collect($this->filters())->firstWhere('state', $state) ?? [];
    }

    protected function fillDefaultFilters(): void
    {
        foreach ($this->filters() as $filter) {
            $state = $filter['state'] ?? null;

            if (!$state || array_key_exists($state, $this->filterState)) {
                continue;
            }

            $this->filterState[$state] = ($filter['type'] ?? null) === 'multi-select'
                ? []
                : ($filter['default'] ?? (($filter['type'] ?? null) === 'date-range'
                    ? ['from' => '', 'to' => '']
                    : (($filter['type'] ?? null) === 'segmented' ? 'all' : null)));
        }
    }

    protected function normalizeDateFilterValue(string $value): string
    {
        $value = trim($value);

        return preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) ? $value : '';
    }

    /**
     * @param array<string, mixed> $stored
     * @return array<string, mixed>
     */
    protected function sanitizeStoredFilters(array $stored): array
    {
        $filters = [];

        foreach ($this->filters() as $filter) {
            $state = (string) ($filter['state'] ?? '');

            if ($state === '' || !array_key_exists($state, $stored)) {
                continue;
            }

            $value = $stored[$state];
            $type = (string) ($filter['type'] ?? '');

            if ($type === 'multi-select') {
                $filters[$state] = collect((array) $value)
                    ->map(fn ($item) => (int) $item)
                    ->filter(fn ($item) => $item > 0)
                    ->unique()
                    ->sort()
                    ->values()
                    ->all();

                continue;
            }

            if ($type === 'date-range') {
                $filters[$state] = [
                    'from' => $this->normalizeDateFilterValue((string) data_get($value, 'from', '')),
                    'to' => $this->normalizeDateFilterValue((string) data_get($value, 'to', '')),
                ];

                continue;
            }

            if (is_scalar($value) || $value === null) {
                $filters[$state] = $value;
            }
        }

        return $filters;
    }

    protected function dispatchClientState(): void
    {
        $this->persistServerState();
    }

    protected function restoreSessionState(): void
    {
        if ($this->requestHasTableState()) {
            return;
        }

        $state = session()->get($this->storageKey());

        if (!is_array($state)) {
            return;
        }

        $this->restoreTableState($state);
    }

    protected function persistServerState(): void
    {
        session()->put($this->storageKey(), $this->persistedState());
    }

    /** @param array<string, mixed> $state */
    protected function restoreTableState(array $state): void
    {
        $this->syncConfigState();
        $this->fillDefaultFilters();

        if (array_key_exists('search', $state) && is_scalar($state['search'])) {
            $this->search = (string) $state['search'];
        }

        if (array_key_exists('view', $state) && is_scalar($state['view'])) {
            $view = (string) $state['view'];

            if (in_array($view, $this->tableViews(), true)) {
                $this->viewMode = $view;
            }
        }

        if (array_key_exists('sort', $state) && is_scalar($state['sort'])) {
            $sort = (string) $state['sort'];

            if ($sort === '' || $this->sortableColumn($sort)) {
                $this->sort = $sort;
            }
        }

        if (array_key_exists('direction', $state) && is_scalar($state['direction'])) {
            $this->direction = (string) $state['direction'] === 'desc' ? 'desc' : 'asc';
        }

        if (array_key_exists('filters', $state) && is_array($state['filters'])) {
            $this->filterState = $this->sanitizeStoredFilters($state['filters']);
            $this->fillDefaultFilters();
        }

        if (array_key_exists('page', $state)) {
            $this->page = max(1, (int) $state['page']);
        }

        $this->selectedId = null;
        $this->syncConfigState();
    }

    protected function requestHasTableState(): bool
    {
        $keys = ['q', 'page', 'sort', 'dir', 'f', 'view'];

        $request = request();

        return is_object($request)
            && property_exists($request, 'query')
            && collect($keys)->contains(fn ($key) => $request->query->has($key));
    }

    protected function useReorderSort(): void
    {
        $field = (string) $this->tableConfig('reorder.sort', '');

        if ($field === '' || !$this->sortableColumn($field)) {
            return;
        }

        $this->sort = $field;
        $this->direction = 'asc';
    }

    protected function syncConfigState(): void
    {
        $options = $this->perPageOptions();
        $storedPerPage = $this->storedPerPagePreference($options);
        $default = $storedPerPage ?? (int) $this->tableConfig('per_page', $options[0] ?? 30);

        $this->perPage = in_array($this->perPage, $options, true)
            ? $this->perPage
            : (in_array($default, $options, true) ? $default : ($options[0] ?? 30));
        $views = $this->tableViews();
        $defaultView = (string) $this->tableConfig('default_view', 'table');
        $this->viewMode = in_array($this->viewMode, $views, true)
            ? $this->viewMode
            : (in_array($defaultView, $views, true) ? $defaultView : ($views[0] ?? 'table'));
        $this->direction = $this->direction === 'desc' ? 'desc' : 'asc';

        if ($this->sort === '') {
            $defaultSort = (string) $this->tableConfig('default_sort', '');
            $defaultColumn = $this->sortableColumn($defaultSort);

            if ($defaultColumn) {
                $this->sort = $defaultSort;
                $this->direction = (string) $this->tableConfig(
                    'default_direction',
                    $defaultColumn['default_direction'] ?? 'asc'
                );
                $this->direction = $this->direction === 'desc' ? 'desc' : 'asc';
            }
        }

        if ($this->sort !== '' && !$this->sortableColumn($this->sort)) {
            $this->sort = '';
            $this->direction = 'asc';
        }
    }

    /** @param array<int, int> $options */
    protected function storedPerPagePreference(array $options): ?int
    {
        $cookie = request()->cookie($this->perPageCookieName());
        $perPage = is_scalar($cookie) ? (int) $cookie : 0;

        return in_array($perPage, $options, true) ? $perPage : null;
    }

    public function perPageCookieName(): string
    {
        return 'evo_ui_table_per_page_' . sha1($this->storageKey());
    }

    /** @return array<int, int> */
    protected function perPageOptions(): array
    {
        return collect((array) $this->tableConfig('per_page_options', [10, 20, 30, 50, 100]))
            ->map(fn ($value) => (int) $value)
            ->filter(fn ($value) => $value > 0)
            ->unique()
            ->values()
            ->all() ?: [10, 20, 30, 50, 100];
    }

    /** @return array<int, array<string, mixed>> */
    protected function optionsFor(string $state): array
    {
        return $this->filterOptions($this->provider()->filterGroups())[$state] ?? [];
    }

    /** @return array<int, string> */
    protected function tableViews(): array
    {
        return collect((array) $this->tableConfig('views', ['table']))
            ->map(fn ($view) => (string) $view)
            ->filter(fn ($view) => in_array($view, ['table', 'list'], true))
            ->unique()
            ->values()
            ->all() ?: ['table'];
    }

    /** @return array<string, mixed>|null */
    protected function sortableColumn(string $key): ?array
    {
        if ($key === '') {
            return null;
        }

        $column = collect($this->sortableColumns())
            ->first(fn ($column) => ($column['key'] ?? null) === $key);

        return is_array($column) ? $column : null;
    }

    /** @return array<string, mixed>|null */
    protected function inlineEditableColumn(string $field): ?array
    {
        $field = trim($field);

        if ($field === '') {
            return null;
        }

        $column = collect($this->columns())
            ->first(function (array $column) use ($field) {
                if (empty($column['editable'])) {
                    return false;
                }

                return $field === (string) ($column['edit_field'] ?? $column['key'] ?? '');
            });

        return is_array($column) ? $column : null;
    }

    /**
     * @param array<int, array<string, mixed>> $filterGroups
     * @return array<string, array<int, array<string, mixed>>>
     */
    protected function filterOptions(array $filterGroups): array
    {
        return collect($filterGroups)
            ->mapWithKeys(function ($group) {
                $state = (string) ($group['key'] ?? '');
                $filter = $this->filterByState($state);
                $isMulti = ($filter['type'] ?? null) === 'multi-select';

                return [
                    $state => collect($group['items'] ?? [])
                        ->map(fn ($item) => [
                            'id' => $isMulti ? (int) $item['id'] : (string) $item['id'],
                            'name' => (string) $item['label'],
                        ])
                        ->values()
                        ->all(),
                ];
            })
            ->all();
    }

    /**
     * @param array<int, array<string, mixed>> $filterGroups
     * @return array<string, array<int, mixed>>
     */
    protected function filterLabels(array $filterGroups): array
    {
        return collect($filterGroups)
            ->mapWithKeys(function ($group) {
                $state = $group['key'] ?? '';
                $filter = $this->filterByState((string) $state);
                $isMulti = ($filter['type'] ?? null) === 'multi-select';
                $values = $isMulti
                    ? array_map('intval', (array) ($this->filterState[$state] ?? []))
                    : array_map('strval', (array) ($this->filterState[$state] ?? []));
                $labels = collect($group['items'] ?? [])
                    ->filter(fn ($item) => in_array($isMulti ? (int) $item['id'] : (string) $item['id'], $values, true))
                    ->pluck('label')
                    ->values()
                    ->all();

                return [$state => $labels];
            })
            ->all();
    }

    protected function resetPageState(): void
    {
        $this->page = 1;
        $this->selectedId = null;
    }

    protected function lastPageNumber(): int
    {
        return max(1, (int) ceil($this->provider()->total() / max(1, $this->perPage)));
    }

    /** @return array<int, int|string> */
    protected function paginationItems(int $lastPage): array
    {
        if ($lastPage <= 7) {
            return range(1, $lastPage);
        }

        $pages = collect([1, 2, $this->page - 1, $this->page, $this->page + 1, $lastPage - 1, $lastPage])
            ->filter(fn ($page) => $page >= 1 && $page <= $lastPage)
            ->unique()
            ->sort()
            ->values()
            ->all();

        $items = [];
        $previous = null;

        foreach ($pages as $page) {
            if ($previous !== null && $page > $previous + 1) {
                $items[] = '...';
            }

            $items[] = $page;
            $previous = $page;
        }

        return $items;
    }
}
