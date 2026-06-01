<?php

namespace EvoUI\Support;

use Illuminate\Http\Request;
use Livewire\Drawer\Utils;
use Livewire\Mechanisms\FrontendAssets\FrontendAssets;
use Livewire\Mechanisms\HandleRequests\HandleRequests;
use Symfony\Component\HttpFoundation\Response;

class LivewireManagerEndpoint
{
    public function __invoke(Request $request, ?string $path = null): Response
    {
        $action = (string) $request->query('action', '');
        $runtimePath = trim((string) $path, '/');

        switch ($action) {
            case 'script':
                $response = app(FrontendAssets::class)->returnJavaScriptAsFile();
                break;

            case 'update':
                $response = app(HandleRequests::class)->handleUpdate();
                break;

            default:
                $response = $runtimePath !== ''
                    ? $this->moduleResponse($runtimePath)
                    : app(FrontendAssets::class)->returnJavaScriptAsFile();
        }

        return is_array($response) ? response()->json($response) : $response;
    }

    protected function componentName(string $encoded): string
    {
        $component = str_replace('----', ':', $encoded);
        $component = str_replace('---', '::', $component);

        return str_replace('--', '.', $component);
    }

    protected function moduleResponse(string $path): Response
    {
        if (preg_match('#^js/(.+)\.js$#', $path, $matches)) {
            $component = $this->componentName($matches[1]);
            $instance = app('livewire')->new($component);

            if (!method_exists($instance, 'scriptModuleSrc')) {
                abort(404);
            }

            $file = $instance->scriptModuleSrc();

            if (!is_file($file)) {
                abort(404);
            }

            return Utils::pretendResponseIsFileFromString(
                (string) file_get_contents($file),
                (int) filemtime($file),
                $component . '.js'
            );
        }

        if (preg_match('#^css/(.+)\.global\.css$#', $path, $matches)) {
            $component = $this->componentName($matches[1]);
            $instance = app('livewire')->new($component);

            if (!method_exists($instance, 'globalStyleModuleSrc')) {
                abort(404);
            }

            $file = $instance->globalStyleModuleSrc();

            if (!is_file($file)) {
                abort(404);
            }

            return Utils::pretendResponseIsFileFromString(
                (string) file_get_contents($file),
                (int) filemtime($file),
                $component . '.global.css',
                'text/css; charset=utf-8'
            );
        }

        if (preg_match('#^css/(.+)\.css$#', $path, $matches)) {
            $component = $this->componentName($matches[1]);
            $instance = app('livewire')->new($component);

            if (!method_exists($instance, 'styleModuleSrc')) {
                abort(404);
            }

            $file = $instance->styleModuleSrc();

            if (!is_file($file)) {
                abort(404);
            }

            return Utils::pretendResponseIsFileFromString(
                "[wire\\:name=\"{$component}\"] {\n" . (string) file_get_contents($file) . "\n}",
                (int) filemtime($file),
                $component . '.css',
                'text/css; charset=utf-8'
            );
        }

        abort(404);
    }
}
