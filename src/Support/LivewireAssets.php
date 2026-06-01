<?php

namespace EvoUI\Support;

use Livewire\Mechanisms\FrontendAssets\FrontendAssets;
use Livewire\Mechanisms\HandleRequests\EndpointResolver;

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
        $scriptUrl = rtrim(self::sitePath('livewire/livewire.js'), '/') . '?id=' . rawurlencode($version);

        return sprintf(
            '<script src="%s" %s data-csrf="%s" data-module-url="%s" data-update-uri="%s" %s></script>',
            e($scriptUrl),
            $progressBar,
            e($token),
            e(self::sitePath(ltrim(EndpointResolver::prefix(), '/'))),
            e(self::sitePath('livewire/update')),
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

    protected static function sitePath(string $path = ''): string
    {
        $base = parse_url(EVO_SITE_URL, PHP_URL_PATH) ?: '/';

        return '/' . trim(trim($base, '/') . '/' . trim($path, '/'), '/');
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
