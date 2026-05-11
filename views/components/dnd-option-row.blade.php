@props([
    'uid' => null,
    'index' => 0,
    'optionValue' => '',
    'optionLabel' => '',
    'valueName' => null,
    'labelName' => null,
    'valuePlaceholder' => null,
    'labelPlaceholder' => null,
    'moveUp' => null,
    'moveDown' => null,
    'addAfter' => null,
    'delete' => null,
    'upDisabled' => false,
    'downDisabled' => false,
    'draggable' => true,
])

@php
    $rowUid = $uid ?: 'option-' . $index;
    $valueName = $valueName ?: 'options.' . $index . '.value';
    $labelName = $labelName ?: 'options.' . $index . '.label';
@endphp

<div
    {{ $attributes->class('evo-ui-dnd-option-row')->merge([
        'data-evo-dnd-option-row' => true,
        'data-evo-dnd-uid' => $rowUid,
        'draggable' => $draggable ? 'true' : 'false',
    ]) }}
>
    <x-evo::reorder-rail
        :move-up="$moveUp"
        :move-down="$moveDown"
        :up-disabled="$upDisabled"
        :down-disabled="$downDisabled"
    />

    <div class="evo-ui-dnd-option-row__fields">
        {{ $fields ?? '' }}

        @empty($fields)
            <input
                type="text"
                class="evo-ui-input"
                wire:model.live="{{ $valueName }}"
                value="{{ $optionValue }}"
                placeholder="{{ $valuePlaceholder ?: __('evo::global.value') }}"
                data-evo-dnd-option-value
            >

            <input
                type="text"
                class="evo-ui-input"
                wire:model.live="{{ $labelName }}"
                value="{{ $optionLabel }}"
                placeholder="{{ $labelPlaceholder ?: __('evo::global.label') }}"
                data-evo-dnd-option-label
            >
        @endempty
    </div>

    <div class="evo-ui-dnd-actions evo-ui-row-actions--compact">
        {{ $actions ?? '' }}

        @empty($actions)
            @if($addAfter)
                <button
                    type="button"
                    class="evo-ui-row-action evo-ui-row-action--success"
                    title="@lang('evo::global.add')"
                    aria-label="@lang('evo::global.add')"
                    wire:click="{{ $addAfter }}"
                >
                    <x-evo::icon name="plus" />
                </button>
            @endif

            @if($delete)
                <button
                    type="button"
                    class="evo-ui-row-action evo-ui-row-action--danger"
                    title="@lang('evo::global.delete')"
                    aria-label="@lang('evo::global.delete')"
                    wire:click="{{ $delete }}"
                >
                    <x-evo::icon name="trash" />
                </button>
            @endif
        @endempty
    </div>
</div>
