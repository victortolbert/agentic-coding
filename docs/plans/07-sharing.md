# Plan: Sharing

Rows: **Shared board** and **Public board** in `docs/resources.md`.

## What went wrong the first time

The first attempt, `Add board sharing` at `lesson/07-start`, passed every
check and was wrong in three ways. Each one is a gate that was not held.

- **Resource design.** It added `share`, `unshare` and `public` to
  `BoardsController`, ten methods on a controller the map gives seven, and an
  `is_public` column next to the `share_token` the map already had. The
  prompt said "add sharing" and did not point at the map.
- **The contract.** The client link was `/boards/{id}/public`, so anyone could
  try ids. Turning sharing off and on again brought the same link back. The
  public page's props included the owner, email address and all. Its tests
  passed because they were written after the code and only checked that
  sharing worked, never that it was safe. The brief's second gate says all of
  this, and none of it was a test.
- **Taste.** The public page cropped every image into a square again and
  ignored `docs/taste.md`.

Fixing it in place would have meant arguing with each of those in turn. It
was reverted instead, and redone from the inputs.

## Contract

`tests/Feature/Boards/BoardSharingTest.php`, written first and committed red.

## Build

One commit. The contract covers all three parts, and the diff is under 200
lines, so it is readable in one sitting.

1. **Share and stop sharing.** `SharedBoardsController@store` (takes
   `board_id`, makes a new token) and `@destroy` (clears it). Owner only.
2. **The client's page.** `PublicBoardsController@show`, found by
   `share_token`, outside `auth`. Props are the title, description and pins'
   image URLs and notes, and nothing else. `public-boards/Show.vue` with no
   app layout, using `PinCard`.
3. **The owner's controls.** A Share / Stop sharing control and the link on
   the board page.
