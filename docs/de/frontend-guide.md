# Frontend Guide

evo-ui bietet keine oeffentliche Website-Frontend-API. Es ist eine Manager-UI
Foundation fuer Evolution CMS Extras.

## Assets

Manager Screens laden evo-ui Assets ueber `x-evo::layout` oder
`evo::partials.assets`. Keine CDN CSS/JS, kein Bootstrap, kein jQuery und keine
lokalen Kopien gemeinsamer Controls.

```css
.my-module-local-exception {
    color: var(--evo-ui-text);
    background: var(--evo-ui-bg);
}
```

Lokales CSS ist nur fuer modul-spezifische Layout-Ausnahmen gedacht.

