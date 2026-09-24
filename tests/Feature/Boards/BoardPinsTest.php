<?php

/*
 * Lesson 4. The contract for the Pin row of docs/resources.md, as a list of
 * todos. Turn each one into a test that fails for the right reason, then
 * hand this file to the agent. The done-when list is the tests.
 */

describe('store', function () {
    test('pins an image URL, with an optional note, to your own board')->todo();
    test('the image URL must be an http or https URL')->todo();
    test('the note is at most 140 characters')->todo();
    test('nobody can pin to someone else\'s board')->todo();
});

describe('update', function () {
    test('the owner can change a pin\'s note')->todo();
    test('anyone else gets 403 and the note stays')->todo();
});

describe('destroy', function () {
    test('the owner can take a pin off the board')->todo();
    test('anyone else gets 403 and the pin stays')->todo();
});
