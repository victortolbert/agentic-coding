# Deploy

Lesson 6's exercise. Write this before anything is deployed, and keep it true
afterwards. It is the one document an agent should read before it touches
anything outside your laptop.

The course deploys to Laravel Cloud. The shape of this file is the same on any
host; the "Configured by" row is what changes.

## Environments

Every place this app runs, and what is different about it.

| | Local | CI | Production |
| --- | --- | --- | --- |
| Where it runs | Your machine, `composer dev` | GitHub Actions, `.github/workflows/tests.yml` | Laravel Cloud, one app, one environment |
| URL | `http://localhost:8000` (or `http://agentic-coding.test` under Herd) | none | the Cloud URL, or your own domain |
| Database | SQLite, `database/database.sqlite` | SQLite, made by `composer setup` | the database attached in Cloud |
| Mail | `log`: verification links land in `storage/logs/laravel.log` | `array`, set by `phpunit.xml` | a real mailer. Without one, nobody who signs up can verify their email, and every board route requires a verified email |
| `APP_DEBUG` | `true` | `true` | `false`, always |
| Configured by | `.env`, copied from `.env.example` | `.env.example` and `phpunit.xml` | environment variables in the Cloud dashboard |

## Secrets

Every value that must not be in the repository: what it is, where it lives,
and who can read it.

| Name | What it is | Lives in |
| --- | --- | --- |
| `APP_KEY` | Encrypts sessions and cookies. Changing it signs everyone out | Cloud generates it. Locally, `php artisan key:generate` writes it to `.env` |
| `DB_*` | Production database credentials | Injected by Cloud when the database is attached. Never copied anywhere |
| `MAIL_*` | The mail provider's credentials | Cloud environment variables |

`.env` is in `.gitignore`. Nothing in this table is ever pasted into a chat
with an agent: if it needs a value to debug something, it gets the name and
you look up the value.

## Deploy

1. Merge to `main`. CI runs `composer ci:check` on the push; if it fails,
   stop and fix it before anything else.
2. Cloud builds on push to `main`: `composer install --no-dev`, `npm ci`,
   `npm run build`.
3. Cloud runs the deploy command, `php artisan migrate --force`, then switches
   traffic to the new release.

Steps 2 and 3 run by themselves. Step 1 is the only gate, which is why CI
runs the whole of `composer ci:check` and not a subset of it.

## Check

- `GET /up` returns 200.
- Sign up with a real address and receive the verification email.
- Make a board, pin an image to it, remove the pin.

## Roll back

- In Cloud, redeploy the previous release. A release that ran a migration
  needs the migration to be safe to run backwards, or a new release that
  fixes forward.
- Then find out why CI did not catch it, and add the test.

## What the agent may do

- Read and edit this file, the workflow and `.env.example`.
- Run `composer ci:check` locally and read CI logs with `gh run view`.
- Not: hold production secrets, run commands against production, or deploy.
  Those are yours. The agent can write the command; you run it.
