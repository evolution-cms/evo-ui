<?php

// Offline executable package contract: no site bootstrap, database, or HTTP calls.
$autoload = getenv('EVO_UI_TEST_AUTOLOAD') ?: dirname(__DIR__) . '/vendor/autoload.php';
if (!is_file($autoload)) {
    throw new RuntimeException('Install dependencies or set EVO_UI_TEST_AUTOLOAD to a host vendor/autoload.php.');
}
$loader = require $autoload;
// A host may have another EvoUI release in its class map. Always test this checkout.
$loader->setClassMapAuthoritative(false);
$loader->addPsr4('EvoUI\\', dirname(__DIR__) . '/src/', true);
foreach ($loader->getClassMap() as $class => $file) {
    if (str_starts_with($class, 'EvoUI\\')) {
        $local = dirname(__DIR__) . '/src/' . str_replace('\\', '/', substr($class, 6)) . '.php';
        if (is_file($local)) { $loader->addClassMap([$class => $local]); }
    }
}
if (realpath((new ReflectionClass(\EvoUI\EvoUI::class))->getFileName()) !== realpath(dirname(__DIR__) . '/src/EvoUI.php')) {
    throw new RuntimeException('Package tests must load EvoUI from this checkout.');
}

use EvoUI\EvoUI;
use EvoUI\Livewire\PackagePanel;
use EvoUI\Support\ManagerContext;
use Illuminate\Container\Container;
use Illuminate\Contracts\View\View;
use Illuminate\Session\ArraySessionHandler;
use Illuminate\Session\Store;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Resolve offline services without bootstrapping an Evolution site.
 * @since 1.4.0
 */
function app($key = null) { return $key === null ? Container::getInstance() : Container::getInstance()->make($key); }
/**
 * Capture native view data for lifecycle assertions; real rendering has consumer coverage.
 * @since 1.4.0
 */
function view($name, array $data = []) { return new PackageTestView($name, $data); }

/**
 * Minimal implementation of the native view boundary, without template substitution.
 * @since 1.4.0
 */
final class PackageTestView implements View
{
    /**
 * Keep only the data explicitly returned by PackagePanel.
 * @since 1.4.0
 */
    public function __construct(private string $viewName, private array $data) {}
    /**
 * Return the native view name.
 * @since 1.4.0
 */
    public function name() { return $this->viewName; }
    /**
 * Mirror native view data binding.
 * @since 1.4.0
 */
    public function with($key, $value = null) { $this->data = array_replace($this->data, is_array($key) ? $key : [$key => $value]); return $this; }
    /**
 * Expose captured data for assertions.
 * @since 1.4.0
 */
    public function getData() { return $this->data; }
    /**
 * No static HTML is used by these lifecycle tests.
 * @since 1.4.0
 */
    public function render() { return ''; }
}

/**
 * Count authorization calls independently of expensive data providers.
 * @since 1.4.0
 */
final class PackageTestPolicy
{
    public int $calls = 0;
    public bool $allowed = true;
    /**
 * Deny without returning private state or constructing data providers.
 * @since 1.4.0
 */
    public function authorize(): void { ++$this->calls; if (!$this->allowed) { throw new HttpException(403); } }
}

/**
 * Fail loudly if declaration or an inactive tab tries to resolve its provider.
 * @since 1.4.0
 */
final class PackageInactiveProvider
{
    /**
 * This constructor must never run in passive-registration or inactive-tab tests.
 * @since 1.4.0
 */
    public function __construct() { throw new RuntimeException('Inactive provider was resolved.'); }
    /**
 * Native injectable hook shape for trusted config.
 * @since 1.4.0
 */
    public function data(): array { return []; }
}

/**
 * A synthetic provider for checking instance injection and public context.
 * @since 1.4.0
 */
final class PackageActiveProvider
{
    public int $calls = 0;
    /**
 * Return harmless view data only for the active tab.
 * @since 1.4.0
 */
    public function data(array $context): array { ++$this->calls; return ['reference' => $context['reference'] ?? null]; }
}

/**
 * Supply a native manager permission context independent of a real session.
 * @since 1.4.0
 */
final class PackageManagerContext extends ManagerContext
{
    public bool $allowed = true;
    /**
 * Resolve every synthetic ability through the test's current policy.
 * @since 1.4.0
 */
    public function can(string $ability): bool { return $this->allowed; }
}

/**
 * Assert a behavior result without silently accepting a falsey value.
 * @since 1.4.0
 */
function packageAssert(bool $value, string $message): void { if (!$value) { throw new RuntimeException($message); } }
/**
 * Require the expected controlled failure.
 * @since 1.4.0
 */
function packageRaises(string $class, callable $action): void
{
    try { $action(); } catch (Throwable $error) { if ($error instanceof $class) { return; } throw $error; }
    throw new RuntimeException('Expected ' . $class);
}

