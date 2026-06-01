<?php

if (!isset($_SERVER['REQUEST_TIME_FLOAT'])) {
    $_SERVER['REQUEST_TIME_FLOAT'] = microtime(true);
}

if (!defined('IN_MANAGER_MODE')) {
    define('IN_MANAGER_MODE', true);
}

if (!defined('IN_INSTALL_MODE')) {
    define('IN_INSTALL_MODE', false);
}

if (!defined('EVO_API_MODE')) {
    define('EVO_API_MODE', false);
}

if (!defined('IN_PARSER_MODE')) {
    define('IN_PARSER_MODE', false);
}

$managerPath = __DIR__;

if (file_exists($managerPath . '/config.php')) {
    $config = require $managerPath . '/config.php';
} elseif (file_exists(dirname($managerPath) . '/config.php')) {
    $config = require dirname($managerPath) . '/config.php';
} else {
    $config = [
        'core' => dirname($managerPath) . '/core',
    ];
}

if (empty($config['core']) || !file_exists($config['core'] . '/.install')) {
    http_response_code(503);
    echo 'Unable to load configuration settings';
    exit;
}

require_once $config['core'] . '/bootstrap.php';

$GLOBALS['modx'] = $modx = evo();
$GLOBALS['evo'] = $evo = evo();

if (defined('EVO_SESSION') && EVO_SESSION) {
    \EvoSessionProxy::init();
}

$request = \Illuminate\Http\Request::capture();
$evo->instance(\Illuminate\Http\Request::class, $request);
$evo->instance('request', $request);
$evo->alias(\Illuminate\Http\Request::class, 'request');

$evo->updateValidatedUserSession();

if (empty($_SESSION['mgrValidated']) || \ManagerTheme::hasManagerAccess() === false) {
    http_response_code(403);
    echo 'No Manager Access';
    exit;
}

$action = (string) ($_GET['action'] ?? '');
$runtimePath = livewire_runtime_path();

switch ($action) {
    case 'script':
        $response = app(\Livewire\Mechanisms\FrontendAssets\FrontendAssets::class)->returnJavaScriptAsFile();
        break;

    case 'update':
        $response = app(\Livewire\Mechanisms\HandleRequests\HandleRequests::class)->handleUpdate();
        break;

    default:
        $response = $runtimePath !== ''
            ? livewire_runtime_module_response($runtimePath)
            : app(\Livewire\Mechanisms\FrontendAssets\FrontendAssets::class)->returnJavaScriptAsFile();
}

if (is_array($response)) {
    $response = response()->json($response);
}

$response->send();

function livewire_runtime_path(): string
{
    $path = (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
    $marker = '/evo-ui-livewire.php/';
    $position = strpos($path, $marker);

    return $position === false ? '' : substr($path, $position + strlen($marker));
}

function livewire_runtime_component_name(string $encoded): string
{
    $component = str_replace('----', ':', $encoded);
    $component = str_replace('---', '::', $component);

    return str_replace('--', '.', $component);
}

function livewire_runtime_module_response(string $path): \Symfony\Component\HttpFoundation\Response
{
    if (preg_match('#^js/(.+)\.js$#', $path, $matches)) {
        $component = livewire_runtime_component_name($matches[1]);
        $instance = app('livewire')->new($component);

        if (!method_exists($instance, 'scriptModuleSrc')) {
            abort(404);
        }

        $file = $instance->scriptModuleSrc();

        if (!is_file($file)) {
            abort(404);
        }

        return \Livewire\Drawer\Utils::pretendResponseIsFileFromString(
            (string) file_get_contents($file),
            (int) filemtime($file),
            $component . '.js'
        );
    }

    if (preg_match('#^css/(.+)\.global\.css$#', $path, $matches)) {
        $component = livewire_runtime_component_name($matches[1]);
        $instance = app('livewire')->new($component);

        if (!method_exists($instance, 'globalStyleModuleSrc')) {
            abort(404);
        }

        $file = $instance->globalStyleModuleSrc();

        if (!is_file($file)) {
            abort(404);
        }

        return \Livewire\Drawer\Utils::pretendResponseIsFileFromString(
            (string) file_get_contents($file),
            (int) filemtime($file),
            $component . '.global.css',
            'text/css; charset=utf-8'
        );
    }

    if (preg_match('#^css/(.+)\.css$#', $path, $matches)) {
        $component = livewire_runtime_component_name($matches[1]);
        $instance = app('livewire')->new($component);

        if (!method_exists($instance, 'styleModuleSrc')) {
            abort(404);
        }

        $file = $instance->styleModuleSrc();

        if (!is_file($file)) {
            abort(404);
        }

        return \Livewire\Drawer\Utils::pretendResponseIsFileFromString(
            "[wire\\:name=\"{$component}\"] {\n" . (string) file_get_contents($file) . "\n}",
            (int) filemtime($file),
            $component . '.css',
            'text/css; charset=utf-8'
        );
    }

    abort(404);
}
