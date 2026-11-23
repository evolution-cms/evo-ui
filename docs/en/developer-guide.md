# Developer Guide

Use evo-ui as the shared declarative UI foundation. Consumer modules provide
configuration, providers and persistence; evo-ui provides the shell, components,
state behavior, assets and visual contracts.

## Canonical Module Shell

```blade
<x-evo::layout :title="$pageTitle">
    <x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
        @if($activeTab === 'items')
            <livewire:evo-ui.module-table preset="vendor.module.items" />
        @elseif($activeTab === 'settings')
            <livewire:evo-ui.form preset="vendor.module.settings" />
        @endif
    </x-evo::module-tab-shell>
</x-evo::layout>
```

Do not load Bootstrap, jQuery, manager `main.js`, `tabpane.js`, Roboto, CDN UI
assets or legacy manager CSS inside evo-ui-owned screens.

## Layer Rules

- evo-ui owns shared UI primitives, CSS tokens, runtime helpers and dirty-state
  behavior.
- Consumer modules own routes, translations, permissions, database queries,
  validation semantics and business actions.
- If two modules need the same UI pattern, promote it to evo-ui before copying
  it locally.
- Temporary consumer CSS or JS must be scoped and backed by a visible follow-up
  task.

## Declarative Surfaces

Use `evo-ui.module-table` for table/list CRUD, `evo-ui.form` for settings and
model forms, and `evo-ui.issue-workspace` for provider-backed list/kanban
workspaces. Use `x-evo::dashboard` for cards that sit above tables.

```php
return [
    'key' => 'vendor.module.settings',
    'variant' => 'config',
    'density' => 'compact',
    'layout' => 'settings',
    'actions' => [
        ['type' => 'save', 'label' => 'evo::global.action_save'],
    ],
];
```

```blade
<x-evo::dashboard>
    <x-evo::dashboard-card title="vendor::global.status" icon="list" span="6">
        <span class="evo-ui-card__label">Updated today</span>
    </x-evo::dashboard-card>

    <x-slot:body>
        <x-evo::table.livewire preset="vendor.module.activity" />
    </x-slot:body>
</x-evo::dashboard>
```

## Tests

Run the package contract suite before changing shared behavior:

```bash
composer test
composer drift
```

Consumer-specific business behavior stays in the consumer module tests.

## Navigation accessories and field descriptions

`module-tab-shell` accepts an optional `navigationAside` slot for a status badge or other accessory. EvoUI keeps it at the trailing edge, centered vertically, while tabs retain their own horizontal scrolling. Consumers must not use absolute positioning for this slot.

```blade
<x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
    <x-slot:navigationAside>
        <x-evo::badge :label="$statusLabel" icon="activity" />
    </x-slot:navigationAside>
    <!-- Module content -->
</x-evo::module-tab-shell>
```

For administrator-authored descriptions, `EvoUI\Support\DescriptionHtml::render($description)` returns sanitized inline HTML. It keeps links with relative, HTTP(S), mailto and tel destinations and basic emphasis, code and line breaks. Scriptable elements and arbitrary attributes are removed. Render the returned string as HTML; do not render the original description unescaped.

Wide desktop typography grows gradually from a module viewport width of 2048 CSS pixels and is capped. The module iframe width, OS display scaling and browser zoom affect the effective viewport; physical 4K resolution is not a detection rule. Narrow layouts retain their existing typography.

## Wide workspace sizing

Above 2048 CSS pixels of module viewport width, Evo UI scales text, controls, icons, tabs, table rows and spacing together. Body text reaches 18 px at 2560 CSS pixels and is capped at 20 px; controls are capped at 44 px. Full HD (1920 CSS pixels) keeps the existing sizing. OS scaling, browser zoom and the module iframe determine the effective width. This does not change the legacy Manager toolbar.

`--evo-ui-desktop-unit` is a shared length token from 1 px to 1.333333 px. Consumers can use `calc(320 * var(--evo-ui-desktop-unit, 1px))` for a 320 px sidebar that grows to about 427 px. Keep breakpoint conditions in CSS pixels; do not use this token in media queries. Do not apply a second zoom/transform to a consuming module.

## Active section

Internal form tabs (`.evo-ui-form-tab.is-active`) use the theme primary accent for their text, icon and underline. Mark the current navigation section with `aria-current="page"`; after navigation, only the selected item should retain that attribute.
