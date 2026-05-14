@props([
    'controller',
    'preset',
    'config',
    'rows',
    'filters' => [],
    'filterOptions' => [],
    'filterLabels' => [],
    'selected' => [],
    'viewMode' => 'table',
    'sort' => '',
    'direction' => 'asc',
    'perPage' => 10,
    'perPageOptions' => [],
    'page' => 1,
    'total' => 0,
    'lastPage' => 1,
    'paginationItems' => [],
])

@php($selectedId = count($selected) === 1 ? $selected[0] : null)
@php($titleInTableHeader = ($config['title_placement'] ?? null) === 'table_header')
@php($viewKey = 'evo-ui-table-view-' . str_replace(['.', '/', '\\'], '-', (string) $preset))

<section
    class="evo-ui-table-surface"
    data-evo-table="{{ $preset }}"
    data-evo-table-view="{{ $viewMode }}"
    wire:loading.class="is-loading"
    wire:target="search,perPage,setFilter,applySelectFilter,applyMultiFilter,applyDateRangeFilter,toggleFilter,setSort,switchView,goToPage,firstPage,previousPage,nextPage,goLastPage"
>
    @if(!$titleInTableHeader || $viewMode === 'list')
        <div wire:key="{{ $viewKey }}-toolbar-{{ $viewMode }}">
            <x-evo::table.toolbar
                :controller="$controller"
                :config="$config"
                :filters="$filters"
                :filter-options="$filterOptions"
                :filter-labels="$filterLabels"
                :selected-id="$selectedId"
                :view-mode="$viewMode"
                :sort="$sort"
                :direction="$direction"
            />
        </div>
    @endif

    <div wire:key="{{ $viewKey }}-content-{{ $viewMode }}" data-evo-table-view-content="{{ $viewMode }}">
        @if($viewMode === 'list')
            <x-evo::table.list
                :controller="$controller"
                :preset="$preset"
                :config="$config"
                :rows="$rows"
                :selected="$selected"
            />
        @else
            <div wire:key="{{ $viewKey }}-table" @class(['evo-ui-table-wrap', 'evo-ui-table-wrap--with-toolbar' => $titleInTableHeader])>
                @if($titleInTableHeader)
                    <div wire:key="{{ $viewKey }}-toolbar-table-header">
                        <x-evo::table.toolbar
                            :controller="$controller"
                            :config="$config"
                            :filters="$filters"
                            :filter-options="$filterOptions"
                            :filter-labels="$filterLabels"
                            :selected-id="$selectedId"
                            :view-mode="$viewMode"
                            :sort="$sort"
                            :direction="$direction"
                            table-header
                        />
                    </div>
                @endif

                <table class="evo-ui-table">
                    <thead>
                        <tr>
                            @foreach($config['columns'] ?? [] as $column)
                                <x-evo::table.header-cell
                                    :column="$column"
                                    :sort="$sort"
                                    :direction="$direction"
                                />
                            @endforeach

                            @if(!empty($config['row_actions']))
                                <th class="evo-ui-table__actions">@lang('evo::global.column_actions')</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($rows as $row)
                            <x-evo::table.row
                                :controller="$controller"
                                :preset="$preset"
                                :config="$config"
                                :row="$row"
                                :selected="in_array($row->id, $selected, true)"
                            />
                        @empty
                            <tr>
                                <td colspan="{{ count($config['columns'] ?? []) + (!empty($config['row_actions']) ? 1 : 0) }}" class="evo-ui-table-empty">
                                    @lang('evo::global.table_empty')
                                </td>
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
    />
</section>
