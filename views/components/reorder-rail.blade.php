@props([
    'moveUp' => null,
    'moveDown' => null,
    'upDisabled' => false,
    'downDisabled' => false,
    'label' => null,
    'handleDraggable' => true,
])

@php
    $dragLabel = $label ?: __('evo::global.drag_to_reorder');
@endphp

<div {{ $attributes->class('evo-ui-reorder-rail') }} data-evo-reorder-rail>
    <button
        type="button"
        class="evo-ui-reorder-rail__button"
        title="@lang('evo::global.move_up')"
        aria-label="@lang('evo::global.move_up')"
        @if($moveUp) wire:click="{{ $moveUp }}" @endif
        @disabled($upDisabled)
    >
        <x-evo::icon name="chevron-up" />
    </button>

    <span
        class="evo-ui-drag-handle"
        role="button"
        tabindex="0"
        title="{{ $dragLabel }}"
        aria-label="{{ $dragLabel }}"
        @if($handleDraggable) draggable="true" @endif
        data-evo-drag-handle
        data-evo-dnd-handle
    >
        <x-evo::icon name="grip-vertical" />
    </span>

    <button
        type="button"
        class="evo-ui-reorder-rail__button"
        title="@lang('evo::global.move_down')"
        aria-label="@lang('evo::global.move_down')"
        @if($moveDown) wire:click="{{ $moveDown }}" @endif
        @disabled($downDisabled)
    >
        <x-evo::icon name="chevron-down" />
    </button>
</div>
