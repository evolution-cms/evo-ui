@php
    $showSectionHeader = ($section['show_header'] ?? ($config['section_headers'] ?? true)) !== false;
    $sectionSpan = (int) ($section['span'] ?? 12);
    $sectionSpan = in_array($sectionSpan, [3, 4, 6, 8, 12], true) ? $sectionSpan : 12;
@endphp

<x-evo::card
    class="evo-ui-form-section evo-ui-form-section--span-{{ $sectionSpan }}"
    :label="$showSectionHeader ? ($section['label'] ?? null) : null"
    :icon="$showSectionHeader ? ($section['icon'] ?? null) : null"
    wire:key="form-section-{{ $section['key'] ?? \Illuminate\Support\Str::slug(__($section['label'] ?? 'section')) }}"
>
    <div class="evo-ui-form-grid">
        @foreach($section['fields'] ?? [] as $field)
            <x-evo::form.field :controller="$controller" :field="$field" wire:key="form-field-{{ $field['name'] }}" />
        @endforeach
    </div>
</x-evo::card>
