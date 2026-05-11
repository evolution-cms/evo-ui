@props([
    'label' => null,
    'for' => null,
    'usage' => null,
    'description' => null,
    'divider' => false,
    'textarea' => false,
])

@if($divider)
    <div {{ $attributes->class('evo-ui-settings-divider') }} data-evo-settings-divider>
        <span>{{ $label }}</span>
    </div>
@else
    <div
        {{ $attributes->class([
            'evo-ui-settings-row',
            'evo-ui-settings-row--textarea' => $textarea,
        ]) }}
        data-evo-settings-row
    >
        <div class="evo-ui-settings-row__meta">
            @if($label !== null)
                <label class="evo-ui-settings-row__label" @if($for) for="{{ $for }}" @endif>{{ $label }}</label>
            @endif

            @if($usage)
                <code class="evo-ui-settings-row__usage">{{ $usage }}</code>
            @endif
        </div>

        <div class="evo-ui-settings-row__control">
            {{ $slot }}

            @if($description)
                <p class="evo-ui-settings-row__description">{{ $description }}</p>
            @endif
        </div>
    </div>
@endif
