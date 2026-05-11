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
    'viewMode' => 'table',
    'sort' => '',
    'direction' => 'asc',
    'selectedId' => null,
])

@php
    $configuredColumns = collect($config['columns'] ?? []);
    $columns = $configuredColumns
        ->filter(fn ($column) => ($column['key'] ?? null) === 'id')
        ->merge($configuredColumns->reject(fn ($column) => ($column['key'] ?? null) === 'id'))
        ->values()
        ->all();
    $rowActions = $config['row_actions'] ?? [];
    $wireTarget = $config['wire_target'] ?? 'search,perPage,setFilter,applySelectFilter,applyMultiFilter,toggleFilter,setSort,switchView,goToPage,firstPage,previousPage,nextPage,goLastPage';
    $search = $config['search'] ?? [];
    $searchState = $search['state'] ?? 'search';
    $searchWidth = $search['width'] ?? null;
    $surfaceClass = trim('evo-ui-table-surface ' . ($config['class'] ?? ''));
    $colspan = count($columns) + (!empty($rowActions) ? 1 : 0);
    $opensModal = !empty($config['modal']['enabled']) && (($config['modal']['row_dblclick'] ?? true) !== false);
    $reorderEnabled = method_exists($controller, 'reorderEnabled') && $controller->reorderEnabled();
    $titleInTableHeader = ($config['title_placement'] ?? null) === 'table_header';
@endphp

<section
    class="{{ $surfaceClass }}"
    data-evo-table="{{ $config['key'] ?? 'module' }}"
    wire:loading.class="is-loading"
    wire:target="{{ $wireTarget }}"
>
    @if(!$titleInTableHeader || $viewMode === 'list')
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
    @endif

    @if($viewMode === 'list')
        <x-evo::table.module.list
            :controller="$controller"
            :config="$config"
            :rows="$rows"
            :selected-id="$selectedId"
        />
    @else
        <div @class(['evo-ui-table-wrap', 'evo-ui-table-wrap--module', 'evo-ui-table-wrap--with-toolbar' => $titleInTableHeader])>
            @if($titleInTableHeader)
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

                <tbody>
                    @forelse($rows as $row)
                        @php
                            $editUrl = data_get($row, 'edit_url');
                            $rowId = (int) data_get($row, 'id');
                            $rowClass = trim(($rowId > 0 ? 'is-selectable ' : '') .
                                ($selectedId === $rowId ? 'is-selected ' : '') .
                                $controller->rowStateClasses($row));
                        @endphp
                        <tr
                            wire:key="{{ data_get($row, 'wire_key', 'row-' . data_get($row, 'id')) }}"
                            wire:click="selectRow({{ $rowId }})"
                            aria-selected="{{ $selectedId === $rowId ? 'true' : 'false' }}"
                            class="{{ $rowClass }}"
                            @if($opensModal && $rowId > 0)
                                data-evo-modal-dblclick="{{ $rowId }}"
                            @elseif($editUrl)
                                data-evo-manager-dblclick="{{ $editUrl }}"
                            @endif
                        >
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
