# dIssues Full Task Report — all projects

- Generated: `2026-05-09 08:01:38 UTC`
- Source DB: `/Users/dmi3yy/PhpstormProjects/Extras/sArticles/demo/core/database/database.sqlite`
- Scope: every current row in `evo_d_issues`, grouped by project/component/status.
- Total tasks in this snapshot: **167**.
- Total comments included: **597**.
- Tasks without `external_id`: **11**; they are shown as `project-unkeyed-DBID` so analytics does not lose them.

> Note: the expected count mentioned in chat was 147, but the live demo database currently contains 167 tasks. This report intentionally includes the live full set.

## Project totals

| Project | Name | Tasks |
|---|---|---:|
| `dissues` | dIssues | 70 |
| `ddocs` | dDocs | 26 |
| `evo-ui` | evo-ui | 20 |
| `slang` | sLang | 26 |
| `sseo` | sSeo | 25 |

## Status matrix

| Project | Status | Tasks |
|---|---|---:|
| `ddocs` | `backlog` | 2 |
| `ddocs` | `in_progress` | 2 |
| `ddocs` | `ready_to_test` | 22 |
| `dissues` | `backlog` | 4 |
| `dissues` | `blocked` | 1 |
| `dissues` | `closed` | 2 |
| `dissues` | `ready_to_test` | 63 |
| `evo-ui` | `ready_to_test` | 20 |
| `slang` | `ready_to_test` | 26 |
| `sseo` | `ready_to_test` | 25 |

## Project `dissues` — dIssues

- Tasks: **70**
- Statuses: `backlog` 4, `blocked` 1, `closed` 2, `ready_to_test` 63
- Categories: `bug` 1, `feature` 63, `support` 6
- Priorities: `high` 11, `normal` 59
- Component groups: `archive` 2, `evo-ui` 24, `qa` 1, `roadmap` 10, `ui` 4, `unkeyed/imported` 11, `viewport` 7, `workflow` 11

### Task index

| Task | Group | Status | Category | Priority | Phase | Comments | Title |
|---|---|---|---|---|---|---:|---|
| `dissues-evo-ui-015` | `evo-ui` | `backlog` | `feature` | `normal` | `new` | 2 | Підготувати GitHub/GitLab sync boundary |
| `dissues-roadmap-005` | `roadmap` | `backlog` | `feature` | `normal` | `new` | 2 | Implement GitHub issue provider pull |
| `dissues-roadmap-006` | `roadmap` | `backlog` | `feature` | `normal` | `new` | 2 | Implement GitLab issue provider pull |
| `dissues-roadmap-007` | `roadmap` | `backlog` | `feature` | `normal` | `new` | 2 | Push comments and status changes back to providers |
| `dissues-evo-ui-001` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 3 | Перезібрати dIssues shell за новим sArticles патерном |
| `dissues-evo-ui-002` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 3 | Спроєктувати evoUI Issue Workspace surface |
| `dissues-evo-ui-003` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 11 | Додати evoUI Kanban view для issues |
| `dissues-evo-ui-004` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Додати drag-sort між статусами через evoUI |
| `dissues-evo-ui-021` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Зробити status chip кольоровим з іконкою у issue list |
| `dissues-evo-ui-005` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Додати evoUI split-pane list/detail для задач |
| `dissues-evo-ui-017` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Повернути Projects замість Work types |
| `dissues-evo-ui-020` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Стабілізувати issue list/detail і rich editor для опису |
| `dissues-evo-ui-022` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Уніфікувати issue split list зі стандартним evoUI list |
| `dissues-roadmap-001` | `roadmap` | `ready_to_test` | `feature` | `high` | `tests` | 3 | Stabilize local issue board UI in Evolution manager |
| `dissues-roadmap-003` | `roadmap` | `ready_to_test` | `feature` | `high` | `tests` | 3 | Use Evolution manager users for assignment and filtering |
| `dissues-evo-ui-006` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Зібрати Issue Detail conversation surface |
| `dissues-archive-042` | `archive` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Додати archive toggle/view перед List/Kanban |
| `dissues-evo-ui-007` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Оформити dIssues IssuesProvider контракт |
| `dissues-archive-043` | `archive` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Додати bulk archive для Closed lane |
| `dissues-evo-ui-008` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Розширити settings: керування статусами |
| `dissues-evo-ui-009` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Розширити settings: керування категоріями |
| `dissues-evo-ui-010` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Розширити settings: керування проєктами |
| `dissues-evo-ui-011` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 4 | Додати evoUI color picker field |
| `dissues-evo-ui-012` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Додати evoUI badge з dynamic hex color |
| `dissues-evo-ui-023` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Зберігати issue workspace UI state у session як sArticles |
| `dissues-evo-ui-013` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Міграція taxonomy colors з class на hex |
| `dissues-evo-ui-014` | `evo-ui` | `ready_to_test` | `support` | `normal` | `tests` | 4 | Звірити візуал dIssues з sArticles і bird |
| `dissues-evo-ui-016` | `evo-ui` | `ready_to_test` | `support` | `normal` | `tests` | 4 | Наповнити demo задачами і smoke diagnostics |
| `dissues-evo-ui-019` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Показувати фото Evolution manager user на issue cards |
| `dissues-evo-ui-024` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Переробити rich editor integration точно як у sArticles |
| `dissues-roadmap-010` | `roadmap` | `ready_to_test` | `support` | `normal` | `tests` | 4 | Add focused tests for models, migrations, and provider mapping |
| `dissues-evo-ui-018` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Перевести evoUI colors на OKLCH palette |
| `dissues-roadmap-008` | `roadmap` | `ready_to_test` | `feature` | `high` | `tests` | 4 | Design client-facing task/chat surface |
| `dissues-roadmap-004` | `roadmap` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Build settings for providers and sync behavior |
| `dissues-unkeyed-035` | `unkeyed/imported` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Переробити assignee filter на multi-user фільтр |
| `dissues-unkeyed-036` | `unkeyed/imported` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Винести reusable rich editor adapter в evoUI і реально підключити issue body editor |
| `dissues-unkeyed-037` | `unkeyed/imported` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Додати rich editor у reply/comment composer |
| `dissues-unkeyed-038` | `unkeyed/imported` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Зробити повний assignment UX: assign to me, assign user, unassign |
| `dissues-unkeyed-039` | `unkeyed/imported` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Почистити issue detail meta: прибрати дубль MiddleDuck і пояснити дати |
| `dissues-unkeyed-040` | `unkeyed/imported` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Додати reply-to-comment flow для коментарів |
| `dissues-unkeyed-045` | `unkeyed/imported` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Перебудувати Settings UI на окремі вкладки Основне / Синхронізація / Категорії / Статуси / Проєкти |
| `dissues-unkeyed-046` | `unkeyed/imported` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Підключити taxonomy tables у Settings tabs через evoUI table presets |
| `dissues-unkeyed-047` | `unkeyed/imported` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Увімкнути double-click edit modal для taxonomy tables |
| `dissues-unkeyed-048` | `unkeyed/imported` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Довести taxonomy table columns і modal fields до повного settings contract |
| `dissues-unkeyed-041` | `unkeyed/imported` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Додати archive model для closed issues |
| `dissues-workflow-049` | `workflow` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Add status phases/steps taxonomy |
| `dissues-workflow-050` | `workflow` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Render issue phase in workspace |
| `dissues-workflow-051` | `workflow` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Add responsible manager user to statuses |
| `dissues-workflow-052` | `workflow` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Track issue status and phase history |
| `dissues-workflow-053` | `workflow` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Add parent/child issue model |
| `dissues-workflow-054` | `workflow` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Show subtasks progress on issue cards |
| `dissues-workflow-055` | `workflow` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Add simple status quick transitions |
| `dissues-workflow-056` | `workflow` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Seed default phases for current statuses |
| `dissues-workflow-057` | `workflow` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Add phase filter to issue workspace |
| `dissues-workflow-058` | `workflow` | `ready_to_test` | `support` | `normal` | `tests` | 5 | Update demo data and smoke diagnostics for phases/subtasks |
| `dissues-workflow-059` | `workflow` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Add priority workflow controls for issues |
| `dissues-ui-060` | `ui` | `ready_to_test` | `feature` | `high` | `tests` | 3 | Уніфікувати висоту верхніх табів з sArticles |
| `dissues-ui-061` | `ui` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Use system Configuration translations in dIssues |
| `dissues-ui-062` | `ui` | `ready_to_test` | `bug` | `normal` | `tests` | 3 | Align dIssues font scale with sArticles evo-ui baseline |
| `dissues-viewport-063` | `viewport` | `ready_to_test` | `feature` | `high` | `tests` | 3 | Спроєктувати viewport-first Issue Workspace layout |
| `dissues-viewport-064` | `viewport` | `ready_to_test` | `feature` | `high` | `tests` | 3 | Додати provider contract для lazy-loaded issue slices |
| `dissues-viewport-065` | `viewport` | `ready_to_test` | `feature` | `high` | `tests` | 3 | Реалізувати lazy loading kanban cards по lane scroll |
| `dissues-viewport-066` | `viewport` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Реалізувати lazy loading для split list mode |
| `dissues-viewport-067` | `viewport` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Зберігати scroll/load state workspace у session |
| `dissues-viewport-068` | `viewport` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Полірувати hidden-scroll UI для kanban/list panes |
| `dissues-viewport-069` | `viewport` | `ready_to_test` | `support` | `normal` | `tests` | 3 | Додати tests/smoke для viewport lazy workspace |
| `dissues-ui-070` | `ui` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Зробити kanban chips компактнішими і менш жирними |
| `dissues-roadmap-009` | `roadmap` | `blocked` | `support` | `normal` | `blocked` | 2 | Add multilingual polish for manager screens |
| `dissues-roadmap-002` | `roadmap` | `closed` | `feature` | `high` | `done` | 3 | Superseded: Projects taxonomy stays |
| `dissues-qa-044` | `qa` | `closed` | `feature` | `normal` | `done` | 3 | Провести ручний QA Ready-to-test задач і рознести regressions |

### Full task details

#### `dissues-evo-ui-015` — Підготувати GitHub/GitLab sync boundary

| Field | Value |
|---|---|
| DB id | `25` |
| External id | `dissues-evo-ui-015` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `backlog` / Backlog |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `new` / New |
| Position | `0` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 05:56:28` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Не імплементувати провайдери повністю зараз, але не замкнути UI на local-only. Потрібні поля external_id/iid/url/payload/map і сервісний контракт для майбутнього sync.

Acceptance:
- Local issue lifecycle працює без зовнішніх провайдерів.
- Provider contract має методи map statuses/categories/comments.
- Settings має GitHub/GitLab toggles, але вони не заважають local.
- External URL може показуватись у detail, якщо є.
~~~

**Comments / execution log (2)**

- Comment `25` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `103` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-roadmap-005` — Implement GitHub issue provider pull

| Field | Value |
|---|---|
| DB id | `5` |
| External id | `dissues-roadmap-005` |
| Project | `dissues` / dIssues |
| Component group | `roadmap` |
| Status | `backlog` / Backlog |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `new` / New |
| Position | `1` |
| Parent | `-` - |
| Author | admin / d@evo.im |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-07 20:07:38` |
| Updated | `2026-05-09 05:56:28` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Add GitHub provider for importing repository issues into dIssues, mapping labels to categories/work types and external states to local statuses.
~~~

**Comments / execution log (2)**

- Comment `5` · `2026-05-07 20:07:38` · MiddleDuck · `public`

~~~text
Provider interface exists; GitHub implementation is still pending.
~~~

- Comment `83` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-roadmap-006` — Implement GitLab issue provider pull

| Field | Value |
|---|---|
| DB id | `6` |
| External id | `dissues-roadmap-006` |
| Project | `dissues` / dIssues |
| Component group | `roadmap` |
| Status | `backlog` / Backlog |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `new` / New |
| Position | `2` |
| Parent | `-` - |
| Author | admin / d@evo.im |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-07 20:07:38` |
| Updated | `2026-05-09 05:56:28` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Add GitLab provider matching the GitHub provider contract so projects hosted in GitLab can use the same manager UI.
~~~

**Comments / execution log (2)**

- Comment `6` · `2026-05-07 20:07:38` · MiddleDuck · `public`

~~~text
Keep this after GitHub so the abstraction is proven once first.
~~~

- Comment `84` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-roadmap-007` — Push comments and status changes back to providers

| Field | Value |
|---|---|
| DB id | `7` |
| External id | `dissues-roadmap-007` |
| Project | `dissues` / dIssues |
| Component group | `roadmap` |
| Status | `backlog` / Backlog |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `new` / New |
| Position | `3` |
| Parent | `-` - |
| Author | admin / d@evo.im |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-07 20:07:38` |
| Updated | `2026-05-09 05:56:28` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
When enabled, replies from the manager should become GitHub/GitLab comments and local status transitions should map back to the external provider.
~~~

**Comments / execution log (2)**

- Comment `7` · `2026-05-07 20:07:38` · MiddleDuck · `public`

~~~text
This depends on provider pull and mapping settings.
~~~

- Comment `85` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-001` — Перезібрати dIssues shell за новим sArticles патерном

| Field | Value |
|---|---|
| DB id | `11` |
| External id | `dissues-evo-ui-001` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `1` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Проаналізувати нову частину sArticles: module shell, ModulePanel, preset resolution, x-evo::table.livewire, unsaved prompt, wire tabs. Прибрати з dIssues самописний board як основний екран і залишити тільки evoUI-driven surfaces.

Acceptance:
- dIssues tabs працюють як у sArticles через preset/surface resolution.
- Немає inline header/form перед таблицею.
- Assets підтягуються тільки через evoUI manager assets.
- Старий IssuesBoard не рендериться як default.
~~~

**Comments / execution log (3)**

- Comment `11` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `27` · `2026-05-08 03:35:50` · MiddleDuck · `public`

~~~text
Implemented first workflow task: added PRD/SPEC/analysis artifacts, documented the default dIssues task flow, rebuilt ModulePanel around sArticles-style preset resolution, rendered issues/settings through evoUI presets, aligned workflow statuses to Backlog/Decomposition/In progress/Ready to test/Blocked/Closed, added unit tests, ran migration, and passed shell smoke. Checks: php -l, PHPUnit 5 tests/44 assertions, demo migrate, render smoke without SQLSTATE and without default IssuesBoard.
~~~

- Comment `89` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-002` — Спроєктувати evoUI Issue Workspace surface

| Field | Value |
|---|---|
| DB id | `12` |
| External id | `dissues-evo-ui-002` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `2` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
На базі bird issues/index створити reusable evoUI surface для задач: header, category dropdown, assignee segmented, display segmented, progress/loading indicator, compact toolbar. Це не table CRUD, а окремий workspace компонент.

Acceptance:
- Новий x-evo::issues.workspace або Livewire component приймає provider/preset/context.
- Фільтри відповідають bird: category, status для list, assignee me/unassigned/all, display list/kanban.
- Компонент використовує evoUI tokens/classes і не тягне maryUI.
~~~

**Comments / execution log (3)**

- Comment `12` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `29` · `2026-05-08 04:09:37` · MiddleDuck · `public`

~~~text
Implemented evoUI Issue Workspace shell. Added PRD/SPEC/analysis/QA/report, created EvoUI Livewire IssueWorkspace, registered x-evo::issues.workspace, added workspace Blade/CSS, added dIssues workspace config/provider, and switched issues tab from table CRUD to the new workspace surface. Checks passed: php -l, PHPUnit 12 tests/121 assertions, demo migrate, render smoke with category/assignee/display controls, list status filter, no maryUI markers, no SQLSTATE.
~~~

- Comment `90` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-003` — Додати evoUI Kanban view для issues

| Field | Value |
|---|---|
| DB id | `13` |
| External id | `dissues-evo-ui-003` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `4` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Перенести з bird канбан-логіку: статусні колонки, лічильники, картки, category badge, comment count, issue id, assignee avatar/initials, scrollable lanes. Реалізувати як evoUI component, не як локальний CSS-моноліт dIssues.

Acceptance:
- Лани будуються з d_issue_statuses за position.
- Картки групуються за status_id і position.
- Візуально ближче до bird, але в Evo dark/light themes.
- На клік відкривається issue detail modal або side detail залежно від display.
~~~

**Comments / execution log (11)**

- Comment `13` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `30` · `2026-05-08 04:30:31` · MiddleDuck · `internal`

~~~text
Починаю задачу disues-evo-ui-003 за flow: PRD/SPEC/analysis готові, далі реалізую evoUI kanban з sArticles-style header та dIssues provider data.
~~~

- Comment `31` · `2026-05-08 04:37:49` · MiddleDuck · `internal`

~~~text
Зроблено disues-evo-ui-003.

PRD/SPEC/analysis/QA/report додані в docs/tasks/dissues-evo-ui-003.

Реалізація:
- evoUI IssueWorkspace тепер рендерить kanban lanes/cards і preview modal;
- header/filter rhythm приведено до sArticles/evoUI: title+counter, filters зліва, scope/display справа;
- dIssues provider повертає kanbanLanes() та issuePreview() з project/category/status/comments/assignee даними;
- list режим залишено placeholder під наступну split-pane задачу.

Перевірка:
- php -l: pass;
- PHPUnit: 13 tests, 141 assertions;
- manager render smoke: header/kanban/cards є, SQLSTATE немає;
- preview smoke: modal відкривається для issue #13.

Self-score: 8.5/10. Переношу в Ready to test.
~~~

- Comment `32` · `2026-05-08 04:43:56` · MiddleDuck · `internal`

~~~text
Review fix for disues-evo-ui-003:

Прибрав зайвий title/counter header з issue workspace. Тепер toolbar як у sArticles/evoUI table:
- зліва action зона з add button;
- по центру filters: category/status + assignee scope;
- справа controls: List/Kanban + search.

Також додав search у filters.search і провів його через dIssues provider. Під час smoke знайшов стару SQLite проблему в dIssue::scopeSearch з ESCAPE, виправив на сумісний LIKE.

Перевірка після правки:
- old header у render: false;
- evo-ui-table-toolbar/actions/filters/controls/search: true;
- kanban/cards: true;
- SQLSTATE: false;
- search Kanban: 9 cards, issue #13 present;
- PHPUnit: 13 tests, 146 assertions.
~~~

- Comment `33` · `2026-05-08 04:49:28` · MiddleDuck · `internal`

~~~text
UI polish for disues-evo-ui-003:

Привів toolbar ближче до sArticles:
- assignee scope і List/Kanban control тепер icon-only;
- довгі назви лишені тільки у title/aria/sr-only;
- search повернуто на стандартну ширину evo-ui-table-toolbar, без кастомного 420px override.

Перевірка:
- visible assignee labels: false;
- sr-only labels: true;
- search width override 420px: false;
- toolbar/search/kanban render: true;
- SQLSTATE: false;
- PHPUnit: 13 tests, 146 assertions.
~~~

- Comment `34` · `2026-05-08 04:50:37` · MiddleDuck · `internal`

~~~text
UI compact polish for disues-evo-ui-003:

Прибрав зайвий overlay-контейнер навколо kanban:
- issue viewport тепер без border/background/radius;
- kanban padding: 0;
- gap і внутрішні падінги lane/card зменшені;
- workspace padding/gap ущільнені, щоб виглядало ближче до table surface.

Перевірка:
- viewport transparent: true;
- kanban padding 0: true;
- kanban/card render: true;
- SQLSTATE: false;
- PHPUnit: 13 tests, 146 assertions.
~~~

- Comment `35` · `2026-05-08 05:10:30` · MiddleDuck · `internal`

~~~text
UI filter correction for disues-evo-ui-003:

Переробив category/status filters з native select на evoUI multi-choice dropdown filters, як у sArticles table toolbar:
- category/status тепер `evo-ui-filter-dropdown` + `EvoUI.multiFilter`;
- native selects для filters.category_id/status_id прибрані з workspace view;
- додані filter state arrays `category_ids` і `status_ids`;
- provider фільтрує issues по category_ids/status_ids;
- workspace padding прибраний (`padding: 0`), щоб відступи йшли від tab-content як у sArticles.

Перевірка:
- filter dropdowns: 2;
- EvoUI.multiFilter: 2;
- native select: false;
- workspace padding zero: true;
- filtered provider smoke: cards 3, non-matching status/category 0;
- SQLSTATE: false;
- PHPUnit: 13 tests, 155 assertions.
~~~

- Comment `36` · `2026-05-08 05:24:16` · MiddleDuck · `internal`

~~~text
UI pass: вирівняв issues toolbar під sArticles/evoUI каркас. Прибрав issue-specific toolbar/segmented modifiers, assignee і list/kanban тепер використовують стандартний icon-only evo-ui-view-toggle; пошук лишився на стандартній ширині evo-ui-table-search-width. Перевірено: PHP lint OK, PHPUnit 13/13 green, source smoke підтвердив 2 стандартні toggle-групи без evo-ui-segmented у workspace. Статус лишається Ready to test для візуальної перевірки в менеджері.
~~~

- Comment `37` · `2026-05-08 05:27:03` · MiddleDuck · `internal`

~~~text
UI pass: прибрав зайву вертикальну висоту порожньої Kanban дошки. Workspace/viewport/kanban більше не мають vh/620px мінімумів, lane мінімум зменшено до 260px, тому скрол зʼявлятиметься від реальних карток, а не від дефолтного каркаса. Перевірено: PHPUnit 13/13 green, CSS smoke підтвердив відсутність 620px/560px.
~~~

- Comment `38` · `2026-05-08 05:28:18` · MiddleDuck · `internal`

~~~text
UI pass: зробив Kanban колонки компактнішими. Ширина lane тепер 260-360px замість розтягування через 1fr/420px, header зменшено до 44px, зменшено padding, icon і counter. Перевірено: PHPUnit 13/13 green, CSS smoke підтвердив нові розміри.
~~~

- Comment `91` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-004` — Додати drag-sort між статусами через evoUI

| Field | Value |
|---|---|
| DB id | `14` |
| External id | `dissues-evo-ui-004` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `6` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
У bird SortableJS змінює status_id і position. Треба зробити це як evoUI sortable lane behavior, щоб dIssues тільки дав provider method sortIssue/status.

Acceptance:
- Drag між колонками оновлює status_id.
- Порядок у колонці оновлює position.
- Livewire action мінімально перерендерює потрібне.
- Є захист від невалідного status/issue id.
~~~

**Comments / execution log (4)**

- Comment `14` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `40` · `2026-05-08 05:33:18` · MiddleDuck · `internal`

~~~text
Почав виконання по flow: PRD/SPEC/ANALYSIS створені, далі реалізація evoUI drag/drop + dIssues persistence + тести.
~~~

- Comment `41` · `2026-05-08 05:37:58` · MiddleDuck · `internal`

~~~text
Завершено drag-sort task. Додано evoUI Kanban drag/drop contract без CDN: data-evo-issue-kanban/lane/card, native drag helper EvoUI.initIssueKanban(), Livewire boundary sortKanbanLanes(), dIssues persistence через IssuesWorkspaceData::sortKanbanLanes(). Перевірки: PHP lint OK, node --check OK, PHPUnit 13/13 (172 assertions), source smoke OK, DB smoke OK з відновленням demo стану. Оцінка 8/10; статус переведено в Ready to test.
~~~

- Comment `92` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-021` — Зробити status chip кольоровим з іконкою у issue list

| Field | Value |
|---|---|
| DB id | `31` |
| External id | `dissues-evo-ui-021` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `7` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 06:06:31` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
У split list/detail статус зараз виглядає як muted gray chip. Треба використовувати status.color і status.icon з Kanban lane, щоб статуси читались однаково у списку, detail і preview.\n\nAcceptance:\n- У list item статус має іконку.\n- Status chip бере CSS variable зі status.color.\n- Detail/preview meta теж показує статус кольорово.\n- Tests покривають contract.
~~~

**Comments / execution log (2)**

- Comment `45` · `2026-05-08 06:09:14` · Codex · `public`

~~~text
Зроблено.\n\nЩо змінив:\n- у list item статус тепер окремий colored chip з іконкою;\n- chip бере той самий status.color, який використовує Kanban lane;\n- status у detail і Kanban preview теж рендериться тим самим colored chip;\n- додав CSS для компактної іконки всередині issue chip;\n- додав contract test, щоб status chip не повернувся в muted gray.\n\nПеревірка:\n- php -l: OK;\n- PHPUnit: 15 tests, 213 assertions;\n- demo CSS через symlink містить .evo-ui-issue-card__chip--status.\n\nSelf-review: 9/10.\nСтатус: Ready to test.
~~~

- Comment `109` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-005` — Додати evoUI split-pane list/detail для задач

| Field | Value |
|---|---|
| DB id | `15` |
| External id | `dissues-evo-ui-005` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `8` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
З bird issues/list беремо split layout: ліва searchable issue list, права detail panel. Це має бути окремий display режим поруч з kanban.

Acceptance:
- Ліва колонка sticky/scrollable, має пошук по title/body.
- Active issue підсвічується.
- Права панель рендерить detail без popup.
- Mobile fallback не ламає manager.
~~~

**Comments / execution log (4)**

- Comment `15` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `42` · `2026-05-08 05:42:50` · MiddleDuck · `internal`

~~~text
Почав виконання по flow: створив PRD/SPEC/ANALYSIS для split-pane list/detail, далі реалізація в evoUI workspace + dIssues provider + тести.
~~~

- Comment `43` · `2026-05-08 05:46:34` · MiddleDuck · `internal`

~~~text
Завершено split-pane list/detail. List mode більше не заглушка: додано IssuesWorkspaceData::issueList(), IssueWorkspace::issueList()/selectedIssue fallback, Blade split-pane зліва список задач, справа inline detail, Kanban modal preview лишився тільки для Kanban. Перевірки: PHP lint OK, node --check OK, PHPUnit 13/13 (182 assertions), provider smoke повернув 29 задач з id/title/status. Оцінка 8/10; статус переведено в Ready to test.
~~~

- Comment `93` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-017` — Повернути Projects замість Work types

| Field | Value |
|---|---|
| DB id | `27` |
| External id | `dissues-evo-ui-017` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `9` |
| Parent | `-` - |
| Author | MiddleDuck / - |
| Assignee user id | `1` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 03:46:21` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Повернути термінологію і модель Projects, бо задачі будуть групуватись по модулях/підпроєктах поточного сайту: dDocs, dIssues, dArticles та інші. Work types більше не є правильним основним виміром. Acceptance: таблиця/модель/foreign key/фільтри/форми/переклади знову використовують projects/project_id; demo дані збережені; legacy work_type references відсутні у default UI.
~~~

**Comments / execution log (2)**

- Comment `28` · `2026-05-08 03:53:36` · MiddleDuck · `public`

~~~text
Implemented Projects taxonomy return. Added PRD/SPEC/analysis/QA/report, changed fresh schema to d_issue_projects/project_id, added existing-install migration from d_issue_work_types/work_type_id, replaced dIssueWorkType with dIssueProject, updated evoUI table config, settings, old board prototype, detail view, translations, and tests. Checks passed: php -l, PHPUnit 8 tests/83 assertions, demo migrate, DB schema check, render smoke with Projects and without work_type/SQLSTATE.
~~~

- Comment `105` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-020` — Стабілізувати issue list/detail і rich editor для опису

| Field | Value |
|---|---|
| DB id | `30` |
| External id | `dissues-evo-ui-020` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `10` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 05:53:09` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
List mode має не стрибати по висоті при виборі задачі; active item має використовувати evoUI row-selected як у sArticles; body field у modal має перейти на існуючий evoUI rich editor.\n\nAcceptance:\n- Split list/detail має стабільну висоту з internal scroll.\n- Active issue item не використовує суцільний primary background.\n- Опис задачі редагується через evoUI editor field.\n- Контрактні тести покривають CSS і modal config.
~~~

**Comments / execution log (2)**

- Comment `44` · `2026-05-08 06:05:03` · Codex · `public`

~~~text
Зроблено по флоу PRD/SPEC -> implementation -> tests.\n\nЩо змінив:\n- list/detail отримав стабільну висоту та внутрішній scroll, щоб при перемиканні задач не стрибав верхній layout;\n- active item у списку більше не заливається primary-blue, а використовує спільний evoUI --evo-ui-row-selected як у sArticles table/list;\n- поле опису задачі переведено на rich editor;\n- інтеграцію зроблено як у sArticles: body field має editor_provider, а dIssues provider викликає OnRichTextEditorInit з TinyMCE5 fallback, htmlmixed, height і theme option;\n- detail/preview тепер показує rich HTML опису, а не escaped <p> як текст.\n\nПеревірка:\n- php -l для змінених PHP файлів: OK;\n- PHPUnit: 14 tests, 199 assertions;\n- self-review: 9/10.\n\nСтатус: Ready to test.
~~~

- Comment `108` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-022` — Уніфікувати issue split list зі стандартним evoUI list

| Field | Value |
|---|---|
| DB id | `32` |
| External id | `dissues-evo-ui-022` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `11` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 06:10:23` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Issue split list зараз виглядає як злиплий feed з border-bottom. Треба привести його до evoUI/sArticles list стандарту: окремі cards з gap, border, radius і selected row token.\n\nAcceptance:\n- list pane використовує gap між item cards;\n- item має border/radius/background як evoUI list item;\n- не використовує border-bottom як розділювач;\n- active state лишається --evo-ui-row-selected.
~~~

**Comments / execution log (5)**

- Comment `46` · `2026-05-08 06:12:34` · Codex · `public`

~~~text
Зроблено.\n\nЩо змінив:\n- issue split list більше не рендериться як злиплий feed;\n- list pane тепер grid з gap і невеликим внутрішнім padding;\n- issue item отримав evoUI list-card стиль: border, radius, control background, hover border/background;\n- border-bottom divider прибрано;\n- active state лишився на --evo-ui-row-selected.\n\nПеревірка:\n- php -l: OK;\n- PHPUnit: 16 tests, 224 assertions;\n- demo CSS через symlink показує нові list-card правила.\n\nSelf-review: 9/10.\nСтатус: Ready to test.
~~~

- Comment `48` · `2026-05-08 06:21:46` · Codex · `public`

~~~text
Hotfix після browser review: list pane стискав cards у тонкі рядки. Причина — fixed-height pane + shrink поведінка елементів.\n\nВиправив:\n- pane лишив flex column з gap;\n- issue item отримав flex: 0 0 auto;\n- додав min-height: 96px, щоб cards скролились, а не стискались;\n- projects лишаються, work types не повертав.\n\nПеревірка: PHPUnit 16 tests, 227 assertions; demo CSS через symlink містить нові правила.
~~~

- Comment `49` · `2026-05-08 06:29:13` · Codex · `public`

~~~text
Другий hotfix по split list: прибрав окремий overlay/frame навколо list/detail, прибрав fixed height і внутрішній scroll. Тепер використовується scroll всієї manager-сторінки, list cards лишаються evoUI/sArticles-style, Projects не чіпав. Перевірка: PHPUnit 16 tests / 229 assertions.
~~~

- Comment `52` · `2026-05-08 06:37:51` · Codex · `public`

~~~text
Hotfix по стрибку при перемиканні issue: причина була в wire:loading progress, який був звичайним flex-child над toolbar і додавав/прибирав висоту. Переніс progress в absolute layer всередині .evo-ui-issue-workspace, тепер він не впливає на layout. Перевірка: PHPUnit 16 tests / 231 assertions; demo CSS symlink віддає position:absolute.
~~~

- Comment `110` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-roadmap-001` — Stabilize local issue board UI in Evolution manager

| Field | Value |
|---|---|
| DB id | `1` |
| External id | `dissues-roadmap-001` |
| Project | `dissues` / dIssues |
| Component group | `roadmap` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `12` |
| Parent | `-` - |
| Author | admin / d@evo.im |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-07 20:07:38` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Verify the Issues tab in the real Evolution manager, clean up evoUI class mismatches, and make create/list/kanban/detail flows comfortable for repeated admin use.
~~~

**Comments / execution log (3)**

- Comment `1` · `2026-05-07 20:07:38` · MiddleDuck · `public`

~~~text
Started with the first Livewire/evoUI board scaffold. Needs browser pass in manager.
~~~

- Comment `47` · `2026-05-08 06:17:28` · Codex · `public`

~~~text
Recheck виконано перед переносом зі статусу In progress.\n\nПоточна перевірка:\n- PHP lint для src/database/tests: OK;\n- PHPUnit: 16 tests, 224 assertions;\n- shell smoke: workspace=yes, board=no, settings-form=yes;\n- workflow statuses лишаються canonical: Backlog, Decomposition, In progress, Ready to test, Blocked, Closed.\n\nФактично задача вже була реалізована в артефактах, але в адмінці лишалась In progress. Переніс у Ready to test і поставив у кінець колонки.
~~~

- Comment `79` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-roadmap-003` — Use Evolution manager users for assignment and filtering

| Field | Value |
|---|---|
| DB id | `3` |
| External id | `dissues-roadmap-003` |
| Project | `dissues` / dIssues |
| Component group | `roadmap` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `13` |
| Parent | `-` - |
| Author | admin / d@evo.im |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-07 20:07:38` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Assignments must use system manager users from evo_users/evo_user_attributes so each user can filter and work with their own tasks.
~~~

**Comments / execution log (3)**

- Comment `3` · `2026-05-07 20:07:38` · MiddleDuck · `public`

~~~text
MiddleDuck demo user was created and assignment fields use manager internalKey.
~~~

- Comment `53` · `2026-05-08 06:58:48` · Codex · `public`

~~~text
Зроблено по flow. PRD/SPEC/ANALYSIS/QA/REPORT додані в docs/tasks/dissues-manager-users-003.\n\nЩо змінив:\n- mine filters у workspace/table/legacy board більше не leak-ять задачі без mgrInternalKey;\n- assignMyself не перетирає assignee в null, якщо manager session не готова;\n- createLocalIssue приймає assignee_user_id;\n- додано ManagerUserAssignmentContractTest, який фіксує UserAttribute/mgrInternalKey/no custom dIssues users contract.\n\nПеревірка: PHP lint pass, PHPUnit 19 tests / 272 assertions. Self review: 9/10. Перевів у Ready to test.
~~~

- Comment `81` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-006` — Зібрати Issue Detail conversation surface

| Field | Value |
|---|---|
| DB id | `16` |
| External id | `dissues-evo-ui-006` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `16` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
З bird issues/show/comments переносимо поведінку: перший коментар як опис задачі, наступні коментарі як thread, assign myself/unassign, reply, reply and close, reopen.

Acceptance:
- Detail показує author, assignee, category, status, created/updated.
- Reply створює d_issue_comments і переводить open -> in_progress.
- Reply and close ставить closed і solved_at.
- Reopen ставить in_progress і призначає поточного manager user.
~~~

**Comments / execution log (4)**

- Comment `16` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `54` · `2026-05-08 07:02:34` · Codex · `public`

~~~text
Починаю виконання по flow: PRD/SPEC/analysis -> implementation -> verification -> tests -> self review -> Ready to test. Scope: provider-driven conversation surface у evoUI IssueWorkspace, без Eloquent напряму у UI.
~~~

- Comment `55` · `2026-05-08 07:08:34` · Codex · `public`

~~~text
Зроблено по flow. PRD/SPEC/ANALYSIS/QA/REPORT додані в docs/tasks/dissues-conversation-016.\n\nЩо реалізовано:\n- provider-driven conversation у evoUI IssueWorkspace;\n- list detail і kanban preview показують description, metadata, comments thread;\n- додано actions: assign myself, reply, reply and close, close, reopen;\n- reply створює d_issue_comments і переводить open task в in_progress;\n- reply and close створює comment, ставить closed і solved_at;\n- reopen ставить in_progress, очищає solved_at і призначає поточного manager user якщо є;\n- додано evoUI CSS і переклади uk/en/pl/de/fr;\n- додано IssueConversationContractTest.\n\nПеревірка: PHP lint pass, PHPUnit 23 tests / 346 assertions, demo CSS symlink містить conversation styles. Self review: 9/10. Перевів у Ready to test.
~~~

- Comment `94` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-archive-042` — Додати archive toggle/view перед List/Kanban

| Field | Value |
|---|---|
| DB id | `42` |
| External id | `dissues-archive-042` |
| Project | `dissues` / dIssues |
| Component group | `archive` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `17` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:25:35` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Потрібен перемикач Active / Archive перед List/Kanban, щоб менеджер міг перейти до архівних задач і бачити їх окремо.

Acceptance:
- У toolbar перед display toggle є archive mode toggle.
- Active mode показує тільки неархівні задачі.
- Archive mode показує тільки archived tasks.
- Для archive mode kanban або замінюється на table/list, або має зрозумілий read-only режим.
- Archive mode state зберігається в session.
- У archive view є restore action.
- UI не ламає поточні фільтри project/category/status/assignee/search.
- Є tests і browser/demo перевірка.
~~~

**Comments / execution log (2)**

- Comment `171` · `2026-05-09 02:15:42` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `174` · `2026-05-09 02:16:09` · MiddleDuck · `public`

~~~text
Implemented active/archive workspace toggle before List/Kanban. Added PRD/SPEC/ANALYSIS/QA/REPORT, evoUI setArchive/archiveModes state, config, labels, and unit coverage. Full unit suite and demo smoke are green.
~~~

#### `dissues-evo-ui-007` — Оформити dIssues IssuesProvider контракт

| Field | Value |
|---|---|
| DB id | `17` |
| External id | `dissues-evo-ui-007` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `18` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Потрібен provider між evoUI issue workspace і dIssues моделями: filters, statuses, categories, projects, assignees, listRows, kanbanLanes, issueDetail, comments, reply, assign, close, reopen, sort.

Acceptance:
- UI не знає про dIssue Eloquent напряму.
- Provider підтримує поточного manager user.
- Можна буде підмінити local provider на GitHub/GitLab sync layer.
- Є базові diagnostics для query filters.
~~~

**Comments / execution log (5)**

- Comment `17` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `56` · `2026-05-08 07:10:09` · Codex · `public`

~~~text
Починаю виконання по flow. Важливо: у scope цієї задачі terminology оновлюю на Projects, не work types. Роблю окремий evoUI IssueWorkspaceProvider contract, dIssues local workspace provider його реалізує, додаю diagnostics.
~~~

- Comment `57` · `2026-05-08 07:14:09` · Codex · `public`

~~~text
Зроблено по flow. PRD/SPEC/ANALYSIS/QA/REPORT додані в docs/tasks/dissues-provider-contract-017.\n\nЩо реалізовано:\n- додано EvoUI\Contracts\IssueWorkspaceProvider;\n- EvoUI IssueWorkspace тепер приймає тільки provider, який реалізує цей контракт;\n- dIssues IssuesWorkspaceData implements IssueWorkspaceProvider;\n- додано provider methods: projects, listRows, issueDetail, comments, diagnostics;\n- Projects terminology залишена, work types не повертав;\n- додано IssueWorkspaceProviderContractTest.\n\nПеревірка: PHP lint pass, PHPUnit 26 tests / 388 assertions. Self review: 9/10. Перевів у Ready to test.
~~~

- Comment `58` · `2026-05-08 07:15:45` · Codex · `public`

~~~text
Data cleanup після review: roadmap задачі dIssues помилково висіли на project dDocs. Переніс усі поточні issue records з project dDocs на project dIssues. Сам project dDocs лишив у довіднику для майбутніх модулів, але поточна дошка dIssues тепер показує правильний badge.
~~~

- Comment `95` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-archive-043` — Додати bulk archive для Closed lane

