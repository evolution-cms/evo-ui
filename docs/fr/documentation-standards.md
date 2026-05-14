# Standards de documentation

EvoUI suit le dDocs package documentation standard.

## Locales

La release documentation utilise `docs/en`, `docs/uk`, `docs/pl`, `docs/de` et
`docs/fr`. Ne creez pas `docs/ua`; l'input legacy `ua` est normalise vers `uk`.

## Pages

Chaque release locale contient `README.md`, `user-guide.md`,
`developer-guide.md`, `frontend-guide.md`, `configuration.md`, `reference.md`,
`troubleshooting.md` et `documentation-standards.md`.

Les deep implementation contracts peuvent rester English-first dans `docs/en`,
mais les localized pages doivent les lier.
