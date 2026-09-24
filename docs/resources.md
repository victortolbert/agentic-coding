# Resource map

Lesson 2's exercise. Read `docs/brief.md`, then fill this in before you prompt
anything. One row per resource. A resource is a noun with a URL; its verbs are
at most these seven:

`index` · `show` · `create` · `store` · `edit` · `update` · `destroy`

If the brief wants an action that is not one of the seven, the action is
hiding a noun. Name the noun and give it a row of its own.

| Resource | What it is | Verbs | Controller | Stored as |
| --- | --- | --- | --- | --- |
| Board | A named collection of pins, owned by one member | `index` `show` `create` `store` `edit` `update` `destroy` | `BoardsController` | `boards` |
| Pin | One image URL and a one-line note, on one board | `store` `update` `destroy` | `BoardPinsController` | `pins` |
| Shared board | A board that has a public link. A state the board is in, not an action on it | `store` `destroy` | `SharedBoardsController` | `boards.share_token` |
| Public board | What a client sees through the link: images and notes, read-only | `show` | `PublicBoardsController` | reads `boards` by `share_token` |

## Not resources

Anything in the brief you decided is *not* a resource, and why.

- **"Take pins off again"** is `Pin` `destroy`, not a verb on `Board`.
- **The client** has no account and no row. They hold a token; the token is the whole relationship.
- **"Turn the link off"** is `Shared board` `destroy`. Turning it back on is `store`, and makes a new token, so an old link stays dead.
- **Pins have no `index` or `show`.** A pin is only ever seen on its board. Adding one is a form on the board's page, so no `create` or `edit` page either.
