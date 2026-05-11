@props([
    'cards' => [],
    'divided' => true,
])

<section {{ $attributes->class('evo-ui-dashboard')->merge(['data-evo-dashboard' => '']) }}>
    <div
        @class([
            'evo-ui-dashboard__cards',
            'evo-ui-dashboard__cards--divided' => (bool) $divided,
        ])
        data-evo-dashboard-cards
    >
        @foreach($cards as $card)
            <x-evo::dashboard-card
                :title="$card['title'] ?? null"
                :icon="$card['icon'] ?? null"
                :span="$card['span'] ?? 12"
                :status="$card['status'] ?? null"
                :stats="$card['stats'] ?? []"
                :meta="$card['meta'] ?? []"
                :badges="$card['badges'] ?? []"
            />
        @endforeach

        {{ $slot }}
    </div>

    @isset($body)
        <div class="evo-ui-dashboard__body" data-evo-dashboard-body>
            {{ $body }}
        </div>
    @endisset
</section>
