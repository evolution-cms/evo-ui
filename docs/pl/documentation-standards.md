# Standardy dokumentacji

EvoUI stosuje standard dokumentacji dDocs.

## Lokale

Release documentation uzywa `docs/en`, `docs/uk`, `docs/pl`, `docs/de` i
`docs/fr`. Nie tworzymy `docs/ua`; legacy input `ua` mapuje sie do `uk`.

## Strony

Kazdy release locale powinien zawierac `README.md`, `user-guide.md`,
`developer-guide.md`, `frontend-guide.md`, `configuration.md`, `reference.md`,
`troubleshooting.md` i `documentation-standards.md`.

Deep implementation contracts moga pozostac English-first w `docs/en`, ale
localized pages musza linkowac do tych kontraktow.
