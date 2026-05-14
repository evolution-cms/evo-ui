# Dashboard Cards

Dashboard cards are EvoUI-owned manager widgets that summarize module state
above a table, workspace or operational surface. Consumers provide data, labels,
links and actions; EvoUI owns card layout, responsive spans, spacing, badges,
typography and the standard gap before following table content.

Runtime/CSS markers that must stay documented include `x-evo::dashboard`,
`x-evo::dashboard-card`, `dashboard-card`, `span="6"` and `.evo-ui-dashboard`.

## Rendering

```blade
<x-evo::dashboard :cards="$dashboardCards">
    <x-slot:body>
        <x-evo::table.livewire preset="sseo.activity" />
    </x-slot:body>
</x-evo::dashboard>
```

Slot-driven dashboard:

```blade
<x-evo::dashboard>
    <x-evo::dashboard-card title="Sitemap" icon="list" span="6">
        <span class="evo-ui-card__label">/path/to/sitemap.xml</span>
    </x-evo::dashboard-card>

    <x-slot:body>
        <livewire:evo-ui.module-table preset="vendor.module.activity" />
    </x-slot:body>
</x-evo::dashboard>
```

## Card Config

```php
[
    'title' => 'sSeo::global.sitemap',
    'icon' => 'list',
    'span' => 6,
    'stats' => [
        ['value' => 51, 'label' => 'sSeo::global.ready'],
    ],
    'badges' => [
        ['label' => 'sSeo::global.ready', 'tone' => 'success'],
    ],
    'meta' => [
        ['label' => 'sSeo::global.last_created', 'value' => '8 May 2026', 'strong' => true],
        ['value' => '/path/to/sitemap.xml'],
    ],
]
```

## Span Rules

| Span | Meaning |
| --- | --- |
| `12` | Full row. |
| `8` | Wide card. |
| `6` | Half-width card on desktop manager viewports. |
| `4` | Three-column card where the viewport allows it. |
| `3` | Dense four-column stat card. |

All spans collapse to full width on narrow screens. Consumers must not create
local `.module-card--span-6` CSS for shared widths.

## Spacing Before Tables

When a dashboard is followed by a table, EvoUI owns the spacing. Use the
dashboard body slot or documented dashboard/table composition. Do not add a
module-local border or margin between a dashboard and a table.

Rules:

- no redundant border below dashboard cards;
- use the standard `padding-block-end` rhythm from EvoUI;
- tables keep their own frame and toolbar;
- dashboard cards must not stretch to full width when `span => 6` is declared.

## Consumer Notes

| Consumer | Pattern |
| --- | --- |
| `sSeo` | Primary donor for sitemap/status cards above activity table. |
| `sTask` | Use dashboard cards for task/worker summaries after shell cleanup. |
| `dIssues` | Use issue workspace instead of dashboard cards for board/list workflows. |

## Anti-Patterns

- Do not put an entire page section inside a card.
- Do not nest cards inside cards.
- Do not write module-local dashboard grid/flex CSS.
- Do not use dashboard cards for row-based data; use Table.
