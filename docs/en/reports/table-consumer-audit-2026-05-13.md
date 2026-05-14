# Table Consumer Audit - 2026-05-13

Scope: `sArticles`, `sSeo`, `sLang`, `dIssues`, `dGramm`, `sTask`,
`sSettings` and the current `evo-ui` Table docs. The audit checks whether
tables use the declarative EvoUI table contract instead of module-local UI:
toolbar, action buttons, filters, search, sorting, pagination, modal CRUD,
inline editing and table reorder.

## Executive Summary

The platform direction is correct: real row-based manager surfaces are mostly
using `x-evo::table.livewire` or `livewire:evo-ui.module-table`. The strongest
canonical consumers are `sArticles`, `sSeo redirects/activity`, `dIssues`
settings tables and most `sTask` tables.

The initial drift was concentrated in three areas:

- table docs were missing separate pages for search, sorting and table reorder;
- several `dGramm` simple tables defined `default_sort`/`setSort` while no
  columns are marked sortable, so EvoUI clears the UI sort state and provider
  fallback ordering silently takes over;
- `sLang` used `default_sort => tid` while the only static sortable column key
  is `key`; this makes default sort invisible to EvoUI even if the provider
  still orders correctly.

Follow-up cleanup applied:

- `dGramm` table configs now expose sortable date columns that match their
  `default_sort` keys, and `bots` defaults to `last_update_at`.
- `sLang` now defaults to the visible sortable `key` column.
- `dIssues` settings table `wire_target` strings now include `openEditModal`.
- `dGramm` has a lightweight package test runner for these table contracts.

`sSettings` is not a table consumer today. It is a form/DnD builder consumer and
is useful as a DnD donor, but its local CSS/layout should continue moving into
EvoUI primitives instead of being copied into tables.

## Canonical Table Rules

- Use `x-evo::table.livewire` or `livewire:evo-ui.module-table`.
- Keep toolbar actions in `actions`.
- Keep right-lane controls in filters/view/search/control-placement actions.
- Keep row actions in `row_actions`, rendered as the final action column.
- Keep search in `search`, not a custom input.
- Keep filters in `filters`; supported types are `multi-select`, `select`,
  `segmented`, `toggle`, `date-range`.
- Keep sorting on column keys; `default_sort` must match a sortable column
  `key`, while SQL/database mapping belongs in `sort_field`.
- Keep pagination in the shared footer with `per_page_options`.
- Use table reorder only with `reorder.enabled`, a sortable `position` column,
  `moveRow` and `reorderRow`.
- Do not add module-local CSS/JS for table toolbar, row actions, filter badges,
  sort controls, pagination or table DnD.

## Documentation Gaps Closed

Added dedicated Table documentation pages:

- `docs/en/components/table/search.md`
- `docs/en/components/table/sorting.md`
- `docs/en/components/table/reorder.md`

The Table folder now has separate docs for overview, contract, action buttons,
filters, search, sorting, reorder and pagination.

## Consumer Matrix

| Module | Tables | Status | Notes |
| --- | ---: | --- | --- |
| `sArticles` | 8 | Good canonical donor | Broadest table coverage: filters, search, sorting, table/list, modal CRUD, row actions and positioned reorder. |
| `sSeo` | 2 | Good canonical donor | Redirects and activity use shared tables; no local search toolbar; no reorder on non-positioned rows. |
| `sLang` | 1 | Good after sort cleanup | Inline table is good; default sort now uses the visible sortable `key` column. |
| `dIssues` | 5 row tables plus workspace | Good after wire target cleanup | Settings tables use reorder correctly and include `openEditModal` in loading targets. |
| `dGramm` | 7 | Good after sorting cleanup | Uses EvoUI tables; default sorts now map to sortable columns and tests guard the contract. |
| `sTask` | 3 | Mostly good | Uses declarative tables; task/log detail modal is action-modal style and should be documented as intentional. |
| `sSettings` | 0 tables | Not applicable | Uses form/DnD primitives, not Table. Do not use it as a table donor. |

## sArticles

Tables:

- `articles`
- `authors`
- `categories`
- `comments`
- `features`
- `polls`
- `tags`
- `tvparams`

Correct:

- all tables use declarative configs and EvoUI rendering;
- search is enabled through table state;
- filters use canonical types where needed;
- sortable columns expose `sortable` and provider-safe `sort_field`;
- row actions are in `row_actions`;
- modal CRUD is shared;
- pagination is shared;
- `categories`, `features`, `tvparams` correctly use `reorder.enabled`,
  `position` columns, `moveRow` and `reorderRow`.

