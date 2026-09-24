# Agentic Coding — companion repository

Companion repository for [Agentic Coding for Design-Minded Front-End Developers](https://designcoder.net/courses/agentic-coding).

Each lesson has a checkpoint in this repository: a tag you check out before the exercise, and — where the lesson builds something — a tag showing one way to finish it. You can start at any lesson.

## How checkpoints work

```sh
git clone https://github.com/victortolbert/agentic-coding
cd agentic-coding
git checkout lesson/01-start
```

Work the exercise from there. Where a lesson has a `-solution` tag, compare when you are done:

```sh
git diff lesson/01-solution
```

## Checkpoints

| Lesson | Start | Solution | Exercise |
| --- | --- | --- | --- |
| 1. What agentic coding actually is | `lesson/01-start` | — | Write your brief in `brief.md`, and the three gates in your own words |
| 2. Designing the resources before you prompt | `lesson/02-start` | `lesson/02-solution` | Fill in `docs/resources.md` from `docs/brief.md`, then have the agent write the migrations and models from it |
| 3. Driving the agent: plans, diffs and review | `lesson/03-start` | `lesson/03-solution` | Have the agent plan the Boards controller, then build it one reviewed slice at a time |
| 4. Tests as the contract you hand the agent | `lesson/04-start` | `lesson/04-solution` | Turn the todos in `tests/Feature/Boards/BoardPinsTest.php` into failing tests, then have the agent make them pass |
| 5. Taste at speed: layout, spacing and motion | `lesson/05-start` | `lesson/05-solution` | Write `docs/taste.md` as rules, have the agent apply them to the board page, and judge the result in the browser |
| 6. Shipping: environments, secrets and the deploy | `lesson/06-start` | `lesson/06-solution` | Write `docs/deploy.md`, get CI green on your fork, and put the app on a real URL |
| 7. When the agent is wrong | `lesson/07-start` | `lesson/07-solution` | The last commit at `lesson/07-start` is an agent's board sharing. CI is green. Find what is wrong with it, then redo it |

Every lesson's checkpoints are here. The lessons themselves are at [designcoder.net](https://designcoder.net/courses/agentic-coding).

## What you need

Lesson 1 needs nothing but git and a text editor. From lesson 2 the repository is a Laravel, Inertia and Vue application — the Laravel Vue starter kit, with SQLite so there is no database server to run. You need:

- PHP 8.4 and Composer 2 ([Laravel Herd](https://herd.laravel.com) installs both)
- Node 22 or newer
- A coding agent that can read the repository, run commands and show you diffs. The lessons use Claude Code.

Then, from any checkpoint from `lesson/02-start` on:

```sh
composer setup   # install, create .env and the SQLite database, migrate, build
composer dev     # serve the app, the queue and Vite together
composer test    # Pint, PHPStan and the Pest suite — the contract every lesson ends on
```

After checking out a new tag, run `php artisan migrate` if the lesson added a migration.

## License

MIT for the code in this repository. The course text lives at [designcoder.net](https://designcoder.net) and is all rights reserved.
