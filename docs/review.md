# Review

The questions every diff gets, before it is committed. Lesson 3.

## Does it match?

- [ ] Every change in the diff is in the plan. Anything that is not is either
      added to the plan on purpose or reverted.
- [ ] Every new controller method is a row and a verb in `docs/resources.md`.
- [ ] Nothing was renamed, reformatted or "tidied" outside the slice.

## Would I merge this from a colleague?

- [ ] Who is allowed to do this, and where is that checked?
- [ ] What happens with bad input? Where is it validated?
- [ ] Names say what the thing is, in the brief's words.
- [ ] There is a test for the behavior, and I have read it. It fails if the
      behavior is removed.

## Did I read it?

- [ ] I read the whole diff, not the summary of it.
- [ ] I can say in one sentence what this commit does. That sentence is the
      commit message.
