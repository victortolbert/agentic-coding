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
| 2. Designing the resources before you prompt | *not yet published* | | |
| 3. Driving the agent: plans, diffs and review | *not yet published* | | |
| 4. Tests as the contract you hand the agent | *not yet published* | | |
| 5. Taste at speed: layout, spacing and motion | *not yet published* | | |
| 6. Shipping: environments, secrets and the deploy | *not yet published* | | |
| 7. When the agent is wrong | *not yet published* | | |

Lessons 2 to 7 are being written. Their checkpoints appear here as each lesson ships; buying the course once covers all of them. Watch this repository, or follow the course, to know when they land.

## What you need

Lesson 1 needs nothing but git and a text editor — the exercise is writing, not building. Later lessons build a real Laravel, Inertia and Vue application; when they land, this section will say exactly what to install, and the setup will be one command.

## License

MIT for the code in this repository. The course text lives at [designcoder.net](https://designcoder.net) and is all rights reserved.
