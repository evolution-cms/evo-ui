<?php

namespace EvoUI;

use EvolutionCMS\ServiceProvider;
use EvoUI\Support\ManagerContext;
use EvoUI\Support\LivewireManagerEndpoint;
use EvoUI\Support\Permissions;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Http\Kernel as HttpKernelContract;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\RouteCollectionInterface;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Livewire\LivewireServiceProvider;

class EvoUIServiceProvider extends ServiceProvider
{
    protected string $root;

    public function __construct($app)
    {
        parent::__construct($app);

        $this->root = dirname(__DIR__);
    }

    /**
     * Bootstrap the shared manager UI runtime.
     *
     * EvoUI registers its Blade, translation, Livewire and publishable asset
     * surfaces from one provider so consuming modules can depend on the package
     * without duplicating runtime setup.
     *
     * CSS and JavaScript are declared as `symlink:` publish sources. Evolution's
     * vendor:publish command creates public links when the filesystem supports
     * them and falls back to copying on restricted hosting. This keeps installed
     * manager modules on the current EvoUI runtime instead of serving stale
     * files copied from an earlier package version.
     */
    public function boot(): void
    {
        $this->loadViewsFrom($this->root . '/views', 'evo');
        $this->loadTranslationsFrom($this->root . '/lang', 'evo');
        $this->mergeConfigFrom($this->root . '/config/evo-ui.php', 'evo-ui');
        $this->registerBladeComponentNamespace();
        $this->registerLivewireDefaults();
        $this->registerEvoUIComponents();
        $this->app->make(EvoUI::class)->bootComponents();
        $this->registerManagerEndpointRoute();

        $this->publishes([
            $this->root . '/config/evo-ui.php' => config_path('evo-ui.php', true),
            'symlink:' . $this->root . '/resources/css/evo-ui.css' => public_path('assets/modules/evo-ui/evo-ui.css'),
            'symlink:' . $this->root . '/resources/js/evo-ui.js' => public_path('assets/modules/evo-ui/evo-ui.js'),
        ], 'evo-ui');

        $this->ensureRuntimeAssetsArePublished();
    }

    /**
     * Register package services.
     */
    public function register(): void
    {
        $this->registerLivewireProvider();
        $this->registerLivewireBridge();

        $this->app->singleton(EvoUI::class);
        $this->app->alias(EvoUI::class, 'EvoUI');
        $this->app->singleton(ManagerContext::class);
        $this->app->singleton(Permissions::class);
        $this->app->singleton(\EvoUI\Support\ConfigFormService::class);
        $this->app->singleton(\EvoUI\Support\PhpConfigFile::class);
        $this->app->singleton(\EvoUI\Support\FieldCatalog::class);
        $this->app->singleton(\EvoUI\Support\LanguageBridge::class);
        $this->app->singleton(\EvoUI\Support\ResourceFormService::class);
        $this->app->singleton(\EvoUI\Support\ResourceLayoutResolver::class);
        $this->app->singleton(\EvoUI\Support\TvValueRepository::class);

    }

    /**
     * Ensure Livewire services exist before EvoUI wires manager routes and components.
     *
     * Evolution package discovery only reads first-level package providers, while EvoUI depends
     * on Livewire as an internal runtime. Registering Livewire here keeps `php artisan` safe even
     * when no generated `LivewireServiceProvider.php` file exists in `core/custom/config/app`.
     *
     * @since 1.0.1
     */
    protected function registerLivewireProvider(): void
    {
        $this->app->register(LivewireServiceProvider::class);
    }

    protected function ensureRuntimeAssetsArePublished(): void
    {
        $this->ensureRuntimeAsset(
            $this->root . '/resources/css/evo-ui.css',
            public_path('assets/modules/evo-ui/evo-ui.css')
        );

        $this->ensureRuntimeAsset(
            $this->root . '/resources/js/evo-ui.js',
            public_path('assets/modules/evo-ui/evo-ui.js')
        );

    }

