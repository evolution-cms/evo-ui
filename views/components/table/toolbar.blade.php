@props([
    'controller',
    'config',
    'filters' => [],
    'filterOptions' => [],
    'filterLabels' => [],
    'selectedId' => null,
    'viewMode' => 'table',
    'sort' => '',
    'direction' => 'asc',
    'tableHeader' => false,
])

@php
    $title = isset($config['title']) ? trim((string) __($config['title'])) : '';
    $titleIcon = $config['title_icon'] ?? null;
@endphp

<div
    @class(['evo-ui-table-toolbar', 'evo-ui-table-toolbar--table-header' => $tableHeader])
    x-data="{ filtersOpen: false, searchOpen: false }"
    @click.outside="filtersOpen = false; searchOpen = false"
>
    <div class="evo-ui-table-actions" aria-label="@lang('evo::global.table_actions')">
        @if($title !== '')
            <h2 class="evo-ui-table-title">
                @if($titleIcon)
                    <x-evo::icon :name="$titleIcon" />
                @endif
                <span>{{ $title }}</span>
            </h2>
        @endif

        @foreach($config['actions'] ?? [] as $action)
            @php($href = $controller->actionHref($action, selectedId: $selectedId))
            <x-evo::button
                :icon="$action['icon']"
                :label="__($action['label'])"
                :href="$href"
                :disabled="!$href"
                :tone="$action['tone'] ?? 'neutral'"
                icon-only
            />
        @endforeach
    </div>

    <button
        type="button"
        class="evo-ui-mobile-trigger"
        title="@lang('evo::global.filters')"
        aria-label="@lang('evo::global.filters')"
        :aria-expanded="filtersOpen.toString()"
        @click="filtersOpen = !filtersOpen; searchOpen = false"
    >
        <x-evo::icon name="filter" />
    </button>

    <div
        class="evo-ui-table-filters"
        :class="{ 'is-open': filtersOpen }"
    >
        @foreach($filters as $filter)
            <x-evo::table.filter
                :controller="$controller"
                :filter="$filter"
                :options="$filterOptions[$filter['state']] ?? []"
                :labels="$filterLabels[$filter['state']] ?? []"
            />
        @endforeach
    </div>

    <div class="evo-ui-table-controls">
        @if(in_array('list', $config['views'] ?? [], true))
            <div class="evo-ui-view-toggle" aria-label="@lang('evo::global.view_mode')">
                <button
                    type="button"
                    title="@lang('evo::global.view_table')"
                    aria-label="@lang('evo::global.view_table')"
                    @class(['is-active' => $viewMode === 'table'])
                    wire:click="switchView('table')"
                >
                    <x-evo::icon name="table" />
                </button>
                <button
                    type="button"
                    title="@lang('evo::global.view_list')"
                    aria-label="@lang('evo::global.view_list')"
                    @class(['is-active' => $viewMode === 'list'])
                    wire:click="switchView('list')"
                >
                    <x-evo::icon name="list" />
                </button>
            </div>
        @endif

        @if($viewMode === 'list')
            <x-evo::table.order
                :controller="$controller"
                :sort="$sort"
                :direction="$direction"
            />
        @endif

        <button
            type="button"
            class="evo-ui-mobile-trigger"
            title="@lang('evo::global.search_placeholder')"
            aria-label="@lang('evo::global.search_placeholder')"
            :aria-expanded="searchOpen.toString()"
            @click="searchOpen = !searchOpen; filtersOpen = false; $nextTick(() => searchOpen && $refs.tableSearch.focus())"
        >
            <x-evo::icon name="search" />
        </button>

        <label
            class="evo-ui-search"
            :class="{ 'is-open': searchOpen }"
        >
            <x-evo::icon name="search" class="evo-ui-search__icon" />
            <input
                x-ref="tableSearch"
                type="search"
                placeholder="@lang('evo::global.search_placeholder')"
                wire:model.live.debounce.300ms="search"
            >
        </label>
    </div>
</div>
