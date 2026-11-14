@props([
    'page' => 1,
    'total' => 0,
    'lastPage' => 1,
    'paginationItems' => [],
    'perPage' => 10,
    'perPageOptions' => [],
])

<footer {{ $attributes->class('evo-ui-table-footer') }}>
    @php($currentPage = (int) $page)
    <div class="evo-ui-table-footer__meta">
        <span>{{ $total }} @lang('evo::global.rows_total')</span>

        <label class="evo-ui-per-page">
            <span>@lang('evo::global.per_page')</span>
            <select wire:model.live="perPage">
                @foreach($perPageOptions as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </label>
    </div>

    <div class="evo-ui-pager" wire:replace wire:key="table-pager-{{ $currentPage }}-{{ (int) $lastPage }}">
        <button type="button" wire:key="table-page-first" wire:click="firstPage" @disabled($page <= 1) title="@lang('evo::global.first_page')" aria-label="@lang('evo::global.first_page')">
            <x-evo::icon name="chevrons-left" />
        </button>
        <button type="button" wire:key="table-page-previous" wire:click="previousPage" @disabled($page <= 1) title="@lang('evo::global.previous')" aria-label="@lang('evo::global.previous')">
            <x-evo::icon name="chevron-left" />
        </button>

        @foreach($paginationItems as $item)
            @if($item === '...')
                <span class="evo-ui-pager__ellipsis">...</span>
            @else
                @php($isCurrent = $currentPage === (int) $item)
                @if($isCurrent)
                    <button
                        type="button"
                        class="is-active"
                        wire:key="table-page-{{ $item }}"
                        wire:click="goToPage({{ $item }})"
                        aria-current="page"
                    >{{ $item }}</button>
                @else
                    <button
                        type="button"
                        wire:key="table-page-{{ $item }}"
                        wire:click="goToPage({{ $item }})"
                    >{{ $item }}</button>
                @endif
            @endif
        @endforeach

        <button type="button" wire:key="table-page-next" wire:click="nextPage" @disabled($page >= $lastPage) title="@lang('evo::global.next')" aria-label="@lang('evo::global.next')">
            <x-evo::icon name="chevron-right" />
        </button>
        <button type="button" wire:key="table-page-last" wire:click="goLastPage" @disabled($page >= $lastPage) title="@lang('evo::global.last_page')" aria-label="@lang('evo::global.last_page')">
            <x-evo::icon name="chevrons-right" />
        </button>
    </div>
</footer>
