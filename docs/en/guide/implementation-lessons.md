# EvoUI Implementation Lessons

This guide is the first page to read before building or migrating an Evolution
manager module with EvoUI. It turns the current consumer drift into rules that
humans and agents can follow without opening a donor module and copying random
markup.

## Before Coding

Answer these questions before editing a consumer module:

| Question | Use | Do not use |
| --- | --- | --- |
| Is this a full manager screen? | `x-evo::layout` plus local EvoUI assets | legacy manager shell, Bootstrap, CDN UI assets |
| Is this a top-level module section? | `x-evo::module-tab-shell` or documented no-tabs UX | copied tab markup and copied dirty-state modal |
| Is this repeated data? | `evo-ui.module-table` with provider config | hand-built tables with local sorting/filter CSS |
| Is this a settings or model form? | `evo-ui.form`, `x-evo::form`, `x-evo::settings-row` | ad hoc label grids and custom save buttons |
| Is this a dashboard summary? | `x-evo::dashboard` and `x-evo::dashboard-card` | module-local card grids |
| Is this reorderable UI? | `x-evo::reorder-rail`, `data-evo-dnd`, option-list primitives | custom drag handles, custom payloads, local DnD JS |
| Does add create an inline row/tab/card? | `data-evo-inline-create`, `data-evo-inline-focus`, `evo-ui:inline-create.created` | local `scrollIntoView`, local focus scripts, always-visible duplicate add buttons |
| Is this resource-tab content inside Evolution edit page? | Embedded Resource Contract | full `x-evo::layout` or full asset partial |
| Is this task/progress/log UI? | operational primitive task in EvoUI first | widget-local progress bars and inline scripts |

If the right primitive does not exist, create a visible EvoUI backlog task before
shipping a consumer-local workaround. Temporary bridge code must be scoped,
named, tested and linked to the follow-up task.

## Layouts

Full manager modules use the EvoUI shell:

```blade
<x-evo::layout :title="__('vendor::global.title')">
    <livewire:vendor.module-panel :active-tab="$activeTab" />
</x-evo::layout>
```

dDocs is the documented exception: it uses a tree/sidebar and document viewer UX
without upper module tabs. Do not force top tabs into documentation readers.

Embedded resource screens are another exception. sLang resource language tabs
and sSeo resource SEO fields live inside an existing Evolution edit document.
They must expose the embedded markers from the Embedded Resource Contract and
must not render a second full manager shell.

## Buttons And Actions

Common commands must look identical across modules:

```blade
<x-evo::button
    type="submit"
    icon="check"
    tone="primary"
    variant="filled"
    :label="__('evo::global.action_save')"
/>
```

Rules:

- save: `check`, `primary`, `filled`, `evo::global.action_save`;
- add: `plus`, usually `success`;
- edit: `edit`, usually `primary`;
- duplicate/copy: `copy` or `copy-plus`, usually `info`;
- delete: `trash`, `danger`;
- dense row commands use `.evo-ui-row-actions` and `.evo-ui-row-action`.

Do not invent another green save button, another row action size, or another
toolbar gap in a consumer module.

## Tabs And Dirty State

Use `x-evo::module-tab-shell` when switching sections can leave dirty forms:

```blade
<x-evo::module-tab-shell :tabs="$tabs" model="activeTab">
    @if($activeTab === 'items')
        <livewire:evo-ui.module-table preset="vendor.items" />
    @elseif($activeTab === 'settings')
        <livewire:evo-ui.form preset="vendor.settings" />
    @endif
</x-evo::module-tab-shell>
```

The shell owns active tab markup, unsaved-change prompts and the
`window.EvoUI.form.waitForClean` bridge. Consumers own only the tab config and
the business surface rendered in each tab.

## Tables

Use `evo-ui.module-table` for list/table CRUD:

```blade
<livewire:evo-ui.module-table preset="vendor.redirects" />
```

The provider/config owns columns, filters, sorting, pagination, typed cells,
modal metadata, inline edit hooks, row actions, delete guards and reorder hooks.
Do not create a custom table just to change spacing, header actions, pagination,
or double-click behavior. Add the missing table primitive to EvoUI instead.

## Forms

Use declarative forms for settings and model editors:

```php
return [
    'key' => 'vendor.settings',
    'model' => 'config',
    'fields' => [
        ['name' => 'enabled', 'type' => 'checkbox', 'label' => 'vendor::global.enabled'],
        ['name' => 'title', 'type' => 'text', 'label' => 'vendor::global.title'],
    ],
];
```

Label alignment, help text, dirty state, save buttons, in-button saved feedback
and field rendering are EvoUI responsibilities. Consumer modules own persistence,
validation rules and domain semantics.

## Dashboards

