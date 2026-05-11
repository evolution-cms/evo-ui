@props([
    'type' => 'default',
    'reorderMethod' => 'reorderBuilderRows',
])

<div
    {{ $attributes->class('evo-ui-builder')->merge([
        'data-evo-builder' => true,
        'data-evo-builder-type' => $type,
        'data-evo-builder-reorder-method' => $reorderMethod,
    ]) }}
    x-init="$nextTick(() => window.EvoUI?.initBuilder?.($el))"
>
    {{ $slot }}
</div>