$app = new Container(); Container::setInstance($app);
$session = new Store('package-fixture', new ArraySessionHandler(120));
$session->put(['mgrValidated' => true, 'mgrInternalKey' => 7]);
$app->instance('session.store', $session);
$policy = new PackageTestPolicy(); $app->instance(PackageTestPolicy::class, $policy);
$active = new PackageActiveProvider(); $app->instance(PackageActiveProvider::class, $active);
$ui = new EvoUI(); $manager = new PackageManagerContext();
$definition = ['components' => ['example.custom' => PackageInactiveProvider::class],
    'form_fields' => ['example-field' => 'example::field'],
    'table_cells' => ['example-cell' => 'example::cell'],
    'filters' => ['example-filter' => PackageInactiveProvider::class],
    'actions' => ['example-action' => PackageInactiveProvider::class],
    'module' => ['default_tab' => 'settings', 'authorize' => [PackageTestPolicy::class, 'authorize'], 'tabs' => [
        ['key' => 'settings', 'blocks' => [['type' => 'form', 'preset' => 'example.settings']]],
        ['key' => 'items', 'data_provider' => [PackageActiveProvider::class, 'data'], 'blocks' => [
            ['type' => 'dashboard', 'cards' => [['stats' => [['value' => ['bind' => 'reference']]]]]],
        ]],
        ['key' => 'inactive', 'data_provider' => [PackageInactiveProvider::class, 'data']],
        ['key' => 'hidden', 'hidden' => true, 'data_provider' => [PackageInactiveProvider::class, 'data']],
        ['key' => 'restricted', 'permission' => 'private', 'data_provider' => [PackageInactiveProvider::class, 'data']],
    ]]];

$ui->registerPackage('example', $definition);
packageAssert($policy->calls === 0 && $active->calls === 0, 'Registration executed a hook.');
packageAssert($ui->components()['example.custom'] === PackageInactiveProvider::class
    && $ui->formFields()['example-field'] === 'example::field'
    && $ui->tableCells()['example-cell'] === 'example::cell'
    && isset($ui->filters()['example-filter'], $ui->actions()['example-action']), 'Extension maps were lost.');
echo "PASS passive package declaration and extension maps\n";

$bad = $definition; $bad['module']['tabs'][] = ['key' => 'items'];
packageRaises(InvalidArgumentException::class, fn () => $ui->registerPackage('invalid', $bad));
packageRaises(InvalidArgumentException::class, fn () => $ui->package('invalid'));
$bad = $definition; $bad['module']['tabs'][0]['blocks'] = [['type' => 'arbitrary']];
packageRaises(InvalidArgumentException::class, fn () => $ui->registerPackage('invalid', $bad));
echo "PASS malformed declarations fail before registration\n";

$panel = new PackagePanel(); $panel->boot($ui, $manager);
$panel->mount('example', 'settings', ['reference' => 19]);
$render = $panel->render()->getData();
packageAssert($active->calls === 0 && count($render['blocks']) === 1, 'Inactive provider ran.');
$panel->activeTab = 'items';
$render = $panel->render()->getData();
packageAssert($render['blockData'] === ['reference' => 19] && $active->calls === 1, 'Instance hook or trusted context failed.');
packageAssert($render['blocks'][0]['cards'][0]['stats'][0]['value'] === 19, 'Explicit value binding failed.');
$panel->activeTab = 'unknown'; $panel->render();
packageAssert($panel->activeTab === 'settings', 'Unknown tab did not fall back.');
$panel->activeTab = 'hidden'; $panel->render();
packageAssert($panel->activeTab === 'settings', 'Hidden tab was executed.');
$manager->allowed = false; $panel->activeTab = 'restricted'; $panel->render();
packageAssert($panel->activeTab === 'settings', 'Restricted tab was executed.');
echo "PASS active-only data resolution and guarded tab selection\n";

$policy->allowed = false;
packageRaises(HttpException::class, fn () => $panel->hydrate());
packageRaises(HttpException::class, fn () => $panel->render());
$policy->allowed = true; $session->forget('mgrValidated');
packageRaises(HttpException::class, fn () => $panel->hydrate());
packageAssert($active->calls === 1, 'A forbidden request resolved data.');
echo "PASS session and package policy checked on updates\n";

foreach (['preset', 'context'] as $property) {
    $attributes = (new ReflectionProperty($panel, $property))->getAttributes(Livewire\Attributes\Locked::class);
    packageAssert(count($attributes) === 1, 'Package identity/context must be locked.');
}
packageAssert(!isset(get_object_vars($panel)['module'], get_object_vars($panel)['blockData']), 'Server metadata leaked into reactive properties.');
echo "PASS package identity is locked and metadata stays server-side\n";

$finder = new Livewire\Finder\Finder();
$app->instance('livewire.finder', $finder);
Illuminate\Support\Facades\Facade::setFacadeApplication($app);
$ui->bootComponents();
$ui->registerPackage('late', ['components' => ['late.custom' => PackageInactiveProvider::class]]);
packageAssert($finder->resolveClassComponentClassName('example.custom') === PackageInactiveProvider::class
    && $finder->resolveClassComponentClassName('late.custom') === PackageInactiveProvider::class,
    'Registry must support both provider boot orders.');
echo "PASS package extensions register before and after runtime boot\n";
