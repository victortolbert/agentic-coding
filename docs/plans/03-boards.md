# Plan: Boards

Row: **Board** in `docs/resources.md`. All seven verbs, on `BoardsController`.
Only the owner of a board can see, change or delete it.

## Slices

One commit each, reviewed before the next one starts.

1. **List your boards.** `Route::resource('boards', ...)` in a new
   `routes/boards.php`, required from `routes/web.php` inside the `auth` and
   `verified` group. `BoardsController@index` lists the signed-in member's
   boards, newest first, with a pin count. `BoardPolicy` (owner only).
   `boards/Index.vue`, a Boards link in the sidebar. Tests: guests are
   redirected; you see your boards and not someone else's.
2. **Make a board.** `create` and `store`, `StoreBoardRequest` (title
   required, at most 80 characters; description optional, at most 500).
   `boards/Create.vue`. Redirects to the new board. Tests: it is created for
   you; a missing title is rejected.
3. **See and change a board.** `show`, `edit` and `update`,
   `UpdateBoardRequest` with the same rules. `boards/Show.vue` lists the
   pins; `boards/Edit.vue`. Tests: the owner can see and update; anyone else
   gets 403.
4. **Delete a board.** `destroy`, from a button on the edit page that asks
   first. Redirects to the index. Tests: the owner can delete, and the pins
   go too; anyone else gets 403.

## Out of scope

- Adding or removing pins (lesson 4). The show page lists pins that exist.
- Sharing (the Shared board and Public board rows).
- Making the board page look good (lesson 5). It should be plain and correct.

## Decided in review

- No `BoardsController@pins` action for the show page's pin list. The pins
  are loaded by `show`, and adding them is `BoardPinsController`.
- The routes go in `routes/boards.php`, not `routes/web.php`, so each
  resource's routes can be read on their own.
- `store` redirects to the board list in slice 2, and to the new board in
  slice 3, once `show` exists. Redirecting to a route that is not there yet
  would break the build between slices.
