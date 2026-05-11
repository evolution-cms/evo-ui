@props([
    'id' => null,
    'type' => 'row',
    'title' => null,
    'subtitle' => null,
    'chip' => null,
    'draggable' => true,
])

<div
    {{ $attributes->class('evo-ui-builder-row')->merge([
        'data-evo-builder-row' => true,
        'data-evo-builder-id' => $id,
        'data-evo-builder-row-type' => $type,
        'draggable' => $draggable ? 'true' : 'false',
    ]) }}
>
    {{ $rail ?? '' }}

    <button type="button" class="evo-ui-builder-summary" data-evo-builder-summary>
        <span class="evo-ui-builder-summary__main">
            @if($title !== null)
                <span class="evo-ui-builder-summary__title">{{ $title }}</span>
            @endif
            @if($subtitle !== null)
                <span class="evo-ui-builder-summary__subtitle">{{ $subtitle }}</span>
            @endif
        </span>

        @if($chip !== null)
            <span class="evo-ui-builder-chip">{{ $chip }}</span>
        @endif
    </button>

    {{ $slot }}
</div>
