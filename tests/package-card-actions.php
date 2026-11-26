<?php

// Compile the real package card and button components without bootstrapping a CMS.
$autoload = getenv('EVO_UI_TEST_AUTOLOAD') ?: dirname(__DIR__) . '/vendor/autoload.php';
require $autoload;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Js;
use Illuminate\View\Compilers\BladeCompiler;

/** Resolve only the isolated Blade services needed by this rendering regression.
 * @since 1.4.0
 */
function app($key = null) { return $key === null ? Container::getInstance() : Container::getInstance()->make($key); }
/** Translate fixture labels without loading a CMS or language database.
 * @since 1.4.0
 */
function __($key) { return $key; }

$app = new Container();
Container::setInstance($app);
Facade::setFacadeApplication($app);
$files = new Filesystem();
$cache = sys_get_temp_dir() . '/evo-ui-card-actions-' . bin2hex(random_bytes(8));
$files->makeDirectory($cache, 0700, true);
$app->instance('config', new Illuminate\Config\Repository(['view' => ['compiled' => $cache]]));
$app->instance(Illuminate\Contracts\Foundation\Application::class, new class {
    /** Keep Blade component discovery inside the fixture namespace.
     * @since 1.4.0
     */
    public function getNamespace() { return 'Fixture\\'; }
});
$compiler = new BladeCompiler($files, $cache);
$compiler->anonymousComponentNamespace('evo::components', 'evo');
$app->instance('blade.compiler', $compiler);
$app->instance(BladeCompiler::class, $compiler);
$engines = new Illuminate\View\Engines\EngineResolver();
$engines->register('blade', fn () => new Illuminate\View\Engines\CompilerEngine($compiler, $files));
$engines->register('php', fn () => new Illuminate\View\Engines\PhpEngine($files));
$views = new Illuminate\View\Factory($engines, new Illuminate\View\FileViewFinder($files, []), new Illuminate\Events\Dispatcher($app));
$views->setContainer($app);
$views->addNamespace('evo', dirname(__DIR__) . '/views');
$app->instance('view', $views);
$app->instance(Illuminate\Contracts\View\Factory::class, $views);

try {
    foreach (['journal', "activity');alert(1);//", 'quoted"tab'] as $tab) {
        $html = $views->make('evo::packages.block', ['block' => ['type' => 'card',
            'actions' => [['tab' => $tab, 'label' => 'Open <journal>']]]])->render();
        if (!preg_match('/x-on:click="([^"]+)"/', $html, $match)) {
            throw new RuntimeException('The package card lost its native tab action.');
        }
        $handler = html_entity_decode($match[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        if (str_contains($handler, '@js(') || $handler !== 'requestModuleTab(' . Js::from($tab)->toHtml() . ')') {
            throw new RuntimeException('The compiled card action must contain a safely encoded tab key, not a literal Blade directive.');
        }
        if (str_contains($html, 'Open <journal>')) {
            throw new RuntimeException('Action labels must remain escaped by the native button.');
        }
    }
    echo "PASS compiled package card tab actions, quoted keys and escaped labels\n";
} finally {
    $files->deleteDirectory($cache);
}
