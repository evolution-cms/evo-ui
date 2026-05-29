@props([
    'image' => [],
])

@php
    $image = is_array($image) ? $image : ['src' => $image];
    $src = $image['src'] ?? '';
    $alt = $image['alt'] ?? '';
@endphp

<figure class="evo-ui-table-image" @if($src) data-evo-image-preview="{{ $src }}" @endif>
    @if($src)
        <img src="{{ $src }}" alt="{{ $alt }}" width="48" height="32" loading="lazy" decoding="async">
    @else
        <x-evo::icon name="photo" />
    @endif
</figure>
