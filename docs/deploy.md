# Deploy

Lesson 6's exercise. Write this before anything is deployed, and keep it true
afterwards. It is the one document an agent should read before it touches
anything outside your laptop.

## Environments

Every place this app runs, and what is different about it.

| | Local | CI | Production |
| --- | --- | --- | --- |
| Where it runs | | | |
| URL | | | |
| Database | | | |
| Mail | | | |
| `APP_DEBUG` | | | |
| Configured by | | | |

## Secrets

Every value that must not be in the repository: what it is, where it lives,
and who can read it.

| Name | What it is | Lives in |
| --- | --- | --- |
| | | |

## Deploy

The steps from "merged" to "live", in order, and which of them run by
themselves.

1.

## Check

What you look at after a deploy to know it worked.

-

## Roll back

What you do when the check fails.

-

## What the agent may do

-
