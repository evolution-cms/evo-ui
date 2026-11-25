<x-evo::module-tab-shell :tabs="$tabs" model="activeTab" :label="isset($module['label']) ? __($module['label']) : null" :url-parameter="$module['url_parameter'] ?? 'tab'">
    @foreach($blocks as $index => $block)
        @include('evo::packages.block', ['blockKey' => $packageName . '.' . $activeTab . '.' . $index])
    @endforeach
</x-evo::module-tab-shell>