Watch:

- `articles` is the largest provider; keep future business semantics inside
  `ArticlesTableData`, not in EvoUI.
- builder/modal nested item reorder belongs to form/DnD docs, not Table docs.

Verdict: canonical donor for full Table behavior.

## sSeo

Tables:

- `redirects`
- `activity`

Correct:

- both tables use `x-evo::table.livewire`;
- redirects has modal CRUD, row actions, search, sorting and pagination;
- activity uses shared table inside dashboard;
- local dashboard cards should use EvoUI dashboard/card primitives, while the
  activity table remains EvoUI-owned;
- tests explicitly guard against adding reorder to non-positioned SEO tables.

Watch:

- no local module CSS should style the module table or dashboard table spacing;
  only site-content/public output may keep local CSS.

Verdict: canonical donor for non-reorder CRUD/activity tables.

## sLang

Table:

- `translates`

Correct:

- uses EvoUI table;
- search is enabled;
- inline create/edit is configured through `inline`;
- table action, row action, header/inline action paths are present;
- no modal CRUD, which is correct for dictionary inline editing.

Resolved drift:

- `default_sort` was `tid`, but the static sortable column key is `key`.
  The config now uses `default_sort => key` and `default_direction => asc`, so
  EvoUI can show and persist the active default sort state.

Remaining watch:

- document dynamic language columns/header actions as the donor pattern for
  dictionary tables.

Verdict: good inline donor after small sorting cleanup.

## dIssues

Tables:

- `issues`
- settings `categories`
- settings `statuses`
- settings `phases`
- settings `projects`

Correct:

- issue table uses search, filters, sorting, modal CRUD and row actions;
- settings tables use position reorder with shared table rail;
- settings providers implement `moveRow` and `reorderRow`;
- table/list parity is present.

Resolved drift:

- settings table `wire_target` included `openCreateModal` but not
  `openEditModal`, even though toolbar and row edit actions call
  `openEditModal`. The settings table configs now include `openEditModal`.

Remaining watch:

- keep issue workspace logic out of Table docs; workspace has its own contract.

Verdict: canonical donor for table reorder/settings taxonomies.

## dGramm

Tables:

- `bots`
- `chats`
- `contacts`
- `inbox`
- `logs`
- `messages`
- `outbox`

Correct:

- tables render through EvoUI;
- bots uses filters, search, table/list, modal CRUD and row actions;
- logs uses `segmented`, `select` and `date-range` filters;
- messages has sortable columns with a valid default.

Resolved drift:

- `bots` had `default_sort => updated_at`, but the sortable column key was
  `last_update_at`. It now defaults to `last_update_at`.
- `chats`, `contacts`, `inbox`, `logs`, `outbox` defined `default_sort` and
  included `setSort` in `wire_target`, but exposed no sortable columns. They
  now expose sortable date columns matching their defaults.
- `dGramm` now has `tests/run.php` covering default sort keys, sortable
  `sort_field` values and table-state `wire_target` methods.

Remaining watch:

- keep dGramm modal spacing changes in EvoUI modal/card primitives, not local
  table CSS.

Verdict: good after table sorting cleanup.

## sTask

Tables:

- `tasks`
- `workers`
- `logs`

Correct:

- all three use `livewire:evo-ui.module-table`;
- search, filters, sorting, table/list and pagination are declarative;
- task/log details use row action modal flow;
- workers table exposes table actions and row actions.

Watch:

- `tasks` and `logs` use `openActionModal` rather than normal
  `openEditModal`; this is valid for details/read-only action modals, but it
  should be documented as an intentional table action-modal pattern.
- `wire_target` is intentionally shorter for details-only modal flows; do not
  force normal CRUD target strings there unless CRUD is added.

Verdict: good operational table donor; action-modal pattern needs docs.

## sSettings

Tables:

- none.

Correct:

- does not pretend to be a table;
- uses form and DnD primitives for tabs, fields and modal option rows.

Drift outside Table:

- local `ssettings-*` CSS still contains layout/styling that should gradually
  become EvoUI form/DnD primitives.

Verdict: DnD/form donor only, not a Table donor.

## Priority Fix List

1. Done: `dGramm` default sort keys now match sortable columns and have package
   tests.
2. Done: `sLang` default sort now points at the visible `key` column.
3. Done: `dIssues` settings table `wire_target` strings include
   `openEditModal`.
4. Done: `evo-ui` has dedicated docs/tests for table search, sorting and
   reorder.
5. Next: when a module needs new table behavior, add it to
   EvoUI first; do not create local toolbar/filter/sort/pagination CSS.
