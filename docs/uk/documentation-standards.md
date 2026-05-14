# Стандарти документації

EvoUI documentation слідує dDocs package standard.

## Обов'язкові локалі

Release documentation використовує:

- `docs/en`
- `docs/uk`
- `docs/pl`
- `docs/de`
- `docs/fr`

`docs/ua` не створюємо. Legacy Evolution manager input `ua` мапиться на `uk`.

## Обов'язкові сторінки

Кожна release locale має містити:

- `README.md`
- `user-guide.md`
- `developer-guide.md`
- `frontend-guide.md`
- `configuration.md`
- `reference.md`
- `troubleshooting.md`
- `documentation-standards.md`

Глибокі implementation contracts можуть лишатися English-first у `docs/en`,
але localized pages мають вести до них посиланнями.

## Правила

- Один H1 на сторінку.
- Relative links тільки всередині package.
- Code fences завжди з language identifiers.
- Shared UI primitives живуть в EvoUI.
- Business behavior живе в consumer modules.
