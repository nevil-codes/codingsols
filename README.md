# Codingsols

A community forum where programmers ask questions, share answers and help each other level up.

[![CI](https://github.com/nevil-codes/codingsols/actions/workflows/ci.yml/badge.svg)](https://github.com/nevil-codes/codingsols/actions/workflows/ci.yml)
[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

![Codingsols home page](docs/screenshots/home-light.png)

| Dark mode | Thread with syntax highlighting |
| --- | --- |
| ![Home page in dark mode](docs/screenshots/home-dark.png) | ![Thread page](docs/screenshots/thread-dark.png) |

## Features

- **Categories** for C++, Python, Java, JavaScript, Django, Flask, C# and Ruby
- **Questions and answers** written in Markdown, with a live preview and syntax-highlighted code blocks
- **Accounts**: sign up, log in, email verification, password reset and profile settings
- **Ownership rules**: only authors can edit or delete their questions and replies
- **Search** across question titles and bodies
- **Activity page** listing your questions and recent replies
- **Light and dark themes** that follow your system setting, with a manual toggle
- **Responsive and accessible**: mobile layout, keyboard navigation, skip link and visible focus states
- **Secure by default**: CSRF protection, escaped output, safe Markdown (raw HTML and `javascript:` links are stripped) and rate limiting on posting and the contact form

## Tech stack

| Layer | Tools |
| --- | --- |
| Backend | PHP 8.4+, Laravel 13, Breeze (auth) |
| Frontend | Blade, Tailwind CSS, Alpine.js, highlight.js |
| Database | SQLite by default; MySQL / MariaDB / PostgreSQL supported |
| Testing | Pest, Laravel Pint |
| CI | GitHub Actions |

## Getting started

Requirements: PHP 8.4+, Composer and Node.js 20+.

```bash
git clone https://github.com/nevil-codes/codingsols.git
cd codingsols

composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate --seed

composer run dev
```

Open http://localhost:8000. In the `local` environment, the seeder creates sample questions and a demo account:

- **Email:** `demo@codingsols.test`
- **Password:** `password`

Emails (verification, password reset) are written to `storage/logs/laravel.log` by default. Set the `MAIL_*` variables in `.env` to send real mail.

### Using MySQL instead of SQLite

Update `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=codingsols
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

Then run `php artisan migrate --seed`.

## Running tests

```bash
php artisan test        # Pest test suite
vendor/bin/pint --test  # code style check
```

## Project structure

```
app/Http/Controllers   Home, categories, threads, comments, search, contact
app/Models             Category, Thread, Comment, ContactMessage, User
app/Policies           Who can edit or delete threads and comments
database/seeders       Categories, plus demo content for local development
resources/views        Blade pages and reusable components (resources/views/components)
tests/Feature          HTTP tests for every feature
legacy/                The original plain-PHP version, kept for reference
```

## Roadmap

Planned work is tracked in [GitHub issues](https://github.com/nevil-codes/codingsols/issues) and [milestones](https://github.com/nevil-codes/codingsols/milestones): tags, voting and accepted answers, moderation tools, and deployment.

## Contributing

Contributions are welcome. Please read [CONTRIBUTING.md](CONTRIBUTING.md) and the [Code of Conduct](CODE_OF_CONDUCT.md). Issues labeled [`good first issue`](https://github.com/nevil-codes/codingsols/labels/good%20first%20issue) are a good place to start.

## Security

Please report vulnerabilities privately. See [SECURITY.md](SECURITY.md).

## License

Released under the [MIT License](LICENSE).
