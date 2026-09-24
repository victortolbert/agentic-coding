# Taste

Lesson 5's exercise. "Make it look better" is not an instruction an agent can
follow, or one you can check. Write your taste down as rules instead: specific
enough that the agent can apply them and you can see whether it did.

Start from the brief's third gate:

> The board is the product. Images at their own proportions, not cropped into
> identical squares; the note under the image, quieter than the image; nothing
> on the client's page that looks like an app.

Then look at the board page at `lesson/05-start` and write what is wrong with it,
as rules.

## Spacing

Four steps, and nothing between them. No arbitrary values (`[13px]`) on the
board page or its components.

- `1` (4px) between an image and its note.
- `2` (8px) inside a control: a label and its input.
- `4` (16px) between pins, and between the controls in a row.
- `8` (32px) between sections: header, pin form, board.

## Hierarchy

- First: the images. They take the width of the page and keep their own
  proportions. A tall reference stays tall. Never `object-cover` into a
  square: at `lesson/05-start` the tall pin is cropped down to sky.
- Second: the board's title. One heading, nothing else at that weight.
- Third: the notes, under their image, smaller and quieter than the title.
- Last: the controls. The pin form is one compact row, not two labeled
  fields competing with the board. "Remove" appears on the pin you are
  pointing at or focused on, not seven times at full weight.
- Pins flow down each column, newest first, so the second-newest pin is
  under the first, not beside it. Accepted: a moodboard is scanned, not read
  in order. Revisit if order starts to matter.

## Motion

- A new pin fades and rises in, 200ms, ease-out. Nothing else animates on
  arrival.
- The remove control fades in over 150ms on hover or focus.
- Everything is behind `motion-safe:`. With reduced motion, things appear.
- On touch screens there is no hover, so the remove control is always shown.

## Copy

- Empty board: "Nothing pinned yet. Paste an image URL above: a screenshot,
  a specimen, a product shot. Add a note that says what you liked about it."
- The pin form's placeholders say what goes in them: "Image URL" and "What
  you like about it".
- The remove control is an icon with an accessible name: "Remove pin".
