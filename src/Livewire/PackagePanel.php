<?php

namespace EvoUI\Livewire;

use EvoUI\Components\Component;
use EvoUI\EvoUI;
use EvoUI\Support\ManagerContext;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Assemble configured package tabs while mounting only the active tab's widgets.
 *
 * Configuration stays server-side. Locked preset/context prevent a browser from
 * selecting another package or changing the entry point's trusted context.
 * @since 1.4.0
 */
final class PackagePanel extends Component
{
    #[Locked]
    public string $preset = '';
    #[Locked]
    public array $context = [];
    public string $activeTab = '';
    protected EvoUI $ui;
    protected ManagerContext $manager;

    /**
     * Obtain shared runtime services without resolving package business hooks.
     * @param EvoUI $ui Registered package definitions.
     * @param ManagerContext $manager Native manager permissions.
     * @return void
     * @since 1.4.0
     */
    public function boot(EvoUI $ui, ManagerContext $manager): void
    {
        $this->ui = $ui;
        $this->manager = $manager;
    }

    /**
     * Accept trusted entry-point context and check access before rendering widgets.
     * @param string $preset Registered package name, not a configuration path.
     * @param string $activeTab Optional initial tab selected by the entry point.
     * @param array<string, mixed> $context Public nonsecret entry-point context.
     * @return void
     * @since 1.4.0
     */
    public function mount(string $preset, string $activeTab = '', array $context = []): void
    {
        $this->preset = $preset;
        $this->context = $context;
        $this->activeTab = $activeTab;
        $this->ensureAccess();
    }

    /**
     * Recheck the native manager session and package policy after hydration.
     * @return void
     * @since 1.4.0
     */
    public function hydrate(): void { $this->ensureAccess(); }

    /**
     * Render the active configured blocks; inactive data hooks never run.
     * @return View Native shell and selected widgets, without serializing metadata.
     * @since 1.4.0
     */
    public function render(): View
    {
        $module = $this->ensureAccess();
        $tabs = array_values(array_filter($module['tabs'] ?? [], fn (array $tab): bool =>
            empty($tab['hidden']) && (empty($tab['permission']) || $this->manager->can($tab['permission']))));
        $keys = array_column($tabs, 'key');
        if ($keys === []) { throw new HttpException(403, 'Access denied.'); }
        $default = in_array($module['default_tab'] ?? '', $keys, true) ? $module['default_tab'] : $keys[0];
        if (!in_array($this->activeTab, $keys, true)) { $this->activeTab = $default; }
        $tab = $tabs[array_search($this->activeTab, $keys, true)];
        $data = isset($tab['data_provider']) ? $this->callHook($tab['data_provider']) : [];
        if (!is_array($data)) { throw new InvalidArgumentException('EvoUI tab data must be an array.'); }
        return view('evo::livewire.package', ['module' => $module, 'tabs' => $tabs,
            'blocks' => $this->resolveBindings($tab['blocks'] ?? [], $data), 'blockData' => $data, 'packageName' => $this->preset]);
    }

    /**
     * Enforce native manager authentication and an optional package-owned policy.
     * @return array<string, mixed> Trusted module configuration after access checks.
     * @since 1.4.0
     */
    protected function ensureAccess(): array
    {
        $session = app('session.store');
        $validated = $session->get('mgrValidated', $_SESSION['mgrValidated'] ?? false);
        $id = $session->get('mgrInternalKey', $_SESSION['mgrInternalKey'] ?? 0);
        if (!$validated || !is_numeric($id) || (int) $id < 1) { throw new HttpException(403, 'Access denied.'); }
        $module = $this->ui->package($this->preset)->module();
        if (!empty($module['permission']) && !$this->manager->can($module['permission'])) {
            throw new HttpException(403, 'Access denied.');
        }
        if (isset($module['authorize'])) { $this->callHook($module['authorize']); }
        return $module;
    }

    /**
     * Resolve only the selected configured hook through native constructor injection.
     * @param array{class-string, string} $hook Trusted instance service and method.
     * @return mixed Policy result or active tab's view data.
     * @since 1.4.0
     */
    protected function callHook(array $hook): mixed
    {
        return app()->call([app($hook[0]), $hook[1]], ['context' => $this->context]);
    }

    /**
     * Replace explicit data bindings in active blocks without evaluating expressions.
     * @param array $values Configured block tree; ['bind' => 'path'] reads tab data.
     * @param array $data Public data returned by the active tab's provider.
     * @return array Resolved active blocks, kept out of the reactive snapshot.
     * @since 1.4.0
     */
    protected function resolveBindings(array $values, array $data): array
    {
        foreach ($values as $key => $value) {
            if (is_array($value)) {
                $values[$key] = array_keys($value) === ['bind']
                    ? data_get($data, (string) $value['bind']) : $this->resolveBindings($value, $data);
            }
        }
        return $values;
    }
}
