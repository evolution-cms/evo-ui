# User Guide

evo-ui is the shared manager UI kit used by Evolution CMS extras. You normally
see it through modules such as sArticles, dIssues, sLang, sSeo, sSettings and
dDocs.

## What evo-ui Controls

- The manager page shell and theme colors.
- Tabs, toolbars, buttons, badges, cards and modals.
- Tables, list views, filters, pagination and row actions.
- Settings and editor forms with dirty-state protection.
- Save feedback inside the Save button.
- Issue-style workspaces such as list, kanban, detail and comments.

## Standard Actions

Save buttons use the same primary filled style everywhere. Add, edit, duplicate
and delete actions use the shared evo-ui icon and tone rules, so the same action
looks the same in every module.

## Dirty Forms

When a form has unsaved changes, evo-ui keeps the tab guard active. If you try
to leave the tab, the shared unsaved-changes dialog appears. After a successful
save, the button briefly says Saved, then returns to disabled Save until you
change the form again.

## dDocs Exception

dDocs intentionally uses a documentation workspace with a sidebar tree and
viewer. It does not use the normal upper module tabs, but it should still reuse
evo-ui buttons, inputs, cards, badges, colors and typography.

## User Checklist

- The module opens inside the evo-ui manager shell.
- Save buttons have the same label, icon and color.
- Tables keep filters and pagination while you work.
- Modals keep primary actions at the bottom.
- Alerts, badges and chips use the shared visual language.