    protected function ensureRuntimeAsset(string $source, string $target): void
    {
        if (!is_file($source)) {
            return;
        }

        $targetDir = dirname($target);
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0775, true);
        }

        if (!is_dir($targetDir)) {
            return;
        }

        if (is_link($target)) {
            if (readlink($target) === $source) {
                return;
            }

            @unlink($target);
        }

        if (is_file($target) && filemtime($target) >= filemtime($source) && filesize($target) === filesize($source)) {
            return;
        }

        if (!file_exists($target) && @symlink($source, $target)) {
            return;
        }

        @copy($source, $target);
    }

    protected function registerBladeComponentNamespace(): void
    {
        Blade::anonymousComponentNamespace('evo::components', 'evo');
    }

    protected function registerLivewireDefaults(): void
    {
        config()->set('livewire.component_layout', config('evo-ui.livewire.layout', 'evo::layouts.manager'));
        app('livewire')->setPersistentMiddleware(config('app.middleware.mgr', []));
    }

    /**
     * Declare the components provided by EvoUI through its public component registry.
     *
     * @return void
     * @since 1.1.0
     */
    protected function registerEvoUIComponents(): void
    {
        $evoUI = $this->app->make(EvoUI::class);

        $evoUI->registerComponent('evo-ui.table', \EvoUI\Livewire\Table::class);
        $evoUI->registerComponent('evo-ui.form', \EvoUI\Livewire\Form::class);
        $evoUI->registerComponent('evo-ui.module-table', \EvoUI\Livewire\ModuleTable::class);
        $evoUI->registerComponent('evo-ui.issue-workspace', \EvoUI\Livewire\IssueWorkspace::class);
    }

    protected function registerManagerEndpointRoute(): void
    {
        if (!defined('IN_MANAGER_MODE') || !IN_MANAGER_MODE) {
            return;
        }

        foreach ($this->managerEndpointRoutes() as $route) {
            Route::match(['GET', 'POST'], $route, function (?string $path = null) {
                return app(LivewireManagerEndpoint::class)(request(), $path);
            })->where('path', '.*');
        }
    }

    /**
     * @return list<string>
     */
    protected function managerEndpointRoutes(): array
    {
        $routes = ['evo-ui/{path?}'];
        $managerDir = defined('MGR_DIR') ? trim((string) MGR_DIR, '/') : '';

        if ($managerDir !== '') {
            $routes[] = $managerDir . '/evo-ui/{path?}';
        }

        return array_values(array_unique($routes));
    }

    protected function registerLivewireBridge(): void
    {
        $this->app->singleton('encrypter', \EvoUI\Livewire\Foundation\Encryption\Encrypter::class);
        $this->app->alias('encrypter', EncrypterContract::class);
        $this->app->singleton('Illuminate\\Foundation\\Vite', \EvoUI\Livewire\Foundation\LivewireAssetShim::class);
        $this->app->singleton(HttpKernelContract::class, \EvoUI\Livewire\Foundation\Http\Kernel::class);
        $this->app->singleton(GateContract::class, \EvoUI\Auth\EvoGate::class);
        $this->app->alias(GateContract::class, 'gate');
        $this->app->bind(RouteCollectionInterface::class, fn ($app) => $app['router']->getRoutes());
        $this->app->bind(UrlGenerator::class, fn ($app) => $app['url']);
        $this->app->bind(Redirector::class, fn ($app) => $app['redirect']);
        $this->app->bind(\Livewire\Features\SupportRedirects\Redirector::class, fn ($app) => new \Livewire\Features\SupportRedirects\Redirector($app['url']));

        $this->aliasIfMissing(
            'Illuminate\\Foundation\\Http\\Middleware\\TrimStrings',
            \EvoUI\Livewire\Foundation\Http\Middleware\TrimStrings::class
        );

        $this->aliasIfMissing(
            'Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull',
            \EvoUI\Livewire\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class
        );

        $this->aliasIfMissing(
            'Illuminate\\Foundation\\Http\\Events\\RequestHandled',
            \EvoUI\Livewire\Foundation\Http\Events\RequestHandled::class
        );

        $this->aliasIfMissing(
            'Illuminate\\Foundation\\Auth\\Access\\AuthorizesRequests',
            \EvoUI\Livewire\Foundation\Auth\Access\AuthorizesRequests::class
        );
    }

    protected function aliasIfMissing(string $alias, string $target): void
    {
        if ($this->typeExists($alias)) {
            return;
        }

        if ($this->typeExists($target)) {
            class_alias($target, $alias);
        }
    }

    protected function typeExists(string $type): bool
    {
        return class_exists($type) || interface_exists($type) || trait_exists($type);
    }

}
