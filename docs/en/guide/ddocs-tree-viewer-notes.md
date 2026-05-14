# dDocs Tree And Viewer Primitive Notes

dDocs needs a documentation workspace with a left tree/sidebar and a right
Markdown viewer. This is a real product need, but it should not force evo-ui to
grow a generic primitive before the dDocs interaction model stabilizes.

dDocs is the documented no-top-tabs exception. It may use a local tree/viewer
workspace while the API stabilizes. Other modules should not copy that CSS or
force dDocs into `x-evo::module-tab-shell`.

Local exception markers include `ddocs-workspace`, `ddocs-tree`,
`markdown viewer` and `no-top-tabs`.

## Current Boundary

Keep these pieces module-owned in dDocs for now:

- file-only source discovery and safe root validation;
- package/project docs indexing;
- language fallback for docs folders;
- Markdown parsing, sanitizing and link/image resolution;
- tree node payload shape;
- active/expanded tree state;
- search result ranking;
- viewer metadata, anchors, safe local images and missing-link handling;
- viewer breadcrumbs and current document state;
- code-copy behavior tied to documentation blocks;
- dDocs-specific CSS classes such as `ddocs-workspace`, `ddocs-tree`,
  `ddocs-document` and `ddocs-markdown`.

The current dDocs implementation may use evo-ui shell, buttons, inputs, forms,
cards, badges, typography tokens, colors and spacing tokens. It should not copy
Bootstrap, CDN assets or legacy manager bundles into evo-ui-owned screens.

## Potential Future evo-ui Primitives

Only promote a primitive into evo-ui after at least two consumers need the same
behavior. Candidate primitives:

- `evo-ui.workspace-split`: resizable or fixed sidebar/content shell with
  session-persisted split state.
- `evo-ui.tree`: accessible nested tree with active/expanded state, keyboard
  navigation, icons, badges and lazy children.
- `evo-ui.viewer`: document/content viewer shell with sticky metadata header,
  actions, empty/loading/error states and scrollable content.
- `evo-ui.markdown`: theme-aware rendered Markdown typography, code blocks,
  tables, headings and local image/link states.
- `evo-ui.tree-search`: tree search input and result highlighting.

Do not add these until the API is clear from dDocs usage and at least one more
module needs a comparable tree/viewer workflow.

## Promotion Checklist

Promote a dDocs behavior into EvoUI only when:

1. At least one other manager module needs the same tree/viewer behavior.
2. The behavior can be expressed through declarative config.
3. Storage, source registry and Markdown trust rules remain module-owned.
4. Styling can use EvoUI tokens without dDocs-specific selectors.
5. Browser smoke checks cover desktop and mobile manager viewports.

## Shared Styling Rules For dDocs

dDocs local CSS should:

- consume evo-ui tokens: `--evo-ui-bg`, `--evo-ui-surface`,
  `--evo-ui-border`, `--evo-ui-text`, `--evo-ui-muted`,
  `--evo-ui-primary`, `--evo-ui-radius`;
- use evo-ui controls where possible: `evo-ui-input`, `evo-ui-btn`,
  `evo-ui-badge`, `evo-ui-card`/form surfaces when appropriate;
- keep layout names prefixed with `ddocs-` while the primitive is local;
- avoid redefining global body typography, theme colors or manager shell assets;
- avoid introducing module-local CSS for table/form/button/badge behavior that
  already belongs to evo-ui.

## Contract Before Promotion

Before moving any dDocs tree/viewer piece into evo-ui, write a contract doc that
answers:

- What is the generic data shape?
- Who owns loading and persistence?
- Is state URL-based, session-based, or component-local?
- What keyboard and accessibility behavior is required?
- How are empty, loading, blocked, missing and permission states represented?
- Which styles are tokens and which are module-local?
- Which tests move to evo-ui and which remain in dDocs?

## dDocs Implementation Guidance

For the first dDocs release:

- keep the tree/sidebar and Markdown viewer local;
- keep translations/document sources local to dDocs;
- document any reusable pattern in dDocs first;
- reuse evo-ui shell/assets/theme bridge;
- add dDocs tests for file discovery, tree payloads, Markdown safety, links,
  images, search and viewer state;
- add evo-ui tests only if a truly generic primitive is introduced.

This keeps dDocs moving without turning evo-ui into a collection of one-off
widgets.
