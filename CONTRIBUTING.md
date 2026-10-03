# Contributing to Codingsols

Thanks for your interest in improving Codingsols! This guide explains how to get set up and how to submit changes.

## Ways to contribute

- Report bugs or suggest features by [opening an issue](https://github.com/nevil-codes/codingsols/issues/new/choose).
- Pick up an open issue. Ones labeled [`good first issue`](https://github.com/nevil-codes/codingsols/labels/good%20first%20issue) are a good start. Comment on the issue so others know you're working on it.
- Improve documentation.

## Local setup

Follow the [Getting started](README.md#getting-started) steps in the README.

## Workflow

1. Fork the repository and create a branch from `main`:
   ```bash
   git checkout -b feature/short-description
   ```
   Use prefixes like `feature/`, `fix/` or `docs/`.
2. Make your changes. Keep pull requests focused on one thing.
3. Add or update tests in `tests/Feature` (or `tests/Unit`) for any behavior change.
4. Make sure everything passes:
   ```bash
   php artisan test
   vendor/bin/pint
   npm run build
   ```
5. Commit with a clear message in the imperative mood, for example `Add pagination to search results`.
6. Push and open a pull request. Fill in the template and link the issue (`Fixes #123`).

## Code style

- PHP follows the Laravel preset enforced by [Pint](https://laravel.com/docs/pint). Run `vendor/bin/pint` before committing.
- Validate input with Form Requests and authorize with Policies.
- Build UI with the Blade components in `resources/views/components` and Tailwind utility classes. Every new view should work in both light and dark mode and on mobile.
- Never output user content with `{!! !!}` unless it has been sanitized (see the `x-markdown` component).

## Reporting security issues

Do not open public issues for vulnerabilities. See [SECURITY.md](SECURITY.md).

## Code of Conduct

By participating you agree to follow our [Code of Conduct](CODE_OF_CONDUCT.md).
