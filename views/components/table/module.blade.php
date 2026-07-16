@props([
    'controller',
    'config',
    'rows' => [],
    'filters' => [],
    'filterOptions' => [],
    'filterLabels' => [],
    'page' => 1,
    'total' => 0,
    'lastPage' => 1,
    'paginationItems' => [],
    'perPage' => 10,
    'perPageOptions' => [],
    'storageKey' => '',
    'perPageCookieName' => '',
    'urlDefaults' => [],
    'viewMode' => 'table',
    'sort' => '',
    'direction' => 'asc',
    'selectedId' => null,
    'refreshTab' => '',
])

@php
    $configuredColumns = collect($config['columns'] ?? []);
    $columns = $configuredColumns
        ->filter(fn ($column) => ($column['key'] ?? null) === 'id')
        ->merge($configuredColumns->reject(fn ($column) => ($column['key'] ?? null) === 'id'))
        ->values()
        ->all();
    $rowActions = $config['row_actions'] ?? [];
    $wireTarget = $config['wire_target'] ?? 'search,perPage,setFilter,applySelectFilter,applyMultiFilter,toggleFilter,setSort,switchView,moveRow,reorderRow,sortTableRowByUid,goToPage,firstPage,previousPage,nextPage,goLastPage';
    $search = $config['search'] ?? [];
    $searchState = $search['state'] ?? 'search';
    $searchWidth = $search['width'] ?? null;
    $surfaceClass = trim('evo-ui-table-surface ' . ($config['class'] ?? ''));
    $colspan = count($columns) + (!empty($rowActions) ? 1 : 0);
    $opensModal = !empty($config['modal']['enabled']) && (($config['modal']['row_dblclick'] ?? true) !== false);
    $modalDblclickAction = trim((string) data_get($config, 'modal.row_dblclick_action', ''));
    $reorderEnabled = method_exists($controller, 'reorderEnabled') && $controller->reorderEnabled();
    $titleInTableHeader = ($config['title_placement'] ?? null) === 'table_header';
    $viewKey = 'evo-ui-table-view-' . str_replace(['.', '/', '\\'], '-', (string) ($config['key'] ?? 'module'));
    $urlState = [
        'q' => $controller->search,
        'page' => $page,
        'sort' => $sort,
        'dir' => $direction,
        'f' => $controller->filterState,
        'view' => $viewMode,
    ];
    $surfaceAttributes = new \Illuminate\View\ComponentAttributeBag([
        'class' => $surfaceClass,
        'data-evo-table' => $config['key'] ?? 'module',
        'data-evo-table-view' => $viewMode,
        'data-evo-table-storage-key' => $storageKey,
        'data-evo-table-per-page' => $perPage,
        'data-evo-table-per-page-cookie' => $perPageCookieName,
        'data-evo-table-per-page-options' => implode(',', $perPageOptions),
        'data-evo-table-url-defaults' => rawurlencode(json_encode($urlDefaults, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)),
        'data-evo-table-url-state' => rawurlencode(json_encode($urlState, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)),
        'wire:loading.class' => 'is-loading',
        'wire:target' => $wireTarget,
    ]);

    $refreshTab = trim((string) $refreshTab);

    if ($refreshTab !== '') {
        $surfaceAttributes = $surfaceAttributes->merge([
            'x-on:evo-ui:module-tab.refresh.window' => 'if ($event.detail.tab === ' . \Illuminate\Support\Js::from($refreshTab) . ') { $wire.$refresh(); }',
        ]);
    }

    if ($reorderEnabled) {
        $surfaceAttributes = $surfaceAttributes->merge([
            'data-evo-dnd' => true,
            'data-evo-dnd-item-method' => 'sortTableRowByUid',
        ]);
    }

    $bodyAttributes = new \Illuminate\View\ComponentAttributeBag([]);

    if ($reorderEnabled) {
        $bodyAttributes = $bodyAttributes->merge(['data-evo-dnd-list' => true]);
    }
@endphp

