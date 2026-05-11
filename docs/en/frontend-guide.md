# Frontend Guide

evo-ui does not provide a public website frontend API. It is a manager UI
foundation for Evolution CMS extras.

## Where Assets Belong

Manager screens should load evo-ui assets through `x-evo::layout` or the
transitional `evo::partials.assets` partial. Do not add CDN CSS, CDN JS,
Bootstrap, jQuery or custom module copies of shared controls.

## Theme Bridge

The manager shell exposes theme markers and design tokens. Consumer modules
should use evo-ui classes and tokens instead of hard-coded colors.

```css
.my-module-local-exception {
    color: var(--evo-ui-text);
    background: var(--evo-ui-bg);
}
```

Only keep local CSS for module-specific layout that is not reusable yet. When a
pattern appears in more than one module, move it to evo-ui and document it.

## Resource Tabs

Embedded resource tabs are an exception boundary. They may be mounted inside the
legacy Evolution document form, but shared buttons, fields and dirty-state
behavior should still follow evo-ui contracts where possible.

