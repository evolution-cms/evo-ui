@switch($block['type'])
    @case('form')
        @livewire($block['component'] ?? 'evo-ui.form', array_replace($block['parameters'] ?? [], ['preset' => $block['preset']]), key($blockKey))
        @break
    @case('table')
        @livewire($block['component'] ?? 'evo-ui.module-table', array_replace($block['parameters'] ?? [], ['preset' => $block['preset'], 'context' => $context]), key($blockKey))
        @break
    @case('dashboard')
        <x-evo::dashboard :cards="$block['cards'] ?? []" />
        @break
    @case('card')
        <x-evo::card :label="$block['label'] ?? null" :icon="$block['icon'] ?? null">
            @if(isset($block['text']))
                <p>{{ __($block['text']) }}</p>
            @endif
            @foreach($block['actions'] ?? [] as $action)
                <x-evo::button :icon="$action['icon'] ?? null" :label="__($action['label'])" :x-on:click="'requestModuleTab(' . \Illuminate\Support\Js::from($action['tab'])->toHtml() . ')'" />
            @endforeach
        </x-evo::card>
        @break
    @case('view')
        @include($block['view'], ['context' => $context, 'data' => $blockData])
        @break
@endswitch
