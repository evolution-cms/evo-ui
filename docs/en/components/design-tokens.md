# Design Tokens And Visual System

EvoUI owns the manager visual system for shared UI. Consumer modules may store
domain colors and labels, but they must not redefine standard button, table,
form, modal, badge, card, DnD or workspace visuals.

## Token Layers

| Layer | Owned by | Examples |
| --- | --- | --- |
| Theme bridge | EvoUI | manager theme, dark/light markers, color-scheme metadata |
| Core tokens | EvoUI | background, surface, border, text, muted text |
| Semantic tokens | EvoUI | primary, success, warning, danger, info |
| Component tokens | EvoUI | button, table, modal, badge, card, DnD spacing |
| Domain values | Consumer | taxonomy color, status name, sitemap file path |

Use CSS custom properties and EvoUI component classes. Do not define a second palette in a consumer module for shared manager UI.

Shared marker inventory that must stay documented:

- `--evo-ui-bg`
- `--evo-ui-border`
- `--evo-ui-text`
- `oklch(...)`
- `.evo-ui-badge`
- `.evo-ui-chip`
- `data-theme`

## Compact Badges And Chips

Use EvoUI badges and chips for short manager metadata: status, type, count,
field kind, taxonomy, priority and compact row labels.

Canonical classes:

- `.evo-ui-badge` for rounded status/count labels.
- `.evo-ui-badge--compact` when the badge sits inside a dense row action area.
- `.evo-ui-badge--wide` when the label can be longer but must stay one line.
- `.evo-ui-chip` for neutral metadata chips.
- `.evo-ui-chip--wide` for labels such as `Listbox (Single-Select)`.
- `.evo-ui-chip--full` or `.evo-ui-badge--full` only when the surrounding
  layout intentionally owns wrapping/overflow.
- `.evo-ui-dnd-badge` for DnD and reorder rows.

Sizing tokens:

```css
--evo-ui-chip-max-inline-size: 16rem;
--evo-ui-chip-compact-max-inline-size: 13rem;
```

Rules:

- keep chip text on one line;
- expose the full dynamic value with a native `title` attribute when truncation
  is possible;
- do not add module-local chip widths for shared manager rows;
- keep consumer data in config/provider output and pass only label/color/tone
  values to EvoUI.

```blade
<x-evo::badge
    class="evo-ui-badge--compact"
    :label="$fieldTypeLabel"
    :title="$fieldTypeLabel"
/>

<span class="evo-ui-chip evo-ui-chip--wide" title="Listbox (Single-Select)">
    Listbox (Single-Select)
</span>
```

## Allowed Consumer CSS

Consumer CSS is allowed only for:

- public site/content output;
- one-off domain visualization that is not reusable;
- temporary scoped bridge code with a visible dIssues task;
- embedded resource-tab compatibility when covered by the embedded resource
  contract.

Consumer CSS is not allowed for:

- standard buttons, action colors or Save feedback;
- table toolbar, row actions, sorting, filters or pagination;
- form labels, settings rows or modal field layout;
- dashboard card widths and table spacing;
- DnD rails, drag placeholders or option rows;
- badges/chips that can use EvoUI tones or dynamic color variables.

## Color Rules

```blade
<x-evo::button tone="primary" icon="check" label="Save" />
<x-evo::badge tone="success" label="Ready" />
```

Use dynamic color variables only for user-managed taxonomy/status colors:

```blade
<x-evo::badge :label="$status['name']" :color="$status['color']" />
```

Rules:

- do not create new red/green/blue button classes in consumers;
- do not hardcode hover/focus rings in modules;
- do not override `.evo-ui-*` selectors from a consumer stylesheet;
- if the visual is shared by two modules, move it to EvoUI.

## Typography And Density

EvoUI owns manager font rhythm:

- compact forms use `density => compact`;
- table headers use shared uppercase/weight rules;
- row actions use icon-only buttons with accessible labels;
- modal headings use component title scale, not page hero scale;
- dashboard card text uses card/stat classes, not module headings.

## Drift Checklist

Before adding CSS to a consumer, answer:

1. Is this styling for public site output?
2. Is this a shared manager component?
3. Is this a temporary compatibility bridge with a visible task?
4. Does the selector target `.evo-ui-*`?

## Current Consumer Pressure

| Consumer | What to watch |
| --- | --- |
| `sSeo` | Manager dashboard/table spacing must be EvoUI; local CSS should be only site/content output. |
| `sSettings` | DnD/config row CSS should become EvoUI primitives. |
| `sTask` | Legacy Tailwind/CDN/local manager assets must be removed. |
| `sLang` | Resource-tab bridge CSS must stay scoped until the boundary is promoted. |
| `dDocs` | Tree/viewer CSS is a documented exception until the primitive API stabilizes. |
