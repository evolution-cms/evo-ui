# Issue Workspace Contract

`evo-ui.issue-workspace` is a provider-backed workspace surface for issue-like
manager workflows. `dIssues` is the current reference consumer, but the contract
is generic: `evo-ui` owns the UI shell and interaction contract; the consuming
module owns data, workflow rules and persistence.

Runtime markers that must stay documented include `evo-ui.issue-workspace`,
`IssueWorkspaceProvider`, `IssueWorkspace` and `initIssueKanban`.

## Preset

```php
return [
    'key' => 'vendor.module.issues',
    'provider' => Vendor\Module\Workspaces\IssuesWorkspaceData::class,
    'default_display' => 'kanban',
    'default_filters' => [
        'category_ids' => [],
        'status_ids' => [],
        'assignee_ids' => [],
        'archive' => 'active',
        'display' => 'kanban',
        'search' => '',
    ],
];
```

Render:

```blade
<x-evo::issues.workspace
    preset="vendor.module.issues"
    :context="['moduleUrl' => $moduleUrl]"
/>
```

## Provider Interface

The provider must implement `EvoUI\Contracts\IssueWorkspaceProvider`:

```php
public function projects(): array;
public function categories(): array;
public function statuses(): array;
public function assignees(): array;
public function metrics(array $filters = []): array;
public function issueList(array $filters = []): array;
public function listRows(array $filters = []): array;
public function kanbanLanes(array $filters = []): array;
public function issuePreview(int $issueId): ?array;
public function issueDetail(int $issueId): ?array;
public function comments(int $issueId): array;
public function sortKanbanLanes(array $lanes): void;
public function assignIssueToMe(int $issueId): void;
public function assignIssue(int $issueId, int $userId): void;
public function unassignIssue(int $issueId): void;
public function replyIssue(int $issueId, string $body, ?int $parentCommentId = null): void;
public function replyAndCloseIssue(int $issueId, string $body, ?int $parentCommentId = null): void;
public function closeIssue(int $issueId): void;
public function reopenIssue(int $issueId): void;
public function diagnostics(array $filters = []): array;
```

Providers may expose additional optional methods for newer workspace affordances
such as child issue creation or body editing. Optional methods must be checked
with `method_exists()` by the workspace before use.

## Display Modes

Supported displays:

- `list`: compact issue list with selected issue detail
- `kanban`: issues grouped by status/lane

The current display is part of workspace filter state and persists in the
manager session. URL/query state should override restored session state when a
screen is opened through an explicit link.

## Filters

Generic filters are stored in the `filters` state array. Current shared filter
keys:

- `project_ids`
- `category_ids`
- `status_ids`
- `assignee`
- `assignee_ids`
- `archive`
- `display`
- `search`

The provider decides how filters map to database queries. `evo-ui` owns the
filter controls, selected state and reset behavior.

## Issue Payloads

Issue rows should be normalized arrays. Recommended keys:

```php
[
    'id' => 123,
    'title' => 'Document issue workspace contract',
    'body' => '<p>...</p>',
    'project' => ['id' => 1, 'name' => 'evo-ui', 'color' => '#2563EB'],
    'status' => ['id' => 2, 'name' => 'In progress', 'icon' => 'loader'],
    'category' => ['id' => 1, 'name' => 'Feature', 'color' => '#22C55E'],
    'assignee' => ['id' => 7, 'name' => 'MiddleDuck', 'avatar_url' => '...'],
    'priority' => 'high',
    'updated_at' => '2026-05-09 07:00:00',
]
```

The provider may include parent/child metadata, comment counts, transition
metadata or external references. `evo-ui` renders known generic keys and should
ignore unknown keys safely.

## Comments And Replies

The provider owns comment storage. `evo-ui` owns:

- reply editor shell
- reply-to-comment UI state
- reply and reply-and-close calls
- editor synchronization before submit

Comment payloads should include stable ids, author display data, body HTML/text,
visibility and timestamps.

## Assignment

`assignees()` returns manager users or provider users in a normalized option
shape:

```php
[
    ['id' => 1, 'label' => 'MiddleDuck', 'avatar_url' => null],
]
```

The provider owns whether assignment is allowed and how user ids are validated.
`evo-ui` owns assignment controls and selected-user UI.

## Parent And Child Issues

Parent/child UI is generic, but semantics are provider-owned. If a provider
supports child creation, it should expose an optional method such as:

```php
public function createChildIssue(int $parentIssueId): int;
```

The workspace can select the new child id after creation. The provider must
guard invalid parent ids and recursion.

## Archive

Archive state is a generic filter. The provider decides what archived means:
closed status, archived timestamp, hidden flag or another module-specific
contract. The UI should not hard-code dIssues archive rules.

## Kanban Sorting

Kanban sorting sends normalized lanes to the provider:

```php
[
    [
        'status_id' => 2,
        'issue_ids' => [10, 11, 12],
    ],
]
```

The provider must validate status ids and issue ids before persistence. `evo-ui`
owns drag/drop DOM behavior and the Livewire method contract; the provider owns
workflow validation and database writes.

## Diagnostics

`diagnostics()` should return read-only health or setup hints. Diagnostics are
useful for missing provider tokens, disabled sync, empty taxonomy setup or other
workspace-level setup states. They must not mutate data.

## Boundaries

Keep in `evo-ui`:

- workspace layout
- list/kanban mode controls
- filter controls
- selected issue state
- generic issue card/detail rendering
- reply/editor shell
- drag/drop event contract
- manager-session persistence

Keep in the consumer:

- workflow states and allowed transitions
- database schema and migrations
- issue/comment persistence
- external provider sync
- user assignment rules
- business validation

## dIssues Reference

`dIssues` proves the current contract with local projects, statuses, categories,
phases, comments, assignees, archive behavior and Kanban sorting. Use it as the
reference implementation, not as code that should be copied into `evo-ui`.