| Field | Value |
|---|---|
| DB id | `43` |
| External id | `dissues-archive-043` |
| Project | `dissues` / dIssues |
| Component group | `archive` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `19` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:25:35` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Коли у Closed назбирається багато задач, архівувати по одній буде незручно. Потрібна компактна дія для масового архіву закритих задач.

Acceptance:
- У Closed lane/list є selection або lane action для archive selected/all closed visible.
- Дія має confirmation і не чіпає не-closed задачі.
- Після archive картки зникають з active board без стрибків layout.
- Counts оновлюються коректно.
- Soft archive можна відновити з archive view.
- Є tests на bulk action і UI contract.
~~~

**Comments / execution log (2)**

- Comment `172` · `2026-05-09 02:15:42` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `186` · `2026-05-09 02:24:31` · MiddleDuck · `public`

~~~text
Implemented bulk archive for Closed lane. Note: this was completed before we corrected the workflow discipline; future tasks will go Backlog -> Decomposition -> In progress -> Ready to test. Full unit suite and demo smoke are green.
~~~

#### `dissues-evo-ui-008` — Розширити settings: керування статусами

| Field | Value |
|---|---|
| DB id | `18` |
| External id | `dissues-evo-ui-008` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `20` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
У налаштуваннях dIssues має бути не тільки config form, а CRUD/таблиця статусів: name, key, description, icon, color, position, is_closed, external_map.

Acceptance:
- Statuses редагуються з адмінки.
- Неможливо видалити статус, який використовується задачами.
- Можна позначити status as closed.
- Порядок статусів керує порядком kanban lanes.
~~~

**Comments / execution log (4)**

- Comment `18` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `59` · `2026-05-08 07:27:21` · Codex · `internal`

~~~text
Взяв задачу в роботу. Починаю PRD/SPEC для CRUD статусів у settings, Projects лишаються основною таксономією.
~~~

- Comment `60` · `2026-05-08 07:35:56` · Codex · `internal`

~~~text
Готово по флоу: PRD/SPEC/analysis додані; реалізовано evoUI settings table для керування статусами; додано provider із CRUD, guard на видалення статусів з задачами, reorder по position; підключено labels uk/en/pl/de/fr. Перевірка: php -l pass, PHPUnit targeted 4 tests / 171 assertions, full unit suite 30 tests / 559 assertions. Самооцінка 8.5/10. Переношу в Ready to test.
~~~

- Comment `96` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-009` — Розширити settings: керування категоріями

| Field | Value |
|---|---|
| DB id | `19` |
| External id | `dissues-evo-ui-009` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `21` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
У налаштуваннях dIssues потрібен CRUD категорій: name, key, description, icon, color, position, external_map. Категорії це business label задачі, не work type.

Acceptance:
- Categories редагуються в окремій вкладці/section.
- Delete guard блокує категорії з задачами.
- Category badge у list/kanban/detail використовує налаштований колір.
- Є seed значення Bug/Feature/Support.
~~~

**Comments / execution log (4)**

- Comment `19` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `61` · `2026-05-08 07:44:17` · Codex · `internal`

~~~text
Взяв задачу в роботу. Роблю PRD/SPEC і реалізацію CRUD категорій у settings на evoUI ModuleTable, за аналогією зі статусами.
~~~

- Comment `62` · `2026-05-08 07:50:01` · Codex · `internal`

~~~text
Готово по флоу: PRD/SPEC/analysis додані; реалізовано evoUI settings table для керування категоріями; додано provider із CRUD, guard на видалення категорій з задачами, reorder по position; підключено labels uk/en/pl/de/fr. Перевірка: php -l pass, PHPUnit targeted 5 tests / 146 assertions, full unit suite 35 tests / 705 assertions. Самооцінка 8.5/10. Переношу в Ready to test.
~~~

- Comment `97` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-010` — Розширити settings: керування проєктами

| Field | Value |
|---|---|
| DB id | `20` |
| External id | `dissues-evo-ui-010` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `22` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
У налаштуваннях dIssues потрібен CRUD Projects: name, key, description, icon, color, position, external_map. Projects тут означають модулі/напрямки робіт всередині поточного Evolution CMS project, наприклад dIssues, dDocs, sArticles, інтеграції тощо. Це не work type і не окремий сайт/репозиторій.\n\nAcceptance:\n- Projects редагуються в settings.\n- Delete guard блокує проєкти, які використовуються задачами.\n- Project доступний у create/edit issue та фільтрах.\n- Project badge у list/kanban/detail використовує налаштований колір.\n- У коді/текстах не лишається work type terminology.
~~~

**Comments / execution log (5)**

- Comment `20` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `51` · `2026-05-08 06:32:31` · Codex · `public`

~~~text
Перейменував задачу з work types на Projects settings. Поточна модель dIssues: Projects лишаємо як модулі/напрямки робіт, work type terminology більше не використовуємо.
~~~

- Comment `63` · `2026-05-08 07:51:31` · Codex · `internal`

~~~text
Взяв задачу в роботу. Роблю PRD/SPEC і реалізацію CRUD Projects у settings. Projects лишаються модулями/напрямками робіт, не work types.
~~~

- Comment `64` · `2026-05-08 07:56:57` · Codex · `internal`

~~~text
Готово по флоу: PRD/SPEC/analysis додані; реалізовано evoUI settings table для керування Projects; додано external_map у schema/model/migration/demo DB; додано provider із CRUD, guard на видалення проєктів з задачами, reorder по position; підключено labels uk/en/pl/de/fr. Перевірка: php -l pass, PHPUnit targeted 6 tests / 159 assertions, full unit suite 41 tests / 864 assertions. Самооцінка 8.5/10. Переношу в Ready to test.
~~~

- Comment `98` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-011` — Додати evoUI color picker field

| Field | Value |
|---|---|
| DB id | `21` |
| External id | `dissues-evo-ui-011` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `23` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Замість класів badge як у sArticles/aArticles треба справжній color picker. Реалізувати field type=color-picker/color у evoUI для Form, ModuleTable modal, repeater/config-map де потрібно.

Acceptance:
- Є input type=color + text hex input + swatch preview.
- Значення валідується як #RRGGBB.
- Працює в dark/light themes.
- Поле доступне і в config form, і в module modal fields.
~~~

**Comments / execution log (4)**

- Comment `21` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `65` · `2026-05-08 07:59:49` · Codex · `internal`

~~~text
Взяв задачу в роботу. Роблю PRD/SPEC і реалізацію evoUI color/color-picker field для config form та ModuleTable modal fields.
~~~

- Comment `66` · `2026-05-08 08:05:25` · Codex · `internal`

~~~text
Готово по флоу: PRD/SPEC/analysis додані; реалізовано evoUI color/color-picker field для config form, config-map item fields, ModuleTable modal fields і modal repeater fields; додано CSS picker/text/swatch; dIssues taxonomy settings переведені на color-picker з #RRGGBB validation; providers маплять legacy badge classes у hex для modalData. Перевірка: php -l pass, PHPUnit targeted 5 tests / 58 assertions, full unit suite 46 tests / 922 assertions. Самооцінка 8.5/10. Переношу в Ready to test.
~~~

- Comment `99` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-012` — Додати evoUI badge з dynamic hex color

| Field | Value |
|---|---|
| DB id | `22` |
| External id | `dissues-evo-ui-012` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `24` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Коли taxonomy зберігає hex color, evoUI має рендерити badge/chip з inline CSS variables, а не з hardcoded badge classes.

Acceptance:
- Badge підтримує value label + color hex.
- Foreground readable через color-mix або contrast helper.
- Працює в table/list/kanban/detail.
- Старі class-based badge values не ламаються.
~~~

**Comments / execution log (4)**

- Comment `22` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `67` · `2026-05-08 08:15:33` · Codex · `public`

~~~text
Берусь у роботу за workflow: PRD -> SPEC -> analysis -> implementation -> verification -> unit tests -> self-review.
~~~

- Comment `68` · `2026-05-08 08:31:36` · Codex · `public`

~~~text
Готово. PRD/SPEC/ANALYSIS/QA/REPORT додані. Виправив Blade parse error у evoUI issue workspace: inline @php(...) замінено на коректний @php/@endphp. Додав shared evoUI badge component з dynamic hex color через CSS variable/color-mix, підключив у ModuleTable cell/list, dIssues issue rows тепер віддають status/category label+icon+color+legacy class fallback. Перевірка: render issue-workspace без unexpected endif, compiled Blade lint OK, PHPUnit full suite OK: 50 tests / 957 assertions. Self-score: 9/10.
~~~

- Comment `100` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-023` — Зберігати issue workspace UI state у session як sArticles

| Field | Value |
|---|---|
| DB id | `33` |
| External id | `dissues-evo-ui-023` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `25` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 06:14:11` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Після reload dIssues issue workspace скидає інтерфейсні налаштування: display list/kanban, filters, search, assignee scope, selected issue. Треба перенести ту саму логіку session persistence, яка вже є в evoUI ModuleTable/sArticles.\n\nReference:\n- evoUI ModuleTable::mount() викликає restoreSessionState();\n- ModuleTable::updated()/actions викликають dispatchClientState();\n- storageKey() будується від preset/context;\n- persistedState() містить search/page/perPage/filters/sort/direction/view;\n- restoreSessionState() санітизує дані і не перебиває explicit request state.\n\nAcceptance:\n- IssueWorkspace має storageKey аналогічний module-table, але з issue-workspace namespace;\n- зберігає filters: category_ids, status_ids, assignee, display, search;\n- відновлює display list/kanban після reload;\n- відновлює selectedIssueId якщо задача ще доступна, інакше fallback штатний;\n- всі set/apply/switch/select/reset methods персистять state;\n- resetFilters очищає session state до default;\n- тести покривають contract і sanitize invalid values.
~~~

**Comments / execution log (3)**

- Comment `69` · `2026-05-08 08:38:31` · Codex · `public`

~~~text
Берусь у роботу: виправляю session persistence для issue workspace за патерном sArticles/evoUI ModuleTable.
~~~

- Comment `70` · `2026-05-08 08:44:30` · Codex · `public`

~~~text
Готово. Додав session persistence для evoUI IssueWorkspace як у ModuleTable: storageKey/persistedState/restoreSessionState/dispatchClientState, persist після зміни filters/display/search/selected issue, reset пише defaults. normalizeFilters більше не скидає selectedIssueId під час restore. Тести: 51 tests / 992 assertions, render issue-workspace OK.
~~~

- Comment `111` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-013` — Міграція taxonomy colors з class на hex

| Field | Value |
|---|---|
| DB id | `23` |
| External id | `dissues-evo-ui-013` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `26` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Поточні d_issue_statuses/categories/work_types мають color як CSS class. Треба привести до hex color, залишивши backward compatibility або окреме поле color_class якщо знадобиться.

Acceptance:
- Seed data має hex colors.
- Старі записи badge badge-* мігрують у приблизні hex.
- Моделі/провайдери повертають label/color/icon.
- UI не показує сирі CSS class значення.

Диви а давай юзати нові кольори  • OKLCH  вони ж більш цікаві  і в цілому нам би evoUI перевести на цю кольорову палітру вона тоді буде більш насичена + дасть можливості юзати більш цікаві речі з кольорами
~~~

**Comments / execution log (4)**

- Comment `23` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `72` · `2026-05-08 08:45:10` · Codex · `public`

~~~text
Переніс у In progress як просту локальну/підготовчу задачу без GitHub/GitLab інтеграційного шару.
~~~

- Comment `77` · `2026-05-08 08:54:26` · Codex · `public`

~~~text
Готово: taxonomy colors переведені з legacy badge classes на hex. Додав compatibility migration, оновив fresh/alignment/project migrations, settings providers тепер віддають dynamic badge payload, demo DB оновлено. Перевірка: targeted PHPUnit 3 tests / 57 assertions, full unit suite 54 tests / 1049 assertions. Self-score: 9/10.
~~~

- Comment `101` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-014` — Звірити візуал dIssues з sArticles і bird

| Field | Value |
|---|---|
| DB id | `24` |
| External id | `dissues-evo-ui-014` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `27` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Після workspace/kanban/list/detail зробити browser QA: поруч sArticles list, bird reference screenshots, dIssues у Evo manager.

Acceptance:
- Toolbar щільний як у sArticles, не hero/form screen.
- Kanban читається як bird.
- Detail/reply flow не розвалює Evo manager frame.
- Немає SQLSTATE/unstyled inputs/oversized headings.
~~~

**Comments / execution log (4)**

- Comment `24` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `73` · `2026-05-08 08:45:10` · Codex · `public`

~~~text
Переніс у In progress як просту локальну/підготовчу задачу без GitHub/GitLab інтеграційного шару.
~~~

- Comment `78` · `2026-05-08 09:09:08` · Codex · `public`

~~~text
Готово по visual QA contract: перевірив workspace проти sArticles/evoUI очікувань. Покрито toolbar, multi-choice filters, icon-only toggles, kanban статусні акценти, selected state, split-list без fixed height/inner scroll. Перевірка: IssueWorkspaceContractTest 9 tests / 186 assertions, full unit suite 54 tests / 1049 assertions. Browser smoke actual module URL блокується demo fixture: у evo_site_modules зараз 0 rows, тому прямий module URL дає Evolution alert No record found; це виніс у #26 demo/smoke. Self-score: 8/10.
~~~

- Comment `102` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-evo-ui-016` — Наповнити demo задачами і smoke diagnostics

| Field | Value |
|---|---|
| DB id | `26` |
| External id | `dissues-evo-ui-016` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `30` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["roadmap","evoUI","bird-reference"] |
| External URL | - |
| Created | `2026-05-07 20:24:32` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Підтримувати demo дані для реальної роботи з модулем: MiddleDuck user, roadmap issues, коментарі, статуси, кольори, позиції. Додати просту команду/README smoke для перевірки provider render.

Acceptance:
- Demo має задачі для поточного roadmap.
- Кожна задача має статус/категорію/work type/assignee.
- Є короткий smoke сценарій: package discover, cache clear, migrate, render shell.
- Повторний запуск не дублює задачі.
~~~

**Comments / execution log (4)**

- Comment `26` · `2026-05-07 20:24:32` · MiddleDuck · `internal`

~~~text
Task created from fresh comparison of sArticles new Livewire/evoUI layer, evoUI internals, and bird issues reference.
~~~

- Comment `74` · `2026-05-08 08:45:10` · Codex · `public`

~~~text
Переніс у In progress як просту локальну/підготовчу задачу без GitHub/GitLab інтеграційного шару.
~~~

- Comment `104` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `113` · `2026-05-08 09:17:58` · Codex · `public`

~~~text
Готово: додав scripts/demo-seed.php для idempotent roadmap seed і scripts/demo-smoke.php для package/view/migrate/seed/HTTP manager render smoke. README оновлено. Важливий нюанс: dIssues це file-module через registerModule, тому прямий URL використовує md5(label), для української це md5(Задачі), а не numeric site_modules id. Перевірка: repeated seed 34 issues / 112 comments без дублів, smoke OK, targeted PHPUnit 2 tests / 21 assertions, full unit suite 56 tests / 1070 assertions. Self-score: 9/10.
~~~

#### `dissues-evo-ui-019` — Показувати фото Evolution manager user на issue cards

| Field | Value |
|---|---|
| DB id | `29` |
| External id | `dissues-evo-ui-019` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `31` |
| Parent | `-` - |
| Author | admin / - |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 05:31:21` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Якщо в Evolution manager user заповнене фото, dIssues має показувати avatar image на картці задачі, у preview/detail і в conversation surface. Якщо фото немає або файл недоступний, лишаємо initials fallback. Потрібно брати фото з системних користувачів Evolution, не вводити окрему user-модель dIssues.
~~~

**Comments / execution log (4)**

- Comment `39` · `2026-05-08 05:31:21` · MiddleDuck · `internal`

~~~text
Створено за фідбеком: користувачам додані фото в Evolution manager, dIssues має використовувати їх як avatar замість initials там, де фото існує.
~~~

- Comment `75` · `2026-05-08 08:45:10` · Codex · `public`

~~~text
Переніс у In progress як просту локальну/підготовчу задачу без GitHub/GitLab інтеграційного шару.
~~~

- Comment `107` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `114` · `2026-05-08 09:29:13` · Codex · `public`

~~~text
Готово: dIssues тепер бере Evolution manager user photo з evo_user_attributes.photo і передає avatar_url у assignee/author/comment payload. evoUI issue workspace рендерить img на kanban/list cards, detail/preview person meta і comments, fallback лишився initials/icons. Перевірка: targeted PHPUnit 4 tests / 59 assertions, manager HTTP render містить avatar image, image asset 200, full unit suite 57 tests / 1088 assertions. Self-score: 9/10.
~~~

#### `dissues-evo-ui-024` — Переробити rich editor integration точно як у sArticles

| Field | Value |
|---|---|
| DB id | `34` |
| External id | `dissues-evo-ui-024` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `32` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 06:25:06` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Поточний body editor у dIssues підключений недостатньо коректно. Треба ще раз звірити sArticles flow і зробити dIssues/evoUI інтеграцію так само: provider method, editor options/theme, init timing у modal, sync before save, correct height, no broken TinyMCE/manager skin.\n\nReference:\n- sArticles config/tags/table.php editor_provider tagTextEditorHtml;\n- sArticles Tables/TagsTableData::tagTextEditorHtml();\n- sArticlesController::textEditor();\n- evoUI ModuleTable::modalEditorHtml();\n- evoUI modal-field editor rendering.\n\nAcceptance:\n- dIssues issue body editor initializes in manager modal like sArticles;\n- content saves through syncRichEditors before save;\n- editor height/theme/options match sArticles conventions;\n- detail preview safely renders rich HTML;\n- tests cover config/provider and rendered editor contract;\n- browser check confirms editor appears and saves.
~~~

**Comments / execution log (4)**

- Comment `76` · `2026-05-08 08:45:10` · Codex · `public`

~~~text
Переніс у In progress як просту локальну/підготовчу задачу без GitHub/GitLab інтеграційного шару.
~~~

- Comment `112` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `115` · `2026-05-08 09:48:52` · Codex · `public`

~~~text
PRD/SPEC/analysis оновлено. Реалізовано sArticles-style rich editor flow для issue body: поле модалки rows=18, height=560px, editor_switcher=false, provider issueTextEditorHtml; provider тепер делегує у textEditor() з configuredEditor() і tinymce5Theme(), як у sArticles. evoUI syncRichEditors контракт перевірений тестами. Перевірки: php -l OK, IssueWorkspaceContractTest OK (9/199), full unit suite OK (57/1101), demo-smoke OK, manager render HTTP 200 без Evolution CMS Parse Error. Self-score: 9/10. Переведено в Ready to test.
~~~

- Comment `157` · `2026-05-08 18:53:33` · MiddleDuck · `public`

~~~text
Доробив реальний body edit surface у issue detail/preview: dTui editor тепер видно не тільки в абстрактному modal provider, а в основному workspace UI. Tests/smoke/browser check OK.
~~~

#### `dissues-roadmap-010` — Add focused tests for models, migrations, and provider mapping

| Field | Value |
|---|---|
| DB id | `10` |
| External id | `dissues-roadmap-010` |
| Project | `dissues` / dIssues |
| Component group | `roadmap` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `33` |
| Parent | `-` - |
| Author | admin / d@evo.im |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-07 20:07:38` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Cover core model relations, migration shape, provider mapping, assignment filtering, and status transitions with lightweight automated checks.
~~~

**Comments / execution log (4)**

- Comment `10` · `2026-05-07 20:07:38` · MiddleDuck · `public`

~~~text
Testing starts after the first UI pass confirms the contract.
~~~

- Comment `71` · `2026-05-08 08:45:10` · Codex · `public`

~~~text
Переніс у In progress як просту локальну/підготовчу задачу без GitHub/GitLab інтеграційного шару.
~~~

- Comment `88` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `116` · `2026-05-08 09:53:37` · Codex · `public`

~~~text
PRD/SPEC/analysis створено у docs/tasks/dissues-tests-010. Додано focused unit test IssueCoreContractTest: моделі/relations/casts, migration schema + workflow seed statuses, provider mapping, LocalProvider contract, assignment filters, status transitions і solved_at. Перевірки: php -l OK, targeted IssueCoreContractTest OK (4/91), full unit suite OK (61/1192), demo-smoke OK. Self-score: 9/10. Переведено в Ready to test.
~~~

#### `dissues-evo-ui-018` — Перевести evoUI colors на OKLCH palette

| Field | Value |
|---|---|
| DB id | `28` |
| External id | `dissues-evo-ui-018` |
| Project | `dissues` / dIssues |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `34` |
| Parent | `-` - |
| Author | MiddleDuck / - |
| Assignee user id | `1` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 03:46:21` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Окрема задача для evoUI: перевести колірну систему на OKLCH palette, щоб отримати стабільніші light/dark токени, badge/status кольори і майбутній color picker без привʼязки до старих class-only кольорів. Acceptance: визначена OKLCH palette, CSS tokens оновлені, backwards-compatible aliases збережені де потрібно, dIssues badges/settings можуть використовувати нові tokens.
~~~

**Comments / execution log (2)**

- Comment `106` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `118` · `2026-05-08 10:16:04` · Codex · `public`

~~~text
PRD/SPEC/analysis виконано. evoUI theme palette переведено на OKLCH, derived colors переведено на color-mix(in oklch), hardcoded CSS hex/rgb прибрано з evo-ui.css, ManagerContext::themeBackground() тепер повертає OKLCH. Додано EvoUiOklchPaletteContractTest, оновлено badge/color-picker тести. Перевірки: targeted OK (11/109), full unit suite OK (63/1220), demo-smoke OK, Playwright reload manager Issues tab OK. Self-score: 9/10. Переведено в Ready to test.
~~~

#### `dissues-roadmap-008` — Design client-facing task/chat surface

| Field | Value |
|---|---|
| DB id | `8` |
| External id | `dissues-roadmap-008` |
| Project | `dissues` / dIssues |
| Component group | `roadmap` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `35` |
| Parent | `-` - |
| Author | admin / d@evo.im |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-07 20:07:38` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Create a client-friendly interface so clients can submit tasks, see progress, and talk in the task thread instead of using email.
~~~

**Comments / execution log (4)**

- Comment `8` · `2026-05-07 20:07:38` · MiddleDuck · `public`

~~~text
Manager-side task model should settle before exposing the client surface.
~~~

- Comment `86` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `117` · `2026-05-08 10:07:39` · Codex · `public`

~~~text
Переніс у In progress після kanban drag/drop фіксу: Playwright drag для #28 підтвердив, що count оновлюється і empty placeholder ховається; #8 виставлено у In progress для наступного виконання по флоу.
~~~

- Comment `119` · `2026-05-08 10:32:56` · Codex · `public`

~~~text
Готово по #8. Зробив PRD/SPEC/analysis, додав client surface `/dissues/client`: email-gated list/create/detail/comment, frontend routes, controller, standalone views, глобальну реєстрацію views/translations поза manager mode, переклади EN/UK/UA/PL/DE/FR і contract tests. Перевірка: php -l OK, ClientIssueSurfaceContractTest OK (5 tests / 223 assertions), повний Unit suite OK (68 tests / 1443 assertions), demo-smoke OK, frontend GET `/dissues/client?email=client@example.com` після redirect дає HTTP 200. Самооцінка 8.5/10; перевів у Ready to test.
~~~

#### `dissues-roadmap-004` — Build settings for providers and sync behavior

| Field | Value |
|---|---|
| DB id | `4` |
| External id | `dissues-roadmap-004` |
| Project | `dissues` / dIssues |
| Component group | `roadmap` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `36` |
| Parent | `-` - |
| Author | admin / d@evo.im |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-07 20:07:38` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Finish Settings tab for provider toggles, default provider, pull limits, comment push, status push, and later secure token references.
~~~

**Comments / execution log (4)**

- Comment `4` · `2026-05-07 20:07:38` · MiddleDuck · `public`

~~~text
Current settings form is the shell; next step is provider-specific configuration.
~~~

- Comment `82` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `120` · `2026-05-08 10:33:53` · Codex · `public`

~~~text
Взяв #4 у роботу. Роблю саме settings/config boundary для provider/sync: без реальної GitHub/GitLab інтеграції, щоб не чіпати беклогові provider tasks.
~~~

- Comment `121` · `2026-05-08 10:38:19` · Codex · `public`

~~~text
Готово по #4. Зробив PRD/SPEC/analysis, додав canonical providers map для GitHub/GitLab, repository/project references, token_setting references без raw token, лишив старі general.github_on/gitlab_on для сумісності, додав helper-и providerSettings/enabledProviders/defaultProvider/syncSettings/syncFlag, переклади EN/UK/UA/PL/DE/FR і ProviderSettingsContractTest. Перевірка: php -l OK, ProviderSettingsContractTest OK (4 tests / 152 assertions), повний Unit suite OK (72 tests / 1595 assertions), demo-smoke OK. Самооцінка 9/10; перевів у Ready to test.
~~~

#### `dissues-unkeyed-035` — Переробити assignee filter на multi-user фільтр

| Field | Value |
|---|---|
| DB id | `35` |
| External id | `-` |
| Project | `dissues` / dIssues |
| Component group | `unkeyed/imported` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `37` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `-` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:25:35` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Замість вузького перемикача All / Mine / Unassigned потрібен нормальний evoUI multi-choice фільтр по Evolution manager users.

Acceptance:
- У фільтрах issues є multi-select по користувачах системи.
- Можна вибрати кількох assignee одночасно.
- Є стани All і Unassigned без конфлікту з multi-select.
- Фільтр працює однаково для kanban/list/table data.
- Стан фільтра зберігається в session разом з workspace state.
- Немає окремої моделі users у dIssues, використовуємо manager users.
- Є переклади EN/UK/UA/PL/DE/FR і contract tests.
~~~

**Comments / execution log (3)**

- Comment `122` · `2026-05-08 15:29:28` · Codex · `public`

~~~text
Перевів #35 у Decomposition. Починаю PRD/SPEC/subtasks по multi-user assignee фільтру перед реалізацією.
~~~

- Comment `123` · `2026-05-08 15:31:23` · Codex · `public`

~~~text
PRD/SPEC/subtasks готові. Перевів #35 у In progress і почав реалізацію multi-user assignee filter.
~~~

- Comment `124` · `2026-05-08 15:36:02` · Codex · `public`

~~~text
Готово по #35. Зробив PRD/SPEC/subtasks, реалізував standard multi-choice assignee filter: додав `assignee_ids` state в evoUI, замінив segmented All/Mine/Unassigned на multi-filter dropdown, підключив Evolution manager users з `UserAttribute`, додав `Unassigned` sentinel -1, фільтрацію по кількох assignee_user_id і session persistence. Перевірка: php -l OK, targeted contracts OK (18 tests / 382 assertions), full unit suite OK (73 tests / 1619 assertions), demo-smoke OK на активному server 127.0.0.1:8788. Самооцінка 9/10; перевів у Ready to test.
~~~

#### `dissues-unkeyed-036` — Винести reusable rich editor adapter в evoUI і реально підключити issue body editor

| Field | Value |
|---|---|
| DB id | `36` |
| External id | `-` |
| Project | `dissues` / dIssues |
| Component group | `unkeyed/imported` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `38` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `-` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:25:35` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Поточний editor виглядає як заявлений, але фактично не працює як системний rich editor у dIssues. Треба винести логіку з sArticles у reusable evoUI adapter і підключити її до issue body create/edit flow.

Acceptance:
- Проаналізовано sArticles rich editor flow і повторено коректний lifecycle в evoUI.
- evoUI має reusable rich editor adapter/sync API для modal/livewire форм.
- dIssues issue body використовує системний editor, а не простий textarea/fake editor.
- Перед save виконується sync editor content у Livewire/model.
- Працює вставка/завантаження зображень так, як у системному editor.
- Старі напівпідключені місця прибрані або переведені на adapter.
- Є unit/contract tests і demo перевірка.
~~~

**Comments / execution log (5)**

- Comment `125` · `2026-05-08 15:38:16` · Codex · `public`

~~~text
Перевів #36 у Decomposition. Починаю аналіз sArticles rich editor flow + evoUI adapter contract перед реалізацією.
~~~

- Comment `126` · `2026-05-08 15:40:22` · Codex · `public`

~~~text
PRD/SPEC/subtasks готові. Перевів #36 у In progress і почав виносити rich editor init у reusable evoUI adapter.
~~~

- Comment `127` · `2026-05-08 15:43:21` · Codex · `public`

~~~text
Готово по #36. Зробив PRD/SPEC/subtasks, додав `EvoUI\\Support\\RichTextEditor`, переніс `OnRichTextEditorInit/Register` handling у evoUI support, переключив `ModuleTable` fallback і dIssues issue body editor на shared adapter, прибрав дубльовані dIssues `textEditor/configuredEditor` helper-и. Перевірка: php -l OK, IssueWorkspaceContractTest OK (9 tests / 226 assertions), full unit suite OK (73 tests / 1629 assertions), demo-smoke OK. Самооцінка 9/10; перевів у Ready to test.
~~~

- Comment `155` · `2026-05-08 18:35:46` · MiddleDuck · `public`

~~~text
Повернув задачу в In progress: фактично adapter був, але dIssues не вибирав dTuiEditor за замовчуванням, тому редактор не було видно як очікувалось. Доробляю default/config/settings/reply flow.
~~~

- Comment `156` · `2026-05-08 18:53:33` · MiddleDuck · `public`

~~~text
Regression fixed: dIssues тепер явно використовує dTuiEditor у general settings/workspace config; issue detail має inline body editor через evoUI RichTextEditor; Playwright підтвердив dTui для issueBodyDraft і replyBody. Tests: phpunit Unit OK, demo-smoke OK.
~~~

#### `dissues-unkeyed-037` — Додати rich editor у reply/comment composer

| Field | Value |
|---|---|
| DB id | `37` |
| External id | `-` |
| Project | `dissues` / dIssues |
| Component group | `unkeyed/imported` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `41` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `-` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:25:35` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Відповідь на задачу зараз textarea, але для реальної роботи потрібен той самий системний rich editor, щоб можна було вставляти картинки і форматований текст.

Acceptance:
- Reply composer у issue detail/preview використовує evoUI rich editor adapter.
- Reply, reply and close, public/internal future states синхронізують editor перед action.
- Коментарі рендеряться безпечно як HTML з дозволеного editor output.
- Після успішної відповіді editor очищується без завислого state.
- Працює у list/detail і kanban preview режимах.
- Є contract tests і browser/demo перевірка.
~~~

**Comments / execution log (4)**

- Comment `128` · `2026-05-08 15:43:52` · Codex · `public`

~~~text
Перевів #37 у Decomposition. Роблю PRD/SPEC для rich editor у reply/comment composer на базі нового evoUI RichTextEditor adapter.
~~~

- Comment `129` · `2026-05-08 15:44:54` · Codex · `public`

~~~text
PRD/SPEC/subtasks готові. Перевів #37 у In progress і почав підключати rich editor у reply composer.
~~~

- Comment `130` · `2026-05-08 15:55:07` · MiddleDuck · `public`

~~~text
Implemented reply/comment rich editor integration. Added evoUI replyEditorHtml fallback/provider hook, rich editor fields for list/detail and kanban preview replies, JS sync+clear helper, safe rich HTML output for links/images/tables, dIssues provider bridge to system editor config, workspace config, PRD/SPEC/ANALYSIS/QA/REPORT updates, and unit contract coverage. Verification passed: PHP lint, JS check, targeted unit tests, full unit suite, and demo smoke on 127.0.0.1:8788. Status moved to Ready to test.
~~~

- Comment `158` · `2026-05-08 18:53:33` · MiddleDuck · `public`

~~~text
Reply composer тепер отримує editor з workspace config і піднімає dTuiEditor. Browser check confirmed replyBody rich editor. Tests/smoke OK.
~~~

#### `dissues-unkeyed-038` — Зробити повний assignment UX: assign to me, assign user, unassign

| Field | Value |
|---|---|
| DB id | `38` |
| External id | `-` |
| Project | `dissues` / dIssues |
| Component group | `unkeyed/imported` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `42` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `-` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:25:35` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Зараз неочевидно як призначити задачу на себе і немає нормального способу призначити її на іншого користувача.

Acceptance:
- У detail/header є зрозумілий control для assignee.
- Можна assign to me одним кліком.
- Можна вибрати іншого Evolution manager user зі списку.
- Можна unassign задачу.
- Зміна assignee оновлює card/list/detail без ручного reload.
- Provider/workspace має метод assignIssue(issueId, userId|null).
- Є права/guard для відсутньої manager session.
- Є переклади і tests.
~~~

**Comments / execution log (3)**

- Comment `131` · `2026-05-08 15:57:03` · MiddleDuck · `public`

~~~text
Moved to Decomposition. PRD/SPEC/ANALYSIS created for full assignment UX: assign to me, assign selected Evolution manager user, and unassign directly from the issue workspace without opening the edit modal.
~~~

- Comment `132` · `2026-05-08 15:57:58` · MiddleDuck · `public`

~~~text
Moved to In progress. Implementing provider assignment actions, compact assignment dropdown in issue detail/preview, contract tests, and smoke verification.
~~~

- Comment `133` · `2026-05-08 16:03:43` · MiddleDuck · `public`

~~~text
Implemented full assignment UX. Added provider contract methods assignIssue/unassignIssue, dIssues validation against Evolution manager users, compact assignment dropdown in list/detail and kanban preview, unassign action, wire target updates, evoUI option styling, PRD/SPEC/ANALYSIS/QA/REPORT updates, and unit coverage. Verification passed: PHP lint, JS check, targeted contracts, full unit suite, and demo smoke on 127.0.0.1:8788. Status moved to Ready to test.
~~~

#### `dissues-unkeyed-039` — Почистити issue detail meta: прибрати дубль MiddleDuck і пояснити дати

| Field | Value |
|---|---|
| DB id | `39` |
| External id | `-` |
| Project | `dissues` / dIssues |
| Component group | `unkeyed/imported` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `43` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `-` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:25:35` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
У detail meta зараз MiddleDuck може показуватись двічі без пояснення, а created/updated чіпи незрозумілі. Треба зробити metadata осмисленою.

Acceptance:
- Author і assignee не дублюються як два однакові безіменні chips.
- Якщо показуємо обох, вони мають label/tooltip/icon: author/requester vs assignee.
- Якщо author == assignee, UI показує це компактно без повтору.
- Created/updated мають явні labels/tooltips або updated ховається, коли він не несе сенсу.
- Порядок meta chips стабільний: id/status/project/category/assignee/dates/comments.
- Вигляд узгоджений з evoUI/sArticles.
- Є tests на payload і view contract.
~~~

**Comments / execution log (3)**

- Comment `134` · `2026-05-08 16:04:22` · MiddleDuck · `public`

~~~text
Moved to Decomposition. Preparing PRD/SPEC for cleaning issue detail meta: avoid duplicated manager chips and clarify created/updated dates.
~~~

- Comment `135` · `2026-05-08 16:05:02` · MiddleDuck · `public`

~~~text
Moved to In progress. Implementing duplicate author/assignee guard and explicit created/updated date labels in issue detail metadata.
~~~

- Comment `136` · `2026-05-08 16:07:06` · MiddleDuck · `public`

~~~text
Implemented issue detail meta cleanup. Author chip is now hidden when it duplicates the assignee, remains visible for unassigned/different-author cases, and created/updated timestamps now have visible translated labels. Verification passed: targeted workspace contract, full unit suite, and demo smoke on 127.0.0.1:8788. Status moved to Ready to test.
~~~

#### `dissues-unkeyed-040` — Додати reply-to-comment flow для коментарів

| Field | Value |
|---|---|
| DB id | `40` |
| External id | `-` |
| Project | `dissues` / dIssues |
| Component group | `unkeyed/imported` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `44` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `-` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:25:35` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
У коментарях потрібна можливість відповісти саме на конкретний коментар, а не тільки додати загальну відповідь у кінець треду.

Acceptance:
- У comment model/schema є parent_comment_id або інший стабільний reply reference.
- Біля коментаря є дія/checkbox Reply to this comment.
- Composer показує, на який коментар відповідаємо, і дозволяє скинути target.
- Відповідь зберігається з parent reference.
- UI відображає reply context/nesting компактно й читабельно.
- Provider contract не ламає зовнішні інтеграції.
- Є migration, tests і demo seed coverage.
~~~

**Comments / execution log (3)**

- Comment `137` · `2026-05-08 16:07:59` · MiddleDuck · `public`

~~~text
Moved to Decomposition. Preparing PRD/SPEC for reply-to-comment: parent comment link, reply target state, cancel action, and rich editor composer reuse.
~~~

- Comment `138` · `2026-05-08 16:08:43` · MiddleDuck · `public`

~~~text
Moved to In progress. Implementing parent comment storage, reply target state, comment reply action, context banner, and tests.
~~~

- Comment `139` · `2026-05-08 16:16:10` · MiddleDuck · `public`

~~~text
Implemented reply-to-comment flow. Added parent_id storage, comment parent relation, provider parent validation, reply target state, cancel action, per-comment reply buttons, parent context rendering, rich editor composer context banner, translations, PRD/SPEC/ANALYSIS/QA/REPORT updates, and contract tests. Verification passed: PHP lint, targeted contracts, full unit suite, and demo smoke on 127.0.0.1:8788. Status moved to Ready to test.
~~~

