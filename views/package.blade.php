@component('evo::layouts.manager', ['title' => __(app(\EvoUI\EvoUI::class)->package($preset)->module()['title'] ?? $preset)])
    <livewire:evo-ui.package :preset="$preset" :active-tab="$activeTab ?? ''" :context="$context ?? []" />
@endcomponent