<section {{ $surfaceAttributes }}>
    @if(!$titleInTableHeader || $viewMode === 'list')
        <div wire:key="{{ $viewKey }}-toolbar-{{ $viewMode }}">
            <x-evo::table.module.toolbar
                :controller="$controller"
                :config="$config"
                :filters="$filters"
                :filter-options="$filterOptions"
                :filter-labels="$filterLabels"
                :search-state="$searchState"
                :search-width="$searchWidth"
                :view-mode="$viewMode"
                :sort="$sort"
                :direction="$direction"
                :selected-id="$selectedId"
            />
        </div>
    @endif

    <div wire:key="{{ $viewKey }}-content-{{ $viewMode }}" data-evo-table-view-content="{{ $viewMode }}">
        @if($viewMode === 'list')
            <div wire:key="{{ $viewKey }}-list">
                <x-evo::table.module.list
                    :controller="$controller"
                    :config="$config"
                    :rows="$rows"
                    :selected-id="$selectedId"
                />
            </div>
        @else
            <div
                wire:key="{{ $viewKey }}-table"
                @class(['evo-ui-table-wrap', 'evo-ui-table-wrap--module', 'evo-ui-table-wrap--with-toolbar' => $titleInTableHeader])
            >
                @if($titleInTableHeader)
                    <div wire:key="{{ $viewKey }}-toolbar-table-header">
                        <x-evo::table.module.toolbar
                            :controller="$controller"
                            :config="$config"
                            :filters="$filters"
                            :filter-options="$filterOptions"
                            :filter-labels="$filterLabels"
                            :search-state="$searchState"
                            :search-width="$searchWidth"
                            :view-mode="$viewMode"
                            :sort="$sort"
                            :direction="$direction"
                            :selected-id="$selectedId"
                            table-header
                        />
                    </div>
                @endif

                <table class="evo-ui-table evo-ui-table--module">
                    <thead>
                        <tr>
                            @foreach($columns as $column)
                                <x-evo::table.header-cell
                                    :column="$column"
                                    :sort="$sort"
                                    :direction="$direction"
                                />
                            @endforeach

                            @if(!empty($rowActions))
                                <th class="evo-ui-table__actions">@lang('evo::global.column_actions')</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody {{ $bodyAttributes }}>
                        @forelse($rows as $row)
                            @php
                                $editUrl = data_get($row, 'edit_url');
                                $rowId = (int) data_get($row, 'id');
                                $rowClass = trim(($rowId > 0 ? 'is-selectable ' : '') .
                                    ($selectedId === $rowId ? 'is-selected ' : '') .
                                    $controller->rowStateClasses($row));
                                $rowAttributes = new \Illuminate\View\ComponentAttributeBag([
                                    'wire:key' => data_get($row, 'wire_key', 'row-' . data_get($row, 'id')) . '-table',
                                    'wire:click' => 'selectRow(' . $rowId . ')',
                                    'aria-selected' => $selectedId === $rowId ? 'true' : 'false',
                                    'class' => $rowClass,
                                ]);
                                $providerRowAttributes = method_exists($controller, 'rowAttributes')
                                    ? $controller->rowAttributes($row)
                                    : [];
                                $rowAttributes = $rowAttributes
                                    ->class($providerRowAttributes['class'] ?? '')
                                    ->merge(array_diff_key($providerRowAttributes, ['class' => true]));

                                if ($opensModal && $rowId > 0) {
                                    $rowAttributes = $rowAttributes->merge(['data-evo-modal-dblclick' => $rowId]);

                                    if ($modalDblclickAction !== '') {
                                        $rowAttributes = $rowAttributes->merge(['data-evo-modal-action' => $modalDblclickAction]);
                                    }
                                } elseif ($editUrl) {
                                    $rowAttributes = $rowAttributes->merge(['data-evo-manager-dblclick' => $editUrl]);
                                }

                                if ($reorderEnabled && $rowId > 0) {
                                    $rowAttributes = $rowAttributes->merge([
                                        'class' => 'evo-ui-table-row--dnd',
                                        'data-evo-dnd-item' => true,
                                        'data-evo-dnd-uid' => (string) $rowId,
                                        'data-evo-table-row' => (string) $rowId,
                                        'draggable' => 'true',
                                    ]);
                                }
                            @endphp
                            <tr {{ $rowAttributes }}>
                                @foreach($columns as $column)
                                    <x-evo::table.module.cell :row="$row" :column="$column" :reorder-enabled="$reorderEnabled" />
                                @endforeach

                                @if(!empty($rowActions))
                                    <x-evo::table.module.actions :row="$row" :actions="$rowActions" />
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $colspan }}" class="evo-ui-table-empty">@lang('evo::global.table_empty')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <x-evo::table.pagination
        :page="$page"
        :total="$total"
        :last-page="$lastPage"
        :pagination-items="$paginationItems"
        :per-page="$perPage"
        :per-page-options="$perPageOptions"
        class="evo-ui-table-footer--module"
    />

    @if(!empty($config['modal']['enabled']))
        <x-evo::table.module.form-modal :controller="$controller" :config="$config" />
    @endif

    <x-evo::table.module.delete-modal :controller="$controller" />
</section>
