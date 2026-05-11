@props([
    'title' => null,
    'icon' => null,
    'span' => 12,
    'status' => null,
    'stats' => [],
    'meta' => [],
    'badges' => [],
])

@php
    $allowedSpans = [3, 4, 6, 8, 12];
    $span = in_array((int) $span, $allowedSpans, true) ? (int) $span : 12;
    $status = is_scalar($status) || $status === null ? (string) $status : '';
@endphp

<section
    {{ $attributes
        ->class(['evo-ui-card', 'evo-ui-dashboard-card', 'evo-ui-dashboard-card--span-' . $span])
        ->merge(['data-evo-dashboard-card' => '', 'data-evo-dashboard-card-span' => (string) $span]) }}
    @if($status !== '') data-evo-dashboard-card-status="{{ $status }}" @endif
>
    @if($title || $icon)
        <header class="evo-ui-card__header evo-ui-dashboard-card__header">
            @if($icon)
                <x-evo::icon :name="$icon" />
            @endif
            @if($title)
                <h3>{{ __($title) }}</h3>
            @endif
        </header>
    @endif

    @if(!empty($stats) || !empty($badges))
        <div class="evo-ui-dashboard-card__stats">
            @foreach($stats as $stat)
                <span class="evo-ui-dashboard-card__stat">
                    <strong>{{ $stat['value'] ?? '' }}</strong>
                    @if(!empty($stat['label']))
                        <span>{{ __($stat['label']) }}</span>
                    @endif
                </span>
            @endforeach

            @foreach($badges as $badge)
                <x-evo::badge :value="$badge" />
            @endforeach
        </div>
    @endif

    @foreach($meta as $item)
        <span class="evo-ui-card__label evo-ui-dashboard-card__meta">
            @if(!empty($item['label']))
                {{ __($item['label']) }}:
            @endif
            @if(!empty($item['strong']))
                <b>{{ $item['value'] ?? '' }}</b>
            @else
                {{ $item['value'] ?? '' }}
            @endif
        </span>
    @endforeach

    {{ $slot }}
</section>

