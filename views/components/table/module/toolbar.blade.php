@props([
    'controller',
    'config',
    'filters' => [],
    'filterOptions' => [],
    'filterLabels' => [],
    'searchState' => 'search',
    'searchWidth' => null,
    'viewMode' => 'table',
    'sort' => '',
    'direction' => 'asc',
    'selectedId' => null,
    'tableHeader' => false,
])

@php
    $actions = collect((array) ($config['actions'] ?? []));
    $controlActions = $actions
        ->filter(fn ($action) => is_array($action) && (string) ($action['placement'] ?? '') === 'controls')
        ->values();
    $toolbarActions = $actions
        ->reject(fn ($action) => is_array($action) && (string) ($action['placement'] ?? '') === 'controls')
        ->values();
    $searchEnabled = (bool) data_get($config, 'search.enabled', true);
    $searchClass = trim('evo-ui-search ' . ($searchWidth === 'sm' ? 'evo-ui-search--sm' : ''));
    $hasFilters = count($filters) > 0;
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

        @foreach($toolbarActions as $action)
            @php
                $label = method_exists($controller, 'tableActionLabel') ? $controller->tableActionLabel($action) : __($action['label'] ?? '');
                $href = method_exists($controller, 'tableActionHref') ? $controller->tableActionHref($action, $selectedId) : ($action['href'] ?? null);
                $extra = method_exists($controller, 'tableActionAttributes') ? $controller->tableActionAttributes($action, $selectedId) : ($action['attributes'] ?? []);
                $actionAttributes = new \Illuminate\View\ComponentAttributeBag($extra);
                $icon = $action['icon'] ?? null;
                $iconOnly = (bool) ($action['icon_only'] ?? false);
                $tone = $action['tone'] ?? 'neutral';
                $variant = $action['variant'] ?? 'soft';
                $type = $action['type'] ?? 'link';
                $requiresSelection = ($action['selection'] ?? null) === 'single';
                $disabled = $requiresSelection && !$selectedId;
                $buttonClass = trim('evo-ui-btn ' .
                    ($iconOnly ? 'evo-ui-btn--icon ' : '') .
                    (in_array($tone, ['primary', 'info', 'success', 'warning', 'danger'], true) ? 'evo-ui-btn--' . $tone . ' ' : '') .
                    ($variant === 'filled' ? 'evo-ui-btn--filled' : ''));
                $actionAttributes = $actionAttributes->merge([
                    'class' => $buttonClass,
                    'title' => $label,
                    'aria-label' => $iconOnly && $label ? $label : null,
                ]);
            @endphp

            @if($type === 'wire')
                <button
                    type="button"
                    {{ $actionAttributes }}
                    @disabled($disabled)
                    @if(!empty($action['provider']))
                        wire:click="runTableAction(@js($action['key'] ?? ''))"
                    @else
                        wire:click="{{ $action['method'] ?? '' }}"
                    @endif
                >
                    @if($icon)
                        <x-evo::icon :name="$icon" class="evo-ui-btn__icon" />
                    @endif

                    @if($label && !$iconOnly)
                        <span>{{ $label }}</span>
                    @elseif($label)
                        <span class="evo-ui-sr-only">{{ $label }}</span>
                    @endif
                </button>
            @elseif($href && !$disabled)
                <a href="{{ $href }}" {{ $actionAttributes }}>
                    @if($icon)
                        <x-evo::icon :name="$icon" class="evo-ui-btn__icon" />
                    @endif

                    @if($label && !$iconOnly)
                        <span>{{ $label }}</span>
                    @elseif($label)
                        <span class="evo-ui-sr-only">{{ $label }}</span>
                    @endif
                </a>
            @else
                <button type="button" {{ $actionAttributes }} disabled>
                    @if($icon)
                        <x-evo::icon :name="$icon" class="evo-ui-btn__icon" />
                    @endif

                    @if($label && !$iconOnly)
                        <span>{{ $label }}</span>
                    @elseif($label)
                        <span class="evo-ui-sr-only">{{ $label }}</span>
                    @endif
                </button>
            @endif
        @endforeach
    </div>

    @if($hasFilters)
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
    @endif

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

        @foreach($controlActions as $action)
            @php
                $label = method_exists($controller, 'tableActionLabel') ? $controller->tableActionLabel($action) : __($action['label'] ?? '');
                $href = method_exists($controller, 'tableActionHref') ? $controller->tableActionHref($action, $selectedId) : ($action['href'] ?? null);
                $extra = method_exists($controller, 'tableActionAttributes') ? $controller->tableActionAttributes($action, $selectedId) : ($action['attributes'] ?? []);
                $actionAttributes = new \Illuminate\View\ComponentAttributeBag($extra);
                $icon = $action['icon'] ?? null;
                $iconOnly = (bool) ($action['icon_only'] ?? false);
                $tone = $action['tone'] ?? 'neutral';
                $variant = $action['variant'] ?? 'soft';
                $type = $action['type'] ?? 'link';
                $requiresSelection = ($action['selection'] ?? null) === 'single';
                $disabled = $requiresSelection && !$selectedId;
                $buttonClass = trim('evo-ui-btn ' .
                    ($iconOnly ? 'evo-ui-btn--icon ' : '') .
                    (in_array($tone, ['primary', 'info', 'success', 'warning', 'danger'], true) ? 'evo-ui-btn--' . $tone . ' ' : '') .
                    ($variant === 'filled' ? 'evo-ui-btn--filled' : ''));
                $actionAttributes = $actionAttributes->merge([
                    'class' => $buttonClass,
                    'title' => $label,
                    'aria-label' => $iconOnly && $label ? $label : null,
                ]);
            @endphp

            @if($type === 'wire')
                <button
                    type="button"
                    {{ $actionAttributes }}
                    @disabled($disabled)
                    @if(!empty($action['provider']))
                        wire:click="runTableAction(@js($action['key'] ?? ''))"
                    @else
                        wire:click="{{ $action['method'] ?? '' }}"
                    @endif
                >
                    @if($icon)
                        <x-evo::icon :name="$icon" class="evo-ui-btn__icon" />
                    @endif

                    @if($label && !$iconOnly)
                        <span>{{ $label }}</span>
                    @elseif($label)
                        <span class="evo-ui-sr-only">{{ $label }}</span>
                    @endif
                </button>
            @elseif($href && !$disabled)
                <a href="{{ $href }}" {{ $actionAttributes }}>
                    @if($icon)
                        <x-evo::icon :name="$icon" class="evo-ui-btn__icon" />
                    @endif

                    @if($label && !$iconOnly)
                        <span>{{ $label }}</span>
                    @elseif($label)
                        <span class="evo-ui-sr-only">{{ $label }}</span>
                    @endif
                </a>
            @else
                <button type="button" {{ $actionAttributes }} disabled>
                    @if($icon)
                        <x-evo::icon :name="$icon" class="evo-ui-btn__icon" />
                    @endif

                    @if($label && !$iconOnly)
                        <span>{{ $label }}</span>
                    @elseif($label)
                        <span class="evo-ui-sr-only">{{ $label }}</span>
                    @endif
                </button>
            @endif
        @endforeach

        @if($searchEnabled)
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
                class="{{ $searchClass }}"
                title="@lang('global.search')"
                :class="{ 'is-open': searchOpen }"
            >
                <x-evo::icon name="search" class="evo-ui-search__icon" />
                <input x-ref="tableSearch" type="search" wire:model.live.debounce.300ms="{{ $searchState }}" autocomplete="off" />
            </label>
        @endif
    </div>
</div>
