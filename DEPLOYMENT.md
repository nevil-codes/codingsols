# Deploying Codingsols

There are two supported ways to run Codingsols in production:

- **[Vercel](#vercel)**: serverless, free on the Hobby plan for non-commercial use. Database migrations run on every production deploy. Emails are sent during the request because there's no background worker.
- **[Docker](#docker)**: runs on Railway, Render, Fly.io or your own server, with a background queue worker and scheduler.

Both use **PostgreSQL**, **[Resend](https://resend.com)** for email and, optionally, **Cloudflare Turnstile**.

## Vercel

PHP runs on Vercel through the community [`vercel-php`](https://github.com/vercel-community/php) runtime (PHP 8.4). Everything is configured in [`vercel.json`](vercel.json) and [`api/index.php`](api/index.php).

### 1. Create the project

1. In Vercel, **Add New → Project** and import the `codingsols` GitHub repository. Leave the framework preset as **Other**; `vercel.json` handles the build.
2. Open the project's **Storage** tab, choose **Neon (Postgres)** from the Marketplace and connect it to the project. This adds a `DATABASE_URL` environment variable, which the app reads automatically.

### 2. Environment variables

In **Settings → Environment Variables**, add these for **Production**:

| Variable | Value |
| --- | --- |
| `APP_KEY` | Run `php artisan key:generate --show` locally and paste the result. Keep it secret and never change it after launch. |
| `APP_ENV` / `APP_DEBUG` | `production` / `false` |
| `APP_URL` | Your production URL, e.g. `https://codingsols.vercel.app` or your own domain |
| `SESSION_SECURE_COOKIE` | `true` |
| `MAIL_MAILER` | `resend` |
| `RESEND_API_KEY` | Your Resend API key (see [Email with Resend](#email-with-resend)) |
| `MAIL_FROM_ADDRESS` | An address on your verified domain, e.g. `hello@yourdomain.com` |
| `TURNSTILE_SITE_KEY`, `TURNSTILE_SECRET_KEY` | Optional |

Cache paths, logging, sessions and the queue are already set in `vercel.json`.

### 3. Deploy

Redeploy (or push to `main`). Each **production** build:

1. installs PHP and Node dependencies and builds the front-end assets,
2. runs `php artisan app:deploy`, which applies migrations and creates the default categories if there are none.

Preview deployments skip step 2, so they never change the production database.

### 4. Make yourself an admin

Register on the live site, then promote your account. The quickest way is Neon's **SQL Editor** (open it from the Vercel Storage tab):

```sql
UPDATE users SET is_admin = true WHERE email = 'you@example.com';
```

Or, from your machine with the production database URL:

```bash
DB_URL="postgresql://…" php artisan app:make-admin you@example.com
```

### Limitations on Vercel

- **Emails are sent during the request** (`QUEUE_CONNECTION=sync`), so registering takes a moment longer. If Resend is down, the request shows an error.
- **No scheduler.** The daily cleanup of expired password-reset tokens doesn't run. This is harmless; expired tokens are rejected anyway.
- **Cold starts.** The first request after a quiet period can take a second or two.
- **Hobby plan.** It's free but for non-commercial use only. Upgrade to Pro, or move to the Docker setup, if the site becomes commercial.

## Docker

The Docker image runs on any container host (Railway, Render, Fly.io, a VPS, Kubernetes…). The same image plays three roles:

| Role | Command | Needed? |
| --- | --- | --- |
| **web** | default (Nginx + PHP-FPM on port **8080**) | Yes |
| **worker** | `php /var/www/html/artisan queue:work --tries=3 --max-time=3600` | Yes. Sends verification and password-reset emails |
| **scheduler** | `php /var/www/html/artisan schedule:work` | Recommended. Clears expired reset tokens and old failed jobs daily |

On start-up the **web** container automatically runs `storage:link`, `migrate --force` and caches config, routes and views. Set `AUTORUN_ENABLED=false` on the worker and scheduler so migrations only run once.

You'll need:

- A **PostgreSQL** database (16 or newer). Most hosts offer one as an add-on.
- A **[Resend](https://resend.com)** account for email, with a verified sending domain.
- Optionally, a **Cloudflare Turnstile** site key for bot protection on sign-up and contact.

### Environment variables

Copy the list from [`.env.production.example`](.env.production.example) into your host's environment settings. The essentials:

| Variable | Value |
| --- | --- |
| `APP_KEY` | Run `php artisan key:generate --show` locally and paste the result. Keep it secret and never change it after launch (it encrypts sessions). |
| `APP_ENV` / `APP_DEBUG` | `production` / `false` |
| `APP_URL` | Your public URL, e.g. `https://codingsols.example.com` |
| `DB_*` or `DB_URL` | Connection details for your PostgreSQL database |
| `MAIL_MAILER`, `RESEND_API_KEY`, `MAIL_FROM_ADDRESS` | `resend`, your Resend API key, and an address on your verified domain |
| `SESSION_SECURE_COOKIE` | `true` (the site must be served over HTTPS) |
| `LOG_CHANNEL` | `stderr`, so logs show up in your host's log viewer |
| `TURNSTILE_SITE_KEY`, `TURNSTILE_SECRET_KEY` | Optional; leave empty to disable Turnstile |

### First deploy

1. Create the database and set the environment variables above.
2. Deploy the image as the **web** service and expose port **8080**. Your host provides HTTPS in front of it.
3. Add the **worker** service (same image, worker command, `AUTORUN_ENABLED=false`) and optionally the **scheduler**.
4. Once the web service is healthy, run these once in its console:

   ```bash
   php artisan db:seed --force                      # creates the forum categories
   php artisan app:make-admin you@example.com       # after you've registered on the site
   ```

   In production the seeder only creates categories; demo users and questions are local-only.

5. Visit `/up`. It returns `200` when the app is running.

#### Railway

1. **New project → Deploy from GitHub repo** and pick this repository. Railway detects the `Dockerfile`.
2. **Add → Database → PostgreSQL**, then in the web service's variables set `DB_URL` to `${{Postgres.DATABASE_URL}}` (plus the other variables above).
3. **Settings → Networking → Generate domain** (or add your own). Set the port to **8080**.
4. Duplicate the service for the worker: same repo, **Settings → Deploy → Custom start command** set to the worker command, and `AUTORUN_ENABLED=false`.

#### Render

1. **New → Web Service**, connect the repo, runtime **Docker**, port **8080**, health check path `/up`.
2. **New → PostgreSQL**, and copy its *Internal Database URL* into `DB_URL`.
3. **New → Background Worker** from the same repo with the worker command as the start command and `AUTORUN_ENABLED=false`.

#### Your own server (Docker Compose)

[`docker-compose.yml`](docker-compose.yml) runs the web, worker, scheduler and PostgreSQL together. Put a reverse proxy with HTTPS (Caddy, Nginx, Traefik) in front of port 8080, and replace the example database password.

```bash
cp .env.production.example .env.docker   # fill in APP_KEY, mail settings, etc.
docker compose up -d --build
docker compose exec web php artisan db:seed --force
```

## Email with Resend

1. Sign up at [resend.com](https://resend.com) and **add your domain**. Create the DNS records it shows (SPF, DKIM) at your DNS provider and wait for it to verify.
2. Create an **API key** with *sending access* and set it as `RESEND_API_KEY`.
3. Set `MAIL_MAILER=resend` and `MAIL_FROM_ADDRESS` to an address on that domain, e.g. `hello@yourdomain.com`.

Emails are queued, so the **worker must be running** for them to send. To check, register a test account and watch the worker's logs.

## Cloudflare Turnstile (optional)

1. In the Cloudflare dashboard go to **Turnstile → Add widget**, add your domain, and choose *Managed* mode.
2. Set `TURNSTILE_SITE_KEY` and `TURNSTILE_SECRET_KEY`.

The widget then appears on the sign-up and contact forms. If Cloudflare can't be reached, submissions are let through and a warning is logged; the honeypot, timing check and rate limits still apply.

## Backups

Use your database host's automatic backups. Railway, Render, Neon, Supabase and DigitalOcean all offer daily backups or point-in-time recovery for managed PostgreSQL. Make sure they're enabled and test a restore once.

To take a manual backup (with `pg_dump` 16+ installed locally):

```bash
pg_dump "$DATABASE_URL" --format=custom --file=codingsols-$(date +%F).dump
pg_restore --clean --no-owner --dbname "$DATABASE_URL" codingsols-2026-01-01.dump   # restore
```

The app stores no uploaded files, so the database is the only thing to back up.

## Updating

**Vercel:** push to `main`; production builds run new migrations automatically.

**Docker:** push to `main` (or redeploy the image). The web container runs new migrations on start-up. Restart the worker after each deploy so it picks up new code. Most hosts do this automatically when the image changes.

## Troubleshooting

- **"419 Page Expired" or logged out on every request:** `APP_URL` doesn't match the real domain, or `SESSION_SECURE_COOKIE=true` is set while the site isn't on HTTPS.
- **Verification emails never arrive:** the worker isn't running, or the Resend domain isn't verified. Check the worker logs and run `php artisan queue:failed`.
- **Mixed-content or http:// links:** make sure your host forwards `X-Forwarded-Proto`. The app trusts the proxy in front of it and forces https:// URLs in production.
- **Vercel: "500" on every page:** check the function logs in the Vercel dashboard. The usual causes are a missing `APP_KEY` or the Neon database not being connected (`DATABASE_URL` missing).
- **Vercel: unstyled pages:** the front-end build failed. Check the build logs for the `npm run build` step.
