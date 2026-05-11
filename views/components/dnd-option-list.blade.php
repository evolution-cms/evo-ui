@props([
    'method' => null,
    'label' => null,
    'hint' => null,
])

<div
    {{ $attributes->class('evo-ui-dnd evo-ui-dnd-option-list')->merge([
        'data-evo-dnd' => true,
        'data-evo-dnd-option-list' => true,
        'data-evo-dnd-option-method' => $method,
    ]) }}
    x-init="$nextTick(() => window.EvoUI?.initDnd?.($el))"
>
    @if($label || $hint)
        <div class="evo-ui-dnd-option-list__header">
            @if($label)
                <span class="evo-ui-dnd-option-list__label">{{ $label }}</span>
            @endif
            @if($hint)
                <span class="evo-ui-dnd-option-list__hint">{{ $hint }}</span>
            @endif
        </div>
    @endif

    {{ $slot }}
</div>