#### `dissues-unkeyed-045` — Перебудувати Settings UI на окремі вкладки Основне / Синхронізація / Категорії / Статуси / Проєкти

| Field | Value |
|---|---|
| DB id | `45` |
| External id | `-` |
| Project | `dissues` / dIssues |
| Component group | `unkeyed/imported` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `45` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `-` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:27:38` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Зараз налаштування taxonomy фактично зроблені як окремі table configs, але Settings UI не має коректної структури вкладок. Потрібно розділити налаштування так, як очікується в модулі: основні речі окремо, sync окремо, taxonomy CRUD окремими tabs.

Acceptance:
- У вкладці Налаштування є tabs: Основне, Синхронізація, Категорії, Статуси, Проєкти.
- Основне містить тільки базові feature/manager settings.
- Синхронізація містить тільки provider/sync settings.
- Категорії/Статуси/Проєкти відкривають свої evoUI table surfaces.
- Перемикання tabs не ламає ModulePanel і не скидає активний settings tab без потреби.
- Патерн узгоджений із новою частиною sArticles.
- Є переклади EN/UK/UA/PL/DE/FR і contract tests.
~~~

**Comments / execution log (3)**

- Comment `140` · `2026-05-08 17:03:10` · MiddleDuck · `public`

~~~text
Moved to Decomposition. Preparing PRD/SPEC for rebuilding Settings UI into separate tabs: General, Sync, Categories, Statuses, Projects.
~~~

- Comment `141` · `2026-05-08 17:03:54` · MiddleDuck · `public`

~~~text
Moved to In progress. Implementing nested settings tabs, split General/Sync form presets, conditional taxonomy table rendering, and contract tests.
~~~

- Comment `142` · `2026-05-08 17:17:23` · MiddleDuck · `public`

~~~text
Implemented Settings tabs split: General and Sync now render separate evoUI form presets; Categories, Statuses, and Projects render as dedicated evoUI table preset tabs. Added UA/EN/PL/DE/FR labels, unit coverage, fixed runtime Blade/config issues found by smoke. Verification: phpunit tests/Unit OK (76 tests, 1774 assertions), demo smoke OK on 127.0.0.1:8788.
~~~

#### `dissues-unkeyed-046` — Підключити taxonomy tables у Settings tabs через evoUI table presets

| Field | Value |
|---|---|
| DB id | `46` |
| External id | `-` |
| Project | `dissues` / dIssues |
| Component group | `unkeyed/imported` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `46` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `-` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:27:38` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Потрібно не просто мати config/settings/categories.php, statuses.php, projects.php, а реально відрендерити ці таблиці у відповідних вкладках Settings.

Acceptance:
- Tab Категорії рендерить preset `dissues.settings.categories`.
- Tab Статуси рендерить preset `dissues.settings.statuses`.
- Tab Проєкти рендерить preset `dissues.settings.projects`.
- Кнопки create/edit/delete/reorder/search/list-table view працюють у кожній таблиці.
- Таблиці не відображаються в загальному settings form.
- Livewire/evoUI state кожної таблиці ізольований, щоб tabs не конфліктували.
- Є unit/contract tests на ModulePanel/settings preset routing.
~~~

**Comments / execution log (3)**

- Comment `143` · `2026-05-08 17:18:36` · MiddleDuck · `public`

~~~text
Moved to Decomposition. I will verify taxonomy table tabs as a separate acceptance slice after #45 split the Settings shell.
~~~

- Comment `144` · `2026-05-08 17:19:37` · MiddleDuck · `public`

~~~text
PRD/SPEC/Analysis prepared. Moving to In progress: adding a focused regression contract around the dynamic taxonomy table surface, then running phpunit and smoke.
~~~

- Comment `145` · `2026-05-08 17:23:03` · MiddleDuck · `public`

~~~text
Ready to test. Taxonomy table tabs are connected through the dynamic evoUI table surface from #45, and #46 now adds focused regression coverage for that contract. Verified: focused taxonomy/settings suite OK (20 tests, 521 assertions), full unit suite OK (77 tests, 1782 assertions), demo smoke OK.
~~~

#### `dissues-unkeyed-047` — Увімкнути double-click edit modal для taxonomy tables

| Field | Value |
|---|---|
| DB id | `47` |
| External id | `-` |
| Project | `dissues` / dIssues |
| Component group | `unkeyed/imported` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `47` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `-` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:27:38` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
У taxonomy таблицях double-click по рядку має відкривати edit modal, як очікується для evoUI table UX. Зараз у configs row_dblclick вимкнений.

Acceptance:
- Projects, Statuses, Categories table configs мають `modal.row_dblclick = true` або еквівалентну поведінку.
- Double-click по row відкриває edit modal для вибраного запису.
- Single click/selection не ламається.
- Row actions edit/delete продовжують працювати.
- Поведінка однакова для table view і не шкодить list view.
- Є contract test і browser/demo перевірка.
~~~

**Comments / execution log (3)**

- Comment `146` · `2026-05-08 17:23:33` · MiddleDuck · `public`

~~~text
Moved to Decomposition. Scope: enable row double-click edit behavior for Categories, Statuses, and Projects taxonomy tables and cover it with unit contracts.
~~~

- Comment `147` · `2026-05-08 17:24:45` · MiddleDuck · `public`

~~~text
PRD/SPEC/Analysis ready. Moving to In progress and applying the sArticles/evoUI row_dblclick contract to Categories, Statuses, and Projects.
~~~

- Comment `148` · `2026-05-08 17:33:53` · MiddleDuck · `public`

~~~text
Ready to test. Enabled modal.row_dblclick for Categories, Statuses, and Projects settings tables using existing evoUI row behavior. Also aligned local demo package/runtime naming to EvoUi/evo-ui for the first release. Verification: focused taxonomy suite OK (15 tests, 485 assertions), full unit suite OK (77 tests, 1788 assertions), demo smoke OK.
~~~

#### `dissues-unkeyed-048` — Довести taxonomy table columns і modal fields до повного settings contract

| Field | Value |
|---|---|
| DB id | `48` |
| External id | `-` |
| Project | `dissues` / dIssues |
| Component group | `unkeyed/imported` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `48` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `-` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:27:38` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
У Категоріях/Статусах/Проєктах у таблиці й модалці мають бути всі потрібні поля, щоб це було повноцінне керування taxonomy, а не частковий список.

Acceptance:
- Projects table/modal: name, key, description, icon, color picker, position, external_map, issues_count.
- Statuses table/modal: name, key, description, icon, color picker, position, is_closed, external_map, issues_count.
- Categories table/modal: name, key, description, icon, color picker, position, external_map, issues_count.
- Dynamic color badge коректно показується у таблиці.
- Delete guard для used taxonomy показує зрозумілу помилку.
- Sort/reorder по position працює для всіх трьох tables.
- Є tests на config schema, provider save/delete/reorder і labels.
~~~

**Comments / execution log (3)**

- Comment `149` · `2026-05-08 17:34:23` · MiddleDuck · `public`

~~~text
Moved to Decomposition. I will audit taxonomy table columns and modal fields for Categories, Statuses, and Projects against the settings contract, then add/fix focused coverage.
~~~

- Comment `150` · `2026-05-08 17:36:02` · MiddleDuck · `public`

~~~text
PRD/SPEC/Analysis prepared mentally from acceptance. Moving to In progress: add description/external map summary columns, provider row data, and evoUI delete guard message support for used taxonomy rows.
~~~

- Comment `151` · `2026-05-08 17:43:44` · MiddleDuck · `public`

~~~text
Done. Full taxonomy settings contract is implemented for categories, statuses, and projects: table/list columns, modal fields, color picker contract, external_map summary, reorder fields, and delete guard messages. evo-ui ModuleTable now keeps guarded delete modal open and shows a translated danger alert. QA: syntax checks OK, focused taxonomy suite OK (17 tests, 537 assertions), full unit suite OK (79 tests, 1840 assertions), demo smoke OK.
~~~

#### `dissues-unkeyed-041` — Додати archive model для closed issues

| Field | Value |
|---|---|
| DB id | `41` |
| External id | `-` |
| Project | `dissues` / dIssues |
| Component group | `unkeyed/imported` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `49` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `-` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:25:35` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Closed tasks не мають вічно висіти на канбані. Потрібен soft archive поверх closed status, щоб закриті задачі можна було сховати, але не втратити.

Acceptance:
- У issues зʼявляються archived_at / archived_by_user_id або еквівалентний soft-archive state.
- Архів доступний тільки для closed задач або має guard/confirmation.
- Archived tasks за замовчуванням не показуються в active kanban/list.
- Дані не видаляються фізично.
- Є action archive і restore на provider/workspace level.
- Міграція працює для існуючих install.
- Є tests на schema, query scopes і guards.
~~~

**Comments / execution log (3)**

- Comment `152` · `2026-05-08 17:44:22` · MiddleDuck · `public`

~~~text
Moved to Decomposition. Scope: add archived data contract for closed issues before UI archive toggle/bulk actions.
~~~

- Comment `153` · `2026-05-08 17:47:05` · MiddleDuck · `public`

~~~text
PRD/SPEC/analysis prepared. Moving to In progress: implement archived_at/archived_by_user_id model contract, active/archived scopes, workspace/table archive query modes, and focused tests.
~~~

- Comment `154` · `2026-05-08 18:03:30` · MiddleDuck · `public`

~~~text
Done. Added archive data/model contract for closed issues: archived_at, archived_by_user_id, fresh + compatibility migrations, dIssue active/archived scopes, archive/restore methods, workspace archive/restore provider methods, and default active issue queries with archived/all modes for the next UI tasks. Also corrected local package setup: kept EvoUI namespace and removed temporary version from evo-ui composer. QA: syntax checks OK, full unit suite OK (82 tests, 1874 assertions), demo smoke OK.
~~~

#### `dissues-workflow-049` — Add status phases/steps taxonomy

| Field | Value |
|---|---|
| DB id | `49` |
| External id | `dissues-workflow-049` |
| Project | `dissues` / dIssues |
| Component group | `workflow` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `88` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo","roadmap"] |
| External URL | - |
| Created | `2026-05-09 01:34:12` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Створити configurable phases, які належать status. Це micro-progress усередині Kanban column без автоматизації, sTask, Telegram або AI runtime.

Acceptance:
- Є модель/таблиця phases: status_id, name, key, description, icon, color, position, is_default, is_active.
- У d_issues є nullable phase_id.
- Settings UI має CRUD для phases.
- Phase належить конкретному status і може мати default phase.
- Існуючі задачі без phase_id не ламаються.
~~~

**Comments / execution log (5)**

- Comment `159` · `2026-05-09 01:34:12` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `176` · `2026-05-09 02:24:31` · MiddleDuck · `public`

~~~text
Moved from Backlog to Decomposition as part of the corrected task workflow. This task needs PRD/SPEC/decomposition before implementation.
~~~

- Comment `187` · `2026-05-09 02:25:38` · MiddleDuck · `public`

~~~text
Decomposition: add d_issue_phases schema/model; add nullable d_issues.phase_id; add status->phases and issue->phase relations; add Settings CRUD/reorder; enforce one default active phase per status and unique phase key per status. This is foundation for #50/#56/#57/#52.
~~~

- Comment `198` · `2026-05-09 02:27:06` · MiddleDuck · `public`

~~~text
Moved Decomposition -> In progress. Starting implementation for status phases taxonomy: schema/model, issue phase_id, settings CRUD, default/active guards, and tests.
~~~

- Comment `199` · `2026-05-09 02:52:49` · MiddleDuck · `internal`

~~~text
Implemented status phases taxonomy foundation: schema, additive migration, dIssuePhase model/relations, Settings -> Phases CRUD, multilingual labels, and contract tests. Verification: php -l checks, unit suite 90 tests / 2288 assertions, demo smoke OK. Moved to Ready to test.
~~~

#### `dissues-workflow-050` — Render issue phase in workspace

| Field | Value |
|---|---|
| DB id | `50` |
| External id | `dissues-workflow-050` |
| Project | `dissues` / dIssues |
| Component group | `workflow` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `89` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo","roadmap"] |
| External URL | - |
| Created | `2026-05-09 01:34:12` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Показати phase як маленький chip/badge у Kanban card, split list row і issue detail header.

Acceptance:
- Phase chip показується у card/list/detail, якщо phase задана.
- При зміні status phase скидається на default phase нового status.
- Якщо default phase немає, phase очищається або валідується як належна поточному status.
- UI лишається компактним і не дублює status chip.
~~~

**Comments / execution log (5)**

- Comment `160` · `2026-05-09 01:34:12` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `177` · `2026-05-09 02:24:31` · MiddleDuck · `public`

~~~text
Moved from Backlog to Decomposition as part of the corrected task workflow. This task needs PRD/SPEC/decomposition before implementation.
~~~

- Comment `189` · `2026-05-09 02:25:38` · MiddleDuck · `public`

~~~text
Decomposition: eager-load phase; add compact phase chip to kanban card, split list, detail/preview header; centralize status movement so status changes reset phase to target default or clear invalid phase; validate phase belongs to current status.
~~~

- Comment `202` · `2026-05-09 03:00:13` · MiddleDuck · `internal`

~~~text
Moved from Decomposition to In progress. Scope: render phase chip in kanban/list/detail and validate/reset phase when issue status changes.
~~~

- Comment `213` · `2026-05-09 03:10:15` · MiddleDuck · `internal`

~~~text
Implemented phase rendering in Kanban/List/Detail and phase reset validation on status movement. Verification: php -l, IssueWorkspaceContractTest 13 tests / 334 assertions, full unit suite 93 tests / 2339 assertions, demo smoke OK. Moved to Ready to test.
~~~

#### `dissues-workflow-051` — Add responsible manager user to statuses

| Field | Value |
|---|---|
| DB id | `51` |
| External id | `dissues-workflow-051` |
| Project | `dissues` / dIssues |
| Component group | `workflow` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `90` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo","roadmap"] |
| External URL | - |
| Created | `2026-05-09 01:34:12` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Додати owner/responsible manager user для status column.

Acceptance:
- У statuses є owner_user_id/responsible_user_id.
- Settings -> Statuses має select Evolution manager user.
- Kanban lane header показує avatar/initials відповідального за колонку.
- Якщо owner не заданий, lane header лишається акуратним без пустого місця.
~~~

**Comments / execution log (4)**

- Comment `161` · `2026-05-09 01:34:12` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `178` · `2026-05-09 02:24:31` · MiddleDuck · `public`

~~~text
Moved from Backlog to Decomposition as part of the corrected task workflow. This task needs PRD/SPEC/decomposition before implementation.
~~~

- Comment `192` · `2026-05-09 02:25:38` · MiddleDuck · `public`

~~~text
Decomposition: add nullable responsible/owner user id to statuses; add Evolution manager select in Settings -> Statuses; load owner profile in kanbanLanes; render avatar/initials in lane header; hide cleanly when empty or stale.
~~~

- Comment `266` · `2026-05-09 03:48:06` · MiddleDuck · `public`

~~~text
Готово по flow: додано PRD/SPEC/ANALYSIS/QA/REPORT, owner_user_id для statuses у fresh+additive migrations, select Evolution manager user у Settings -> Statuses, owner_label у rows, owner profile payload у kanban lanes і avatar/initials у lane header. Перевірка: PHP lint OK, targeted IssueStatusOwnerContractTest 4/41 OK, full dIssues unit suite 97/2410 OK, canonical demo schema має evo_d_issue_statuses.owner_user_id. Self-review 9/10.
~~~

#### `dissues-workflow-052` — Track issue status and phase history

| Field | Value |
|---|---|
| DB id | `52` |
| External id | `dissues-workflow-052` |
| Project | `dissues` / dIssues |
| Component group | `workflow` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `91` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo","roadmap"] |
| External URL | - |
| Created | `2026-05-09 01:34:12` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Додати історію переходів status/phase, щоб було видно workflow рух задачі.

Acceptance:
- Є transition history table: issue_id, from_status_id, to_status_id, from_phase_id, to_phase_id, user_id, created_at.
- Логуються всі зміни status і phase.
- Provider має метод для читання compact timeline.
- Detail може показати compact timeline без великого audit UI.
- Історія не блокує існуючі задачі без попередніх transitions.
~~~

**Comments / execution log (4)**

- Comment `162` · `2026-05-09 01:34:12` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `179` · `2026-05-09 02:24:31` · MiddleDuck · `public`

~~~text
Moved from Backlog to Decomposition as part of the corrected task workflow. This task needs PRD/SPEC/decomposition before implementation.
~~~

- Comment `190` · `2026-05-09 02:25:38` · MiddleDuck · `public`

~~~text
Decomposition: add transition history table; create shared status/phase transition helper; hook quick transitions, close/reopen, reply-and-close, drag-sort, and modal save; log only real changes; expose compact timeline in detail.
~~~

- Comment `271` · `2026-05-09 04:03:28` · MiddleDuck · `public`

~~~text
Готово по flow: PRD/SPEC/ANALYSIS/QA/REPORT додані; додано d_issue_transitions fresh+additive migration, dIssueTransition model, relation dIssue::transitions(), логування status/phase переходів у kanban drag/status quick actions/close-reopen flow, compact timeline у split detail/modal. Перевірка: PHP lint OK, targeted IssueTransitionHistoryContractTest 4 tests / 75 assertions OK, full dIssues suite 101 tests / 2485 assertions OK, canonical demo schema має evo_d_issue_transitions. Self-review: 9/10.
~~~

#### `dissues-workflow-053` — Add parent/child issue model

| Field | Value |
|---|---|
| DB id | `53` |
| External id | `dissues-workflow-053` |
| Project | `dissues` / dIssues |
| Component group | `workflow` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `92` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo","roadmap"] |
| External URL | - |
| Created | `2026-05-09 01:34:12` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Додати parent/child issues як базу для subtasks.

Acceptance:
- У issues є nullable parent_id.
- Є relations parent/children.
- У detail є Subtasks section.
- Є create child issue action з detail.
- Child list показує status/phase badges.
- Progress parent task може рахувати 2/5 closed.
~~~

**Comments / execution log (5)**

- Comment `163` · `2026-05-09 01:34:12` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `180` · `2026-05-09 02:24:31` · MiddleDuck · `public`

~~~text
Moved from Backlog to Decomposition as part of the corrected task workflow. This task needs PRD/SPEC/decomposition before implementation.
~~~

- Comment `193` · `2026-05-09 02:25:38` · MiddleDuck · `public`

~~~text
Decomposition: add nullable parent_id to issues; add parent/children relations; guard self-parent/cycles; add Subtasks section in detail; create child action with inherited defaults; child remains a normal board issue.
~~~

- Comment `276` · `2026-05-09 04:05:36` · MiddleDuck · `public`

~~~text
Стартую по flow: PRD/SPEC/ANALYSIS/QA, далі реалізація parent_id relations, create child issue action і subtasks section у detail.
~~~

- Comment `291` · `2026-05-09 04:28:40` · MiddleDuck · `public`

~~~text
Готово по flow: PRD/SPEC/ANALYSIS/QA/REPORT додані; реалізовано parent_id на d_issues, dIssue parent()/children(), createChildIssue action, parent row і Subtasks section у split/modal detail, child status/phase chips, переклади EN/UA/PL/DE/FR. Також виправив closure capture для status owner у kanbanLanes. Перевірка: PHP lint OK, IssueParentChildContractTest 4 tests / 77 assertions OK, full unit suite 105 tests / 2563 assertions OK, demo schema має evo_d_issues.parent_id. Self-review: 9/10.
~~~

#### `dissues-workflow-054` — Show subtasks progress on issue cards

| Field | Value |
|---|---|
| DB id | `54` |
| External id | `dissues-workflow-054` |
| Project | `dissues` / dIssues |
| Component group | `workflow` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `93` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo","roadmap"] |
| External URL | - |
| Created | `2026-05-09 01:34:12` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Показувати compact subtasks progress для parent issues.

Acceptance:
- Kanban card показує subtasks counter, якщо children існують.
- Split list row показує такий самий compact counter.
- Detail header/section показує total, closed, open children.
- Closed children визначаються через status.is_closed.
~~~

**Comments / execution log (5)**

- Comment `164` · `2026-05-09 01:34:12` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `181` · `2026-05-09 02:24:31` · MiddleDuck · `public`

~~~text
Moved from Backlog to Decomposition as part of the corrected task workflow. This task needs PRD/SPEC/decomposition before implementation.
~~~

- Comment `194` · `2026-05-09 02:25:38` · MiddleDuck · `public`

~~~text
Decomposition: add children_count and closed children count; render compact subtasks progress on kanban cards and split list only when children exist; detail shows total/open/closed; closed count uses status.is_closed.
~~~

- Comment `292` · `2026-05-09 04:29:06` · MiddleDuck · `public`

~~~text
Стартую по flow: зроблю PRD/SPEC/ANALYSIS/QA, далі provider progress counts для children, UI counters у kanban/list/detail і contract tests.
~~~

- Comment `295` · `2026-05-09 04:32:20` · MiddleDuck · `public`

~~~text
Готово по flow: PRD/SPEC/ANALYSIS/QA/REPORT додані; provider рахує subtasks total/closed/open через children і status.is_closed, UI показує closed/total на kanban card, split list, detail header/modal і Subtasks header. Перевірка: PHP lint OK, IssueSubtaskProgressContractTest 2 tests / 23 assertions OK, full unit suite 107 tests / 2586 assertions OK. Self-review: 9/10.
~~~

#### `dissues-workflow-055` — Add simple status quick transitions

| Field | Value |
|---|---|
| DB id | `55` |
| External id | `dissues-workflow-055` |
| Project | `dissues` / dIssues |
| Component group | `workflow` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `94` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo","roadmap"] |
| External URL | - |
| Created | `2026-05-09 01:34:12` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Додати прості quick transitions для status без workflow engine.

Acceptance:
- У detail actions є move previous / move next за position статусів.
- Кнопки ховаються на першому/останньому статусі.
- Перехід використовує існуючу status update логіку.
- При переході застосовується phase default/validation logic.
- Немає складних rules або guards у цій задачі.
~~~

**Comments / execution log (2)**

- Comment `165` · `2026-05-09 01:34:12` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `170` · `2026-05-09 02:04:07` · MiddleDuck · `public`

~~~text
Implemented simple previous/next status quick transitions. Added PRD/SPEC/ANALYSIS/QA/REPORT, provider actions, evoUI buttons, labels, and tests. Full unit suite and demo smoke are green. Phase default/reset part remains naturally owned by the upcoming phases tasks because phase_id does not exist yet.
~~~

#### `dissues-workflow-056` — Seed default phases for current statuses

| Field | Value |
|---|---|
| DB id | `56` |
| External id | `dissues-workflow-056` |
| Project | `dissues` / dIssues |
| Component group | `workflow` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `95` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo","roadmap"] |
| External URL | - |
| Created | `2026-05-09 01:34:12` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Додати default phase seed для існуючих статусів, щоб demo board одразу показував micro-progress.

Acceptance:
- Для Backlog, Decomposition, In progress, Ready to test, Blocked, Closed є базові phases.
- Є default phase на кожен status.
- Demo seed ідемпотентний.
- Існуючі задачі без phase_id не ламаються.
~~~

**Comments / execution log (5)**

- Comment `166` · `2026-05-09 01:34:12` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `182` · `2026-05-09 02:24:31` · MiddleDuck · `public`

~~~text
Moved from Backlog to Decomposition as part of the corrected task workflow. This task needs PRD/SPEC/decomposition before implementation.
~~~

- Comment `188` · `2026-05-09 02:25:38` · MiddleDuck · `public`

~~~text
Decomposition: seed canonical phases for Backlog, Decomposition, In progress, Ready to test, Blocked, Closed; keep seed idempotent; do not break existing issues without phase_id; add unit contract for default uniqueness and phase ordering.
~~~

- Comment `200` · `2026-05-09 02:52:49` · MiddleDuck · `internal`

~~~text
Moved from Decomposition to In progress. Scope: seed default phases for current statuses without rendering phase chips yet; keep existing issues without phase_id safe.
~~~

- Comment `201` · `2026-05-09 02:59:56` · MiddleDuck · `internal`

~~~text
Implemented default phase seed: additive migration, demo seed idempotent phase upsert, default phase assignment for issues, task docs, and tests. Verification: php -l, unit suite 92 tests / 2316 assertions, demo smoke OK. Moved to Ready to test.
~~~

#### `dissues-workflow-057` — Add phase filter to issue workspace

| Field | Value |
|---|---|
| DB id | `57` |
| External id | `dissues-workflow-057` |
| Project | `dissues` / dIssues |
| Component group | `workflow` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `96` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo","roadmap"] |
| External URL | - |
| Created | `2026-05-09 01:34:12` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Додати optional phase filter у workspace поруч із project/category/status/assignee.

Acceptance:
- Є phase multi-select filter для list і kanban.
- Фільтр може бути загальним або залежним від status, але UI має лишитись простим.
- Фільтр зберігається в session state як інші workspace filters.
- Provider query коректно фільтрує phase_id.
~~~

**Comments / execution log (5)**

- Comment `167` · `2026-05-09 01:34:12` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `183` · `2026-05-09 02:24:31` · MiddleDuck · `public`

~~~text
Moved from Backlog to Decomposition as part of the corrected task workflow. This task needs PRD/SPEC/decomposition before implementation.
~~~

- Comment `191` · `2026-05-09 02:25:38` · MiddleDuck · `public`

~~~text
Decomposition: add phase_ids to workspace filters/session/diagnostics; add provider phases() options; add toolbar multi-select; apply whereIn phase_id; keep null-phase issues visible when filter is clear.
~~~

- Comment `214` · `2026-05-09 03:10:35` · MiddleDuck · `internal`

~~~text
Moved from Decomposition to In progress. Scope: add phase multi-select filter to the workspace and persist it with the existing session state.
~~~

- Comment `246` · `2026-05-09 03:39:24` · MiddleDuck · `public`

~~~text
Готово по flow: додано PRD/SPEC/ANALYSIS/QA/REPORT, phase_ids state у evoUI workspace, provider phases(), phase multi-select dropdown, query filtering by phase_id, diagnostics/session coverage і переклади UA/EN/PL/DE/FR. Перевірка: PHP lint OK, targeted IssueWorkspace+IssuePhase tests 18/612 OK, full dIssues unit suite 93/2369 OK. Self-review 9/10.
~~~

#### `dissues-workflow-058` — Update demo data and smoke diagnostics for phases/subtasks

| Field | Value |
|---|---|
| DB id | `58` |
| External id | `dissues-workflow-058` |
| Project | `dissues` / dIssues |
| Component group | `workflow` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `97` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo","roadmap"] |
| External URL | - |
| Created | `2026-05-09 01:34:12` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Оновити demo data і smoke diagnostics під phases/subtasks/status owners.

Acceptance:
- Demo seed додає parent/child задачі.
- Demo seed додає різні phases і status owners.
- Smoke diagnostics перевіряють phases, owner users, parent_id і transition history.
- Demo board після seed має видимі приклади для Kanban/List/Detail QA.
~~~

**Comments / execution log (5)**

- Comment `168` · `2026-05-09 01:34:12` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `184` · `2026-05-09 02:24:31` · MiddleDuck · `public`

~~~text
Moved from Backlog to Decomposition as part of the corrected task workflow. This task needs PRD/SPEC/decomposition before implementation.
~~~

- Comment `196` · `2026-05-09 02:25:38` · MiddleDuck · `public`

~~~text
Decomposition: after phases/owners/parent-child/history/priority land, extend demo seed with visible examples and smoke diagnostics for phases, owner users, parent_id, history rows and priority distribution. Keep seed idempotent.
~~~

- Comment `299` · `2026-05-09 04:42:05` · MiddleDuck · `public`

~~~text
Стартую по flow: оновлю demo seed і smoke diagnostics під phases/subtasks/status owners/transition history. Seed не запускаю, щоб не зачепити shared board.
~~~

- Comment `305` · `2026-05-09 04:53:00` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Реалізовано demo workflow fixtures: seed тепер знає про d_issue_transitions, status owners, non-default phases, parent/child demo issues і idempotent initial transition history. Unit tests більше не запускають seed напряму, щоб не мутувати shared demo DB. Перевірено: PHP lint OK; DemoSeedSmokeContractTest 2/23 OK; parent/child + transition + owner contracts 12/193 OK; full tests/Unit 111/2639 OK. Статус: Ready to test.
~~~

#### `dissues-workflow-059` — Add priority workflow controls for issues

| Field | Value |
|---|---|
| DB id | `59` |
| External id | `dissues-workflow-059` |
| Project | `dissues` / dIssues |
| Component group | `workflow` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `98` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo","roadmap"] |
| External URL | - |
| Created | `2026-05-09 02:03:28` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Поле priority вже є в d_issues і modal form, але workspace має дати нормальний UI для фільтрації, сортування і відображення пріоритету.

Acceptance:
- Priority показується компактним chip/icon у kanban card, split list і detail header.
- Є priority filter у workspace.
- Є сортування/порядок за priority без ламання position у kanban.
- Demo seed має приклади low/normal/high priority.
- Priority не конфліктує зі status/phase workflow.
~~~

**Comments / execution log (5)**

- Comment `169` · `2026-05-09 02:03:28` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `185` · `2026-05-09 02:24:31` · MiddleDuck · `public`

~~~text
Moved from Backlog to Decomposition as part of the corrected task workflow. This task needs PRD/SPEC/decomposition before implementation.
~~~

- Comment `195` · `2026-05-09 02:25:38` · MiddleDuck · `public`

~~~text
Decomposition: priority field exists; add priority chip/icon to kanban/list/detail; add priority filter and diagnostics; optional list sort by priority; preserve kanban lane position as manual order; seed low/normal/high examples.
~~~

- Comment `296` · `2026-05-09 04:32:59` · MiddleDuck · `public`

~~~text
Стартую по flow: priority filter/chips/list ordering без зміни kanban position, PRD/SPEC/ANALYSIS/QA + tests.
~~~

- Comment `298` · `2026-05-09 04:41:49` · MiddleDuck · `public`

~~~text
Готово по flow: PRD/SPEC/ANALYSIS/QA/REPORT додані; додано priority_ids state, provider priorities(), priority filter, priority chips у kanban/list/detail/modal, list-only priority order high > normal > low без зміни kanban position. Переклади EN/UA/PL/DE/FR. Перевірка: PHP lint OK, IssuePriorityWorkspaceContractTest 4 tests / 49 assertions OK, full unit suite 111 tests / 2635 assertions OK. Self-review: 9/10.
~~~

#### `dissues-ui-060` — Уніфікувати висоту верхніх табів з sArticles

| Field | Value |
|---|---|
| DB id | `91` |
| External id | `dissues-ui-060` |
| Project | `dissues` / dIssues |
| Component group | `ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `99` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["dissues","ui-parity","tabs","evo-ui"] |
| External URL | - |
| Created | `2026-05-09 03:40:42` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Cross-module UI parity task from 2026-05-09 feedback. dIssues top tabs/header height must match sArticles for the same evo-ui shell pattern. Decomposition: inspect sArticles module shell/tab classes, compare dIssues rendered header/tab height, update dIssues shell styling or shared evo-ui usage so the rhythm is identical, then verify in the shared demo. Acceptance: dIssues top tabs have the same height, spacing and placement as sArticles.
~~~

**Comments / execution log (3)**

- Comment `252` · `2026-05-09 03:40:42` · MiddleDuck · `public`

~~~text
Backlog parity task requested while working on sLang.
~~~

- Comment `308` · `2026-05-09 04:54:18` · MiddleDuck · `public`

~~~text
Стартую по коректному flow: decomposition -> PRD/SPEC/ANALYSIS -> implementation -> tests -> Ready to test. Спочатку звірю sArticles/evoUI tab shell і знайду, де dIssues відрізняється по висоті/line-height/padding.
~~~

- Comment `310` · `2026-05-09 05:05:32` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Реалізовано через shared evoUI: додано --evo-ui-nav-tab-height, стабілізовано height/min-height для module tab scroller і tab buttons, dIssues markup лишився сумісним із sArticles. Додано IssueTopTabsContractTest. Перевірено: php -l OK; targeted IssueTopTabsContractTest+ModulePanelTest 7/60 OK; full tests/Unit 113/2654 OK. Статус: Ready to test.
~~~

#### `dissues-ui-061` — Use system Configuration translations in dIssues

| Field | Value |
|---|---|
| DB id | `103` |
| External id | `dissues-ui-061` |
| Project | `dissues` / dIssues |
| Component group | `ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `100` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 04:25:15` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Audit dIssues labels for Settings/Nалаштування/Настройки and replace generic labels with Evolution CMS system translations such as settings_config/edit_settings where they already express Configuration. Keep only dIssues-specific text in module lang files. Acceptance: UI consistently says Configuration/Конфігурація; generic labels are not duplicated in package lang files; browser checks confirm the affected tabs/headings.
~~~

**Comments / execution log (3)**

- Comment `287` · `2026-05-09 04:25:15` · MiddleDuck · `public`

~~~text
Created from shared UI consistency feedback.
~~~

- Comment `311` · `2026-05-09 05:06:09` · MiddleDuck · `public`

~~~text
Стартую decomposition: звірю, де dIssues дублює системний Configuration/Settings label, підготую PRD/SPEC і заміню на стандартний переклад там, де це має бути shared manager wording.
~~~

- Comment `312` · `2026-05-09 05:11:00` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Settings surface тепер використовує системний Evolution label global.settings_config: module tab, ModulePanel title, settings aria-label і settings form title. dIssues-specific child tabs лишились локальними. Додано SystemConfigurationTranslationContractTest. Перевірено: php -l OK; targeted SystemConfigurationTranslationContractTest+ModulePanelTest 6/58 OK; full tests/Unit 114/2667 OK. Статус: Ready to test.
~~~

#### `dissues-ui-062` — Align dIssues font scale with sArticles evo-ui baseline

| Field | Value |
|---|---|
| DB id | `104` |
| External id | `dissues-ui-062` |
| Project | `dissues` / dIssues |
| Component group | `ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `101` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 04:25:15` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Audit dIssues module styles/root classes for font-size drift and align them to the sArticles evo-ui baseline. Acceptance: no module-specific font-size overrides for shared evo-ui surfaces; computed font sizes for tabs, tables, and forms match sArticles; any required fix uses shared evo-ui classes/components instead of ad hoc CSS.
~~~

**Comments / execution log (3)**

- Comment `288` · `2026-05-09 04:25:15` · MiddleDuck · `public`

~~~text
Created from shared UI consistency feedback.
~~~

- Comment `313` · `2026-05-09 05:11:21` · MiddleDuck · `public`

~~~text
Стартую decomposition: перевіряю dIssues issue-workspace font-size проти shared evoUI/sArticles baseline, приберу надмірні локальні масштаби і закріплю contract test.
~~~

- Comment `317` · `2026-05-09 05:15:15` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Font scale перенесено в shared evoUI tokens для issue workspace: page title 20px, card/lane title 14px, split list 13/12px, detail 18/14px. Додано IssueFontScaleContractTest. Перевірено: php -l OK; targeted IssueFontScaleContractTest+IssueTopTabsContractTest 3/29 OK; full tests/Unit 115/2681 OK. Статус: Ready to test.
~~~

#### `dissues-viewport-063` — Спроєктувати viewport-first Issue Workspace layout

| Field | Value |
|---|---|
| DB id | `156` |
| External id | `dissues-viewport-063` |
| Project | `dissues` / dIssues |
| Component group | `viewport` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `630` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["viewport","workspace","evo-ui","performance"] |
| External URL | - |
| Created | `2026-05-09 07:19:25` |
| Updated | `2026-05-09 07:44:08` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Поточний kanban/list може розтягувати всю сторінку, коли в колонках багато задач. Треба зробити workspace як single-page surface, який займає доступну висоту manager viewport.

Acceptance:
- Issues tab не створює довгий page scroll для канбан/list workspace.
- Toolbar зверху лишається компактним і стабільним.
- Kanban area має горизонтальний scroll колонок.
- Кожна kanban lane має власний вертикальний scroll.
- List mode має незалежний scroll для лівого списку і правої detail panel.
- Рішення базується на evoUI tokens/classes, щоб його можна було повторно використати.
~~~

**Comments / execution log (3)**

- Comment `510` · `2026-05-09 07:19:25` · MiddleDuck · `public`

~~~text
Backlog task created from UX discussion: dIssues має поводитись як viewport-first SPA workspace, а не як довга сторінка.
~~~

- Comment `533` · `2026-05-09 07:25:24` · MiddleDuck · `public`

~~~text
Decomposition done: PRD/SPEC/ANALYSIS created. Scope: viewport-first layout contract, kanban horizontal scroll, lane vertical scroll, split list/detail independent scroll. Docs: docs/tasks/dissues-viewport-063/
~~~

- Comment `582` · `2026-05-09 07:44:08` · MiddleDuck · `public`

~~~text
Implemented viewport/lazy workspace slice: fixed-height issue workspace, lazy provider slices with total/loaded/has_more metadata, automatic scroll-triggered loading for kanban lanes and split list, persisted lazy limits in session, hidden technical load-more sentinel, and PHPUnit coverage. Verified: php -l component/provider/config/test, node --check evo-ui.js, demo/core/vendor/bin/phpunit tests/Unit/IssueWorkspaceContractTest.php, demo/core/vendor/bin/phpunit tests/Unit.
~~~

#### `dissues-viewport-064` — Додати provider contract для lazy-loaded issue slices

| Field | Value |
|---|---|
| DB id | `157` |
| External id | `dissues-viewport-064` |
| Project | `dissues` / dIssues |
| Component group | `viewport` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `640` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["pagination","provider","kanban","performance"] |
| External URL | - |
| Created | `2026-05-09 07:19:25` |
| Updated | `2026-05-09 07:44:09` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Зараз workspace отримує повні масиви issues для kanban lanes/list. Для 100+ задач у колонці треба provider-level pagination/slicing.

Acceptance:
- IssueWorkspaceProvider/evoUI має контракт для total count + paged items.
- Kanban lane повертає total count окремо від loaded cards.
- List mode повертає total count і порцію rows.
- Existing non-paged behavior лишається backward-compatible.
- dIssues provider використовує limit/offset або cursor без завантаження всіх задач у PHP collection.
- Tests покривають total vs loaded count.
~~~

**Comments / execution log (3)**

- Comment `511` · `2026-05-09 07:19:25` · MiddleDuck · `public`

~~~text
Backlog task created: перед UI infinite scroll треба винести slice contract на provider/evoUI рівень.
~~~

