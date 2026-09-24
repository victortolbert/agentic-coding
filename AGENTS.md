# Working in this repository

Standing instructions for any coding agent. The person you are working with
reads every diff, so keep them small enough to read.

## Before you write code

- Read `docs/brief.md` and `docs/resources.md`. The resource map is settled:
  build what it says. If a change needs a resource or a verb that is not in
  the map, stop and say so rather than adding one.
- Controllers have at most the seven resource verbs: `index`, `show`,
  `create`, `store`, `edit`, `update`, `destroy`. No other public methods.
- For anything bigger than a one-file fix, write a plan first, to
  `docs/plans/NN-name.md`, and wait for it to be approved. The plan lists the
  slices you will commit, in order, and the files each one touches.

## Tests are the contract

- Tests that exist before your change are the contract. Do not edit, skip or
  delete them to make them pass. If you think a test is wrong, stop and say
  which one and why.
- A test you add must fail before your change and pass after it.

## While you work

- One slice per commit. Stop after each slice so the diff can be reviewed.
- Follow the conventions of the files next to the one you are editing.
- Use Wayfinder imports (`@/actions/...`, `@/routes/...`) for URLs in Vue,
  never hard-coded paths.

## Before you say you are done

- `composer test` passes: Pint, PHPStan and Pest.
- `npm run check` and `npm run types:check` pass.
- Say what you did not do, and anything you were unsure about.
