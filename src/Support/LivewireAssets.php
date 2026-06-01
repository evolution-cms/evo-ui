<?php

namespace EvoUI\Support;

use Livewire\Mechanisms\FrontendAssets\FrontendAssets;

class LivewireAssets
{
    /**
     * @param array<string, mixed> $options
     */
    public static function scripts(array $options = []): string
    {
        if (!class_exists(FrontendAssets::class)) {
            return '';
        }

        $assets = app(FrontendAssets::class);

        if ($assets->hasRenderedScripts) {
            return '';
        }

        $assets->hasRenderedScripts = true;

        $token = app()->has('session.store') ? csrf_token() : '';
        $progressBar = config('livewire.navigate.show_progress_bar', true) ? '' : 'data-no-progress-bar';
        $attributes = self::attributes($assets->scriptTagAttributes ?? []);
        $version = self::manifestVersion();
        $scriptUrl = self::managerEndpointUrl('script', ['id' => $version]);

        return sprintf(
            '<script src="%s" %s data-csrf="%s" data-module-url="%s" data-update-uri="%s" %s></script>',
            e($scriptUrl),
            $progressBar,
            e($token),
            e(self::managerEndpointBaseUrl()),
            e(self::managerEndpointUrl('update')),
            $attributes
        );
    }

    protected static function manifestVersion(): string
    {
        $frontendAssetsPath = (new \ReflectionClass(FrontendAssets::class))->getFileName();
        $manifestPath = is_string($frontendAssetsPath)
            ? dirname($frontendAssetsPath, 4) . '/dist/manifest.json'
            : '';

        if (!is_file($manifestPath)) {
            return 'dev';
        }

        $manifest = json_decode((string) file_get_contents($manifestPath), true);

        return is_array($manifest) ? ($manifest['/livewire.js'] ?? 'dev') : 'dev';
    }

    /**
     * @param array<string, string> $query
     */
    protected static function managerEndpointUrl(string $action, array $query = []): string
    {
        $query = array_merge(['action' => $action], $query);

        return self::managerEndpointBaseUrl() . '?' . http_build_query($query);
    }

    protected static function managerEndpointBaseUrl(): string
    {
        return rtrim(EVO_MANAGER_URL, '/') . '/evo-ui';
    }

    /**
     * @param array<string, mixed> $attributes
     */
    protected static function attributes(array $attributes): string
    {
        $html = [];

        foreach ($attributes as $key => $value) {
            if ($value === false || $value === null) {
                continue;
            }

            $html[] = $value === true ? e((string) $key) : e((string) $key) . '="' . e((string) $value) . '"';
        }

        return implode(' ', $html);
    }
}