- Comment `534` · `2026-05-09 07:25:24` · MiddleDuck · `public`

~~~text
Decomposition done: PRD/SPEC/ANALYSIS created. Scope: provider slice contract with total vs loaded counts, backward compatibility, DB-level limit/offset. Docs: docs/tasks/dissues-viewport-064/
~~~

- Comment `583` · `2026-05-09 07:44:08` · MiddleDuck · `public`

~~~text
Implemented viewport/lazy workspace slice: fixed-height issue workspace, lazy provider slices with total/loaded/has_more metadata, automatic scroll-triggered loading for kanban lanes and split list, persisted lazy limits in session, hidden technical load-more sentinel, and PHPUnit coverage. Verified: php -l component/provider/config/test, node --check evo-ui.js, demo/core/vendor/bin/phpunit tests/Unit/IssueWorkspaceContractTest.php, demo/core/vendor/bin/phpunit tests/Unit.
~~~

#### `dissues-viewport-065` — Реалізувати lazy loading kanban cards по lane scroll

| Field | Value |
|---|---|
| DB id | `158` |
| External id | `dissues-viewport-065` |
| Project | `dissues` / dIssues |
| Component group | `viewport` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `650` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["kanban","infinite-scroll","ajax","evo-ui"] |
| External URL | - |
| Created | `2026-05-09 07:19:25` |
| Updated | `2026-05-09 07:44:09` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Kanban має спочатку показувати обмежену кількість карток у кожній колонці, але лічильник має показувати total. При прокрутці lane вниз треба довантажувати наступну порцію cards.

Acceptance:
- Lane header показує total count, не тільки loaded count.
- Початковий render вантажить невелику порцію карток на колонку.
- Scroll донизу lane викликає Livewire/Ajax load more для конкретного status/lane.
- Empty placeholder не лишається над картками після довантаження/drag-drop.
- Drag-sort не ламається для вже завантажених карток.
- Loading state компактний і не стрибає по висоті.
~~~

**Comments / execution log (3)**

- Comment `512` · `2026-05-09 07:19:25` · MiddleDuck · `public`

~~~text
Backlog task created: kanban колонки треба довантажувати по lane scroll, щоб не рендерити 100 карток одразу.
~~~

- Comment `535` · `2026-05-09 07:25:24` · MiddleDuck · `public`

~~~text
Decomposition done: PRD/SPEC/ANALYSIS created. Scope: per-lane kanban lazy loading, load-more on lane scroll, total count remains visible, drag-sort stays stable for loaded cards. Docs: docs/tasks/dissues-viewport-065/
~~~

- Comment `584` · `2026-05-09 07:44:09` · MiddleDuck · `public`

~~~text
Implemented viewport/lazy workspace slice: fixed-height issue workspace, lazy provider slices with total/loaded/has_more metadata, automatic scroll-triggered loading for kanban lanes and split list, persisted lazy limits in session, hidden technical load-more sentinel, and PHPUnit coverage. Verified: php -l component/provider/config/test, node --check evo-ui.js, demo/core/vendor/bin/phpunit tests/Unit/IssueWorkspaceContractTest.php, demo/core/vendor/bin/phpunit tests/Unit.
~~~

#### `dissues-viewport-066` — Реалізувати lazy loading для split list mode

| Field | Value |
|---|---|
| DB id | `159` |
| External id | `dissues-viewport-066` |
| Project | `dissues` / dIssues |
| Component group | `viewport` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `660` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["list","split-pane","infinite-scroll","evo-ui"] |
| External URL | - |
| Created | `2026-05-09 07:19:25` |
| Updated | `2026-05-09 07:44:09` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
List mode має працювати так само viewport-first: лівий список довантажує задачі при прокрутці, права detail panel має власний scroll і не змушує всю сторінку рости.

Acceptance:
- Left list має fixed viewport height і власний scroll.
- Right detail panel має власний scroll для body/comments/history.
- Initial list render вантажить першу порцію задач.
- Scroll донизу списку довантажує наступні задачі.
- Selected issue не скидається без потреби при load more.
- Перемикання list/kanban не стрибає по висоті.
~~~

**Comments / execution log (3)**

- Comment `513` · `2026-05-09 07:19:25` · MiddleDuck · `public`

~~~text
Backlog task created: split list теж має бути SPA-style surface з lazy loading.
~~~

- Comment `536` · `2026-05-09 07:25:24` · MiddleDuck · `public`

~~~text
Decomposition done: PRD/SPEC/ANALYSIS created. Scope: split list lazy loading, independent list/detail scroll, selected issue stability. Docs: docs/tasks/dissues-viewport-066/
~~~

- Comment `585` · `2026-05-09 07:44:09` · MiddleDuck · `public`

~~~text
Implemented viewport/lazy workspace slice: fixed-height issue workspace, lazy provider slices with total/loaded/has_more metadata, automatic scroll-triggered loading for kanban lanes and split list, persisted lazy limits in session, hidden technical load-more sentinel, and PHPUnit coverage. Verified: php -l component/provider/config/test, node --check evo-ui.js, demo/core/vendor/bin/phpunit tests/Unit/IssueWorkspaceContractTest.php, demo/core/vendor/bin/phpunit tests/Unit.
~~~

#### `dissues-viewport-067` — Зберігати scroll/load state workspace у session

| Field | Value |
|---|---|
| DB id | `160` |
| External id | `dissues-viewport-067` |
| Project | `dissues` / dIssues |
| Component group | `viewport` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `670` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["scroll-state","session","ux","evo-ui"] |
| External URL | - |
| Created | `2026-05-09 07:19:25` |
| Updated | `2026-05-09 07:44:09` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Після reload або перемикання вкладок UI має пам'ятати не тільки filters/display, але й практичний workspace state: selected issue, loaded pages/slices і бажано scroll position.

Acceptance:
- Existing session state не ламається.
- Workspace пам'ятає display/filter/search/archive як зараз.
- Для kanban можна відновити loaded lane pages або безпечно повернутись до first page без UI стрибка.
- Для list можна відновити selected issue і достатню кількість rows, щоб вибрана задача була видима.
- State key лишається scoped per preset/context.
~~~

**Comments / execution log (3)**

- Comment `514` · `2026-05-09 07:19:25` · MiddleDuck · `public`

~~~text
Backlog task created: lazy loading має дружити з уже реалізованим session state.
~~~

- Comment `537` · `2026-05-09 07:25:24` · MiddleDuck · `public`

~~~text
Decomposition done: PRD/SPEC/ANALYSIS created. Scope: persist lazy loaded pages/state in session, restore selected issue, reset stale state on filter changes. Docs: docs/tasks/dissues-viewport-067/
~~~

- Comment `586` · `2026-05-09 07:44:09` · MiddleDuck · `public`

~~~text
Implemented viewport/lazy workspace slice: fixed-height issue workspace, lazy provider slices with total/loaded/has_more metadata, automatic scroll-triggered loading for kanban lanes and split list, persisted lazy limits in session, hidden technical load-more sentinel, and PHPUnit coverage. Verified: php -l component/provider/config/test, node --check evo-ui.js, demo/core/vendor/bin/phpunit tests/Unit/IssueWorkspaceContractTest.php, demo/core/vendor/bin/phpunit tests/Unit.
~~~

#### `dissues-viewport-068` — Полірувати hidden-scroll UI для kanban/list panes

| Field | Value |
|---|---|
| DB id | `161` |
| External id | `dissues-viewport-068` |
| Project | `dissues` / dIssues |
| Component group | `viewport` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `680` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["scrollbar","visual","evo-ui","sarticles"] |
| External URL | - |
| Created | `2026-05-09 07:19:25` |
| Updated | `2026-05-09 07:44:09` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Після viewport layout і lazy loading треба акуратно оформити scroll: без зайвого page scrollbar, без жирних системних scrollbar там, де вони візуально заважають, але з доступним scroll behavior.

Acceptance:
- Page scrollbar не з'являється тільки через kanban/list content.
- Lane/list/detail scrollbars можуть бути тонкими або прихованими залежно від evoUI класів.
- UI лишається доступним для wheel/trackpad/keyboard scroll.
- Padding/gap відповідає sArticles/evoUI стилю.
- Немає overlay/border контейнера, який візуально дублює cards/list panels.
~~~

**Comments / execution log (3)**

- Comment `515` · `2026-05-09 07:19:25` · MiddleDuck · `public`

~~~text
Backlog task created: окремий візуальний polish після основної lazy-load логіки.
~~~

- Comment `538` · `2026-05-09 07:25:24` · MiddleDuck · `public`

~~~text
Decomposition done: PRD/SPEC/ANALYSIS created. Scope: hidden/thin scroll polish, remove noisy wrappers, align spacing with sArticles/evoUI. Docs: docs/tasks/dissues-viewport-068/
~~~

- Comment `587` · `2026-05-09 07:44:09` · MiddleDuck · `public`

~~~text
Implemented viewport/lazy workspace slice: fixed-height issue workspace, lazy provider slices with total/loaded/has_more metadata, automatic scroll-triggered loading for kanban lanes and split list, persisted lazy limits in session, hidden technical load-more sentinel, and PHPUnit coverage. Verified: php -l component/provider/config/test, node --check evo-ui.js, demo/core/vendor/bin/phpunit tests/Unit/IssueWorkspaceContractTest.php, demo/core/vendor/bin/phpunit tests/Unit.
~~~

#### `dissues-viewport-069` — Додати tests/smoke для viewport lazy workspace

| Field | Value |
|---|---|
| DB id | `162` |
| External id | `dissues-viewport-069` |
| Project | `dissues` / dIssues |
| Component group | `viewport` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `690` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["qa","tests","smoke","performance"] |
| External URL | - |
| Created | `2026-05-09 07:19:25` |
| Updated | `2026-05-09 07:44:09` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Потрібні contract tests і demo smoke, щоб lazy workspace не регресив при наступних змінах evoUI/dIssues.

Acceptance:
- Unit/contract tests перевіряють provider pagination API.
- Tests перевіряють total count окремо від loaded count.
- Tests перевіряють session state для lazy workspace.
- Demo data має lane з 100+ задачами для smoke.
- Browser smoke перевіряє: нема page scroll overflow, lane scroll існує, load more додає cards.
- Документація описує нову модель lazy loading.
~~~

**Comments / execution log (3)**

- Comment `516` · `2026-05-09 07:19:25` · MiddleDuck · `public`

~~~text
Backlog task created: окрема QA/test задача для viewport-first lazy workspace пакету.
~~~

- Comment `539` · `2026-05-09 07:25:24` · MiddleDuck · `public`

~~~text
Decomposition done: PRD/SPEC/ANALYSIS created. Scope: tests and browser smoke for provider slices, total vs loaded counts, viewport containment, lane/list load more. Docs: docs/tasks/dissues-viewport-069/
~~~

- Comment `588` · `2026-05-09 07:44:09` · MiddleDuck · `public`

~~~text
Implemented viewport/lazy workspace slice: fixed-height issue workspace, lazy provider slices with total/loaded/has_more metadata, automatic scroll-triggered loading for kanban lanes and split list, persisted lazy limits in session, hidden technical load-more sentinel, and PHPUnit coverage. Verified: php -l component/provider/config/test, node --check evo-ui.js, demo/core/vendor/bin/phpunit tests/Unit/IssueWorkspaceContractTest.php, demo/core/vendor/bin/phpunit tests/Unit.
~~~

#### `dissues-ui-070` — Зробити kanban chips компактнішими і менш жирними

| Field | Value |
|---|---|
| DB id | `163` |
| External id | `dissues-ui-070` |
| Project | `dissues` / dIssues |
| Component group | `ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `700` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["ui","kanban","chips","evo-ui"] |
| External URL | - |
| Created | `2026-05-09 07:46:15` |
| Updated | `2026-05-09 07:47:50` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Kanban card chips зараз надто жирні і займають забагато місця. Треба зробити їх трохи меншими та легшими саме у kanban cards, не змінюючи list/detail chips.

Acceptance:
- Kanban card chips мають менший font-size/min-height/padding.
- Font weight у kanban chips легший.
- Icons у kanban chips зменшені разом з текстом.
- List/detail chips не змінюються глобально.
- Є contract test на scoped kanban CSS.
~~~

**Comments / execution log (3)**

- Comment `589` · `2026-05-09 07:46:15` · MiddleDuck · `public`

~~~text
Task created from UI feedback: kanban card badges/chips should be more compact and less bold.
~~~

- Comment `590` · `2026-05-09 07:46:15` · MiddleDuck · `public`

~~~text
PRD/SPEC/analysis prepared in docs/tasks/dissues-kanban-chip-density-070. Scope is kanban-only CSS density: smaller/lighter chips, icons scaled down, no global list/detail chip changes.
~~~

- Comment `591` · `2026-05-09 07:47:49` · MiddleDuck · `public`

~~~text
Implemented. Kanban card chips now have scoped compact density: 20px min-height, 11px text, lighter 640 weight, smaller 13px icons. Shared list/detail chip defaults remain unchanged. Verified with php -l and PHPUnit: IssueWorkspaceContractTest.php and full tests/Unit.
~~~

#### `dissues-roadmap-009` — Add multilingual polish for manager screens

| Field | Value |
|---|---|
| DB id | `9` |
| External id | `dissues-roadmap-009` |
| Project | `dissues` / dIssues |
| Component group | `roadmap` |
| Status | `blocked` / Blocked |
| Category | `support` / Support |
| Priority | `normal` |
| Phase | `blocked` / Blocked |
| Position | `0` |
| Parent | `-` - |
| Author | admin / d@evo.im |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-07 20:07:38` |
| Updated | `2026-05-09 04:41:17` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Keep labels translated in EN, UA/UK, PL, DE, and FR as the UI grows. Avoid hardcoded English in Blade/config where possible.
~~~

**Comments / execution log (2)**

- Comment `9` · `2026-05-07 20:07:38` · MiddleDuck · `public`

~~~text
Initial language files exist; future UI additions need translation keys immediately.
~~~

- Comment `87` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-roadmap-002` — Superseded: Projects taxonomy stays

| Field | Value |
|---|---|
| DB id | `2` |
| External id | `dissues-roadmap-002` |
| Project | `dissues` / dIssues |
| Component group | `roadmap` |
| Status | `closed` / Closed |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `done` / Done |
| Position | `0` |
| Parent | `-` - |
| Author | admin / d@evo.im |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-07 20:07:38` |
| Updated | `2026-05-09 04:41:17` |
| Solved | `2026-05-08 10:06:32` |
| Archived | `-` |

**Task statement / body**

~~~text
Стара задача про work types більше неактуальна. Поточна модель dIssues лишає Projects як основну таксономію для модулів/напрямків робіт всередині поточного Evolution CMS project. Реалізація повернення Projects вже зроблена в #27.
~~~

**Comments / execution log (3)**

- Comment `2` · `2026-05-07 20:07:38` · MiddleDuck · `public`

~~~text
Project concept was renamed to work type and demo DB was migrated.
~~~

- Comment `50` · `2026-05-08 06:31:30` · Codex · `public`

~~~text
Закрив як superseded: work type більше не робимо. Projects лишаємо, бо це підтверджена модель; повернення Projects вже виконано в #27 і покрито ProjectTaxonomyContractTest.
~~~

- Comment `80` · `2026-05-08 09:15:10` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

#### `dissues-qa-044` — Провести ручний QA Ready-to-test задач і рознести regressions

| Field | Value |
|---|---|
| DB id | `44` |
| External id | `dissues-qa-044` |
| Project | `dissues` / dIssues |
| Component group | `qa` |
| Status | `closed` / Closed |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `done` / Done |
| Position | `1` |
| Parent | `-` - |
| Author | Codex / - |
| Assignee user id | `2` |
| Labels | - |
| External URL | - |
| Created | `2026-05-08 15:25:35` |
| Updated | `2026-05-09 06:44:45` |
| Solved | `2026-05-09 06:44:45` |
| Archived | `-` |

**Task statement / body**

~~~text
Після великої серії ready-to-test задач потрібен окремий QA pass: пройти UI як користувач, звірити з sArticles/bird, і все, що не приймається, повернути в Backlog/Decomposition як конкретні corrective tasks.

Acceptance:
- Перевірені основні сценарії: create/edit/list/kanban/detail/comments/settings/client portal.
- Для кожної rejected ready-to-test задачі додано коментар, чому не прийнято.
- Неякісні або неповні задачі не лишаються без пояснення в Ready to test.
- Нові regressions оформлені окремими задачами.
- Є короткий QA report у docs/tasks.
- Unit/demo smoke прогнані після сортування.
~~~

**Comments / execution log (3)**

- Comment `173` · `2026-05-09 02:15:42` · MiddleDuck · `public`

~~~text
Demo seed keeps this roadmap task available for manager smoke checks.
~~~

- Comment `175` · `2026-05-09 02:24:31` · MiddleDuck · `public`

~~~text
Moved from Backlog to Decomposition as part of the corrected task workflow. This task needs PRD/SPEC/decomposition before implementation.
~~~

- Comment `197` · `2026-05-09 02:25:38` · MiddleDuck · `public`

~~~text
Decomposition: manual QA should run after current ready-to-test pack. Check kanban/list, filters, archive toggle, closed bulk archive, reload/session, labels. Do not fix regressions here; create scoped regression tasks.
~~~

## Project `ddocs` — dDocs

- Tasks: **26**
- Statuses: `backlog` 2, `in_progress` 2, `ready_to_test` 22
- Categories: `bug` 3, `feature` 20, `support` 3
- Priorities: `high` 14, `low` 2, `normal` 10
- Component groups: `ddocs` 20, `milestones` 6

### Task index

| Task | Group | Status | Category | Priority | Phase | Comments | Title |
|---|---|---|---|---|---|---:|---|
| `ddocs-019` | `ddocs` | `backlog` | `bug` | `high` | `new` | 1 | Restrict package docs discovery to Evo and Extras packages |
| `ddocs-020` | `ddocs` | `backlog` | `support` | `normal` | `new` | 1 | Add nested three-level dDocs demo documentation |
| `ddocs-017` | `ddocs` | `in_progress` | `bug` | `high` | `implementation` | 2 | Fix dDocs manager translation labels in demo |
| `ddocs-018` | `ddocs` | `in_progress` | `bug` | `high` | `implementation` | 2 | Start docs tree collapsed and add real collapse action |
| `ddocs-m1` | `milestones` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Milestone 1: Module opens |
| `ddocs-m2` | `milestones` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Milestone 2: Discovery and language |
| `ddocs-m3` | `milestones` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Milestone 3: Tree and viewer |
| `ddocs-m4` | `milestones` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Milestone 4: Search and links |
| `ddocs-m5` | `milestones` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Milestone 5: Config, cache, diagnostics, polish |
| `ddocs-m6` | `milestones` | `ready_to_test` | `support` | `low` | `tests` | 5 | Milestone 6: Future design only |
| `ddocs-001` | `ddocs` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Create dDocs package skeleton |
| `ddocs-002` | `ddocs` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Add evo-ui manager shell and two-pane workspace |
| `ddocs-003` | `ddocs` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Build safe source registry for package docs |
| `ddocs-004` | `ddocs` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Implement language resolver and localized docs selection |
| `ddocs-005` | `ddocs` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Build file-only docs index and tree model |
| `ddocs-006` | `ddocs` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Create evo-ui compatible tree/sidebar primitive for dDocs |
| `ddocs-007` | `ddocs` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Implement read-only Markdown renderer |
| `ddocs-008` | `ddocs` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Wire tree selection to document viewer |
| `ddocs-009` | `ddocs` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Add file-based search |
| `ddocs-010` | `ddocs` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Resolve relative Markdown links inside dDocs |
| `ddocs-011` | `ddocs` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Add safe asset and image handling |
| `ddocs-012` | `ddocs` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Add file index cache config |
| `ddocs-013` | `ddocs` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Add settings config surface |
| `ddocs-014` | `ddocs` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Add demo sources and smoke diagnostics |
| `ddocs-015` | `ddocs` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Polish document viewer UX |
| `ddocs-016` | `ddocs` | `ready_to_test` | `support` | `low` | `tests` | 5 | Prepare future project docs and overrides design only |

### Full task details

#### `ddocs-019` — Restrict package docs discovery to Evo and Extras packages

| Field | Value |
|---|---|
| DB id | `166` |
| External id | `ddocs-019` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `backlog` / Backlog |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `new` / New |
| Position | `703` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo-feedback","discovery","extras"] |
| External URL | - |
| Created | `2026-05-09 07:59:43` |
| Updated | `2026-05-09 07:59:43` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Problem: dDocs currently discovers docs from generic Composer dependencies such as assert, carbon, cache, cli-parser, and webp-convert. MVP should discover Evolution/Extras components, not the entire PHP dependency graph.

Acceptance: automatic vendor discovery includes dDocs, dIssues, sArticles, sLang, sSeo, evo-ui, dTui/eTinyMCE and similar installed Evolution/Extras packages, while excluding generic third-party libraries. Discovery must stay file-only and safe, without whole-disk scans or hardcoded production paths.
~~~

**Comments / execution log (1)**

- Comment `594` · `2026-05-09 07:59:43` · MiddleDuck · `public`

~~~text
Created from demo review feedback on 2026-05-09.
~~~

#### `ddocs-020` — Add nested three-level dDocs demo documentation

| Field | Value |
|---|---|
| DB id | `167` |
| External id | `ddocs-020` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `backlog` / Backlog |
| Category | `support` / Support |
| Priority | `normal` |
| Phase | `new` / New |
| Position | `704` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo-feedback","docs","nested-tree"] |
| External URL | - |
| Created | `2026-05-09 07:59:43` |
| Updated | `2026-05-09 07:59:43` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Problem: the dDocs package needs nested documentation folders to test the sidebar tree beyond a flat list.

Acceptance: dDocs includes Markdown demo documentation with at least three folder levels and multiple files. The content should be useful for testing nested folders, readable labels, README/index sorting, and relative links inside dDocs.
~~~

**Comments / execution log (1)**

- Comment `595` · `2026-05-09 07:59:43` · MiddleDuck · `public`

~~~text
Created from demo review feedback on 2026-05-09.
~~~

#### `ddocs-017` — Fix dDocs manager translation labels in demo

| Field | Value |
|---|---|
| DB id | `164` |
| External id | `ddocs-017` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `in_progress` / In progress |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `implementation` / Implementation |
| Position | `701` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo-feedback","i18n","manager-ui"] |
| External URL | - |
| Created | `2026-05-09 07:59:43` |
| Updated | `2026-05-09 08:00:02` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Problem: in the Evolution manager demo, dDocs labels render as raw keys such as dDocs::global.docs and dDocs::global.file_only. The module must show human-readable labels in the active manager language.

Acceptance: module tab, header, toolbar, search placeholder, tabs, and viewer empty states render translated labels. The fix must work even when the module entry is rendered before Laravel translation namespace lookup is reliable in the manager runtime.
~~~

**Comments / execution log (2)**

- Comment `592` · `2026-05-09 07:59:43` · MiddleDuck · `public`

~~~text
Created from demo review feedback on 2026-05-09.
~~~

- Comment `596` · `2026-05-09 08:00:03` · MiddleDuck · `public`

~~~text
Status: In progress

Починаю виправлення manager translations: прибираю raw dDocs::global.* ключі з demo UI, щоб модуль стабільно показував людські лейбли навіть у менеджерському runtime.
~~~

#### `ddocs-018` — Start docs tree collapsed and add real collapse action

| Field | Value |
|---|---|
| DB id | `165` |
| External id | `ddocs-018` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `in_progress` / In progress |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `implementation` / Implementation |
| Position | `702` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo-feedback","tree","ux"] |
| External URL | - |
| Created | `2026-05-09 07:59:43` |
| Updated | `2026-05-09 08:00:04` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Problem: root source nodes are expanded by default, which makes the first view noisy. The toolbar collapse action also needs to actually close the tree state.

Acceptance: initial dDocs tree shows source roots collapsed. Folder rows still expand/collapse on click. Search can expand matching paths when useful, but the default empty-search state is compact. Toolbar collapse resets expanded folder state and keeps the selected document stable.
~~~

**Comments / execution log (2)**

- Comment `593` · `2026-05-09 07:59:43` · MiddleDuck · `public`

~~~text
Created from demo review feedback on 2026-05-09.
~~~

- Comment `597` · `2026-05-09 08:00:05` · MiddleDuck · `public`

~~~text
Status: In progress

Починаю UX-виправлення дерева: root source nodes мають стартувати схлопнутими, а toolbar collapse має реально скидати expanded state.
~~~

#### `ddocs-m1` — Milestone 1: Module opens

