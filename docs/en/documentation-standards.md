# Documentation Standards

EvoUI documentation follows the dDocs package standard.

## Required Locales

Release documentation uses these folders:

- `docs/en`
- `docs/uk`
- `docs/pl`
- `docs/de`
- `docs/fr`

Do not create `docs/ua`. Legacy Evolution manager input `ua` maps to the
documentation locale `uk`.

## Required Pages

Each release locale should include:

- `README.md`
- `user-guide.md`
- `developer-guide.md`
- `frontend-guide.md`
- `configuration.md`
- `reference.md`
- `troubleshooting.md`
- `documentation-standards.md`

Deep implementation contracts may remain English-first under `docs/en` while
localized pages link to them.

## Writing Rules

- Use one H1 per page.
- Keep links relative and inside the package.
- Use fenced code blocks with language identifiers.
- Keep UI primitives in EvoUI and business behavior in consumer modules.
- Document every new shared primitive before consumer modules adopt it.
- Update tests or coverage reports when documentation contracts change.

## Blade Attribute Safety

Do not put Blade control-flow directives inside an HTML opening tag in EvoUI
views or consumer manager views. Complex tags are easy to break during compiled
view caching, pagination rendering, or conditional action wiring, and the result
can leak raw text such as `aria-current="page" >1` into the manager UI.

Avoid this pattern:

```blade
<button
    type="button"
    class="evo-ui-pager__button"
    @if($isCurrent) aria-current="page" @endif
>
    {{ $page }}
</button>
```

Use a whole-element branch when the element shape changes:

```blade
@if($isCurrent)
    <button type="button" class="evo-ui-pager__button is-active" aria-current="page">
        {{ $page }}
    </button>
@else
    <button type="button" class="evo-ui-pager__button">
        {{ $page }}
    </button>
@endif
```

Use an attribute bag when only optional attributes change:

```blade
@php
    $buttonAttributes = new \Illuminate\View\ComponentAttributeBag([
        'type' => 'button',
        'class' => 'evo-ui-btn',
    ]);

    if ($action !== '') {
        $buttonAttributes = $buttonAttributes->merge(['wire:click' => $action]);
    }
@endphp

<button {{ $buttonAttributes }}>
    {{ $label }}
</button>
```

For table, list, pagination, modal and onboarding views, EvoUI tests guard
against `@if`, `@unless`, `@isset`, `@empty`, loop and switch directives inside
opening tags. If a consumer needs conditional attributes, branch the full
element or build attributes before rendering the tag.