Use shared dashboard cards for summaries:

```blade
<x-evo::dashboard>
    <x-evo::dashboard-card
        icon="sitemap"
        :title="$siteTitle"
        span="6"
        :stats="[['value' => $count, 'label' => __('vendor::global.ready')]]"
    />

    <x-slot:body>
        <livewire:evo-ui.module-table preset="vendor.recent-activity" />
    </x-slot:body>
</x-evo::dashboard>
```

The card grid, half-width spans and table spacing belong to EvoUI. Modules only
provide data and labels.

## DnD And Inline Create

Use the shared DnD contract for nested rows, settings builders and tables:

```blade
<div
    class="evo-ui-dnd"
    data-evo-dnd
    data-evo-dnd-group-method="sortGroupByUid"
    data-evo-dnd-item-method="sortItemByUid"
>
    <section class="evo-ui-dnd-group-row" data-evo-dnd-group data-evo-dnd-uid="{{ $group['_uid'] }}">
        <x-evo::reorder-rail />

        <div class="evo-ui-dnd-list" data-evo-dnd-list data-evo-dnd-group-uid="{{ $group['_uid'] }}">
            <div class="evo-ui-dnd-row" data-evo-dnd-item data-evo-dnd-uid="{{ $item['_uid'] }}">
                <x-evo::reorder-rail />
            </div>
        </div>
    </section>
</div>
```

After an inline create action, the new row/tab/card should scroll into view and
focus the primary input. Use the shared inline-create primitive:

```blade
<div class="evo-ui-inline-create" data-evo-inline-create="settings-config">
    <div data-evo-inline-created="{{ $uid }}" data-evo-inline-create-id="{{ $uid }}">
        <input data-evo-inline-focus wire:model.live="field.label">
    </div>

    <div class="evo-ui-inline-create-bottom" data-evo-inline-create-bottom hidden>
        <x-evo::button icon="plus" tone="success" wire:click="addField" />
    </div>
</div>
```

```js
window.dispatchEvent(new CustomEvent('evo-ui:inline-create.created', {
    detail: { root: 'settings-config', id: uid }
}));
```

`data-evo-inline-create-bottom` appears only when the page or configured root
overflows. Do not copy local `scrollIntoView`, `focus()` or duplicate-bottom-add
scripts into modules.

## Modals

Use `x-evo::modal`, table form modals and delete confirmation modals. Modal
header, body spacing, footer alignment, close buttons and destructive action
placement are shared. Consumers provide title, fields, save/delete methods and
domain validation.

Do not place cards inside cards or add extra borders just because a modal looks
empty. Prefer compact EvoUI modal body spacing and shared panel primitives.

## Operational Modules

sTask and dGramm need operational UI, not one-off widgets. Treat these as EvoUI
primitive candidates:

- task runner panel;
- progress and status cells;
- log/code viewer;
- upload/drop-zone;
- command list;
- onboarding cards;
- dashboard cards;
- adapter boundary for third-party worker widgets.

Task execution, permissions, worker discovery, command allowlists and log
contents remain consumer-owned. Progress bars, log chrome, runner layout and
empty/loading/error states belong in EvoUI when reused.

## Blade-Safe Attributes

Do not put conditional Blade directives inside complex opening tags:

```blade
{{-- Bad: can render raw text in older/embedded Blade compilation paths. --}}
<button @if($active) aria-current="page" @endif>
    {{ $page }}
</button>
```

Use whole-element branches or an attribute bag:

```blade
@if($active)
    <button aria-current="page" class="is-active">{{ $page }}</button>
@else
    <button>{{ $page }}</button>
@endif
```

```blade
@php
    $rowAttributes = new \Illuminate\View\ComponentAttributeBag([
        'class' => $rowClass,
        'wire:key' => $rowKey,
    ]);

    if ($opensModal) {
        $rowAttributes = $rowAttributes->merge(['data-evo-modal-dblclick' => $rowId]);
    }
@endphp

<tr {{ $rowAttributes }}>
```

This rule applies to pagination, table rows, list cards, onboarding actions and
any markup that mixes Livewire, Alpine and conditional attributes.

## Anti-Custom Checklist

Before closing a task, search the consumer diff for:

- `<style>` blocks in manager views;
- `style="..."` used for shared layout;
- Bootstrap, jQuery, Roboto, CDN UI assets or legacy manager bundles;
- module-local `.btn`, tab, modal, card, table, DnD or progress CSS;
- copied dirty-state or unsaved modal logic;
- inline conditional Blade attributes in opening tags;
- duplicated save/add/delete visual patterns;
- generic UI code living in a consumer instead of EvoUI.

If any item is present, either replace it with an EvoUI primitive or create a
visible backlog task that explains why a temporary scoped bridge exists.