| Field | Value |
|---|---|
| DB id | `116` |
| External id | `ddocs-m1` |
| Project | `ddocs` / dDocs |
| Component group | `milestones` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `10` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["epic","milestone","file-only","evo-ui"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:37:15` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Epic for the first visible slice of dDocs. Goal: create the dmi3yy/ddocs package, register it as an Evolution CMS manager module, and open a minimal evo-ui two-pane documentation workspace. Constraints: no database tables, no migrations, no editor, no override sync, no vendor-doc writes, no Bootstrap/CDN/legacy UI.
~~~

**Comments / execution log (5)**

- Comment `366` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Initial dDocs file-only planning epic captured from user direction on 2026-05-09.
~~~

- Comment `406` · `2026-05-09 07:00:25` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `448` · `2026-05-09 07:02:24` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `566` · `2026-05-09 07:37:15` · MiddleDuck · `public`

~~~text
Status: In progress

Milestone closeout: перевіряю Milestone 1 після завершення ddocs-001 і ddocs-002. Код не змінюю, тільки фіксую готовність milestone-епіка за дочірніми задачами.
~~~

- Comment `568` · `2026-05-09 07:37:25` · MiddleDuck · `public`

~~~text
Status: Ready to test

Milestone summary:
- ddocs-001 package skeleton готовий: composer package, provider, module entry, routes/lang/views skeleton, no migrations.
- ddocs-002 evo-ui manager shell готовий: two-pane workspace, toolbar/search/refresh placeholders, light/dark scoped UI, no Bootstrap/CDN.

Verification:
- Дочірні задачі ddocs-001 і ddocs-002 у Ready to test.
- PHP syntax checks для module/provider/ui layer проходили в рамках child tasks.

Self-review: 9/10.
~~~

#### `ddocs-m2` — Milestone 2: Discovery and language

| Field | Value |
|---|---|
| DB id | `117` |
| External id | `ddocs-m2` |
| Project | `ddocs` / dDocs |
| Component group | `milestones` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `20` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["epic","milestone","discovery","language"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:37:46` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Epic for file-only source discovery and localized document selection. Goal: find only safe package/project docs roots, resolve manager language with ua/uk equivalence and English/neutral fallback, and build a file-only tree index from Markdown files. Constraints: no whole-disk scan, no hardcoded local production paths, no DB index.
~~~

**Comments / execution log (5)**

- Comment `367` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Groups ddocs-003 through ddocs-005.
~~~

- Comment `407` · `2026-05-09 07:00:25` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `449` · `2026-05-09 07:02:24` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `569` · `2026-05-09 07:37:45` · MiddleDuck · `public`

~~~text
Status: In progress

Milestone closeout: перевіряю Milestone 2 після завершення discovery/language/index задач ddocs-003, ddocs-004 і ddocs-005. Код не змінюю, фіксую readiness епіка.
~~~

- Comment `570` · `2026-05-09 07:37:47` · MiddleDuck · `public`

~~~text
Status: Ready to test

Milestone summary:
- ddocs-003 safe source registry готовий: configured roots, Composer/local package discovery, deterministic source list, no whole-disk scan.
- ddocs-004 language resolver готовий: manager language, ua/uk equivalence, en and neutral fallback metadata.
- ddocs-005 file-only index/tree готовий: stable ids, folders/documents, localized effective tree, sorting, no DB.

Verification:
- Дочірні задачі ddocs-003, ddocs-004, ddocs-005 у Ready to test.
- Standalone smoke checks підтвердили discovery, language fallback і індексацію.

Self-review: 9/10.
~~~

#### `ddocs-m3` — Milestone 3: Tree and viewer

| Field | Value |
|---|---|
| DB id | `118` |
| External id | `ddocs-m3` |
| Project | `ddocs` / dDocs |
| Component group | `milestones` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `30` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["epic","milestone","tree","viewer"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:38:01` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Epic for the core Obsidian-like reader experience inside Evolution manager. Goal: create the evo-ui compatible tree/sidebar primitive, render Markdown safely, and connect tree selection to the right-hand viewer without page reload.
~~~

**Comments / execution log (5)**

- Comment `368` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Groups ddocs-006 through ddocs-008.
~~~

- Comment `408` · `2026-05-09 07:00:25` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `450` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `571` · `2026-05-09 07:37:59` · MiddleDuck · `public`

~~~text
Status: In progress

Milestone closeout: перевіряю Milestone 3 після завершення tree/viewer задач ddocs-006, ddocs-007 і ddocs-008. Код не змінюю, фіксую readiness епіка.
~~~

- Comment `572` · `2026-05-09 07:38:02` · MiddleDuck · `public`

~~~text
Status: Ready to test

Milestone summary:
- ddocs-006 tree/sidebar primitive готовий: scoped evo-ui-compatible tree, expand/collapse, active state, icons, badges, scroll, empty states.
- ddocs-007 Markdown renderer готовий: league/commonmark adapter, safe HTML policy, GFM basics, unsafe script stripped.
- ddocs-008 tree selection wired: Livewire selected document, expanded folders, viewer rendering without page reload.

Verification:
- Дочірні задачі ddocs-006, ddocs-007, ddocs-008 у Ready to test.
- PHP/Blade syntax checks і document read/render smoke checks проходили в рамках child tasks.

Self-review: 9/10.
~~~

#### `ddocs-m4` — Milestone 4: Search and links

| Field | Value |
|---|---|
| DB id | `119` |
| External id | `ddocs-m4` |
| Project | `ddocs` / dDocs |
| Component group | `milestones` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `40` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["epic","milestone","search","links","assets"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:38:14` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Epic for making the file-only browser useful at real documentation scale. Goal: add title/path/source/content search, rewrite relative Markdown links to indexed dDocs documents, and safely render local Markdown images from configured docs roots.
~~~

**Comments / execution log (5)**

- Comment `369` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Groups ddocs-009 through ddocs-011.
~~~

- Comment `409` · `2026-05-09 07:00:25` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `451` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `573` · `2026-05-09 07:38:13` · MiddleDuck · `public`

~~~text
Status: In progress

Milestone closeout: перевіряю Milestone 4 після завершення search/link/asset задач ddocs-009, ddocs-010 і ddocs-011. Код не змінюю, фіксую readiness епіка.
~~~

- Comment `574` · `2026-05-09 07:38:15` · MiddleDuck · `public`

~~~text
Status: Ready to test

Milestone summary:
- ddocs-009 file search готовий: пошук по title/path/source/package/content з max file size guard.
- ddocs-010 relative docs links готові: internal Markdown links відкривають indexed docs через dDocs, external links лишаються external, missing links не ламають viewer.
- ddocs-011 safe image/assets готові: local docs images проходять safe-root check, traversal/remote images блокуються.

Verification:
- Дочірні задачі ddocs-009, ddocs-010, ddocs-011 у Ready to test.
- Smoke checks підтвердили content search, link rewrite, missing link marker і image safety.

Self-review: 9/10.
~~~

#### `ddocs-m5` — Milestone 5: Config, cache, diagnostics, polish

| Field | Value |
|---|---|
| DB id | `120` |
| External id | `ddocs-m5` |
| Project | `ddocs` / dDocs |
| Component group | `milestones` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `50` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["epic","milestone","config","cache","polish"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:38:28` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Epic for operational readiness after the core reader works. Goal: add optional file-based index cache, settings UI, demo diagnostics, and viewer UX polish while keeping DB disabled/not present.
~~~

**Comments / execution log (5)**

- Comment `370` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Groups ddocs-012 through ddocs-015.
~~~

- Comment `410` · `2026-05-09 07:00:25` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `452` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `576` · `2026-05-09 07:38:27` · MiddleDuck · `public`

~~~text
Status: In progress

Milestone closeout: перевіряю Milestone 5 після завершення cache/settings/diagnostics/polish задач ddocs-012, ddocs-013, ddocs-014 і ddocs-015. Код не змінюю, фіксую readiness епіка.
~~~

- Comment `578` · `2026-05-09 07:38:29` · MiddleDuck · `public`

~~~text
Status: Ready to test

Milestone summary:
- ddocs-012 file index cache готовий: optional generated PHP cache, refresh rebuild, runtime fallback when cache off, no DB.
- ddocs-013 settings surface готовий: evo-ui settings preset, safe roots, extensions, max file size, cache controls, invalid roots rejected.
- ddocs-014 diagnostics готові: source/doc/language/path safety smoke report.
- ddocs-015 viewer polish готовий: heading anchors, metadata header, badges, copy actions, empty/loading states.

Verification:
- Дочірні задачі ddocs-012, ddocs-013, ddocs-014, ddocs-015 у Ready to test.
- Cache, diagnostics, heading anchors і settings syntax/smoke checks проходили в рамках child tasks.

Self-review: 9/10.
~~~

#### `ddocs-m6` — Milestone 6: Future design only

| Field | Value |
|---|---|
| DB id | `121` |
| External id | `ddocs-m6` |
| Project | `ddocs` / dDocs |
| Component group | `milestones` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `low` |
| Phase | `tests` / Tests |
| Position | `60` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["epic","milestone","future-design","no-runtime-editor"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:38:43` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Epic for documenting future project docs and override direction without implementing editor/write-back/runtime sync. Goal: keep the roadmap file-first and prevent accidental DB/editor scope from entering MVP.
~~~

**Comments / execution log (5)**

- Comment `371` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Groups ddocs-016.
~~~

- Comment `411` · `2026-05-09 07:00:25` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `453` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `579` · `2026-05-09 07:38:42` · MiddleDuck · `public`

~~~text
Status: In progress

Milestone closeout: перевіряю Milestone 6 після завершення ddocs-016. Код не змінюю, фіксую readiness design-only milestone.
~~~

- Comment `580` · `2026-05-09 07:38:44` · MiddleDuck · `public`

~~~text
Status: Ready to test

Milestone summary:
- ddocs-016 готовий: додано design note для майбутніх project docs та overrides.
- Майбутній напрямок зафіксовано як file-first: vendor docs read-only, project-owned safe roots для project docs/overrides, no DB canonical content.
- MVP runtime лишився без editor/write-back/sync engine.

Verification:
- Дочірня задача ddocs-016 у Ready to test.
- Перевірено, що зміна документаційна і не додає runtime editing або DB behavior.

Self-review: 9/10.
~~~

#### `ddocs-001` — Create dDocs package skeleton

| Field | Value |
|---|---|
| DB id | `122` |
| External id | `ddocs-001` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `101` |
| Parent | `ddocs-m1` Milestone 1: Module opens |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["package","skeleton","manager-module","no-db"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:08:35` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: dDocs must exist as an independent Evolution CMS module/package. Composer package: dmi3yy/ddocs. Namespace: Dmi3yy\dDocs. Manager module title: Docs or Documentation. Icon: book-2/notebook.

SPEC: Create composer metadata, service provider, module entry, routes/lang/views skeleton, facade/service entrypoint if needed, and package settings config. Register the module using the existing Evolution provider pattern used by dIssues/sArticles. Do not add migrations or d_docs_* tables.

Acceptance: package boots in the local demo, provider registers without fatal errors, manager module opens a minimal page, package contains no DB migrations, no DB tables are referenced.
~~~

**Comments / execution log (5)**

- Comment `372` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 1. Start here after PRD review.
~~~

- Comment `412` · `2026-05-09 07:00:25` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `454` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `488` · `2026-05-09 07:07:11` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-001: створюю package skeleton dmi3yy/ddocs, namespace Dmi3yy\dDocs, provider/module/lang/routes/views/config без DB migrations або d_docs_* таблиць.
~~~

- Comment `490` · `2026-05-09 07:08:35` · MiddleDuck · `public`

~~~text
Implemented package skeleton: composer package dmi3yy/ddocs, provider, module entry, health route, config/lang/views, facade/service, minimal Livewire shell. Verification: PHP lint OK for all PHP/Blade PHP files; searched runtime package for migrations/d_docs_/Schema/DB/local hardcoded paths, no runtime hits. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-002` — Add evo-ui manager shell and two-pane workspace

| Field | Value |
|---|---|
| DB id | `123` |
| External id | `ddocs-002` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `102` |
| Parent | `ddocs-m1` Milestone 1: Module opens |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["evo-ui","shell","workspace","two-pane"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:09:41` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: The first screen must be the documentation workspace, not a landing page. Left panel is tree/search/refresh placeholder; right panel is Markdown viewer placeholder; top toolbar can hold source/language/search/refresh controls and tree collapse.

SPEC: Build shell.blade.php and Livewire ModulePanel using evo-ui shell/assets/theme. Reuse x-evo::layout or ManagerContext-compatible shell as appropriate. Add responsive two-pane layout, empty states, and icon-only controls with accessible labels. Do not load Bootstrap, CDN UI libraries, legacy manager UI, or custom broad globals.

Acceptance: dDocs looks native to evo-ui, follows manager light/dark theme, remains usable at manager iframe widths, and opens without database access.
~~~

**Comments / execution log (5)**

- Comment `373` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 1.
~~~

- Comment `413` · `2026-05-09 07:00:25` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `455` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `491` · `2026-05-09 07:08:43` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-002: оформлю evo-ui manager shell у двопанельний docs workspace з toolbar/search/refresh placeholders, responsive layout, без Bootstrap/CDN/legacy UI.
~~~

- Comment `494` · `2026-05-09 07:09:41` · MiddleDuck · `public`

~~~text
Implemented evo-ui two-pane workspace shell with header actions, search/refresh placeholders, left sidebar, right viewer empty state, responsive layout, and scoped dDocs CSS. Verification: PHP lint OK; searched dDocs views/src for Bootstrap/CDN/jQuery/legacy manager assets and found none. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-003` — Build safe source registry for package docs

| Field | Value |
|---|---|
| DB id | `124` |
| External id | `ddocs-003` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `201` |
| Parent | `ddocs-m2` Milestone 2: Discovery and language |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["discovery","safe-roots","packages","file-only"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:11:24` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: dDocs discovers documentation only from real installed/configured packages and safe roots. It must support Docs/ and docs/ folders, including dDocs own Docs, dIssues, sArticles, sLang, sSeo, evo-ui when available, and Evolution Docs only when explicitly configured.

SPEC: Implement Support/DocsSourceRegistry. Inputs: configured safe_roots, extra_docs_roots, Composer/package discovery from the active project, and local demo configuration when present. Output deterministic source list with key, name, type, package_name, root_path, docs_path, is_vendor, enabled metadata. Reject roots outside configured safe roots and avoid whole-disk scans. No hardcoded /Users paths in production defaults.

Acceptance: registry returns deterministic source list for available packages, excludes random root repos, rejects unsafe paths, and works without DB.
~~~

**Comments / execution log (5)**

- Comment `374` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 2.
~~~

- Comment `414` · `2026-05-09 07:00:25` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `456` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `497` · `2026-05-09 07:09:58` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-003: додаю DocsSourceRegistry + DocumentPath для safe roots/package docs discovery. Scope: Docs/docs/README/index, Composer/vendor/configured roots, без whole-disk scan і без hardcoded production /Users paths.
~~~

- Comment `500` · `2026-05-09 07:11:24` · MiddleDuck · `public`

~~~text
Implemented DocsSourceRegistry and DocumentPath. Discovery covers package root, configured roots, Composer installed roots, and shallow vendor packages; supports Docs/docs and root README/index docs; no recursive whole-disk scan. Verification: PHP lint OK; standalone smoke discovers dDocs docs; searched src/config for recursive scanners, DB/migrations, and hardcoded local paths, none found. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-004` — Implement language resolver and localized docs selection

| Field | Value |
|---|---|
| DB id | `125` |
| External id | `ddocs-004` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `202` |
| Parent | `ddocs-m2` Milestone 2: Discovery and language |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["language","fallback","ua-uk","file-only"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:12:23` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: dDocs shows only the effective language version by default, not every language duplicate. Manager language should select localized docs when present, fallback to English, then neutral docs/pages or README/index. Ukrainian must support ua/uk equivalence.

SPEC: Implement Support/LanguageResolver. Detect manager language using existing manager session/site-cache/app locale patterns. Normalize aliases. Candidate order examples: manager uk -> uk, ua, en, neutral; manager ua -> ua, uk, en, neutral; manager ru -> ru, en, neutral; unknown -> en, neutral. Preserve available_languages metadata for future switcher.

Acceptance: focused checks/tests cover ua, uk, en, ru, unknown language, missing current language, missing English, and neutral fallback. Selected path and fallback metadata are correct.
~~~

**Comments / execution log (5)**

- Comment `375` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 2.
~~~

- Comment `415` · `2026-05-09 07:00:25` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `457` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `501` · `2026-05-09 07:11:33` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-004: додаю LanguageResolver для manager language detection, ua/uk equivalence, English fallback і neutral docs fallback, без DB.
~~~

- Comment `504` · `2026-05-09 07:12:23` · MiddleDuck · `public`

~~~text
Implemented LanguageResolver with manager/default language detection, ua/uk equivalence, English fallback, neutral docs/pages fallback, and available_languages metadata. Verification: PHP lint OK; focused smoke confirms uk -> uk/ua/en/neutral, ua -> ua/uk/en/neutral, ru -> ru/en/neutral, sArticles uk resolves to ua, sLang resolves to neutral docs/pages. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-005` — Build file-only docs index and tree model

| Field | Value |
|---|---|
| DB id | `126` |
| External id | `ddocs-005` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `203` |
| Parent | `ddocs-m2` Milestone 2: Discovery and language |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["index","tree-model","file-only","no-db"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:19:28` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: MVP index is a DTO/array structure from files, not a DB model. It must support Docs/, docs/, localized folders, docs/pages, README.md, index.md, md/mdx files, stable IDs, parent_id tree links, mtime, optional checksum, and available_languages metadata.

SPEC: Implement Support/DocsIndexer. Build source -> folder/document nodes with stable hashes, readable titles, logical_path, relative_path, absolute_path, source metadata, type folder/document, parent_id, language/fallback_language, is_vendor. Sort folders before files, README/index first, numeric prefixes in order, labels stripped of prefixes/extensions/separators.

Acceptance: tree builds from sArticles docs, sLang docs/pages, sSeo docs/pages, evo-ui docs, and dDocs Docs when present. Stable node IDs stay consistent across refresh. No DB or migrations are used.
~~~

**Comments / execution log (5)**

- Comment `376` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 2.
~~~

- Comment `416` · `2026-05-09 07:00:26` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `458` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `506` · `2026-05-09 07:12:36` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-005: додаю file-only DocsIndexer, який будує tree nodes із Markdown files, stable ids, parent_id, README/index first, numeric sorting, readable labels, без DB.
~~~

- Comment `517` · `2026-05-09 07:19:28` · MiddleDuck · `public`

~~~text
Implemented file-only DocsIndexer. It builds source/folder/document nodes with stable ids, parent_id, language metadata, mtime, optional checksum, README/index ordering, numeric/readable labels, and Markdown extension filtering. Verification: PHP lint OK; standalone smoke built dDocs tree nodes from file system; searched src/config for DB/migrations/local hardcoded paths, none found. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-006` — Create evo-ui compatible tree/sidebar primitive for dDocs

| Field | Value |
|---|---|
| DB id | `127` |
| External id | `ddocs-006` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `301` |
| Parent | `ddocs-m3` Milestone 3: Tree and viewer |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["tree","sidebar","evo-ui","component"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:20:44` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: dDocs needs a compact Obsidian-like docs tree in evo-ui style. DaisyUI/MaryUI do not provide the needed manager tree primitive, so implement it locally first but design it so it can later move into evo-ui.

SPEC: Build a scoped dDocs tree/sidebar component and CSS using evo-ui tokens. Support folder/document nodes, expand/collapse, active node, icons, badges, nested levels, search/filter visual state, keyboard-friendly clickable rows, large-tree scrolling, empty states, and light/dark themes. Keep classes scoped under dDocs.

Acceptance: tree is readable and compact, active/hover/expanded states are clear, dark/light themes work, large tree scroll does not break layout, and implementation is isolated enough to promote to evo-ui later.
~~~

**Comments / execution log (5)**

- Comment `377` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 3.
~~~

- Comment `417` · `2026-05-09 07:00:26` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `459` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `518` · `2026-05-09 07:19:44` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-006: роблю локальний dDocs tree/sidebar primitive, сумісний з evo-ui tokens: nested folders/documents, expand/collapse, icons, badges, empty state, scroll, dark/light.
~~~

- Comment `521` · `2026-05-09 07:20:44` · MiddleDuck · `public`

~~~text
Implemented local dDocs tree/sidebar primitive. It renders indexed source/folder/document nodes, nested children, expand/collapse, folder/document/source icons, document counts/language badges, empty state, scroll area, and scoped evo-ui-token CSS. Verification: PHP lint OK for PHP and Blade; tree markers/toggle/partial present. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-007` — Implement read-only Markdown renderer

| Field | Value |
|---|---|
| DB id | `128` |
| External id | `ddocs-007` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `302` |
| Parent | `ddocs-m3` Milestone 3: Tree and viewer |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["markdown","renderer","security","viewer"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:21:35` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: Use a real Markdown renderer such as league/commonmark if acceptable. Do not write a custom Markdown parser. Rendering must be safe and read-only.

SPEC: Implement Support/MarkdownRenderer adapter. Support headings, lists, tables, fenced code blocks, blockquotes, links, and basic images. Disable or sanitize unsafe raw HTML. Style output with evo-ui tokens for readable manager docs. Add file size guard before reading/rendering.

Acceptance: Markdown docs render cleanly in the viewer, code blocks/tables are readable in light/dark mode, unsafe script/raw HTML does not execute, and the renderer does not require DB/cache.
~~~

**Comments / execution log (5)**

- Comment `378` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 3.
~~~

- Comment `418` · `2026-05-09 07:00:26` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `460` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `523` · `2026-05-09 07:20:56` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-007: додаю read-only MarkdownRenderer adapter на league/commonmark, raw HTML strip, unsafe links off, без custom Markdown parser.
~~~

- Comment `525` · `2026-05-09 07:21:36` · MiddleDuck · `public`

~~~text
Implemented read-only MarkdownRenderer using league/commonmark ^2.7 with GithubFlavoredMarkdownConverter, html_input=strip, allow_unsafe_links=false. Verification: PHP lint OK; composer validate OK with existing evo-ui '*' warning matching local package style; renderer dependency declared, no custom Markdown parser. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-008` — Wire tree selection to document viewer

| Field | Value |
|---|---|
| DB id | `129` |
| External id | `ddocs-008` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `303` |
| Parent | `ddocs-m3` Milestone 3: Tree and viewer |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["livewire","selection","viewer","tree"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:23:08` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: A user should browse the tree and read documents without page reload. Folder rows expand/collapse; document rows open the right viewer.

SPEC: Add Livewire state for selected node, selected document, expanded folders, current tree/search state, and runtime index refresh. Implement FileDocumentRepository lookup by stable id, not arbitrary request path. Preserve selected document when tree filters change when possible.

Acceptance: click folder toggles it, click document renders viewer, selected row stays active, browsing is page-reload-free, and no arbitrary file read by request path is possible.
~~~

**Comments / execution log (5)**

- Comment `379` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 3.
~~~

- Comment `419` · `2026-05-09 07:00:26` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `461` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `526` · `2026-05-09 07:21:52` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-008: підключаю selected document state, click у tree, FileDocumentRepository safe read by stable id, Markdown viewer у правій панелі без page reload.
~~~

- Comment `529` · `2026-05-09 07:23:08` · MiddleDuck · `public`

~~~text
Implemented tree selection to viewer wiring. Added selectedDocumentId state, selectDocument action, active tree rows, FileDocumentRepository safe read by stable id, and right-panel Markdown viewer with metadata/readability state. Verification: PHP lint OK; standalone smoke confirms indexed doc can be found/read through repository; selection/viewer markers present. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-009` — Add file-based search

| Field | Value |
|---|---|
| DB id | `130` |
| External id | `ddocs-009` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `401` |
| Parent | `ddocs-m4` Milestone 4: Search and links |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["search","content-search","file-only"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:24:12` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: MVP search can be simple but must work across title, relative_path, source/package name, and Markdown content. Search may filter the tree or show results in the left panel.

SPEC: Implement Support/FileSearch. Use case-insensitive contains matching. Read Markdown content only from safe roots and only within max_file_size_kb. Search effective-language documents by default. Keep selected state stable when filtering. Consider excerpts later, but no DB index.

Acceptance: user can find docs by title/path/source and by text inside Markdown; oversized files are skipped safely; selected document is not lost unnecessarily; search works with runtime index and optional file cache.
~~~

**Comments / execution log (5)**

- Comment `380` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 4.
~~~

- Comment `420` · `2026-05-09 07:00:26` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `462` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `530` · `2026-05-09 07:23:21` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-009: додаю FileSearch і Livewire search state по title/path/source/content з max_file_size guard, без DB index.
~~~

- Comment `531` · `2026-05-09 07:24:13` · MiddleDuck · `public`

~~~text
Implemented file-based search. Added FileSearch for title/path/source/package/content contains matching with repository max-size safety; wired Livewire search input and visible result count/no-results state. Verification: PHP lint OK; standalone smoke finds documents by content/title and returns zero for missing query. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-010` — Resolve relative Markdown links inside dDocs

| Field | Value |
|---|---|
| DB id | `131` |
| External id | `ddocs-010` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `402` |
| Parent | `ddocs-m4` Milestone 4: Search and links |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["links","markdown","navigation"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:25:32` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: Relative links between indexed Markdown files should open the target document inside dDocs when possible. Missing links must not break rendering.

SPEC: Implement Support/LinkResolver. Resolve relative hrefs from the current document path against the file-only index. Rewrite internal links to Livewire/document selection actions or module URLs. Preserve external links as external with safe attributes. Mark missing internal links with a safe visual state.

Acceptance: relative docs links open target documents in dDocs, external links remain external, anchors still work, missing links are visible but harmless.
~~~

**Comments / execution log (5)**

- Comment `381` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 4.
~~~

- Comment `421` · `2026-05-09 07:00:26` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `463` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `532` · `2026-05-09 07:24:28` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-010: додаю LinkResolver для relative Markdown links -> indexed dDocs documents, missing link marker, external links untouched.
~~~

- Comment `541` · `2026-05-09 07:25:32` · MiddleDuck · `public`

~~~text
Implemented LinkResolver and MarkdownRenderer integration. Relative Markdown links are rewritten to data-ddocs-document-id and handled by Livewire click delegation; missing relative docs links get a ddocs-link-missing class; external links are left unchanged. Verification: PHP lint OK; standalone resolver smoke maps setup.md to target doc and marks missing/external correctly. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-011` — Add safe asset and image handling

| Field | Value |
|---|---|
| DB id | `132` |
| External id | `ddocs-011` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `403` |
| Parent | `ddocs-m4` Milestone 4: Search and links |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["assets","images","path-safety"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:26:45` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: Markdown images should render only when they are local files under configured docs roots. Path traversal and arbitrary file reads must be blocked.

SPEC: Extend DocumentPath and MarkdownRenderer/LinkResolver for image assets. Normalize image paths through realpath/safe-root checks. Support relative images near docs files and common docs image folders. Do not proxy remote images in MVP unless explicitly approved. Block ../ escape and unsupported extensions.

Acceptance: safe local Markdown images render, unsafe paths are blocked, missing images show harmless fallback, and no image request can read outside configured docs roots.
~~~

**Comments / execution log (5)**

- Comment `382` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 4.
~~~

- Comment `422` · `2026-05-09 07:00:26` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `464` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `543` · `2026-05-09 07:25:48` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-011: додаю safe Markdown image handling з docs-root path checks, no ../ escape, no arbitrary file reads, external images blocked/no proxy.
~~~

- Comment `544` · `2026-05-09 07:26:45` · MiddleDuck · `public`

~~~text
Implemented safe image handling in LinkResolver. Relative local images under docs_path are safe-root/max-size/extension checked and embedded as data URIs; traversal, unsupported files, missing files, and external images are blocked without arbitrary reads. Verification: PHP lint OK; smoke blocks ../composer.json and remote image; smoke embeds safe local jpg under docs root. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-012` — Add file index cache config

| Field | Value |
|---|---|
| DB id | `133` |
| External id | `ddocs-012` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `501` |
| Parent | `ddocs-m5` Milestone 5: Config, cache, diagnostics, polish |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["cache","generated-index","file-only","no-db"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:28:20` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: If an index cache is needed, it must be a generated PHP/JSON file in an allowed cache/config location, not database tables. Cache is optional; runtime indexing is acceptable if fast enough.

SPEC: Add config keys cache_index and index_cache_path. Implement cache read/write for the file-only index with checksum/mtime metadata. Refresh action rebuilds cache when enabled; when disabled it clears runtime state and rebuilds on the fly. Ensure cache path is within allowed safe cache root.

Acceptance: cache can be enabled/disabled, refresh works, invalid cache path is rejected, generated index contains file-only node fields, and no DB tables/migrations exist.
~~~

**Comments / execution log (5)**

- Comment `383` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 5.
~~~

- Comment `423` · `2026-05-09 07:00:26` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `465` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `545` · `2026-05-09 07:27:00` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-012: додаю optional file index cache як generated PHP file з cache_index/index_cache_path і refresh rebuild, без DB.
~~~

- Comment `548` · `2026-05-09 07:28:20` · MiddleDuck · `public`

~~~text
Implemented optional FileIndexCache. cache_index=false keeps runtime indexing; cache_index=true writes a generated PHP index file under allowed cache roots and refreshIndex rebuilds it. Verification: PHP lint OK; smoke with temp storage_path writes /tmp cache file and reads cached nodes; no DB tables. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-013` — Add settings config surface

| Field | Value |
|---|---|
| DB id | `134` |
| External id | `ddocs-013` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `502` |
| Parent | `ddocs-m5` Milestone 5: Config, cache, diagnostics, polish |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["settings","config","evo-ui-form"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:31:20` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: dDocs config is file-based. Settings should control enabled, scan_vendor_packages, scan_project_docs, safe_roots, extra_docs_roots, language_fallback, default_language, allowed_extensions, max_file_size_kb, cache_index, index_cache_path, show_internal_task_docs, and show_evolution_docs. DB must remain disabled/not present.

SPEC: Add config/dDocsSettings.php and evo-ui settings form following package settings patterns. Validate roots and extensions. Keep show_internal_task_docs false by default. Keep production defaults free of hardcoded /Users paths; local demo can provide demo-specific sources.

Acceptance: settings save through package config pattern, invalid roots/extensions are rejected, defaults are file-first/read-only/no-DB, and settings changes affect discovery/search safely.
~~~

**Comments / execution log (5)**

- Comment `384` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 5.
~~~

- Comment `424` · `2026-05-09 07:00:26` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `466` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `549` · `2026-05-09 07:28:32` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-013: додаю evo-ui settings form preset для file-based dDocs config і Settings tab; без DB.
~~~

- Comment `553` · `2026-05-09 07:31:20` · MiddleDuck · `public`

~~~text
Implemented file-based settings surface. Added evo-ui form preset ddocs.settings, Settings tab, config form fields for language/extensions/file size/safe roots/cache flags, settings translations, path-list validation rule, and string-list normalization for runtime settings. Verification: PHP lint OK; preset merged as evo-ui.forms.ddocs.settings and rendered via livewire:evo-ui.form; no DB. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-014` — Add demo sources and smoke diagnostics

| Field | Value |
|---|---|
| DB id | `135` |
| External id | `ddocs-014` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `503` |
| Parent | `ddocs-m5` Milestone 5: Config, cache, diagnostics, polish |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["demo","diagnostics","smoke"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:32:17` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: The local sArticles demo should prove that dDocs sees real installed/local package docs without relying on production hardcoded local paths.

SPEC: Add demo config or diagnostics command/view that reports discovered sources, document counts, languages, skipped oversized files, and path safety checks. Include dDocs Docs, dIssues docs, sArticles docs, sLang/sSeo docs/pages, evo-ui docs if available. Keep diagnostics read-only.

Acceptance: smoke output shows source count, document count, language coverage, and blocked unsafe path examples; local demo confirms expected packages are visible when installed/available.
~~~

**Comments / execution log (5)**

- Comment `385` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 5.
~~~

- Comment `425` · `2026-05-09 07:00:26` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `467` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `555` · `2026-05-09 07:31:30` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-014: додаю read-only diagnostics для sources/docs/languages/cache/path-safety smoke, без hardcoded local production paths.
~~~

- Comment `556` · `2026-05-09 07:32:17` · MiddleDuck · `public`

~~~text
Implemented read-only diagnostics. Added Diagnostics service and /ddocs/diagnostics route reporting file-only mode, cache mode/path, source count, document count, languages, sources, and path-safety smoke. Verification: PHP lint OK; standalone diagnostics smoke reports file-only, source/doc counts, and escape_blocked=true; no hardcoded local production paths. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-015` — Polish document viewer UX

| Field | Value |
|---|---|
| DB id | `136` |
| External id | `ddocs-015` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `504` |
| Parent | `ddocs-m5` Milestone 5: Config, cache, diagnostics, polish |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["ux","viewer","polish"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:34:48` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: Viewer should be comfortable for humans and useful as AI/Codex filesystem context. It should clearly explain what file is being read without turning into a landing page.

SPEC: Add document metadata header with title, source/package, relative path, language/fallback marker, optional mtime, source badge, empty/loading states, heading anchors, copy logical path, and optional copy file path. Keep action buttons compact and icon-first with accessible labels.

Acceptance: selected documents are easy to identify/copy/cite, fallback language is visible, loading/empty states are calm, heading anchors work, and UI remains clean in light/dark themes.
~~~

**Comments / execution log (5)**

- Comment `386` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 5.
~~~

- Comment `426` · `2026-05-09 07:00:27` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `468` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `557` · `2026-05-09 07:32:30` · MiddleDuck · `public`

~~~text
Починаю implementation ddocs-015: додаю viewer polish — metadata badges, fallback marker, mtime, copy actions, heading anchors, loading states.
~~~

- Comment `561` · `2026-05-09 07:34:48` · MiddleDuck · `public`

~~~text
Implemented viewer UX polish: metadata badges with source/path/language/fallback/mtime, copy logical and relative path actions, loading strip, heading anchors, and associated styles/translations. Verification: PHP lint OK; heading anchor smoke passes; polish markers present. Self-review: 9/10. Status: Ready to test.
~~~

#### `ddocs-016` — Prepare future project docs and overrides design only

| Field | Value |
|---|---|
| DB id | `137` |
| External id | `ddocs-016` |
| Project | `ddocs` / dDocs |
| Component group | `ddocs` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `low` |
| Phase | `tests` / Tests |
| Position | `601` |
| Parent | `ddocs-m6` Milestone 6: Future design only |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["design-only","future","project-docs","overrides"] |
| External URL | - |
| Created | `2026-05-09 06:55:57` |
| Updated | `2026-05-09 07:36:46` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: Do not implement editing, DB overrides, sync engine, write-back, Git export, or AI automation in MVP. Capture only the future file-first direction so later work does not reintroduce DB canonical content by accident.

SPEC: Add a short docs/design note describing future project docs and overrides as file-first: filesystem remains source of truth, vendor docs remain read-only, project docs/overrides live in configured project roots, edits require explicit future task and permission model, no automatic commits. No runtime editor/write-back code.

Acceptance: design note exists, future scope is clear, and there is no editor, DB table, migration, sync engine, or Git/export workflow implementation.
~~~

**Comments / execution log (5)**

- Comment `387` · `2026-05-09 06:55:57` · MiddleDuck · `public`

~~~text
Child of Milestone 6.
~~~

- Comment `427` · `2026-05-09 07:00:27` · MiddleDuck · `public`

~~~text
Стартую decomposition для dDocs file-only lane: готую PRD/SPEC/ANALYSIS/QA без коду, DB, migrations, editor, overrides або sync engine. Артефакти будуть у dDocs/Docs/tasks/ddocs-file-only-decomposition-20260509/.
~~~

- Comment `469` · `2026-05-09 07:02:25` · MiddleDuck · `public`

~~~text
Decomposition ready for file-only dDocs lane. Artifacts: Docs/tasks/ddocs-file-only-decomposition-20260509/PRD.md, SPEC.md, ANALYSIS.md, QA.md, DECOMPOSITION.md. Scope remains read-only/file-first: no DB, no migrations, no editor, no overrides, no sync engine. Status: Decomposition.
~~~

- Comment `563` · `2026-05-09 07:36:11` · MiddleDuck · `public`

~~~text
Status: In progress

Починаю design-only задачу: фіксую майбутню модель project docs та overrides як file-first підхід без DB canonical content, без editor/write-back runtime і без запису у vendor docs. Реалізація має бути тільки документаційним design note.
~~~

- Comment `564` · `2026-05-09 07:36:51` · MiddleDuck · `public`

~~~text
Status: Ready to test

Artifacts:
- Docs/design/project-docs-and-overrides-file-first.md

Implementation summary:
- Added a design-only note for future project docs and overrides.
- Kept the future model file-first: vendor docs read-only, project docs/overrides in project-owned safe roots, no DB canonical Markdown content.
- Documented safe write rules, override identity, conflict handling, and explicit exclusions for automatic Git/upstream workflows.

Verification:
- php -l src/Livewire/ModulePanel.php passed.
- Searched runtime/documentation for migration/DB/editor/write-back markers; no runtime DB or editor implementation was added.
- Confirmed this task is documentation-only.

Self-review: 9/10.
~~~

## Project `evo-ui` — evo-ui

- Tasks: **20**
- Statuses: `ready_to_test` 20
- Categories: `bug` 1, `feature` 19
- Priorities: `high` 12, `normal` 8
- Component groups: `core` 2, `evo-ui` 18

### Task index

| Task | Group | Status | Category | Priority | Phase | Comments | Title |
|---|---|---|---|---|---|---:|---|
| `evo-ui-core-002` | `core` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Add module-table column header action slot |
| `evo-ui-core-001` | `core` | `ready_to_test` | `bug` | `high` | `tests` | 4 | Reset dirty navigation guard after successful form save |
| `evo-ui-001` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Create canonical module integration contract docs |
| `evo-ui-002` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Document canonical consumer patterns |
| `evo-ui-003` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Expand module table contract docs |
| `evo-ui-004` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Create form and field catalogue docs |
| `evo-ui-005` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Document issue workspace contract |
| `evo-ui-006` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Create testing matrix docs |
| `evo-ui-007` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Upgrade package test harness |
| `evo-ui-008` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Add module shell and asset contract tests |
| `evo-ui-009` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Add module table contract tests |
| `evo-ui-010` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Add form and field contract tests |
| `evo-ui-011` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Add issue workspace contract tests |
| `evo-ui-012` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Add design token and visual contract tests |
| `evo-ui-013` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Add sArticles compatibility tests |
| `evo-ui-014` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Split dIssues compatibility assertions |
| `evo-ui-015` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Convert sLang regression to repeatable tests |
| `evo-ui-016` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Tighten sSeo compatibility tests |
| `evo-ui-017` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Create release checklist and smoke matrix |
| `evo-ui-018` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 5 | Add dDocs tree/viewer primitive notes |

### Full task details

#### `evo-ui-core-002` — Add module-table column header action slot

| Field | Value |
|---|---|
| DB id | `113` |
| External id | `evo-ui-core-002` |
| Project | `evo-ui` / evo-ui |
| Component group | `core` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `0` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 05:55:36` |
| Updated | `2026-05-09 07:01:06` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Shared evo-ui table enhancement needed by sLang dictionary: language columns need compact actions in the column header, for example translate all empty cells in that column. Acceptance: module-table columns can declare safe header actions rendered beside the label/sort control, actions call Livewire providers with the column key, styling matches existing compact icon buttons, and existing tables without header actions remain unchanged.
~~~

**Comments / execution log (4)**

- Comment `341` · `2026-05-09 05:55:36` · MiddleDuck · `public`

~~~text
Captured from user request before implementation per dIssues visible workflow.
~~~

- Comment `351` · `2026-05-09 06:05:31` · MiddleDuck · `public`

~~~text
Повертаю в Backlog: це окрема feature-задача для header action slot, її не починаю без окремого decomposition/implementation циклу.
~~~

- Comment `364` · `2026-05-09 06:45:47` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю reusable header_actions contract у module table header-cell, з Livewire provider call через ModuleTable.
~~~

- Comment `428` · `2026-05-09 07:01:06` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Реалізовано: додано контракт column.header_actions у ModuleTable; додано Livewire handler runHeaderAction з валідацією колонки/action/provider; додано compact header action UI у header-cell і shared CSS; додано evo-ui regression test. Перевірено: PHP lint OK; evo-ui tests/run.php OK; HTTP/browser smoke sLang показав header action без raw Blade/Parse/SQL помилок. Self-review: 9/10. Статус: Ready to test.
~~~

#### `evo-ui-core-001` — Reset dirty navigation guard after successful form save

| Field | Value |
|---|---|
| DB id | `112` |
| External id | `evo-ui-core-001` |
| Project | `evo-ui` / evo-ui |
| Component group | `core` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `5` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 05:55:36` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Shared evo-ui form guard regression: after clicking Save, the page shows saved state but the unsaved-changes modal remains when the user tries to switch tabs. Acceptance: after a successful Livewire form save, evo-ui marks the form clean, closes any pending unsaved modal, and if the user originally clicked another tab, navigation can continue. Verify in sLang and smoke the same behavior does not regress other modules using evo-ui forms.
~~~

**Comments / execution log (4)**

- Comment `340` · `2026-05-09 05:55:36` · MiddleDuck · `public`

~~~text
Captured from user screenshot before implementation per dIssues visible workflow.
~~~

- Comment `346` · `2026-05-09 05:58:14` · MiddleDuck · `public`

~~~text
Стартую decomposition: аналізую shared evo-ui form dirty guard, Livewire saved event і pending tab navigation після save.
~~~

- Comment `347` · `2026-05-09 05:58:14` · MiddleDuck · `public`

~~~text
Починаю implementation: фікшу reset clean state після evo-ui:form.saved і перевіряю на sLang Settings.
~~~

- Comment `350` · `2026-05-09 06:05:07` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові.\n\nPRD:\n- Після успішного Save unsaved-changes prompt не має залишатися активним і має дозволити pending tab navigation.\n- Acceptance: якщо користувач клікнув інший таб, побачив prompt і натиснув Save, після clean state prompt ховається, pending tab відкривається; якщо validation не очистила dirty state, prompt лишається.\n\nSPEC:\n- Додати shared EvoUI.form.isDirty()/waitForClean() helper у evo-ui.js.\n- Module panels sArticles/sLang/sSeo/dIssues мають використовувати shared helper і чекати clean DOM після requestSubmit/form.saved перед переходом.\n\nANALYSIS:\n- Guard був продубльований у module-panel кожного модуля.\n- Проблема була у timing: Save міг завершитися, але prompt/navigation логіка не чекала реального data-evo-form-dirty=false після Livewire morph.\n\nQA:\n- JS syntax: node --check evo-ui.js OK.\n- evo-ui tests: php tests/run.php OK.\n- sLang regression: php tests/regression/slang-demo-regression.php OK.\n- sLang smoke: php scripts/demo-smoke.php OK.\n- sSeo targeted ModulePanelContractTest OK; sSeo demo-smoke OK.\n- dIssues targeted ModulePanelTest OK.\n- Browser smoke на sLang: dirty form -> click Dictionary -> prompt -> Save; activeDictionary=true, dirty=false; modal backdrop hidden; test setting restored.\n\nРеалізовано:\n- Shared evo-ui form dirty helper.\n- Однакова save-and-switch поведінка у sArticles, sLang, sSeo, dIssues module panels.\n\nSelf-review: 9/10.\nСтатус: Ready to test.
~~~

#### `evo-ui-001` — Create canonical module integration contract docs

| Field | Value |
|---|---|
| DB id | `138` |
| External id | `evo-ui-001` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `10` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-1","docs","contract"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:08:53` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 1 - Docs contracts first.

Goal: document the single correct way to integrate evo-ui into an Evolution manager module: service provider, routes, views namespace, x-evo::layout or manager shell, evo::partials.assets, Livewire components, config merge keys, tabs, dirty-state behavior, and the rule against Bootstrap/CDN/legacy assets in evo-ui-owned screens.

Acceptance:
- A new module can be built from the docs without searching through sArticles or dIssues.
- The docs clearly separate evo-ui-owned shell/runtime behavior from module-owned business logic.
- Examples use existing consumer patterns but do not ask developers to copy random code fragments.
~~~

**Comments / execution log (5)**

- Comment `388` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD. Start in backlog; move to decomposition before preparing artifacts.
~~~

- Comment `430` · `2026-05-09 07:01:21` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `470` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-001/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `489` · `2026-05-09 07:07:54` · MiddleDuck · `public`

~~~text
Починаю implementation: оновлюю canonical module integration docs у evo-ui, без runtime/code змін.
~~~

- Comment `492` · `2026-05-09 07:08:53` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Реалізовано: оновлено canonical module integration docs у docs/module-integration.md; додано REPORT. Перевірено: documentation-only manual review, acceptance covered. Self-review: 9/10. Статус: Ready to test.
~~~

#### `evo-ui-002` — Document canonical consumer patterns

| Field | Value |
|---|---|
| DB id | `139` |
| External id | `evo-ui-002` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `20` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-1","docs","consumers"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:09:41` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 1 - Docs contracts first.

Goal: create or expand consumers.md so sArticles, dIssues, sLang, and sSeo are documented as canonical consumers.

For each consumer, document:
- what it takes from evo-ui;
- what remains module-owned;
- which examples should be used as donor patterns for new modules;
- which behavior must not be moved into evo-ui.

Acceptance:
- Codex can choose the correct donor pattern for a new module.
- sArticles, dIssues, sLang, and sSeo are all represented, not only the first two consumers.
~~~

**Comments / execution log (5)**

- Comment `389` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD. This is a docs-only contract task until moved forward.
~~~

- Comment `431` · `2026-05-09 07:01:21` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `471` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-002/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `493` · `2026-05-09 07:09:00` · MiddleDuck · `public`

~~~text
Починаю implementation: оновлюю canonical consumer patterns docs для sArticles, dIssues, sLang, sSeo; без runtime/code змін.
~~~

- Comment `495` · `2026-05-09 07:09:41` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Реалізовано: оновлено docs/consumers.md для sArticles, dIssues, sLang, sSeo; додано donor-pattern map і REPORT. Перевірено: documentation-only manual review, acceptance covered. Self-review: 9/10. Статус: Ready to test.
~~~

#### `evo-ui-003` — Expand module table contract docs

| Field | Value |
|---|---|
| DB id | `140` |
| External id | `evo-ui-003` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `30` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-1","docs","table"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:10:35` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 1 - Docs contracts first.

Goal: document the full table/list contract: columns, typed cells, filters, search, sorting, pagination, session/url state, table/list parity, inline editing, modal CRUD, row actions, delete guards, duplicate/publish actions, reorder/drag-sort, double-click edit, and provider hooks.

Acceptance:
- Table features no longer need to be discovered by reading consumer configs.
- Examples cover sArticles article tables, sSeo redirects, sLang dictionary rows, and dIssues settings tables where relevant.
- The docs explain which provider methods are optional and which are required for each feature.
~~~

**Comments / execution log (5)**

- Comment `390` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `432` · `2026-05-09 07:01:21` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `472` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-003/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `496` · `2026-05-09 07:09:53` · MiddleDuck · `public`

~~~text
Починаю implementation: розширюю docs/module-table-contract.md для table/list, filters, modal CRUD, inline, actions, state і provider hooks.
~~~

- Comment `498` · `2026-05-09 07:10:35` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Реалізовано: розширено docs/module-table-contract.md для actions, header actions, delete guards, extended modal fields, provider hooks і checklist. Перевірено: documentation-only manual review. Self-review: 9/10. Статус: Ready to test.
~~~

#### `evo-ui-004` — Create form and field catalogue docs

| Field | Value |
|---|---|
| DB id | `141` |
| External id | `evo-ui-004` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `40` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-1","docs","forms"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:11:43` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 1 - Docs contracts first.

Goal: document all supported form fields and behavior: config forms, model forms, resource forms, config-map, resource-parent, csv, datetime-local, color-picker, alias, choices, image, file, editor, repeater, builder, custom fields, validation metadata, and dirty state.

Acceptance:
- Every field has a config example.
- Every field documents source, casting, save behavior, and important constraints.
- Module-specific semantics stay in consumers; evo-ui documents only shared field behavior.
~~~

**Comments / execution log (5)**

- Comment `391` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `433` · `2026-05-09 07:01:21` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `473` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-004/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `499` · `2026-05-09 07:10:42` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю form and field catalogue docs з config examples, casting/save behavior і boundaries.
~~~

- Comment `502` · `2026-05-09 07:11:43` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Реалізовано: додано docs/forms.md field catalogue і посилання в docs/README.md. Перевірено: documentation-only manual review, required fields covered. Self-review: 9/10. Статус: Ready to test.
~~~

#### `evo-ui-005` — Document issue workspace contract

| Field | Value |
|---|---|
| DB id | `142` |
| External id | `evo-ui-005` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `50` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-1","docs","workspace"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:12:35` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 1 - Docs contracts first.

Goal: document the provider-backed issue workspace used by dIssues: list/kanban, filters, assignees, comments, replies, close/reopen, parent-child, archive, sorting, diagnostics, and state persistence.

Acceptance:
- Generic workspace API is described in evo-ui docs.
- dIssues-specific workflow and persistence logic remain in dIssues.
- The provider interface and optional methods are understandable without reading dIssues internals.
~~~

**Comments / execution log (5)**

- Comment `392` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `434` · `2026-05-09 07:01:22` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `474` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-005/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `503` · `2026-05-09 07:11:49` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю issue workspace contract docs для generic provider-backed API, без перенесення dIssues workflow logic.
~~~

- Comment `505` · `2026-05-09 07:12:35` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Реалізовано: додано docs/issue-workspace-contract.md і README link. Перевірено: documentation-only manual review, generic workspace API documented, dIssues logic лишається consumer-owned. Self-review: 9/10. Статус: Ready to test.
~~~

#### `evo-ui-006` — Create testing matrix docs

| Field | Value |
|---|---|
| DB id | `143` |
| External id | `evo-ui-006` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `60` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-1","docs","testing"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:18:55` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 1 - Docs contracts first.

Goal: document what is tested in the evo-ui package and what is tested in consumer modules. Generic behavior belongs in evo-ui. Module business behavior belongs in the consumer module.

Acceptance:
- testing.md exists with commands, scope, and smoke matrix.
- The matrix covers evo-ui tests, consumer tests, syntax checks, and UI smoke checks.
- The docs make it clear when a task must run sArticles, dIssues, sLang, or sSeo tests.
~~~

**Comments / execution log (5)**

- Comment `393` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `435` · `2026-05-09 07:01:22` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `475` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-006/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `507` · `2026-05-09 07:12:46` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю testing matrix docs для package vs consumer scope, commands і smoke responsibilities.
~~~

- Comment `508` · `2026-05-09 07:18:55` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Реалізовано: додано docs/testing.md і README link. Перевірено: documentation-only manual review, package vs consumer scope documented. Self-review: 9/10. Статус: Ready to test.
~~~

#### `evo-ui-007` — Upgrade package test harness

| Field | Value |
|---|---|
| DB id | `144` |
| External id | `evo-ui-007` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `70` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-2","tests","harness"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:20:08` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 2 - Package test foundation.

Goal: expand or replace the current tests/run.php with a clear package contract suite. A lightweight PHP runner is acceptable if PHPUnit or Pest would add unnecessary weight at this stage.

Acceptance:
- composer test runs grouped contract tests.
- Output clearly identifies the group and failing contract.
- The test harness can validate PHP files, views, config shapes, CSS/JS markers, and support classes without relying on consumer repos.
~~~

**Comments / execution log (5)**

- Comment `394` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `436` · `2026-05-09 07:01:22` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `476` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-007/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `509` · `2026-05-09 07:19:10` · MiddleDuck · `public`

~~~text
Починаю implementation: оновлюю tests/run.php у grouped lightweight contract runner, зберігаючи наявні assertions.
~~~

- Comment `519` · `2026-05-09 07:20:08` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Реалізовано: tests/run.php переведено на grouped lightweight contract runner зі збереженням існуючих assertions. Перевірено: php -l tests/run.php; composer test OK (7 tests). Self-review: 9/10. Статус: Ready to test.
~~~

#### `evo-ui-008` — Add module shell and asset contract tests

| Field | Value |
|---|---|
| DB id | `145` |
| External id | `evo-ui-008` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `80` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-2","tests","shell","assets"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:20:55` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 2 - Package test foundation.

Goal: test provider registration, Blade namespace, component registration, x-evo layout markers, evo assets, theme bridge, data-evo-ui-root, no legacy manager asset leakage, JS syntax, and window.EvoUI markers.

Acceptance:
- Shell and asset regressions cannot pass unnoticed.
- Tests guard against Bootstrap/CDN/legacy manager assets inside evo-ui-owned screens.
- JS syntax and public EvoUI API markers are covered.
~~~

**Comments / execution log (5)**

- Comment `395` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `437` · `2026-05-09 07:01:22` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `477` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-008/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `520` · `2026-05-09 07:20:14` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю package tests для shell/assets/theme/root markers/no legacy leakage/window.EvoUI.
~~~

- Comment `522` · `2026-05-09 07:20:55` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Реалізовано: додано shell/assets/theme/no-legacy/window.EvoUI contract tests у tests/run.php. Перевірено: composer test OK (11 tests); node --check resources/js/evo-ui.js OK. Self-review: 9/10. Статус: Ready to test.
~~~

#### `evo-ui-009` — Add module table contract tests

| Field | Value |
|---|---|
| DB id | `146` |
| External id | `evo-ui-009` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `90` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-2","tests","table"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:21:57` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 2 - Package test foundation.

Goal: test table config shape, filters, sorting, pagination, view switching, URL/session state, typed cells, inline edit markers, modal metadata, row actions, delete guards, and reorder provider hooks.

Acceptance:
- Generic table behavior is fixed in evo-ui.
- Consumers no longer serve as the only test surface for shared table behavior.
- Tests map back to the module-table docs.
~~~

**Comments / execution log (5)**

- Comment `396` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `438` · `2026-05-09 07:01:22` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `478` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-009/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `524` · `2026-05-09 07:21:01` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю module table package contract tests для state, filters, cells, inline, modal, actions, delete guards і reorder markers.
~~~

- Comment `527` · `2026-05-09 07:21:58` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Реалізовано: додано module-table contract tests для filters/sort/pagination/view state/cells/inline/modal/delete/reorder. Перевірено: composer test OK (15 tests). Self-review: 9/10. Статус: Ready to test.
~~~

#### `evo-ui-010` — Add form and field contract tests

| Field | Value |
|---|---|
| DB id | `147` |
| External id | `evo-ui-010` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `100` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-2","tests","forms"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:25:25` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 2 - Package test foundation.

Goal: test config/model/resource form contracts, field casting, choices, CSV, datetime, color-picker, alias, image/file markers, editor sync markers, custom field registration, validation metadata, and dirty-state events.

Acceptance:
- The field catalogue has corresponding tests.
- Generic field rendering and casting are protected in evo-ui.
- Module-specific save rules stay in consumer modules.
~~~

**Comments / execution log (5)**

- Comment `397` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `439` · `2026-05-09 07:01:22` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `479` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-010/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `528` · `2026-05-09 07:22:04` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю form/field package contract tests для casting, field markers, custom registration, editor/file/image і dirty events.
~~~

- Comment `540` · `2026-05-09 07:25:25` · MiddleDuck · `public`

~~~text
Implementation complete. Artifacts: /Users/dmi3yy/PhpstormProjects/Extras/evo-ui/docs/tasks/evo-ui-010/REPORT.md. Додано form/field contract tests для dirty-state, resource-parent, field catalogue markers, modal choices/media/editor/builder/color contracts, custom field registry і casting. Verification: php -l tests/run.php; composer test => OK 20 tests. Self-review: 9/10. Status: Ready to test.
~~~

#### `evo-ui-011` — Add issue workspace contract tests

| Field | Value |
|---|---|
| DB id | `148` |
| External id | `evo-ui-011` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `110` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-2","tests","workspace"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:27:11` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 2 - Package test foundation.

Goal: test provider interface shape, display/filter state, list/kanban markers, comments/replies contract, assignment markers, archive markers, parent-child markers, and drag/drop sorting contract.

Acceptance:
- dIssues can evolve without silently breaking the generic evo-ui workspace layer.
- Tests focus on generic workspace rendering and contract markers, not dIssues business persistence.
~~~

**Comments / execution log (5)**

- Comment `398` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `440` · `2026-05-09 07:01:22` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `480` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-011/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `542` · `2026-05-09 07:25:43` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю package contract tests для IssueWorkspace provider API, display/filter state, list/kanban Blade markers, comments/replies, assignment/archive/parent-child і drag/drop sorting contract.
~~~

- Comment `546` · `2026-05-09 07:27:11` · MiddleDuck · `public`

~~~text
Implementation complete. Artifacts: /Users/dmi3yy/PhpstormProjects/Extras/evo-ui/docs/tasks/evo-ui-011/REPORT.md. Додано IssueWorkspace package contract tests: provider API, filters/display/archive persistence, list/kanban markers, comments/replies/body editor sync, assignment/archive/parent-child markers і kanban drag/drop sorting payload. Verification: php -l tests/run.php; composer test => OK 26 tests. Self-review: 9/10. Status: Ready to test.
~~~

#### `evo-ui-012` — Add design token and visual contract tests

| Field | Value |
|---|---|
| DB id | `149` |
| External id | `evo-ui-012` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `120` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-2","tests","design-tokens"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:29:04` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 2 - Package test foundation.

Goal: test CSS tokens, OKLCH palette, dynamic badge colors, color picker styles, issue cards/list cards, compact manager typography, and dark/light markers.

Acceptance:
- New modules do not need local CSS for common UI primitives.
- Visual token regressions are caught by package tests.
- The tests map to documented design-token rules.
~~~

**Comments / execution log (5)**

- Comment `399` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `441` · `2026-05-09 07:01:22` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `481` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-012/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `547` · `2026-05-09 07:27:22` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю package contract tests для CSS theme tokens, OKLCH palette, dynamic badge/chip colors, color picker styles, issue/list cards, compact typography і dark/light theme markers.
~~~

- Comment `550` · `2026-05-09 07:29:04` · MiddleDuck · `public`

~~~text
Implementation complete. Artifacts: /Users/dmi3yy/PhpstormProjects/Extras/evo-ui/docs/tasks/evo-ui-012/REPORT.md. Додано design-token/visual contract tests для theme selectors, OKLCH palette, semantic tokens, dynamic badges/chips, color picker, issue/list cards і compact typography; додано missing --evo-ui-radius-sm token. Verification: php -l tests/run.php; composer test => OK 31 tests; node --check resources/js/evo-ui.js. Self-review: 9/10. Status: Ready to test.
~~~

#### `evo-ui-013` — Add sArticles compatibility tests

| Field | Value |
|---|---|
| DB id | `150` |
| External id | `evo-ui-013` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `130` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-3","consumer","sarticles"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:31:07` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 3 - Consumer compatibility.

Goal: add lightweight sArticles tests for table presets, settings form, article modal, builder config, relation choices, rich editor, image/file fields, and publish/duplicate/delete hooks.

Acceptance:
- sArticles, the largest consumer, no longer lacks test safety.
- Tests focus on sArticles-specific configuration and business hooks.
- Shared behavior remains covered by evo-ui package tests.
~~~

**Comments / execution log (5)**

- Comment `400` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `442` · `2026-05-09 07:01:22` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `482` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-013/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `551` · `2026-05-09 07:29:14` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю lightweight sArticles compatibility tests для table presets, settings form, article modal, builder config, relation choices, rich editor, image/file fields і provider hooks.
~~~

- Comment `552` · `2026-05-09 07:31:07` · MiddleDuck · `public`

~~~text
Implementation complete. Artifacts: /Users/dmi3yy/PhpstormProjects/Extras/evo-ui/docs/tasks/evo-ui-013/REPORT.md; /Users/dmi3yy/PhpstormProjects/Extras/sArticles/tests/run.php. Додано sArticles compatibility tests і composer test для evo-ui shell, table/list preset, filters/columns/actions, article modal, builder, settings config-map і provider hooks. Verification: php -l tests/run.php; composer test => OK 7 tests. Self-review: 9/10. Status: Ready to test.
~~~

#### `evo-ui-014` — Split dIssues compatibility assertions

| Field | Value |
|---|---|
| DB id | `151` |
| External id | `evo-ui-014` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `140` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-3","consumer","dissues"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:32:49` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 3 - Consumer compatibility.

Goal: keep workflow, taxonomy, provider, and board behavior tests in dIssues, while moving or duplicating generic assertions that only inspect evo-ui files/classes/views into evo-ui fixtures.

Acceptance:
- dIssues is not the accidental test runner for evo-ui.
- dIssues tests remain focused on dIssues behavior.
- Generic evo-ui assertions exist in the evo-ui package suite.
~~~

**Comments / execution log (5)**

- Comment `401` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `443` · `2026-05-09 07:01:22` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `483` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-014/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `554` · `2026-05-09 07:31:23` · MiddleDuck · `public`

~~~text
Починаю implementation: перевіряю dIssues tests, фіксую split generic evo-ui assertions у evo-ui package suite і лишаю dIssues compatibility scope на workflow/taxonomy/provider/board behavior.
~~~

- Comment `558` · `2026-05-09 07:32:49` · MiddleDuck · `public`

~~~text
Implementation complete. Artifacts: /Users/dmi3yy/PhpstormProjects/Extras/evo-ui/docs/tasks/evo-ui-014/REPORT.md; /Users/dmi3yy/PhpstormProjects/Extras/dIssues/docs/evo-ui-compatibility-scope.md; /Users/dmi3yy/PhpstormProjects/Extras/dIssues/tests/Unit/EvoUIPackageDelegationContractTest.php. Зафіксовано split: generic evo-ui contracts делеговані package suite, dIssues scope лишається workflow/taxonomy/provider/board behavior. Verification: php -l delegation test; phpunit delegation => OK 2 tests/20 assertions; evo-ui composer test => OK 31 tests. Self-review: 8/10. Status: Ready to test.
~~~

#### `evo-ui-015` — Convert sLang regression to repeatable tests

| Field | Value |
|---|---|
| DB id | `152` |
| External id | `evo-ui-015` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `150` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-3","consumer","slang"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:34:41` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 3 - Consumer compatibility.

Goal: cover dictionary inline editing, dynamic language columns, settings choices, dirty-state navigation, and the legacy resource-tab boundary.

Acceptance:
- Multilingual/dictionary evo-ui behavior no longer depends on a manual regression script.
- sLang-specific translation behavior remains in sLang tests.
- evo-ui package tests cover only generic inline/table/form behavior.
~~~

**Comments / execution log (5)**

- Comment `402` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `444` · `2026-05-09 07:01:23` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `484` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-015/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `559` · `2026-05-09 07:33:00` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю repeatable sLang compatibility tests для dictionary inline editing, dynamic language columns, settings choices, dirty-state navigation і legacy resource-tab boundary.
~~~

- Comment `560` · `2026-05-09 07:34:41` · MiddleDuck · `public`

~~~text
Implementation complete. Artifacts: /Users/dmi3yy/PhpstormProjects/Extras/evo-ui/docs/tasks/evo-ui-015/REPORT.md; /Users/dmi3yy/PhpstormProjects/Extras/sLang/tests/run.php. Додано repeatable sLang compatibility tests і composer test для dictionary inline editing, dynamic language columns, settings choices, dirty-state navigation, legacy resource-tab boundary; composer type normalized to evolution-cms-module. Verification: php -l tests/run.php; composer test => OK 7 tests. Self-review: 9/10. Status: Ready to test.
~~~

#### `evo-ui-016` — Tighten sSeo compatibility tests

| Field | Value |
|---|---|
| DB id | `153` |
| External id | `evo-ui-016` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `160` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-3","consumer","sseo"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:37:04` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 3 - Consumer compatibility.

Goal: cover redirects table, settings/analytics forms, custom server protocol field, robots/meta editors, resource SEO fields, and legacy route compatibility.

Acceptance:
- sSeo as a mixed module/resource consumer has a stable contract.
- Tests focus on sSeo-specific SEO/resource behavior and custom field registration.
- Generic evo-ui form/table/editor behavior is covered in evo-ui package tests.
~~~

**Comments / execution log (5)**

- Comment `403` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `445` · `2026-05-09 07:01:23` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `485` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-016/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `562` · `2026-05-09 07:34:51` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю/підсилюю sSeo compatibility tests для redirects table, settings/analytics forms, custom server/protocol field, robots/meta editors, resource SEO fields і legacy route compatibility.
~~~

- Comment `565` · `2026-05-09 07:37:04` · MiddleDuck · `public`

~~~text
Implementation complete. Artifacts: /Users/dmi3yy/PhpstormProjects/Extras/evo-ui/docs/tasks/evo-ui-016/REPORT.md; /Users/dmi3yy/PhpstormProjects/Extras/sSeo/tests/Unit/EvoUiCompatibilityMatrixContractTest.php. Додано composer test і sSeo compatibility matrix для shell routes, redirects table/list/modal CRUD, settings/analytics forms, server protocol field, robots/meta editors, resource SEO fields і legacy routes. Verification: php -l matrix test; targeted phpunit => OK 4 tests/88 assertions; composer test => OK 55 tests/537 assertions. Self-review: 9/10. Status: Ready to test.
~~~

#### `evo-ui-017` — Create release checklist and smoke matrix

| Field | Value |
|---|---|
| DB id | `154` |
| External id | `evo-ui-017` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `170` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-4","release","smoke"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:38:17` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 4 - Release and future primitives.

Goal: document exact commands for evo-ui tests, consumer tests, syntax checks, browser/manual smoke, and release readiness.

Smoke matrix must include:
- module shell loads;
- tab dirty-state;
- table/list state;
- modal flows;
- rich editor sync;
- image/file picker;
- dIssues Kanban drag/drop;
- sLang inline save;
- sSeo resource SEO save.

Acceptance:
- Before evo-ui changes, there is one checklist to run.
- The checklist names package and consumer commands clearly.
~~~

**Comments / execution log (5)**

- Comment `404` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `446` · `2026-05-09 07:01:23` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `486` · `2026-05-09 07:06:46` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-017/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `567` · `2026-05-09 07:37:15` · MiddleDuck · `public`

~~~text
Починаю implementation: оновлюю release checklist/smoke matrix з точними командами для evo-ui і consumer tests, плюс manual smoke по shell/tabs/table/modal/editor/media/workspace flows.
~~~

- Comment `575` · `2026-05-09 07:38:17` · MiddleDuck · `public`

~~~text
Implementation complete. Artifacts: /Users/dmi3yy/PhpstormProjects/Extras/evo-ui/docs/tasks/evo-ui-017/REPORT.md; /Users/dmi3yy/PhpstormProjects/Extras/evo-ui/docs/release-checklist.md. Release checklist expanded with exact package/consumer commands and smoke matrix for shell, dirty tabs, table/list, modals, rich editor, media, dIssues workspace, sLang and sSeo. Verification: evo-ui composer test => OK 31 tests; docs readback. Self-review: 9/10. Status: Ready to test.
~~~

#### `evo-ui-018` — Add dDocs tree/viewer primitive notes

| Field | Value |
|---|---|
| DB id | `155` |
| External id | `evo-ui-018` |
| Project | `evo-ui` / evo-ui |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `180` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["wave-4","future-primitive","ddocs"] |
| External URL | - |
| Created | `2026-05-09 06:58:13` |
| Updated | `2026-05-09 07:39:27` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Wave 4 - Release and future primitives.

Goal: add a short design note for dDocs needs: tree/sidebar and markdown viewer. Clarify what stays local in dDocs for now and what could later become an evo-ui primitive.

Acceptance:
- dDocs is not blocked by evo-ui platform work.
- The note prevents random module-local CSS/JS from becoming the default shared pattern.
- Any future shared primitive is explicitly documented before implementation.
~~~

**Comments / execution log (5)**

- Comment `405` · `2026-05-09 06:58:13` · MiddleDuck · `public`

~~~text
Backlog created from approved evo-ui PRD.
~~~

- Comment `447` · `2026-05-09 07:01:23` · MiddleDuck · `public`

~~~text
Стартую decomposition: готую PRD/SPEC/ANALYSIS/QA для цієї evo-ui platform задачі. Код і implementation не чіпаю; фіксую scope, approach, findings і QA path перед майбутнім переходом в In progress.
~~~

- Comment `487` · `2026-05-09 07:06:47` · MiddleDuck · `public`

~~~text
Decomposition artifacts ready: docs/tasks/evo-ui-018/PRD.md, SPEC.md, ANALYSIS.md, QA.md. No implementation/code changes for this task. No blocker found during decomposition review; keep in Decomposition until user approval to move this wave into In progress.
~~~

- Comment `577` · `2026-05-09 07:38:28` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю dDocs tree/viewer design note у evo-ui docs, з boundary що лишається локально в dDocs і що може стати майбутнім evo-ui primitive.
~~~

- Comment `581` · `2026-05-09 07:39:27` · MiddleDuck · `public`

~~~text
Implementation complete. Artifacts: /Users/dmi3yy/PhpstormProjects/Extras/evo-ui/docs/tasks/evo-ui-018/REPORT.md; /Users/dmi3yy/PhpstormProjects/Extras/evo-ui/docs/ddocs-tree-viewer-notes.md. Додано dDocs tree/viewer design note: що лишається локально в dDocs, майбутні evo-ui primitive candidates, shared styling rules і promotion contract. Verification: evo-ui composer test => OK 31 tests; docs readback. Self-review: 9/10. Status: Ready to test.
~~~

## Project `slang` — sLang

- Tasks: **26**
- Statuses: `ready_to_test` 26
- Categories: `bug` 7, `feature` 13, `support` 6
- Priorities: `high` 18, `normal` 8
- Component groups: `evo-ui` 26

### Task index

| Task | Group | Status | Category | Priority | Phase | Comments | Title |
|---|---|---|---|---|---|---:|---|
| `slang-evo-ui-026` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 4 | Add dictionary action to translate all empty values in a language column |
| `slang-evo-ui-025` | `evo-ui` | `ready_to_test` | `bug` | `high` | `tests` | 4 | Limit frontend language choices to selected site languages |
| `slang-evo-ui-001` | `evo-ui` | `ready_to_test` | `support` | `high` | `tests` | 2 | Зафіксувати baseline sLang у shared demo |
| `slang-evo-ui-002` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 2 | Описати migration contract для sLang -> evo-ui |
| `slang-evo-ui-003` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 2 | Перезібрати sLang manager module shell на evo-ui |
| `slang-evo-ui-004` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 2 | Перенести Dictionary на evo-ui module-table |
| `slang-evo-ui-005` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Додати evo-ui редагування перекладів і create flow |
| `slang-evo-ui-006` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 2 | Перенести Settings на evo-ui form |
| `slang-evo-ui-007` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 2 | Стабілізувати resource edit multilingual tabs під новий UI |
| `slang-evo-ui-008` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Оформити sLang integration API для sArticles/sSeo/evo-ui |
| `slang-evo-ui-009` | `evo-ui` | `ready_to_test` | `support` | `normal` | `tests` | 2 | Додати targeted tests і demo smoke для sLang migration |
| `slang-evo-ui-010` | `evo-ui` | `ready_to_test` | `support` | `normal` | `tests` | 2 | Оновити docs і agent handoff після sLang evo-ui міграції |
| `slang-evo-ui-011` | `evo-ui` | `ready_to_test` | `bug` | `high` | `tests` | 3 | Відновити Dictionary seed і create/update flow без SQL помилок |
| `slang-evo-ui-012` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 3 | Уніфікувати Dictionary controls з sArticles |
| `slang-evo-ui-013` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 3 | Перезібрати Settings layout за патерном sArticles |
| `slang-evo-ui-014` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 3 | Замінити довгі чекбокси Settings на compact choices |
| `slang-evo-ui-015` | `evo-ui` | `ready_to_test` | `support` | `high` | `tests` | 3 | Додати ручний QA/smoke для Dictionary і Settings після feedback фіксів |
| `slang-evo-ui-016` | `evo-ui` | `ready_to_test` | `support` | `high` | `tests` | 3 | Додати regression test runner для sLang Dictionary/Settings |
| `slang-evo-ui-017` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Повернути auto-translate controls у evo-ui Dictionary |
| `slang-evo-ui-018` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 3 | Оцінити повний evo-ui restyle resource multilingual tabs |
| `slang-evo-ui-019` | `evo-ui` | `ready_to_test` | `support` | `normal` | `tests` | 3 | Винести Settings choices у reusable evo-ui component якщо потрібен strict standard |
| `slang-evo-ui-020` | `evo-ui` | `ready_to_test` | `bug` | `high` | `tests` | 2 | Прибрати зайвий верхній відступ module tabs і вирівняти з sArticles |
| `slang-evo-ui-021` | `evo-ui` | `ready_to_test` | `bug` | `high` | `tests` | 2 | Полірувати Settings form labels/help/alignment |
| `slang-evo-ui-022` | `evo-ui` | `ready_to_test` | `bug` | `high` | `tests` | 3 | Make sLang save button dirty-state aware and use system Configuration label |
| `slang-evo-ui-023` | `evo-ui` | `ready_to_test` | `bug` | `high` | `tests` | 3 | Align sLang font scale with sArticles evo-ui baseline |
| `slang-evo-ui-024` | `evo-ui` | `ready_to_test` | `bug` | `high` | `tests` | 4 | Fix raw Blade output in sLang Settings choices |

### Full task details

#### `slang-evo-ui-026` — Add dictionary action to translate all empty values in a language column

| Field | Value |
|---|---|
| DB id | `114` |
| External id | `slang-evo-ui-026` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `1` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 05:55:36` |
| Updated | `2026-05-09 07:01:06` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
sLang dictionary needs a bulk helper for untranslated rows. Acceptance: each non-default language column can expose a header action to auto-translate only empty cells from the default language, filled cells are not overwritten, action reports a result safely, and regression/smoke tests cover the provider behavior.
~~~

**Comments / execution log (4)**

- Comment `342` · `2026-05-09 05:55:36` · MiddleDuck · `public`

~~~text
Captured from user request before implementation per dIssues visible workflow.
~~~

- Comment `352` · `2026-05-09 06:05:31` · MiddleDuck · `public`

~~~text
Повертаю в Backlog: bulk translate empty values залежить від evo-ui-core-002 і має йти окремим flow після header action slot.
~~~

- Comment `365` · `2026-05-09 06:45:47` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю header action для non-default мовних колонок і provider, який перекладає тільки порожні значення.
~~~

- Comment `429` · `2026-05-09 07:01:06` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові. Реалізовано: non-default мовні колонки отримали header action auto_translate_empty; додано provider autoTranslateEmptyColumn, який перекладає тільки порожні target values з непорожнім default source і не чіпає заповнені; додано wire target runHeaderAction і переклади label. Перевірено: PHP lint OK; sLang demo regression OK; scripts/demo-smoke.php OK; HTTP smoke з URL OK; Playwright smoke: 2 header actions на EN/AZ, 0 на KEY/UK, raw Blade false, errors []. Self-review: 9/10. Статус: Ready to test.
~~~

#### `slang-evo-ui-025` — Limit frontend language choices to selected site languages

| Field | Value |
|---|---|
| DB id | `111` |
| External id | `slang-evo-ui-025` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `3` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 05:49:00` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Settings dependency regression: the frontend languages choice field persists only selected site languages, but its dropdown still shows every available language. Acceptance: the frontend languages dropdown only offers languages currently selected in site languages, removing a site language also removes it from frontend languages, the default language stays protected, and regression/smoke tests cover the dependency.
~~~

**Comments / execution log (4)**

- Comment `337` · `2026-05-09 05:49:00` · MiddleDuck · `public`

~~~text
Captured from user screenshot before implementation per dIssues visible workflow.
~~~

- Comment `338` · `2026-05-09 05:49:00` · MiddleDuck · `public`

~~~text
Стартую decomposition: перевіряю SettingsPanel data flow і evo-ui choices options, щоб frontend languages отримував тільки selected site languages, а не весь langList.
~~~

- Comment `339` · `2026-05-09 05:49:00` · MiddleDuck · `public`

~~~text
Починаю implementation: обмежую options для frontend choices, синхронізую frontend selections при зміні site languages і додаю regression/smoke перевірку.
~~~

- Comment `345` · `2026-05-09 05:58:03` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові.\n\nPRD:\n- У Settings поле frontend languages має залежати від site languages.\n- Acceptance: dropdown frontend показує тільки мови, вибрані у site languages; frontend selection автоматично чиститься при видаленні site language; default language лишається захищеним.\n\nSPEC:\n- Додати окремий render payload frontendLanguages у SettingsPanel.\n- Фільтрувати frontendLanguages по data.s_lang_config.\n- У Blade для s_lang_front передавати filtered options замість повного languages.\n\nANALYSIS:\n- normalizeLanguageSelections вже правильно чистив data.s_lang_front по site list.\n- UI помилка була тільки в choices options: dropdown отримував весь langList і показував недоступні мови.\n\nQA:\n- PHP lint OK: SettingsPanel.php, slang-demo-regression.php.\n- targeted tests: php tests/regression/slang-demo-regression.php OK.\n- full relevant suite: php scripts/demo-smoke.php OK.\n- HTTP smoke: php scripts/demo-smoke.php --url=http://127.0.0.1:8795 OK.\n- Browser DOM check: frontend options дорівнюють site chips; rawBlade=false.\n\nРеалізовано:\n- frontend choices отримує тільки selected site languages.\n- regression test перевіряє filtered frontend options і cleanup invalid frontend values.\n\nSelf-review: 9/10.\nСтатус: Ready to test.
~~~

#### `slang-evo-ui-001` — Зафіксувати baseline sLang у shared demo

| Field | Value |
|---|---|
| DB id | `60` |
| External id | `slang-evo-ui-001` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `14` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","migration","analysis"] |
| External URL | - |
| Created | `2026-05-09 03:10:13` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis:
- sLang уже прописаний у /Users/dmi3yy/PhpstormProjects/Extras/sArticles/demo/core/custom/composer.json як path repository на ../../../../sLang.
- vendor/seiger/slang є symlink, package discovery бачить provider, SQLite уже має evo_s_lang_translates і evo_s_lang_content.
- Поточний UI ще legacy manager::template.page + WebFXTabPane + CDN select2/bootstrap/jquery.

Scope:
- Зафіксувати demo bootstrap для sLang перед міграцією.
- Додати/оновити smoke-команди для package:discover, migrate, view:clear і basic manager render.
- Переконатись, що sLang не ламає sArticles, dIssues, sSeo у спільному demo.

Acceptance:
- `php artisan package:discover` показує sLang provider.
- `php artisan migrate --force` не падає і не має pending migrations.
- Є documented command sequence для агентів, які заходять у shared demo.
- Перед кожним записом у dIssues база backup-иться через dissues-demo-ops.
~~~

**Comments / execution log (2)**

- Comment `203` · `2026-05-09 03:10:13` · MiddleDuck · `public`

~~~text
Initial backlog item from sLang migration analysis. Keep this as baseline/smoke gate before UI rewrites.
~~~

- Comment `233` · `2026-05-09 03:27:42` · MiddleDuck · `public`

~~~text
Implementation slice completed: sLang evo-ui shell, dictionary table, settings panel, language bridge, docs, and shared-demo smoke are in place. Verified with php syntax checks, package discovery, migrations, HTTP module smoke, resource edit smoke, and Playwright snapshot.
~~~

#### `slang-evo-ui-002` — Описати migration contract для sLang -> evo-ui

| Field | Value |
|---|---|
| DB id | `61` |
| External id | `slang-evo-ui-002` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `29` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","migration","architecture"] |
| External URL | - |
| Created | `2026-05-09 03:10:13` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis:
- sLang має дві великі поверхні: manager module dictionary/settings і resource-edit tabs для мультимовного контенту/TVs.
- Частина API використовується іншими модулями напряму: sLang facade, models, Paginator current path resolver, URL processor helpers, content/TV translation helpers.
- Міграція не має ламати runtime language routing і sArticles LangIntegration.

Scope:
- Скласти PRD/SPEC для міграції з поділом на module shell, dictionary, settings, resource tabs, integration API, QA.
- Визначити що лишається legacy-сумісним у першому релізі.
- Зафіксувати backward compatibility для `sLang::langConfig()`, `sLang::langDefault()`, `sLangContent`, `sLangTmplvarContentvalue`, existing routes/actions.

Acceptance:
- Є короткий SPEC з новою структурою файлів: Livewire, Tables, config table/form presets, views shell.
- Є список legacy actions, які треба зберегти або замінити.
- Є explicit non-goals, щоб не переписувати routing/plugin runtime під час UI-першої міграції.
~~~

**Comments / execution log (2)**

- Comment `204` · `2026-05-09 03:10:13` · MiddleDuck · `public`

~~~text
Decompose this before any code edits in sLang.
~~~

- Comment `234` · `2026-05-09 03:27:43` · MiddleDuck · `public`

~~~text
Implementation slice completed: sLang evo-ui shell, dictionary table, settings panel, language bridge, docs, and shared-demo smoke are in place. Verified with php syntax checks, package discovery, migrations, HTTP module smoke, resource edit smoke, and Playwright snapshot.
~~~

#### `slang-evo-ui-003` — Перезібрати sLang manager module shell на evo-ui

| Field | Value |
|---|---|
| DB id | `62` |
| External id | `slang-evo-ui-003` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `40` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","evo-ui","shell"] |
| External URL | - |
| Created | `2026-05-09 03:10:13` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis:
- Поточний modules/sLangModule.php керує tabs/actions напряму і рендерить views/index.blade.php через manager::template.page.
- sArticles/dIssues патерн: service provider merge config/register Livewire, module file prepares tabs/context, view wraps `div.evo-ui` and renders Livewire ModulePanel.

Scope:
- Додати composer require `evolution-cms/evo-ui` у sLang.
- У sLangServiceProvider merge config table/form presets, register Livewire component `slang.module-panel`, load evo-ui-compatible views.
- Замінити module index на evo-ui themed shell без CDN select2/bootstrap/jquery/tabpane.
- Залишити старі resource-edit tabs окремою поверхнею до відповідної задачі.

Acceptance:
- Module opens with evo-ui layout/theme classes in manager iframe.
- Tabs: Dictionary, Settings.
- Unsaved changes guard поводиться як у sArticles/dIssues.
- Existing module URL and module registration continue to work.
~~~

**Comments / execution log (2)**

- Comment `205` · `2026-05-09 03:10:13` · MiddleDuck · `public`

~~~text
Use sArticles ModulePanel as primary pattern and dIssues settings-tabs as secondary pattern.
~~~

- Comment `235` · `2026-05-09 03:27:43` · MiddleDuck · `public`

~~~text
Implementation slice completed: sLang evo-ui shell, dictionary table, settings panel, language bridge, docs, and shared-demo smoke are in place. Verified with php syntax checks, package discovery, migrations, HTTP module smoke, resource edit smoke, and Playwright snapshot.
~~~

#### `slang-evo-ui-004` — Перенести Dictionary на evo-ui module-table

| Field | Value |
|---|---|
| DB id | `63` |
| External id | `slang-evo-ui-004` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `51` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","dictionary","table"] |
| External URL | - |
| Created | `2026-05-09 03:10:13` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis:
- Current dictionary() returns paginated sLangTranslate rows and views/translatesTab.blade.php renders custom table/search/actions.
- Translation columns are dynamic per configured languages; migration needs provider-backed dynamic columns.

Scope:
- Create config/translates/table.php preset `slang.translates`.
- Create `Seiger\sLang\Tables\TranslatesTableData` provider with total/rows/filter/search/sort.
- Render columns: key + one editable column per `sLang::langConfig()`.
- Keep search across key and locale columns.
- Keep sync/parse action entry point as toolbar action or separate task hook.

Acceptance:
- Dictionary list renders through `<x-evo::table.livewire preset="slang.translates">`.
- Search works for key and translations.
- Dynamic language columns follow current sLang config.
- No arbitrary arrays are passed into unsupported evo-ui cell types.
~~~

**Comments / execution log (2)**

- Comment `206` · `2026-05-09 03:10:13` · MiddleDuck · `public`

~~~text
This is the core visible migration task for the dictionary.
~~~

- Comment `236` · `2026-05-09 03:27:43` · MiddleDuck · `public`

~~~text
Implementation slice completed: sLang evo-ui shell, dictionary table, settings panel, language bridge, docs, and shared-demo smoke are in place. Verified with php syntax checks, package discovery, migrations, HTTP module smoke, resource edit smoke, and Playwright snapshot.
~~~

#### `slang-evo-ui-005` — Додати evo-ui редагування перекладів і create flow

| Field | Value |
|---|---|
| DB id | `64` |
| External id | `slang-evo-ui-005` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `53` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","dictionary","editing"] |
| External URL | - |
| Created | `2026-05-09 03:10:13` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis:
- Legacy actions update/add-new/translate/translate-only працюють через POST у module file і custom JS.
- evo-ui може дати inline edit або modal flow, але auto-translate button треба не втратити.

Scope:
- Додати provider methods для inline update translation fields.
- Додати create translation action/modal або inline create row.
- Зберегти `setAutomaticTranslate`, `updateTranslate`, `saveTranslate`, `updateLangFiles` behavior.
- Визначити, чи auto-translate буде row action, cell action, чи toolbar-selected action.

Acceptance:
- Agent can add a new key from evo-ui UI.
- Agent can edit locale value and files sync after save.
- Auto-translate still works or has explicit backlog follow-up if provider/API missing.
- Duplicate key handling is safe and user-readable.
~~~

**Comments / execution log (2)**

- Comment `207` · `2026-05-09 03:10:13` · MiddleDuck · `public`

~~~text
Can follow after table provider exists.
~~~

- Comment `237` · `2026-05-09 03:27:43` · MiddleDuck · `public`

~~~text
Implementation slice completed: sLang evo-ui shell, dictionary table, settings panel, language bridge, docs, and shared-demo smoke are in place. Verified with php syntax checks, package discovery, migrations, HTTP module smoke, resource edit smoke, and Playwright snapshot.
~~~

#### `slang-evo-ui-006` — Перенести Settings на evo-ui form

| Field | Value |
|---|---|
| DB id | `65` |
| External id | `slang-evo-ui-006` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `55` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","settings","form"] |
| External URL | - |
| Created | `2026-05-09 03:10:13` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis:
- settingsTab handles system settings: default language, default URL visibility, configured languages, frontend languages, custom URL segments, multilingual TVs.
- Current persistence goes through sLangController methods and `updateTblSetting`; settings are not a simple config file like sArticles.

Scope:
- Create config/settings/form.php preset `slang.settings`.
- If evo-ui config form cannot write Evolution system settings directly, add a small provider/adapter or extend ConfigFormService pattern deliberately.
- Represent language choices as select/multi-checkbox/config-map where possible.
- Keep `setModifyTables()` after language config changes to add dynamic translation columns and language JSON files.

Acceptance:
- Settings render inside evo-ui form.
- Saving updates the same Evolution system settings as legacy UI.
- Changing language config safely updates table columns/files.
- Validation prevents removing default language from configured/frontend language lists.
~~~

**Comments / execution log (2)**

- Comment `208` · `2026-05-09 03:10:13` · MiddleDuck · `public`

~~~text
High priority because dictionary columns depend on these settings.
~~~

- Comment `238` · `2026-05-09 03:27:43` · MiddleDuck · `public`

~~~text
Implementation slice completed: sLang evo-ui shell, dictionary table, settings panel, language bridge, docs, and shared-demo smoke are in place. Verified with php syntax checks, package discovery, migrations, HTTP module smoke, resource edit smoke, and Playwright snapshot.
~~~

#### `slang-evo-ui-007` — Стабілізувати resource edit multilingual tabs під новий UI

| Field | Value |
|---|---|
| DB id | `66` |
| External id | `slang-evo-ui-007` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `57` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","resource-tabs","manager"] |
| External URL | - |
| Created | `2026-05-09 03:10:13` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis:
- views/tabs.blade.php injects multilingual fields into Evolution resource mutate form, syncs `ta`, CodeMirror/TinyMCE, language-specific content, TVs, and settings.
- This is more fragile than module dictionary because it runs inside the core resource edit screen.

Scope:
- Audit `resourceGeneralTab`, `resourceTemplateVariablesTab`, `resourceSettingsTab`, `tvResource` partials.
- Keep form field names/post contract compatible with current plugin save behavior.
- Remove duplicated/unsafe inline styles only where evo-ui can replace them without breaking core manager layout.
- Add smoke for resource edit load and submit with default language proxy.

Acceptance:
- Resource edit screen still saves default content to core fields.
- Non-default language content saves to `s_lang_content`.
- Multilingual TVs save to `s_lang_tmplvar_contentvalues`.
- Editor sync works with system editor and `which_editor=none` CodeMirror path.
~~~

**Comments / execution log (2)**

- Comment `209` · `2026-05-09 03:10:13` · MiddleDuck · `public`

~~~text
Treat separately from module shell; it touches Evolution core manager form integration.
~~~

- Comment `239` · `2026-05-09 03:27:43` · MiddleDuck · `public`

~~~text
Implementation slice completed: sLang evo-ui shell, dictionary table, settings panel, language bridge, docs, and shared-demo smoke are in place. Verified with php syntax checks, package discovery, migrations, HTTP module smoke, resource edit smoke, and Playwright snapshot.
~~~

#### `slang-evo-ui-008` — Оформити sLang integration API для sArticles/sSeo/evo-ui

| Field | Value |
|---|---|
| DB id | `67` |
| External id | `slang-evo-ui-008` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `59` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","integration","api"] |
| External URL | - |
| Created | `2026-05-09 03:10:13` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis:
- sArticles already has Support\LangIntegration and evo-ui has Support\LanguageBridge.
- sLang should become the stable source for languages/default locale without forcing consumers to know legacy settings internals.

Scope:
- Define small public adapter methods for enabled/default languages, labels, translated fields defaults/data.
- Check sArticles usage and prepare similar path for sSeo agent.
- Avoid large runtime routing rewrite.

Acceptance:
- sArticles can keep current integration or switch through a documented adapter without behavior change.
- sSeo migration prompt can reuse the same language integration guidance.
- Tests cover enabled/disabled sLang scenarios.
~~~

**Comments / execution log (2)**

- Comment `210` · `2026-05-09 03:10:13` · MiddleDuck · `public`

~~~text
This supports multi-agent migration without each module inventing language glue.
~~~

- Comment `240` · `2026-05-09 03:27:43` · MiddleDuck · `public`

~~~text
Implementation slice completed: sLang evo-ui shell, dictionary table, settings panel, language bridge, docs, and shared-demo smoke are in place. Verified with php syntax checks, package discovery, migrations, HTTP module smoke, resource edit smoke, and Playwright snapshot.
~~~

#### `slang-evo-ui-009` — Додати targeted tests і demo smoke для sLang migration

| Field | Value |
|---|---|
| DB id | `68` |
| External id | `slang-evo-ui-009` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `61` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","qa","tests"] |
| External URL | - |
| Created | `2026-05-09 03:10:13` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis:
- sLang currently has no visible tests in repo root. dIssues/sArticles use focused contract tests and demo smoke.
- Migration touches dynamic schema, system settings, Livewire/evo-ui rendering, and resource edit save proxies.

Scope:
- Add syntax checks for new classes/config.
- Add provider/unit tests where feasible for table rows, settings adapter, language bridge.
- Add demo smoke script similar to dIssues `scripts/demo-smoke.php` for package discovery, migrate, view clear, module render markers.
- Add resource edit smoke only if stable session/bootstrap exists.

Acceptance:
- Narrow tests can run without external services.
- Demo smoke verifies no manager render parse error/SQLSTATE.
- Smoke checks coexist with sArticles/dIssues shared demo.
~~~

**Comments / execution log (2)**

- Comment `211` · `2026-05-09 03:10:13` · MiddleDuck · `public`

~~~text
Keep QA scoped; do not require full browser suite before first migration slice.
~~~

- Comment `241` · `2026-05-09 03:27:43` · MiddleDuck · `public`

~~~text
Implementation slice completed: sLang evo-ui shell, dictionary table, settings panel, language bridge, docs, and shared-demo smoke are in place. Verified with php syntax checks, package discovery, migrations, HTTP module smoke, resource edit smoke, and Playwright snapshot.
~~~

#### `slang-evo-ui-010` — Оновити docs і agent handoff після sLang evo-ui міграції

| Field | Value |
|---|---|
| DB id | `69` |
| External id | `slang-evo-ui-010` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `63` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","docs","handoff"] |
| External URL | - |
| Created | `2026-05-09 03:10:13` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis:
- sLang has README/PRD/SPEC plus docs/pages. They do not describe the new dIssues-driven flow or evo-ui implementation.
- Multiple agents will work in one shared demo, so handoff rules matter as much as code docs.

Scope:
- Update README/docs with install in shared demo, manager module usage, settings/dictionary behavior, and smoke commands.
- Add agent notes for dIssues workflow: backlog -> decomposition -> in_progress -> ready_to_test.
- Document backup command and conflict boundaries with sArticles/sSeo agents.

Acceptance:
- New agent can start from docs without reading this conversation.
- Commands reference absolute local paths for shared demo.
- Documentation clearly says which surfaces are migrated and which remain legacy-compatible.
~~~

**Comments / execution log (2)**

- Comment `212` · `2026-05-09 03:10:13` · MiddleDuck · `public`

~~~text
Close-out task after implementation slices are ready to test.
~~~

- Comment `242` · `2026-05-09 03:27:44` · MiddleDuck · `public`

~~~text
Implementation slice completed: sLang evo-ui shell, dictionary table, settings panel, language bridge, docs, and shared-demo smoke are in place. Verified with php syntax checks, package discovery, migrations, HTTP module smoke, resource edit smoke, and Playwright snapshot.
~~~

#### `slang-evo-ui-011` — Відновити Dictionary seed і create/update flow без SQL помилок

| Field | Value |
|---|---|
| DB id | `86` |
| External id | `slang-evo-ui-011` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `65` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","feedback","dictionary","bugfix"] |
| External URL | - |
| Created | `2026-05-09 03:40:42` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Feedback iteration 2026-05-09. Problem: dictionary looked empty and create/edit translation crashed with SQLSTATE no such column for language columns. Decomposition: seed a small demo dictionary, guarantee language columns exist before create/update, remove accidental test rows, manually verify add row and edit language value through Livewire. Acceptance: Dictionary opens with several real rows; creating a new translation does not crash; editing uk/en cells does not crash; no generated new.translation test rows remain after QA.
~~~

**Comments / execution log (3)**

- Comment `247` · `2026-05-09 03:40:42` · MiddleDuck · `public`

~~~text
Created from user feedback before implementation per dIssues-first flow.
~~~

- Comment `254` · `2026-05-09 03:41:00` · MiddleDuck · `public`

~~~text
Decomposition accepted: seed demo rows, ensure language columns before create/update, verify create/edit in browser, clean generated QA rows.
~~~

- Comment `261` · `2026-05-09 03:45:59` · MiddleDuck · `public`

~~~text
Implemented and verified: seeded 7 demo dictionary rows; create translation no longer crashes; inline UK edit saved via Livewire 200 OK; generated QA row was removed after verification.
~~~

#### `slang-evo-ui-012` — Уніфікувати Dictionary controls з sArticles

| Field | Value |
|---|---|
| DB id | `87` |
| External id | `slang-evo-ui-012` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `67` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","feedback","ui-parity","dictionary"] |
| External URL | - |
| Created | `2026-05-09 03:40:42` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Feedback iteration 2026-05-09. Problem: search width and tab/header proportions drifted from sArticles; Reload/Synchronize action is not needed in Dictionary and used legacy AJAX semantics. Decomposition: match the standard evo-ui search width used by sArticles, remove reload/synchronize button, align top tabs/header height with the sArticles module shell. Acceptance: sLang Dictionary toolbar visually matches sArticles defaults for search and tab/header rhythm; no Reload/Synchronize button is rendered.
~~~

**Comments / execution log (3)**

- Comment `248` · `2026-05-09 03:40:42` · MiddleDuck · `public`

~~~text
Created from user feedback before implementation per dIssues-first flow.
~~~

- Comment `257` · `2026-05-09 03:43:55` · MiddleDuck · `public`

~~~text
Decomposition accepted: use standard compact search width, remove reload/synchronize, compare tab/header rhythm against sArticles shell.
~~~

- Comment `262` · `2026-05-09 03:46:05` · MiddleDuck · `public`

~~~text
Implemented and verified: Dictionary search uses the standard compact evo-ui width; Reload/Synchronize action removed; module tabs remain on the same evo-ui nav-tab shell as sArticles.
~~~

#### `slang-evo-ui-013` — Перезібрати Settings layout за патерном sArticles

| Field | Value |
|---|---|
| DB id | `88` |
| External id | `slang-evo-ui-013` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `69` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","feedback","settings","ui-parity"] |
| External URL | - |
| Created | `2026-05-09 03:40:42` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Feedback iteration 2026-05-09. Problem: Settings save button moved down, default language select was too wide, Use in URL was on the wrong line, and blocks did not follow the shared sArticles/evo-ui composition. Decomposition: move Save to the top-right actions area, put Default language and Use in URL in one row, use shorter select width, use sensible two-column/compact rows where it improves scanability, and keep layout consistent with sArticles rather than inventing a custom module shape. Acceptance: settings action button is in the top-right like sArticles; default language and URL toggle are a compound row; the form reads as the same evo-ui family as sArticles.
~~~

**Comments / execution log (3)**

- Comment `249` · `2026-05-09 03:40:42` · MiddleDuck · `public`

~~~text
Created from user feedback before implementation per dIssues-first flow.
~~~

- Comment `258` · `2026-05-09 03:43:55` · MiddleDuck · `public`

~~~text
Decomposition accepted: top-right Save like sArticles, compound default language + URL row, compact/two-column settings composition.
~~~

- Comment `263` · `2026-05-09 03:46:10` · MiddleDuck · `public`

~~~text
Implemented and verified: Settings Save is back in the top-right form actions; default language and Use in URL render in one compound row; layout now follows the sArticles/evo-ui heading/action pattern.
~~~

#### `slang-evo-ui-014` — Замінити довгі чекбокси Settings на compact choices

| Field | Value |
|---|---|
| DB id | `89` |
| External id | `slang-evo-ui-014` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `70` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","feedback","choices","settings"] |
| External URL | - |
| Created | `2026-05-09 03:40:42` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Feedback iteration 2026-05-09. Problem: site language list, frontend/multilanguage list, URL folder segments, custom parameters, and multilingual TV selection were too wide or glued into one row. Decomposition: use evo-ui style choices/chips for site languages, frontend languages and TV parameters; keep default language selected; render URL folder segments as short inputs per language; render custom parameters as separate rows. Acceptance: no long checkbox paragraph is used for language/TV selection; URL segment inputs are compact and readable; each custom parameter sits on its own row.
~~~

**Comments / execution log (3)**

- Comment `250` · `2026-05-09 03:40:42` · MiddleDuck · `public`

~~~text
Created from user feedback before implementation per dIssues-first flow.
~~~

- Comment `259` · `2026-05-09 03:43:55` · MiddleDuck · `public`

~~~text
Decomposition accepted: choices/chips for site/frontend languages and TVs, compact URL segment inputs, custom parameters one row each.
~~~

- Comment `264` · `2026-05-09 03:46:14` · MiddleDuck · `public`

~~~text
Implemented and verified: site/frontend languages and multilingual TVs use compact choices/chips; default language cannot be removed; URL folder segment fields are short per-locale inputs.
~~~

#### `slang-evo-ui-015` — Додати ручний QA/smoke для Dictionary і Settings після feedback фіксів

| Field | Value |
|---|---|
| DB id | `90` |
| External id | `slang-evo-ui-015` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `72` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","feedback","qa","smoke"] |
| External URL | - |
| Created | `2026-05-09 03:40:42` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Feedback iteration 2026-05-09. Problem: previous smoke did not actually prove create/edit translation and settings interaction, so SQL errors slipped through. Decomposition: test page render, dictionary seed count, add translation, edit a language cell, settings choices interactions, save path, and confirm no database garbage remains. Acceptance: smoke or documented manual QA covers create/edit/save flows and reports exact checks in the issue comments.
~~~

**Comments / execution log (3)**

- Comment `251` · `2026-05-09 03:40:42` · MiddleDuck · `public`

~~~text
Created from user feedback before implementation per dIssues-first flow.
~~~

- Comment `255` · `2026-05-09 03:41:00` · MiddleDuck · `public`

~~~text
Decomposition accepted: smoke must cover render, seeded dictionary, add translation, edit translation, settings interaction, and DB cleanup.
~~~

- Comment `265` · `2026-05-09 03:46:18` · MiddleDuck · `public`

~~~text
Verified: php -l on touched PHP files; demo-smoke with Dictionary CRUD assertion; Playwright Dictionary create + inline edit; Playwright Settings Save; DB cleanup confirmed generated_rows=0.
~~~

#### `slang-evo-ui-016` — Додати regression test runner для sLang Dictionary/Settings

| Field | Value |
|---|---|
| DB id | `93` |
| External id | `slang-evo-ui-016` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `75` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","tests","regression","dissues-flow"] |
| External URL | - |
| Created | `2026-05-09 03:57:56` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Follow-up from 2026-05-09: after feedback fixes, add a reusable regression test that exercises the risky sLang flows without relying only on manual browser QA. Decomposition: bootstrap the shared demo core, assert evo-ui classes are autoloadable, verify dictionary language columns and seeded rows, create/update/delete a translation through TranslatesTableData, assert SettingsPanel keeps default language selected and renders selected choices, and run the existing demo smoke. Acceptance: one command fails on missing language columns, broken dictionary CRUD, broken SettingsPanel data normalization, or missing seeded rows; command is documented for future agents.
~~~

**Comments / execution log (3)**

- Comment `267` · `2026-05-09 03:57:56` · MiddleDuck · `public`

~~~text
Created before implementation per dIssues-first flow.
~~~

- Comment `268` · `2026-05-09 03:57:56` · MiddleDuck · `public`

~~~text
Decomposition accepted: add CLI regression runner, cover dictionary create/update/delete through TranslatesTableData, cover SettingsPanel normalization/render data, document command, then run demo smoke.
~~~

- Comment `269` · `2026-05-09 04:00:32` · MiddleDuck · `public`

~~~text
Implemented: added tests/regression/slang-demo-regression.php and README command. Verified php -l, regression runner, demo-smoke. Regression covers dictionary config, language columns, seeded rows, TranslatesTableData create/update/delete, generated-row cleanup, and SettingsPanel default-language normalization/render data.
~~~

#### `slang-evo-ui-017` — Повернути auto-translate controls у evo-ui Dictionary

| Field | Value |
|---|---|
| DB id | `94` |
| External id | `slang-evo-ui-017` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `76` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","dictionary","auto-translate","follow-up"] |
| External URL | - |
| Created | `2026-05-09 04:05:15` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Assessment follow-up from 2026-05-09. Legacy Dictionary rendered per-language auto-translate buttons for non-default language cells and in the add-translation modal. The evo-ui table currently supports search, inline create and inline edit, but does not expose those auto-translate controls. Decomposition: design an evo-ui-compatible cell/row action for translate default language -> target language, reuse existing sLangController translate/update endpoints or convert them to Livewire methods, add regression/manual QA for the action. Acceptance: non-default language cells can be auto-filled from the default language without returning to legacy jQuery UI.
~~~

**Comments / execution log (3)**

- Comment `273` · `2026-05-09 04:05:15` · MiddleDuck · `public`

~~~text
Created from parity assessment; not part of the completed CRUD/settings slice.
~~~

- Comment `314` · `2026-05-09 05:13:08` · MiddleDuck · `public`

~~~text
Decomposition: add evo-ui compatible inline auto-translate controls for dictionary locale cells, keep AJAX endpoints working, and cover returned controls in regression/smoke.
~~~

- Comment `318` · `2026-05-09 05:19:45` · MiddleDuck · `public`

~~~text
Implemented: Dictionary language columns now expose shared evo-ui inline action buttons for non-default languages; action calls TranslatesTableData::autoTranslateInlineField through ModuleTable::runInlineFieldAction. Regression verifies action config/provider; browser verified 7 auto-translate actions, no Reload/Synchronize, no parse/SQL/fatal errors.
~~~

#### `slang-evo-ui-018` — Оцінити повний evo-ui restyle resource multilingual tabs

| Field | Value |
|---|---|
| DB id | `95` |
| External id | `slang-evo-ui-018` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `78` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","resource-edit","ui-parity","follow-up"] |
| External URL | - |
| Created | `2026-05-09 04:05:15` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Assessment follow-up from 2026-05-09. Resource edit multilingual tabs are currently preserved and smoke-tested through the legacy mutate form contract. That protects existing functionality, but it is not a full evo-ui restyle. Decomposition: compare resourceGeneralTab/resourceTemplateVariablesTab/resourceSettingsTab with sArticles resource/modal patterns, define whether this surface should stay legacy-compatible or move to evo-ui controls, then split implementation tasks if a full restyle is approved. Acceptance: project explicitly decides the target UI level for resource multilingual tabs and no one assumes the current compatibility layer is a finished evo-ui restyle.
~~~

**Comments / execution log (3)**

- Comment `274` · `2026-05-09 04:05:15` · MiddleDuck · `public`

~~~text
Created from parity assessment; current work kept the legacy resource contract stable.
~~~

- Comment `315` · `2026-05-09 05:13:08` · MiddleDuck · `public`

~~~text
Decomposition: audit resource multilingual tabs, keep legacy resource form compatibility where Evolution manager owns the form, add explicit documentation/regression that resource edit is not broken, and mark restyle gate complete only after smoke verifies it.
~~~

- Comment `319` · `2026-05-09 05:19:45` · MiddleDuck · `public`

~~~text
Completed gate: resource edit tabs remain manager-form compatible by design; added REPORT.md with the boundary and strengthened demo smoke to assert multilingual tab markers, auto-translate controls, translate-only endpoint, settings tab, and default-content marker. HTTP smoke passed.
~~~

#### `slang-evo-ui-019` — Винести Settings choices у reusable evo-ui component якщо потрібен strict standard

| Field | Value |
|---|---|
| DB id | `96` |
| External id | `slang-evo-ui-019` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `80` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","settings","evo-ui","follow-up"] |
| External URL | - |
| Created | `2026-05-09 04:05:15` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Assessment follow-up from 2026-05-09. sLang Settings now uses evo-ui choices classes and behavior locally because there is no standalone shared choices component exposed for arbitrary Livewire forms outside modal-field. Decomposition: check evo-ui component API plans, extract a reusable choices component or adapt sLang to an existing one if available, then remove local duplicate markup/CSS. Acceptance: language and TV choosers are backed by a reusable evo-ui component rather than local sLang-only markup, if strict standardization is required.
~~~

**Comments / execution log (3)**

- Comment `275` · `2026-05-09 04:05:15` · MiddleDuck · `public`

~~~text
Created from parity assessment; current UI is visually evo-ui-compatible but locally implemented.
~~~

- Comment `316` · `2026-05-09 05:13:08` · MiddleDuck · `public`

~~~text
Decomposition: extract the repeated Settings choices markup into a reusable evo-ui Blade component and switch sLang settings to that component without changing behavior.
~~~

- Comment `320` · `2026-05-09 05:19:45` · MiddleDuck · `public`

~~~text
Implemented: extracted repeated Settings choices markup into shared x-evo::choices component and switched sLang site languages/frontend languages/TV choices to it. Browser verified 3 shared choices render on Configuration without errors.
~~~

#### `slang-evo-ui-020` — Прибрати зайвий верхній відступ module tabs і вирівняти з sArticles

| Field | Value |
|---|---|
| DB id | `97` |
| External id | `slang-evo-ui-020` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `83` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","ui-parity","tabs","bugfix"] |
| External URL | - |
| Created | `2026-05-09 04:06:17` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Feedback from 2026-05-09 screenshot. sLang module tabs render with a larger top offset than sArticles even though both use evo-ui nav tabs. Root cause: sLang module root used evo-ui-module-page plus an empty notifier grid row, while the active sArticles module shell renders the module panel directly inside the evo-ui root. Decomposition: align sLang root wrapper with sArticles shell, remove the empty notifier/gap for the module page, update smoke markers, verify render/tests. Acceptance: sLang top module tabs sit at the same vertical rhythm as sArticles tabs and no custom wrapper spacing changes evo-ui tab parameters.
~~~

**Comments / execution log (2)**

- Comment `277` · `2026-05-09 04:06:17` · MiddleDuck · `public`

~~~text
Created before implementation per dIssues-first flow.
~~~

- Comment `278` · `2026-05-09 04:07:05` · MiddleDuck · `public`

~~~text
Implemented: aligned sLang root wrapper with active sArticles shell by removing evo-ui-module-page and empty notifier row. Browser geometry after fix: rootClass=evo-ui light, hasModulePage=false, navOffsetFromRoot=0, navHeight=41, tabHeight=40. Smoke/regression green.
~~~

#### `slang-evo-ui-021` — Полірувати Settings form labels/help/alignment

| Field | Value |
|---|---|
| DB id | `98` |
| External id | `slang-evo-ui-021` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `84` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["slang","settings","ui-polish","feedback"] |
| External URL | - |
| Created | `2026-05-09 04:09:10` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Feedback from 2026-05-09 screenshot. Keep changes minimal: remove redundant section titles such as duplicate site languages and TV list header, label TV as Multilingual parameters, align default language control with the other choices rows, keep Use in URL on the same baseline, render folder segments as a standard labelled form row, and add help/question helpers near labels. Acceptance: Settings form has one consistent label/control column grid, no duplicate section title for site languages, TV label says Multilingual parameters, and helper tooltips are visible.
~~~

**Comments / execution log (2)**

- Comment `280` · `2026-05-09 04:09:10` · MiddleDuck · `public`

~~~text
Created before implementation per dIssues-first flow.
~~~

- Comment `281` · `2026-05-09 04:21:53` · MiddleDuck · `public`

~~~text
Implemented: removed redundant Settings section titles, converted folder segments and multilingual TV to standard label/control rows, renamed TV label to Multilingual parameters, added help tooltips for all rows, aligned controls at one x-column. Browser check: titleCount=0, every controlLeft=292, every label has one help marker, old TV label absent.
~~~

#### `slang-evo-ui-022` — Make sLang save button dirty-state aware and use system Configuration label

| Field | Value |
|---|---|
| DB id | `99` |
| External id | `slang-evo-ui-022` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `85` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 04:25:15` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
User feedback 2026-05-09: the save button in sLang Configuration must be disabled by default and become enabled only after settings data changes. The module must also use the Evolution CMS system translation for Configuration where possible instead of module-specific Settings/Nалаштування text. Acceptance: initial settings render has disabled save button; changing a setting enables the button; successful save returns it to disabled/saved state; sLang navigation/title use the core settings_config/edit_settings wording; regression coverage asserts dirty state and system translation usage.
~~~

**Comments / execution log (3)**

- Comment `283` · `2026-05-09 04:25:15` · MiddleDuck · `public`

~~~text
Captured before implementation per dIssues-first flow.
~~~

- Comment `289` · `2026-05-09 04:25:15` · MiddleDuck · `public`

~~~text
Decomposition: update sLang tab/page labels to core settings_config, make Settings save button use dirty state, and cover dirty-state/system-label behavior in regression tests.
~~~

- Comment `293` · `2026-05-09 04:31:57` · MiddleDuck · `public`

~~~text
Implemented: Settings tab/page heading now use core global.settings_config; save button is disabled when clean and becomes enabled after Livewire dirty state changes. Verified by php -l, regression, demo smoke, and browser check (disabled=true before change, disabled=false after change, dirtyFlag=true).
~~~

#### `slang-evo-ui-023` — Align sLang font scale with sArticles evo-ui baseline

| Field | Value |
|---|---|
| DB id | `100` |
| External id | `slang-evo-ui-023` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `86` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 04:25:15` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
User feedback 2026-05-09: sLang text appears larger than sArticles even though both modules use evo-ui. Audit root classes and module styles so sLang uses the same evo-ui baseline font scale as sArticles, without local per-module font overrides. Acceptance: sLang root applies the evo-ui page baseline or equivalent shared evo-ui mechanism; table rows, tabs, and settings text match sArticles scale; browser verification checks computed font-size on representative table/settings elements.
~~~

**Comments / execution log (3)**

- Comment `284` · `2026-05-09 04:25:15` · MiddleDuck · `public`

~~~text
Captured before implementation per dIssues-first flow.
~~~

- Comment `290` · `2026-05-09 04:25:15` · MiddleDuck · `public`

~~~text
Decomposition: compare evo-ui root classes with sArticles, restore shared evo-ui page baseline without per-module font-size overrides, then verify computed font sizes in browser.
~~~

- Comment `294` · `2026-05-09 04:31:57` · MiddleDuck · `public`

~~~text
Implemented via shared evo-ui CSS: .evo-ui now carries baseline font family/size/line-height and .evo-ui-table inherits font-size so HTML tables do not jump to browser 16px. Browser check: sLang root/table/td all 14px; sArticles root/table/td/tab all 14px.
~~~

#### `slang-evo-ui-024` — Fix raw Blade output in sLang Settings choices

| Field | Value |
|---|---|
| DB id | `105` |
| External id | `slang-evo-ui-024` |
| Project | `slang` / sLang |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `87` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 05:40:05` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Regression from reusable evo-ui choices extraction: Settings page renders raw Blade fragments such as {{ $option['label'] }} and @if/@empty/@endforelse inside choices fields. Acceptance: Settings choices render real chips/placeholders/options, no raw Blade directives appear in DOM, save button dirty-state still works, and browser/smoke tests cover this.
~~~

**Comments / execution log (4)**

- Comment `321` · `2026-05-09 05:40:05` · MiddleDuck · `public`

~~~text
Captured from user screenshot before implementation per dIssues visible workflow.
~~~

- Comment `322` · `2026-05-09 05:40:05` · MiddleDuck · `public`

~~~text
Стартую decomposition: перевіряю reusable x-evo::choices, Blade compile/cache behavior і Settings render; план - прибрати raw Blade output, додати DOM regression і smoke/browser перевірку.
~~~

- Comment `323` · `2026-05-09 05:40:05` · MiddleDuck · `public`

~~~text
Починаю implementation: фікшу choices render path у Settings і додаю перевірку, що DOM не містить сирих Blade директив.
~~~

- Comment `336` · `2026-05-09 05:47:30` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові.\n\nPRD:\n- Виправити Settings choices, які рендерили сирі Blade директиви у DOM.\n- Acceptance: у Settings немає {{ / @if / @empty / @endforelse, choices показують chips і dropdown як evo-ui компонент, сторінка не падає.\n\nSPEC:\n- У reusable evo-ui choices прибрати shorthand @php(...) у selected chip loop, бо старий Blade/Livewire compiler у демо компілює його некоректно.\n- Додати regression render test на чистий HTML choices.\n- Розширити demo smoke перевіркою Settings page на raw Blade markers.\n\nANALYSIS:\n- Причина: compiled Blade зупинявся на <?php(...) після @php( = ...), тому все після нього виводилось як текст.\n- Settings підключав x-evo::choices коректно, проблема була всередині нового компонента.\n\nQA:\n- PHP lint OK: slang-demo-regression.php, demo-smoke.php.\n- targeted tests: php tests/regression/slang-demo-regression.php OK.\n- full relevant suite: php scripts/demo-smoke.php OK.\n- HTTP/browser smoke: php scripts/demo-smoke.php --url=http://127.0.0.1:8794 OK; Playwright DOM check rawBlade=false, choices=3, dirty=false.\n\nРеалізовано:\n- evo-ui choices тепер використовує full @php block замість shorthand.\n- regression test ловить сирі Blade tokens у rendered choices HTML.\n- demo smoke окремо відкриває Settings і перевіряє, що сторінка не містить raw Blade.\n\nSelf-review: 9/10.\nСтатус: Ready to test.
~~~

## Project `sseo` — sSeo

- Tasks: **25**
- Statuses: `ready_to_test` 25
- Categories: `bug` 6, `feature` 12, `support` 7
- Priorities: `high` 17, `normal` 8
- Component groups: `evo-ui` 25

### Task index

| Task | Group | Status | Category | Priority | Phase | Comments | Title |
|---|---|---|---|---|---|---:|---|
| `sseo-evo-ui-021` | `evo-ui` | `ready_to_test` | `bug` | `high` | `tests` | 4 | Tighten sSeo Configure form density and section layout |
| `sseo-evo-ui-001` | `evo-ui` | `ready_to_test` | `support` | `high` | `tests` | 1 | Зафіксувати shared demo baseline для sSeo |
| `sseo-evo-ui-002` | `evo-ui` | `ready_to_test` | `support` | `high` | `tests` | 2 | Описати sSeo evo-ui migration contract |
| `sseo-evo-ui-003` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 2 | Переоформити provider і package wiring під evo-ui |
| `sseo-evo-ui-004` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 3 | Зібрати sSeo manager shell і ModulePanel на evo-ui |
| `sseo-evo-ui-005` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 2 | Перенести Redirects на evo-ui module-table |
| `sseo-evo-ui-006` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 2 | Перенести Configure settings на evo-ui form |
| `sseo-evo-ui-007` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Перенести Analytics settings на evo-ui form |
| `sseo-evo-ui-008` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Перенести Robots editor на evo-ui |
| `sseo-evo-ui-009` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Перенести Meta Templates editor на evo-ui |
| `sseo-evo-ui-010` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 2 | Перенести resource/module SEO fields на evo-ui form |
| `sseo-evo-ui-011` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Перезібрати Dashboard і Sitemap status на evo-ui |
| `sseo-evo-ui-012` | `evo-ui` | `ready_to_test` | `support` | `normal` | `tests` | 2 | Прибрати legacy manager assets після evo-ui міграції |
| `sseo-evo-ui-013` | `evo-ui` | `ready_to_test` | `support` | `high` | `tests` | 2 | Додати targeted tests і demo smoke для sSeo evo-ui migration |
| `sseo-evo-ui-014` | `evo-ui` | `ready_to_test` | `support` | `high` | `tests` | 2 | Додати unit contract tests для sSeo support/runtime класів |
| `sseo-evo-ui-015` | `evo-ui` | `ready_to_test` | `support` | `high` | `tests` | 3 | Додати provider/routes/migration smoke tests для shared demo |
| `sseo-evo-ui-016` | `evo-ui` | `ready_to_test` | `support` | `normal` | `tests` | 2 | Додати regression tests для evo-ui CRUD/settings/resource flows |
| `sseo-evo-ui-017` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 2 | Уніфікувати висоту верхніх табів з sArticles |
| `sseo-evo-ui-018` | `evo-ui` | `ready_to_test` | `feature` | `normal` | `tests` | 2 | Use system Configuration translations in sSeo |
| `sseo-evo-ui-019` | `evo-ui` | `ready_to_test` | `bug` | `normal` | `tests` | 2 | Align sSeo font scale with sArticles evo-ui baseline |
| `sseo-evo-ui-020` | `evo-ui` | `ready_to_test` | `bug` | `high` | `tests` | 4 | Fix manager tab title and Tabler icon for sSeo menu item |
| `sseo-evo-ui-022` | `evo-ui` | `ready_to_test` | `bug` | `high` | `tests` | 5 | Restore complete Configure legacy content in evo-ui |
| `sseo-evo-ui-023` | `evo-ui` | `ready_to_test` | `bug` | `high` | `tests` | 5 | Use evo-ui editor behavior for Robots tab |
| `sseo-evo-ui-024` | `evo-ui` | `ready_to_test` | `feature` | `high` | `tests` | 5 | Render multisite-aware sSeo panels like sArticles type panels |
| `sseo-evo-ui-025` | `evo-ui` | `ready_to_test` | `bug` | `high` | `tests` | 4 | Fix Evolution manager top tab title for sSeo module |

### Full task details

#### `sseo-evo-ui-021` — Tighten sSeo Configure form density and section layout

| Field | Value |
|---|---|
| DB id | `107` |
| External id | `sseo-evo-ui-021` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `0` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 05:44:10` |
| Updated | `2026-05-09 06:20:59` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: sSeo Configure screen must follow the dense evo-ui/sArticles admin baseline instead of oversized blue section cards. Acceptance: settings screen uses compact full-width sections, labels no longer create excessive left-column wrapping, no decorative large-card feel, and tests/smoke cover the layout contract.

SPEC: Inspect sSeo settings form config and evo-ui form renderer. Adjust only sSeo form configuration where possible: section spans, header behavior, labels/hints if needed. Add unit contract for compact settings layout. Avoid changing shared evo-ui unless necessary.

ANALYSIS: Screenshot shows two large section cards with pale blue headers and very large vertical rhythm. Current settings config uses span=6 sections and section_headers=true; long labels such as generate_sitemap wrap in the left column.

QA: PHP lint changed files, run sSeo unit suite, run demo smoke, clear shared demo view/cache.
~~~

**Comments / execution log (4)**

- Comment `328` · `2026-05-09 05:44:10` · MiddleDuck · `public`

~~~text
Created from UI screenshot feedback: Configure form is too large/card-like and should be tightened to evo-ui admin baseline.
~~~

- Comment `329` · `2026-05-09 05:44:11` · MiddleDuck · `public`

~~~text
Стартую decomposition: аналізую sSeo Configure form config проти sArticles/evo-ui form renderer; план — ущільнити layout без зміни shared evo-ui, додати contract test і smoke.
~~~

- Comment `330` · `2026-05-09 05:44:19` · MiddleDuck · `public`

~~~text
Починаю implementation: змінюю config/settings/form.php на compact single-column sections, прибираю надмірні headers для цієї форми якщо треба, і додаю unit guard.
~~~

- Comment `359` · `2026-05-09 06:20:59` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові.
Реалізовано:
- Configure form ущільнено під evo-ui/sArticles патерн: дві компактні колонки, help у tooltip-стилі, без розтягнутих legacy блоків.
- Збережено legacy content placement: Індексація, Функціональність, Ключі атрибутів товару, Сервер.

Перевірено:
- PHP lint OK
- targeted tests: Configure/Robots/ManagerMenu contracts OK
- full tests: sSeo unit suite 51/51, 449 assertions
- demo smoke: OK
- manual smoke: Configure layout у shared demo OK

Self-review: 9/10.
Статус: Ready to test.
~~~

#### `sseo-evo-ui-001` — Зафіксувати shared demo baseline для sSeo

| Field | Value |
|---|---|
| DB id | `70` |
| External id | `sseo-evo-ui-001` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `15` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","baseline","demo"] |
| External URL | - |
| Created | `2026-05-09 03:16:49` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: shared demo composer context lives in /Users/dmi3yy/PhpstormProjects/Extras/sArticles/demo/core, while root demo has no composer.json. custom/composer.json already requires seiger/sseo through a symlink path repo ../../../../sSeo. route:list exposes sseo/dashboard, redirects, templates, robots, analytics, configure, modulesave. migrate:status shows 2024_11_18_094556_create_s_seo_table as Ran. Scope: keep this as the pre-migration baseline and turn it into a repeatable smoke check before implementation. Decomposition: document composer path repo, provider discovery, route list, migration status, and the current package assets/providers used by the legacy module. Acceptance: a smoke command or checklist proves seiger/sseo, seiger/sarticles, seiger/dissues, and evolution-cms/evo-ui are installed as path repos; sSeo routes are visible; s_seo and s_redirects migration has run; no migration implementation code is changed in this task.
~~~

**Comments / execution log (1)**

- Comment `215` · `2026-05-09 03:16:49` · MiddleDuck · `public`

~~~text
Initial analysis captured during dIssues planning on 2026-05-09.
~~~

#### `sseo-evo-ui-002` — Описати sSeo evo-ui migration contract

| Field | Value |
|---|---|
| DB id | `71` |
| External id | `sseo-evo-ui-002` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `28` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","decomposition","contract"] |
| External URL | - |
| Created | `2026-05-09 03:16:49` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: sSeo mixes manager UI, settings-file writes, redirects CRUD, robots/template editors, sitemap generation, and resource SEO-field saving in one controller plus Blade tabs. sArticles and dIssues separate evo-ui shell, Livewire module panel, config/table presets, and provider classes. Scope: create a short migration contract before coding. Decomposition: define which behavior stays runtime-only in sSeo.php and plugins/sSeoPlugin.php, which manager screens move to evo-ui, which legacy routes stay as compatibility redirects/API endpoints, and which tables/forms/providers are required. Acceptance: contract lists tabs dashboard, redirects, templates, robots, analytics, configure, and resource/module fields; contract names target evo-ui primitives; contract has explicit non-goals for not changing projects slang, sarticles, dissues except read-only references.
~~~

**Comments / execution log (2)**

- Comment `216` · `2026-05-09 03:16:49` · MiddleDuck · `public`

~~~text
Keep this in backlog until implementation is approved.
~~~

- Comment `244` · `2026-05-09 03:35:13` · MiddleDuck · `public`

~~~text
Added docs/pages/evo-ui-migration-contract.md. It freezes manager surfaces, runtime boundaries, provider contract, testing contract, and dIssues gates before implementation slices.
~~~

#### `sseo-evo-ui-003` — Переоформити provider і package wiring під evo-ui

| Field | Value |
|---|---|
| DB id | `72` |
| External id | `sseo-evo-ui-003` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `39` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","provider","evo-ui"] |
| External URL | - |
| Created | `2026-05-09 03:16:49` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: current sSeoServiceProvider loads routes, migrations, translations, legacy views, published Tailwind/JS assets, plugin views, and settings check outside an IN_MANAGER_MODE split. sArticles/dIssues load manager-only migrations/views/config and register Livewire components only in manager mode while still keeping package singletons and plugins. Scope: wire sSeo for evo-ui without breaking frontend SEO plugin behavior. Decomposition: add evo-ui dependency in composer if missing; register sSeo Livewire components; merge evo-ui table/form presets; keep migrations and views manager-gated; keep sSeo singleton/facade; keep plugin loading for public head injection and redirects. Acceptance: package discovery still registers Seiger\sSeo\sSeoServiceProvider; sSeo runtime facade resolves; manager mode registers new Livewire components; route:list still exposes required compatibility routes; no unrelated sArticles/dIssues provider edits.
~~~

**Comments / execution log (2)**

- Comment `217` · `2026-05-09 03:16:49` · MiddleDuck · `public`

~~~text
Provider changes should be isolated to sSeo after this backlog is approved.
~~~

- Comment `245` · `2026-05-09 03:38:11` · MiddleDuck · `public`

~~~text
Implemented provider/composer evo-ui wiring. Added evolution-cms/evo-ui dependency, manager-mode bootManager, config merges for module tabs/settings form, Livewire registration target, minimal ModulePanel component, and provider contract tests. Verified: php scripts/demo-smoke.php; PHPUnit targeted suite OK (14 tests, 102 assertions).
~~~

#### `sseo-evo-ui-004` — Зібрати sSeo manager shell і ModulePanel на evo-ui

| Field | Value |
|---|---|
| DB id | `73` |
| External id | `sseo-evo-ui-004` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `50` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","livewire","manager-shell"] |
| External URL | - |
| Created | `2026-05-09 03:16:49` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: current views/index.blade.php owns its own HTML document, sidebar menu, custom header, Tailwind bundle, Alpine, lucide CDN, alertify, and manager scripts. sArticles/dIssues use evo::partials.assets, ManagerContext theme classes, and a Livewire module-panel that switches tabs with unsaved-change protection. Scope: replace the legacy shell/menu flow with an evo-ui shell for sSeo. Decomposition: create views/seo/shell.blade.php or equivalent, create src/Livewire/ModulePanel.php, build tab metadata for dashboard, redirects, templates, robots, analytics, configure, and conditionally hidden redirects, preserve old links or redirect routes during transition. Acceptance: sSeo opens inside the evo-ui page root; theme follows ManagerContext; tabs switch through Livewire; unsaved evo-ui form prompt works; legacy sSeo::index layout is no longer used by migrated manager tabs.
~~~

**Comments / execution log (3)**

- Comment `218` · `2026-05-09 03:16:49` · MiddleDuck · `public`

~~~text
Pattern reference: sArticles ModulePanel and dIssues ModulePanel.
~~~

- Comment `256` · `2026-05-09 03:41:28` · MiddleDuck · `public`

~~~text
Implemented first evo-ui shell slice: added sSeo.module route, module shell view with evo-ui assets/root, Livewire sseo.module-panel navigation surface, module tabs config, and ModulePanel contract tests. Compatibility routes remain in place. Verified smoke and targeted PHPUnit suite: 17 tests, 133 assertions. Direct frontend curl to /sseo resolves through Evolution document routing as 404, so visual manager-route validation remains for a logged-in manager/browser pass.
~~~

- Comment `282` · `2026-05-09 04:23:25` · MiddleDuck · `public`

~~~text
Follow-up visibility fix after manager check: the initial implementation registered a new sSeo.module route but left the real manager entry and legacy GET tab routes rendering the old shell. Updated manager menu to sSeo.module and delegated dashboard/redirects/robots/analytics/configure GET routes into the evo-ui module shell with active tabs. Added dashboard evo-ui partial and contract assertions. Verification: sSeo PHPUnit OK (31 tests, 228 assertions), scripts/demo-smoke.php OK, demo cache/view cache cleared.
~~~

#### `sseo-evo-ui-005` — Перенести Redirects на evo-ui module-table

| Field | Value |
|---|---|
| DB id | `74` |
| External id | `sseo-evo-ui-005` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `52` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","redirects","table"] |
| External URL | - |
| Created | `2026-05-09 03:16:49` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: redirectsTab currently renders a custom table, search input, manual pagination, alertify add/delete dialogs, AJAX to sSeo.aredirect and sSeo.dredirect, and natural sorting in sRedirect. It also has multisite site_key handling. Scope: implement redirects as an evo-ui table preset and provider. Decomposition: add config/redirects/table.php, create Tables/RedirectsTableData, map columns old_url, new_url, type, site_key, updated_at, add modal fields and validation, preserve duplicate guard for old_url plus site_key/all, keep clearCache after writes, support search/filter/sort/perPage. Acceptance: user can list, search, sort, create, edit if included, and delete redirects from evo-ui; duplicate redirects are rejected with the existing translated message; multisite site selector appears when check_sMultisite is enabled; old AJAX endpoints either remain compatible or are intentionally deprecated in the migration contract.
~~~

**Comments / execution log (2)**

- Comment `219` · `2026-05-09 03:16:49` · MiddleDuck · `public`

~~~text
High priority because redirects are the main mutable data table.
~~~

- Comment `260` · `2026-05-09 03:44:09` · MiddleDuck · `public`

~~~text
Implemented evo-ui redirects table slice. Added config/redirects/table.php, Seiger\sSeo\Tables\RedirectsTableData, ModulePanel rendering for redirects via x-evo::table.livewire, and RedirectsTableContractTest. Legacy AJAX routes remain for compatibility. Verified smoke plus targeted PHPUnit suite: 21 tests, 161 assertions.
~~~

#### `sseo-evo-ui-006` — Перенести Configure settings на evo-ui form

| Field | Value |
|---|---|
| DB id | `75` |
| External id | `sseo-evo-ui-006` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `54` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","settings","form"] |
| External URL | - |
| Created | `2026-05-09 03:16:49` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: configureTab writes custom/config/seiger/settings/sSeo.php through controller helpers saveSettings, dumpSettingsPhp, and config keys meta_tags_mode, manage_www, paginates_get, noindex_get, redirects_enabled, generate_sitemap, product_attribute_aliases. sArticles and dIssues use evo-ui form presets with config source and validation rules. Scope: make sSeo configure a config-form preset. Decomposition: add config/settings/form.php or config/settings/general.php for sSeo; map booleans, selects, text arrays, and number-like fields; use ConfigFormService/PhpConfigFile behavior instead of custom dump code where possible; preserve setting defaults from config/sSeoSettings.php. Acceptance: saving Configure updates custom/config/seiger/settings/sSeo.php; booleans persist as 0/1 or compatible values; comma lists are normalized safely; unsaved changes are detected; invalid values return evo-ui validation messages.
~~~

**Comments / execution log (2)**

- Comment `220` · `2026-05-09 03:16:49` · MiddleDuck · `public`

~~~text
This should reduce custom controller write code.
~~~

- Comment `270` · `2026-05-09 04:02:15` · MiddleDuck · `public`

~~~text
Implemented Configure settings on evo-ui form. Added sSeo form config for indexing/functionality/commerce/server settings, renders configure tab via livewire:evo-ui.form preset sseo.settings, and added generic evo-ui csv config field support for comma-list arrays like noindex_get/product_attribute_aliases. Verification: php -l changed PHP files OK; evo-ui tests OK (5 tests); sSeo PHPUnit OK (25 tests, 186 assertions); scripts/demo-smoke.php OK.
~~~

#### `sseo-evo-ui-007` — Перенести Analytics settings на evo-ui form

| Field | Value |
|---|---|
| DB id | `76` |
| External id | `sseo-evo-ui-007` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `56` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","analytics","form"] |
| External URL | - |
| Created | `2026-05-09 03:16:49` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: analyticsTab handles GTM and GA4 IDs globally or per multisite domain, validates via AnalyticsIdParser, and stores keys like gtm_container_id, ga4_measurement_id, and siteKey-specific variants. Scope: make Analytics an evo-ui form or nested settings tab that preserves all ID parsing and validation. Decomposition: model single-site and multisite field generation; reuse AnalyticsIdParser for comma-separated IDs; surface active/invalid IDs in evo-ui form help or validation; keep headInjection behavior in sSeo.php unchanged. Acceptance: valid GTM and GA4 IDs save; invalid IDs are rejected with sSeo::global.analytics_invalid_ids; multisite displays per-site fields when check_sMultisite is enabled; saved settings are consumed by existing headInjection output without regression.
~~~

**Comments / execution log (2)**

- Comment `221` · `2026-05-09 03:16:49` · MiddleDuck · `public`

~~~text
Runtime analytics injection must remain stable.
~~~

- Comment `272` · `2026-05-09 04:05:07` · MiddleDuck · `public`

~~~text
Implemented Analytics settings on evo-ui form. Added sseo.analytics config preset, provider registration, dynamic AnalyticsSettingsForm builder for sMultisite site-specific GTM/GA4 fields, and ModulePanel analytics preset rendering through livewire:evo-ui.form. Added contract tests for analytics form and runtime fallback. Verification: php -l changed PHP files OK; sSeo PHPUnit OK (29 tests, 201 assertions); scripts/demo-smoke.php OK.
~~~

#### `sseo-evo-ui-008` — Перенести Robots editor на evo-ui

| Field | Value |
|---|---|
| DB id | `77` |
| External id | `sseo-evo-ui-008` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `58` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","robots","editor"] |
| External URL | - |
| Created | `2026-05-09 03:16:49` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: robotsTab reads and writes robots.txt for single-site or multisite storage, uses textEditor configuration, and has writeability checks in the controller. Scope: replace the legacy Robots tab with an evo-ui form/editor surface while preserving file safety. Decomposition: extract RobotsFileRepository, expose per-site editor fields, reuse evo-ui editor support or textarea fallback, keep ensureSettingsDir/canWrite style guards for target files, and show clear validation for missing write permissions. Acceptance: robots.txt can be edited and saved for the active single site; multisite robots files are selectable or rendered per site; empty content is blocked by translated validation; non-writable targets show the existing not_writable translation; no sitemap or redirect behavior changes.
~~~

**Comments / execution log (2)**

- Comment `222` · `2026-05-09 03:16:49` · MiddleDuck · `public`

~~~text
File writes need explicit guards before implementation.
~~~

- Comment `279` · `2026-05-09 04:07:25` · MiddleDuck · `public`

~~~text
Implemented Robots editor on evo-ui surface. Added sseo.robots-editor Livewire component with single-site and sMultisite file-backed robots.txt loading/saving, evo-ui form-surface Blade view, module panel rendering, and provider registration. Added contract tests for file-backed runtime behavior and evo-ui view wiring. Verification: php -l changed PHP/Blade files OK; sSeo PHPUnit OK (31 tests, 221 assertions); scripts/demo-smoke.php OK.
~~~

#### `sseo-evo-ui-009` — Перенести Meta Templates editor на evo-ui

| Field | Value |
|---|---|
| DB id | `78` |
| External id | `sseo-evo-ui-009` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `60` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","templates","editor"] |
| External URL | - |
| Created | `2026-05-09 03:16:49` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: templatesTab is currently gated by sseo_pro, builds language-aware template fields, adds sCommerce product/category placeholders, and uses controller textEditor. Scope: migrate templates editing to evo-ui without losing conditional Pro, sLang, and sCommerce behavior. Decomposition: extract template field catalog, build evo-ui form tabs for base/languages and resource types document/prodcat/product, expose available placeholders including configured product_attribute_aliases, and persist through the same settings file. Acceptance: non-Pro state renders a clear migrated empty/disabled state matching current behavior; Pro fields save per language/resource type; placeholders include existing document fields and valid sCommerce attributes; sLang-enabled sites get language-specific fields.
~~~

**Comments / execution log (2)**

- Comment `223` · `2026-05-09 03:16:49` · MiddleDuck · `public`

~~~text
This is normal priority because it depends on settings/form foundations.
~~~

- Comment `297` · `2026-05-09 04:39:44` · MiddleDuck · `public`

~~~text
Implemented Meta Templates editor in the evo-ui module shell. Added sseo.meta-templates-editor Livewire component backed by Evolution system_settings, pro-gated templates tab with cms_setting=sseo_pro, module-shell GET delegation for templates, and evo-ui form-surface Blade view. Verification: php -l changed files OK; sSeo PHPUnit OK (34 tests, 250 assertions); scripts/demo-smoke.php OK.
~~~

#### `sseo-evo-ui-010` — Перенести resource/module SEO fields на evo-ui form

| Field | Value |
|---|---|
| DB id | `79` |
| External id | `sseo-evo-ui-010` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `62` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","resource-fields","form"] |
| External URL | - |
| Created | `2026-05-09 03:16:49` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: moduleTab, resourceTab, fieldsBlock, and partials/fieldsBlock render SEO metadata fields for documents/products and save through updateModuleFields/updateSeoFields into s_seo. Fields include meta title, description, keywords, robots, canonical, OG, Twitter card, structured_data, extra_meta, sitemap priority/changefreq/last_modified/exclude flag, with sLang and multisite dimensions. Scope: create reusable evo-ui form surface for resource SEO editing. Decomposition: design a SeoFields provider/form service, map resource_id/resource_type/domain_key/lang, load defaults from existing sSeoModel, validate JSON-LD and numeric priority, preserve resource edit integration points used by sArticles/other modules, and keep updateSeoFields behavior compatible. Acceptance: document SEO fields load and save through evo-ui; language/domain-specific rows are not overwritten accidentally; JSON fields cast correctly; existing sArticles SeoIntegration keeps working; module save remains compatible until legacy consumers are migrated.
~~~

**Comments / execution log (2)**

- Comment `224` · `2026-05-09 03:16:49` · MiddleDuck · `public`

~~~text
High priority because this is the cross-module integration surface.
~~~

- Comment `300` · `2026-05-09 04:42:30` · MiddleDuck · `public`

~~~text
Implemented resource/module SEO fields evo-ui surface. Rebuilt shared fieldsBlock partial with evo-ui form-surface/sections/inputs while preserving the existing sseo[lang][field] payload and resource/product/article save handlers. Verification: php -l changed files OK; sSeo PHPUnit OK (36 tests, 272 assertions); scripts/demo-smoke.php OK.
~~~

#### `sseo-evo-ui-011` — Перезібрати Dashboard і Sitemap status на evo-ui

| Field | Value |
|---|---|
| DB id | `80` |
| External id | `sseo-evo-ui-011` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `64` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","dashboard","sitemap"] |
| External URL | - |
| Created | `2026-05-09 03:16:49` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: dashboardTab currently shows sitemap page counts and last generated dates using custom card classes and contains many commented diagnostic widgets. Sitemap generation logic lives in sSeoController and sSeo.php. Scope: migrate the dashboard to evo-ui surfaces while keeping sitemap generation and count logic intact. Decomposition: extract SitemapDashboardData, render cards with evo-ui components, add optional action for generate sitemap only if it already exists safely, keep multisite sitemap paths, and remove commented legacy widgets from the migrated view. Acceptance: dashboard shows one card per sitemap/domain with page count and last generated date; missing sitemap shows unknown state; layout follows evo-ui theme; no sitemap files are modified by simply viewing the dashboard.
~~~

**Comments / execution log (2)**

- Comment `225` · `2026-05-09 03:16:49` · MiddleDuck · `public`

~~~text
Dashboard should be read-only unless a separate generate action is approved.
~~~

- Comment `301` · `2026-05-09 04:45:57` · MiddleDuck · `public`

~~~text
Implemented evo-ui sitemap status cards: dashboard summary now includes file/exists/status metadata, ready/missing badges, file path display, and contract tests. Verified with PHPUnit unit suite (38 tests, 288 assertions) and sSeo demo smoke.
~~~

#### `sseo-evo-ui-012` — Прибрати legacy manager assets після evo-ui міграції

| Field | Value |
|---|---|
| DB id | `81` |
| External id | `sseo-evo-ui-012` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `66` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","assets","cleanup"] |
| External URL | - |
| Created | `2026-05-09 03:16:49` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: sSeo publishes css/tailwind.min.css, js/main.js, js/tooltip.js, seigerit assets, loads unpkg Alpine, unpkg lucide, jsdelivr alertify, media/script/main.js, and custom menu styles. evo-ui modules use evo::partials.assets and shared component styles. Scope: clean up manager-only legacy assets after migrated tabs are stable, while preserving public frontend assets used by SEO runtime if any. Decomposition: inventory published assets, separate manager-only from frontend/public plugin assets, update PublishAssets if needed, stop loading remote CDNs in manager shell, replace alertify confirmations with evo-ui modals. Acceptance: migrated manager screens load through evo-ui assets only; no remote CDN is required for manager sSeo; published obsolete manager assets are either unused or marked deprecated; public plugin behavior and asset URLs remain compatible.
~~~

**Comments / execution log (2)**

- Comment `226` · `2026-05-09 03:16:49` · MiddleDuck · `public`

~~~text
Do after shell/table/form migration to avoid breaking current screens early.
~~~

- Comment `302` · `2026-05-09 04:48:25` · MiddleDuck · `public`

~~~text
Removed legacy manager asset publishing for sSeo tailwind/js/tooltip files while keeping compatible icon assets. Publish command now prunes old manager files. Removed unreachable legacy GET render blocks after evo-ui tab delegation. Verified with PHPUnit unit suite (40 tests, 304 assertions), PHP lint, and sSeo demo smoke.
~~~

#### `sseo-evo-ui-013` — Додати targeted tests і demo smoke для sSeo evo-ui migration

| Field | Value |
|---|---|
| DB id | `82` |
| External id | `sseo-evo-ui-013` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `68` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","tests","smoke"] |
| External URL | - |
| Created | `2026-05-09 03:16:49` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: migration touches provider boot, migrations, routes, Livewire manager UI, settings-file persistence, redirect CRUD, robots/template editors, resource SEO fields, and runtime head injection. Scope: add focused verification for high-risk behavior before moving implementation tasks past ready_to_test. Decomposition: create demo smoke for route:list and migrate:status; add provider/config tests where available; add redirects CRUD smoke in SQLite; add settings save smoke for Configure/Analytics; manually verify manager screens in shared demo after implementation. Acceptance: smoke proves sSeo provider and migrations still work in /Users/dmi3yy/PhpstormProjects/Extras/sArticles/demo; migrated tabs render without fatal errors; redirect create/delete works; settings write to custom/config/seiger/settings/sSeo.php; runtime checkMeta/headInjection behavior has at least targeted regression coverage.
~~~

**Comments / execution log (2)**

- Comment `227` · `2026-05-09 03:16:49` · MiddleDuck · `public`

~~~text
Testing issue belongs in backlog now and gates implementation later.
~~~

- Comment `303` · `2026-05-09 04:49:14` · MiddleDuck · `public`

~~~text
Extended scripts/demo-smoke.php with evo-ui migration assertions: provider config/Livewire registrations, module shell/panel surfaces, delegated manager routes, menu route target, and legacy manager asset cleanup. Verified smoke output and PHPUnit unit suite (40 tests, 304 assertions).
~~~

#### `sseo-evo-ui-014` — Додати unit contract tests для sSeo support/runtime класів

| Field | Value |
|---|---|
| DB id | `83` |
| External id | `sseo-evo-ui-014` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `71` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","tests","unit"] |
| External URL | - |
| Created | `2026-05-09 03:19:47` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: sSeo has pure or mostly pure support/runtime behavior in AnalyticsIdParser, FastTagParser, MetaBuilder, Sitemaper, DescribesTable, and parts of sSeo.php that can regress during UI migration even without browser coverage. Scope: create package-level tests similar to dIssues/tests/Unit/*ContractTest.php and run them through the demo vendor autoload or a package-local harness. Decomposition: cover valid/invalid GTM and GA4 parsing; fast tag placeholder parsing; meta builder replace/fill mode behavior; sitemap count parsing; model casts/table contracts for sSeoModel and sRedirect; route helper expectations where possible. Acceptance: targeted unit tests can be run without the full demo suite; tests fail on broken parser/meta contracts; tests are documented in the migration handoff; no external network or browser is needed.
~~~

**Comments / execution log (2)**

- Comment `228` · `2026-05-09 03:19:47` · MiddleDuck · `public`

~~~text
Added after explicit user reminder that stable unit coverage is required.
~~~

- Comment `243` · `2026-05-09 03:28:32` · MiddleDuck · `public`

~~~text
Implemented package unit/contract coverage in tests/Unit/SupportRuntimeContractTest.php for AnalyticsIdParser, FastTagParser, Sitemaper, and storage/model migration contracts. Verified targeted suite: 9 tests, 70 assertions.
~~~

#### `sseo-evo-ui-015` — Додати provider/routes/migration smoke tests для shared demo

| Field | Value |
|---|---|
| DB id | `84` |
| External id | `sseo-evo-ui-015` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `73` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","tests","demo-smoke"] |
| External URL | - |
| Created | `2026-05-09 03:19:47` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: the shared demo proves package wiring through composer path repositories and Evolution provider discovery. Current full demo Pest discovery is not a reliable single gate because unrelated core tests can fail before targeted package tests are listed. Scope: add a focused sSeo smoke that checks the path repo, provider, route list, and migration status. Decomposition: assert custom/composer.json contains seiger/sseo path repo; assert installed package metadata points to ../../../../sSeo; assert package discovery includes Seiger\\sSeo\\sSeoServiceProvider; assert sseo routes are registered; assert migration 2024_11_18_094556_create_s_seo_table is Ran and tables s_seo/s_redirects exist. Acceptance: smoke command returns non-zero on missing provider/routes/migration; output is short enough for CI/agent handoff; it does not mutate the demo database.
~~~

**Comments / execution log (3)**

- Comment `229` · `2026-05-09 03:19:47` · MiddleDuck · `public`

~~~text
This is the first executable guard for step-by-step work.
~~~

- Comment `231` · `2026-05-09 03:20:01` · MiddleDuck · `public`

~~~text
Unit/smoke gate starts first. Full demo Pest discovery currently hits an unrelated core install-test bootstrap issue, so sSeo must use targeted package/demo checks until the global demo suite is healthy.
~~~

- Comment `232` · `2026-05-09 03:26:31` · MiddleDuck · `public`

~~~text
Implemented targeted sSeo demo smoke: scripts/demo-smoke.php plus tests/Unit/DemoWiringContractTest.php. Verified via php scripts/demo-smoke.php and demo vendor PHPUnit: 5 tests, 29 assertions. Also aligned demo composer metadata with canonical dmi3yy/dissues provider so artisan package discovery reaches sSeo.
~~~

#### `sseo-evo-ui-016` — Додати regression tests для evo-ui CRUD/settings/resource flows

| Field | Value |
|---|---|
| DB id | `85` |
| External id | `sseo-evo-ui-016` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `support` / Support |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `74` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration","tests","regression"] |
| External URL | - |
| Created | `2026-05-09 03:19:47` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Analysis: after the UI moves to evo-ui, the riskiest regressions are redirect CRUD, settings-file persistence, analytics validation, robots/template file writes, and resource/module SEO field persistence. Scope: define and implement focused tests alongside the migrated features. Decomposition: redirects provider validates create/update/delete and duplicate guard; settings form writes custom/config/seiger/settings/sSeo.php with expected types; analytics form rejects invalid IDs; resource SEO provider preserves resource_id/resource_type/domain_key/lang rows; robots/template repositories refuse unsafe writes. Acceptance: each migrated feature lands with at least one regression test; tests can run targeted from demo/vendor or package harness; failing tests block moving the related dIssues task out of ready_to_test.
~~~

**Comments / execution log (2)**

- Comment `230` · `2026-05-09 03:19:47` · MiddleDuck · `public`

~~~text
Added to make tests a gate for every later implementation slice.
~~~

- Comment `304` · `2026-05-09 04:50:52` · MiddleDuck · `public`

~~~text
Added EvoUiRegressionFlowsContractTest covering redirects CRUD duplicate/cache contracts, settings file dump type preservation, analytics strict validation paths, robots writable file persistence, meta template system_settings persistence, and resource SEO field cast/save contracts. Verified PHPUnit unit suite (43 tests, 346 assertions) and sSeo demo smoke.
~~~

#### `sseo-evo-ui-017` — Уніфікувати висоту верхніх табів з sArticles

| Field | Value |
|---|---|
| DB id | `92` |
| External id | `sseo-evo-ui-017` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `77` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["sseo","ui-parity","tabs","evo-ui"] |
| External URL | - |
| Created | `2026-05-09 03:40:42` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Cross-module UI parity task from 2026-05-09 feedback. sSeo top tabs/header height must match sArticles for the same evo-ui shell pattern. Decomposition: inspect sArticles module shell/tab classes, carry the same tab/header rhythm into sSeo migration, and verify in the shared demo. Acceptance: sSeo top tabs have the same height, spacing and placement as sArticles.
~~~

**Comments / execution log (2)**

- Comment `253` · `2026-05-09 03:40:42` · MiddleDuck · `public`

~~~text
Backlog parity task requested while working on sLang.
~~~

- Comment `306` · `2026-05-09 04:53:06` · MiddleDuck · `public`

~~~text
Aligned sSeo ModulePanel structure with sArticles: shared evo-ui nav markup, Alpine entangled activeTab rhythm, tab-content wrapper, evo-ui surface panel, and unsaved-change modal. PHPUnit unit suite passes (43 tests, 352 assertions). Browser attempt reached manager login in the in-app browser, so visual verification should be done in the already-authenticated manager session.
~~~

#### `sseo-evo-ui-018` — Use system Configuration translations in sSeo

| Field | Value |
|---|---|
| DB id | `101` |
| External id | `sseo-evo-ui-018` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `79` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 04:25:15` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Audit sSeo labels for Settings/Nалаштування/Настройки and replace generic labels with Evolution CMS system translations such as settings_config/edit_settings where they already express Configuration. Keep only module-specific text in the module lang files. Acceptance: UI consistently says Configuration/Конфігурація with the same key strategy as sArticles; module lang files do not duplicate generic Evolution labels; screenshots or browser checks confirm the top tab and page heading.
~~~

**Comments / execution log (2)**

- Comment `285` · `2026-05-09 04:25:15` · MiddleDuck · `public`

~~~text
Created from shared UI consistency feedback.
~~~

- Comment `307` · `2026-05-09 04:53:47` · MiddleDuck · `public`

~~~text
Switched sSeo Configuration tab/form/legacy menu label to system global.settings_config translation and removed duplicated configure label from sSeo en/uk/ru module language files. Verified PHPUnit unit suite (44 tests, 359 assertions), PHP lint for config files, and sSeo demo smoke.
~~~

#### `sseo-evo-ui-019` — Align sSeo font scale with sArticles evo-ui baseline

| Field | Value |
|---|---|
| DB id | `102` |
| External id | `sseo-evo-ui-019` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `normal` |
| Phase | `tests` / Tests |
| Position | `81` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 04:25:15` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
Audit sSeo module styles/root classes for font-size drift and align them to the sArticles evo-ui baseline. Acceptance: no module-specific font-size overrides for shared evo-ui surfaces; computed font sizes for tabs, tables, and forms match sArticles; any required fix uses shared evo-ui classes/components instead of ad hoc CSS.
~~~

**Comments / execution log (2)**

- Comment `286` · `2026-05-09 04:25:15` · MiddleDuck · `public`

~~~text
Created from shared UI consistency feedback.
~~~

- Comment `309` · `2026-05-09 04:54:53` · MiddleDuck · `public`

~~~text
Added FontScaleParityContractTest to prevent module-specific font-size/Tailwind text-scale overrides in sSeo evo-ui views and to assert the shared sArticles/evo-ui tab structure is used. Verified PHPUnit unit suite (46 tests, 385 assertions) and sSeo demo smoke.
~~~

#### `sseo-evo-ui-020` — Fix manager tab title and Tabler icon for sSeo menu item

| Field | Value |
|---|---|
| DB id | `106` |
| External id | `sseo-evo-ui-020` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `82` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 05:40:15` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: Manager top tab and Tools dropdown must identify the module as sSeo, not the active inner tab label. The menu icon must use a Tabler SVG equivalent to the current chart-line icon. Acceptance: manager tab title renders sSeo; Tools menu item renders sSeo with Tabler chart-line icon; dashboard inner tab can still be named Information panel; regression tests cover title/icon wiring.

SPEC: Inspect sSeo manager menu registration and evo-ui module shell title flow. Keep inner module tabs unchanged, but force the manager-facing menu title to sSeo and replace legacy icon HTML with a rendered Tabler SVG. Add contract tests and run lint/unit/smoke checks.

ANALYSIS: Initial report shows active manager tab displays the dashboard label. Existing OnManagerMenuPrerender uses sSeo::global.icon via a legacy <i> tag and sSeo::global.title for tooltip/title.

QA: PHP lint changed files, run sSeo unit suite from demo vendor, run sSeo demo smoke, clear view/cache if needed.
~~~

**Comments / execution log (4)**

- Comment `324` · `2026-05-09 05:40:15` · MiddleDuck · `public`

~~~text
Created from manager UI feedback: active tab title should be sSeo and Tools icon should be Tabler chart-line.
~~~

- Comment `325` · `2026-05-09 05:40:15` · MiddleDuck · `public`

~~~text
Стартую decomposition: перевіряю manager menu title/icon wiring, як Evolution бере назву верхнього tab, і додаю мінімальний план PRD/SPEC/ANALYSIS/QA перед fix.
~~~

- Comment `326` · `2026-05-09 05:40:32` · MiddleDuck · `public`

~~~text
Починаю implementation: міняю manager menu label/icon contract у plugins/sSeoPlugin.php і додаю unit guard, щоб верхній manager tab брав sSeo, а не dashboard label.
~~~

- Comment `327` · `2026-05-09 05:43:23` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові.
Реалізовано:
- Manager menu icon switched from legacy FontAwesome class to Tabler chart-line via sSeo::global.icon = tabler-chart-line.
- Legacy GET tab routes now redirect to the canonical sSeo module URL, so old #sseo/dashboard links stop naming the manager tab after the dashboard label.
- Added ManagerMenuContractTest and updated smoke/contracts for canonical route redirects.

Перевірено:
- PHP lint OK: 68 files
- targeted lint: plugin/controller/new test OK
- targeted smoke: scripts/demo-smoke.php OK
- full tests: PHPUnit 48 tests, 408 assertions OK
- demo cache/view cleared

Self-review: 9/10.
Статус: Ready to test.
~~~

#### `sseo-evo-ui-022` — Restore complete Configure legacy content in evo-ui

| Field | Value |
|---|---|
| DB id | `108` |
| External id | `sseo-evo-ui-022` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `102` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 05:46:39` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: Configure must preserve all legacy sSeo settings and explanatory content while following evo-ui layout rules. Acceptance: meta tags mode belongs to Functionality; indexing contains only pagination/noindex controls; Server shows the current site protocol/status text plus WWW management; product attribute aliases remain present; all legacy help text remains available without stretching the form.

SPEC: Compare views/configureTab.blade.php with config/settings/form.php. Update the evo-ui config form sections/fields and add readonly/display helpers only where evo-ui already supports them or via scoped sSeo view support. Keep storage keys unchanged.

ANALYSIS: User screenshots show only part of legacy Server content was migrated and meta_tags_mode is in the wrong section. The current evo-ui form loses the protocol status row from legacy Configure.

QA: PHP lint, Configure form contract test, relevant sSeo unit suite, demo smoke, manual browser smoke for Configure.
~~~

**Comments / execution log (5)**

- Comment `331` · `2026-05-09 05:46:39` · MiddleDuck · `public`

~~~text
Captured from user feedback: Configure migration is incomplete; keep this separate from the density-only task.
~~~

- Comment `334` · `2026-05-09 05:46:50` · MiddleDuck · `public`

~~~text
Стартую decomposition: звіряю legacy configureTab з evo-ui config form, фіксую секції, порядок полів, server protocol/status і всі help-тексти.
~~~

- Comment `335` · `2026-05-09 05:46:50` · MiddleDuck · `public`

~~~text
Починаю implementation: оновлюю config/settings/form.php і contract tests без зміни storage keys.
~~~

- Comment `356` · `2026-05-09 06:06:40` · MiddleDuck · `public`

~~~text
Manifest replay помилково повернув задачу в backlog; відновлюю фактичний статус in_progress, implementation уже виконаний і проходить tests.
~~~

- Comment `360` · `2026-05-09 06:20:59` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові.
Реалізовано:
- Повернуто всі legacy Configure налаштування в новий evo-ui form: pagination/noindex, meta tags mode, redirects, sitemap, product attributes, protocol, WWW.
- Додано display-only field для server protocol і підтримку save=false в evo-ui ConfigFormService.

Перевірено:
- PHP lint OK
- targeted tests: ConfigureSettingsFormContractTest + provider wiring OK
- full tests: sSeo unit suite 51/51, 449 assertions
- evo-ui tests: 6/6
- manual smoke: Configure показує всі секції і режим метатегів у Функціональність

Self-review: 9/10.
Статус: Ready to test.
~~~

#### `sseo-evo-ui-023` — Use evo-ui editor behavior for Robots tab

| Field | Value |
|---|---|
| DB id | `109` |
| External id | `sseo-evo-ui-023` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `103` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 05:46:39` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: Robots must not render as a tiny plain textarea; it should use the default Evolution editor behavior available through CodeMirror/eCodeMirror and fit the evo-ui admin surface. Acceptance: editor spans the content width, has a useful height, preserves robots.txt content exactly, works in light/dark manager themes, and saves through the existing Livewire flow.

SPEC: Audit the current sseo.robots-editor Livewire view/class, legacy robotsTab.blade.php, and evo-ui editor primitives. Prefer an evo-ui-compatible editor shell and manager CodeMirror/eCodeMirror assets; avoid custom global CSS unless the shared primitive lacks support.

ANALYSIS: User screenshot shows a narrow textarea around 460px wide, while the expected result is a full-width code editor with line numbers similar to CodeMirror/eCodeMirror.

QA: PHP lint, robots editor unit/contract test, relevant sSeo unit suite, demo smoke, manual browser smoke for Robots.
~~~

**Comments / execution log (5)**

- Comment `332` · `2026-05-09 05:46:39` · MiddleDuck · `public`

~~~text
Captured from user feedback: Robots editor must follow evo-ui/editor rules and use the available manager editor behavior.
~~~

- Comment `343` · `2026-05-09 05:56:34` · MiddleDuck · `public`

~~~text
Стартую decomposition: звіряю Robots Livewire view із legacy robotsTab і доступними evo-ui/editor primitives; план — повноширинний code editor із manager CodeMirror/eCodeMirror поведінкою.
~~~

- Comment `344` · `2026-05-09 05:56:35` · MiddleDuck · `public`

~~~text
Починаю implementation: оновлюю robots editor view/assets і додаю contract coverage.
~~~

- Comment `357` · `2026-05-09 06:06:41` · MiddleDuck · `public`

~~~text
Manifest replay помилково повернув задачу в backlog; відновлюю фактичний статус in_progress, Robots editor implementation уже виконаний і проходить tests.
~~~

- Comment `361` · `2026-05-09 06:20:59` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові.
Реалізовано:
- Robots editor перенесено в evo-ui form/card surface з повним textarea content і save sync.
- Підключено RichTextEditor Codemirror contract і fallback на стандартні Evo CodeMirror assets через Alpine lifecycle, щоб editor оживав після Livewire tab switch.
- Save перед викликом Livewire синхронізує window.myCodeMirrors/tinymce у textarea.

Перевірено:
- PHP lint OK
- targeted tests: RobotsEditorContractTest OK
- full tests: sSeo unit suite 51/51, 449 assertions
- demo smoke: OK
- manual smoke: Robots у shared demo показує CodeMirror з line numbers, full-width editor, file path visible

Self-review: 9/10.
Статус: Ready to test.
~~~

#### `sseo-evo-ui-024` — Render multisite-aware sSeo panels like sArticles type panels

| Field | Value |
|---|---|
| DB id | `110` |
| External id | `sseo-evo-ui-024` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `feature` / Feature |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `104` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 05:46:39` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: When sMultisite is enabled, sSeo surfaces that are site-specific must render as clear per-site panels, similar to sArticles type panels, so users understand which site they are editing. Acceptance: Analytics and Robots show per-site cards/panels with site name/key; Configure handles global vs site-specific settings explicitly; single-site mode stays compact; save paths remain correct per site.

SPEC: Compare sSeo site-key handling with sArticles type panel patterns. Centralize site context discovery if needed, pass context into evo-ui form/Livewire surfaces, and add tests for default and multisite paths.

ANALYSIS: User screenshot points out Analytics already looks like a single site card, but the migration should handle multiple sites as multiple panels rather than one stretched global panel.

QA: PHP lint, multisite contract tests, relevant sSeo unit suite, demo smoke, manual browser smoke with default demo context.
~~~

**Comments / execution log (5)**

- Comment `333` · `2026-05-09 05:46:39` · MiddleDuck · `public`

~~~text
Captured from user feedback: sSeo must be beautiful and explicit in multisite mode, following sArticles panel patterns.
~~~

- Comment `348` · `2026-05-09 06:02:34` · MiddleDuck · `public`

~~~text
Стартую decomposition: перевіряю існуючий multisite flow AnalyticsSettingsForm і RobotsEditor; план — закріпити per-site panel contract і довести Robots до x-evo card layout.
~~~

- Comment `349` · `2026-05-09 06:02:35` · MiddleDuck · `public`

~~~text
Починаю implementation: додаю/уточнюю unit contracts для Analytics per-site sections і Robots per-site card editor layout.
~~~

- Comment `358` · `2026-05-09 06:06:41` · MiddleDuck · `public`

~~~text
Manifest replay помилково повернув задачу в backlog; відновлюю фактичний статус in_progress, multisite contracts уже додані.
~~~

- Comment `362` · `2026-05-09 06:20:59` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові.
Реалізовано:
- Multisite-aware contract збережено для Robots і Analytics: per-site panels/cards як у sArticles type panels.
- Robots items отримують стабільні editor_id на кожен сайт; Analytics runtime builder має multisite panel contract.

Перевірено:
- PHP lint OK
- targeted tests: AnalyticsSettingsFormContractTest + RobotsEditorContractTest OK
- full tests: sSeo unit suite 51/51, 449 assertions
- demo smoke: OK
- manual smoke: single-site shared demo не ламає layout, multisite paths покриті контрактами

Self-review: 9/10.
Статус: Ready to test.
~~~

#### `sseo-evo-ui-025` — Fix Evolution manager top tab title for sSeo module

| Field | Value |
|---|---|
| DB id | `115` |
| External id | `sseo-evo-ui-025` |
| Project | `sseo` / sSeo |
| Component group | `evo-ui` |
| Status | `ready_to_test` / Ready to test |
| Category | `bug` / Bug |
| Priority | `high` |
| Phase | `tests` / Tests |
| Position | `105` |
| Parent | `-` - |
| Author | MiddleDuck / middleduck@evo.im |
| Assignee user id | `2` |
| Labels | ["migration"] |
| External URL | - |
| Created | `2026-05-09 06:06:09` |
| Updated | `2026-05-09 06:44:30` |
| Solved | `-` |
| Archived | `-` |

**Task statement / body**

~~~text
PRD: The Evolution manager top tab for sSeo must show the module name sSeo, not the active dashboard label. Acceptance: the parent manager tab and browser title use sSeo after loading or switching inside the module; internal module tabs may still show Dashboard/Redirects/etc.; the Tabler chart icon remains.

SPEC: Add a scoped manager-tab title sync from the sSeo module shell if the Evolution parent frame derives the tab title from the dashboard document title. Keep it limited to text containing the old dashboard title plus sSeo.

ANALYSIS: Manual Safari smoke on 2026-05-09 still showed the top manager tab as 'Інформаційна панель sSeo' while the user requested 'sSeo'. The menu icon/title strings are correct; parent tab synchronization is the remaining issue.

QA: PHP lint, manager menu/module panel contract tests, full sSeo unit suite, demo smoke, manual browser smoke on the opened manager tab.
~~~

**Comments / execution log (4)**

- Comment `353` · `2026-05-09 06:06:09` · MiddleDuck · `public`

~~~text
Captured from manual QA after user feedback: top Evolution manager tab still displays the dashboard title.
~~~

- Comment `354` · `2026-05-09 06:06:09` · MiddleDuck · `public`

~~~text
Стартую decomposition: manual smoke показав, що parent manager tab лишається 'Інформаційна панель sSeo'; перевіряю menu/title/shell і додаю scoped title sync.
~~~

- Comment `355` · `2026-05-09 06:06:09` · MiddleDuck · `public`

~~~text
Починаю implementation: правлю тільки sSeo module shell/title guard і додаю contract coverage.
~~~

- Comment `363` · `2026-05-09 06:20:59` · MiddleDuck · `public`

~~~text
PRD/SPEC/ANALYSIS/QA/REPORT готові.
Реалізовано:
- Evolution manager top tab для модуля синхронізується на sSeo, а menu item використовує Tabler chart-line і title sSeo.
- Shell проходить ancestor frames і прибирає legacy 'Інформаційна панель sSeo' з manager tab text, коли iframe оновлюється.

Перевірено:
- PHP lint OK
- targeted tests: ManagerMenuContractTest OK
- full tests: sSeo unit suite 51/51, 449 assertions
- demo smoke: OK
- manual smoke: manager tab у shared demo показує sSeo

Self-review: 9/10.
Статус: Ready to test.
~~~

