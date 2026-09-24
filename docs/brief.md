# Brief: Moodboard

The course's own brief, written the way lesson 1 asks. Your `brief.md` at the
root of the repository is about your feature; this one is about the app the
course builds, so every lesson has the same thing to compare against.

---

## The feature

When I start on a new direction I collect reference: screenshots, a type
specimen, a product page with a detail I like. Today that lives in a folder
and a chat thread. I want boards instead. I make a board per project, pin
images to it by URL with a one-line note on each, take pins off again, and
send a client a link that shows the board without asking them to sign up. I
can turn that link off. Finished means: a signed-in member can do all of that
to their own boards and nobody else's, and a client with the link sees the
images and the notes and nothing that lets them change anything.

---

## The three gates

### 1. The resource design

A board and a pin are obvious. The link is the one to get right: sharing is not
something you do to a board, it is a state the board is in, and the page the
client sees is not the page I see.

### 2. The contract

A stranger with a board's id and no link sees nothing. A turned-off link stops
working. A client never sees an edit button or the owner's email.

### 3. The taste

The board is the product. Images at their own proportions, not cropped into
identical squares; the note under the image, quieter than the image; nothing
on the client's page that looks like an app.
