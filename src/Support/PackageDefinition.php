<?php

namespace EvoUI\Support;

use InvalidArgumentException;

/**
 * Validate declarative package metadata without loading data or widget classes.
 *
 * Definitions come from trusted PHP configuration, never a reactive snapshot.
 * @since 1.4.0
 */
final readonly class PackageDefinition
{
    /**
     * Validate the complete declaration before any extensions are registered.
     * @param array<string, mixed> $definition Extension maps and module metadata.
     * @since 1.4.0
     */
    public function __construct(private array $definition)
    {
        foreach (['components', 'form_fields', 'table_cells', 'filters', 'actions'] as $key) {
            $map = $definition[$key] ?? [];
            if (!is_array($map)) { throw new InvalidArgumentException('Invalid EvoUI extension map.'); }
            foreach ($map as $alias => $value) {
                if (!is_string($alias) || $alias === '' || !is_string($value) || $value === '') {
                    throw new InvalidArgumentException('Invalid EvoUI extension declaration.');
                }
            }
        }
        $module = $definition['module'] ?? [];
        if (!is_array($module)) { throw new InvalidArgumentException('Invalid EvoUI module.'); }
        $tabs = $module['tabs'] ?? [];
        if (!is_array($tabs)) { throw new InvalidArgumentException('Invalid EvoUI tabs.'); }
        $seen = [];
        foreach ($tabs as $tab) {
            $key = is_array($tab) ? ($tab['key'] ?? null) : null;
            if (!is_string($key) || !preg_match('/^[A-Za-z][A-Za-z0-9_-]*$/D', $key) || isset($seen[$key])) {
                throw new InvalidArgumentException('Invalid or duplicate EvoUI tab.');
            }
            $seen[$key] = true;
            if (!is_array($tab['blocks'] ?? [])) { throw new InvalidArgumentException('Invalid EvoUI blocks.'); }
            $this->validateHook($tab['data_provider'] ?? null);
            foreach ($tab['blocks'] ?? [] as $block) {
                if (!is_array($block) || !in_array($block['type'] ?? null, ['form', 'table', 'dashboard', 'card', 'view'], true)) {
                    throw new InvalidArgumentException('Unknown EvoUI package block.');
                }
                if (in_array($block['type'], ['form', 'table'], true)
                    && (!is_string($block['preset'] ?? null) || $block['preset'] === '')) {
                    throw new InvalidArgumentException('EvoUI form/table blocks require a preset.');
                }
                if ($block['type'] === 'view' && (!is_string($block['view'] ?? null) || $block['view'] === '')) {
                    throw new InvalidArgumentException('EvoUI view blocks require a view.');
                }
            }
        }
        $this->validateHook($module['authorize'] ?? null);
    }

    /**
     * Keep hooks serializable and server-owned; do not resolve their services.
     * @param mixed $hook Optional class and public instance-method pair.
     * @return void
     * @since 1.4.0
     */
    private function validateHook(mixed $hook): void
    {
        if ($hook !== null && (!is_array($hook) || array_keys($hook) !== [0, 1]
            || !is_string($hook[0]) || $hook[0] === '' || !is_string($hook[1]) || $hook[1] === '')) {
            throw new InvalidArgumentException('Invalid EvoUI package hook.');
        }
    }

    /**
     * Return a validated extension map without resolving its classes.
     * @param string $key Registry family requested by EvoUI.
     * @return array<string, string> Class or field-view declarations.
     * @since 1.4.0
     */
    public function extensions(string $key): array { return $this->definition[$key] ?? []; }

    /**
     * Read server-owned module metadata for guarded rendering.
     * @return array<string, mixed> Navigation, authorization and active data hooks.
     * @since 1.4.0
     */
    public function module(): array { return $this->definition['module'] ?? []; }
}
