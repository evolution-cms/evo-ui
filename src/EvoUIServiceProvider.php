<?php

namespace EvoUI;

use EvolutionCMS\ServiceProvider;
use EvoUI\Support\ManagerContext;
use EvoUI\Support\Permissions;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Contracts\Http\Kernel as HttpKernelContract;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\RouteCollectionInterface;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Livewire\Mechanisms\FrontendAssets\FrontendAssets;
use Livewire\Livewire;
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
     * Bootstrap the package.
     */
    public function boot(): void
    {
        $this->loadViewsFrom($this->root . '/views', 'evo');
        $this->loadTranslationsFrom($this->root . '/lang', 'evo');
        $this->mergeConfigFrom($this->root . '/config/evo-ui.php', 'evo-ui');
        $this->registerBladeComponentNamespace();
        $this->registerLivewireDefaults();
        $this->registerLivewireComponents();

        $this->publishes([
            $this->root . '/config/evo-ui.php' => config_path('evo-ui.php', true),
            $this->root . '/resources/css/evo-ui.css' => public_path('assets/modules/evo-ui/evo-ui.css'),
            $this->root . '/resources/js/evo-ui.js' => public_path('assets/modules/evo-ui/evo-ui.js'),
        ], 'evo-ui');
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

    protected function registerBladeComponentNamespace(): void
    {
        Blade::anonymousComponentNamespace('evo::components', 'evo');
    }

    protected function registerLivewireDefaults(): void
    {
        config()->set('livewire.component_layout', config('evo-ui.livewire.layout', 'evo::layouts.manager'));
        $this->registerLivewireManagerRoutes();
    }

    protected function registerLivewireManagerRoutes(): void
    {
        $this->registerLivewireMiddlewareGroup();
        $livewire = app('livewire');

        $livewire->setPersistentMiddleware(config('app.middleware.mgr', []));
        $livewire->setUpdateRoute(fn ($handle) => Route::post('livewire/update', $handle)
            ->middleware('mgr')
            ->name('manager.livewire.update'));
        $livewire->setScriptRoute(fn ($handle) => Route::get('livewire/livewire.js', $handle)
            ->middleware('mgr'));

        Route::get('livewire/livewire.min.js.map', [FrontendAssets::class, 'maps'])
            ->middleware('mgr');

        Route::get('livewire/livewire.csp.min.js.map', [FrontendAssets::class, 'cspMaps'])
            ->middleware('mgr');
    }

    protected function registerLivewireMiddlewareGroup(): void
    {
        $router = app('router');

        if (!$router->hasMiddlewareGroup('web')) {
            $router->middlewareGroup('web', []);
        }
    }

    protected function registerLivewireComponents(): void
    {
        Livewire::component('evo-ui.table', \EvoUI\Livewire\Table::class);
        Livewire::component('evo-ui.form', \EvoUI\Livewire\Form::class);
        Livewire::component('evo-ui.module-table', \EvoUI\Livewire\ModuleTable::class);
        Livewire::component('evo-ui.issue-workspace', \EvoUI\Livewire\IssueWorkspace::class);
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
