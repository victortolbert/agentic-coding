<?php

use App\Models\Board;

test('the owner can share a board', function () {
    $board = Board::factory()->create();

    $this->actingAs($board->owner)
        ->post(route('boards.share', $board))
        ->assertRedirect(route('boards.show', $board));

    expect($board->fresh()->is_public)->toBeTrue();
});

test('the owner can make a board private again', function () {
    $board = Board::factory()->create(['is_public' => true]);

    $this->actingAs($board->owner)
        ->delete(route('boards.unshare', $board))
        ->assertRedirect(route('boards.show', $board));

    expect($board->fresh()->is_public)->toBeFalse();
});

test('guests can see a public board', function () {
    $board = Board::factory()->create(['is_public' => true]);

    $this->get(route('boards.public', $board))->assertOk();
});

test('guests cannot see a private board', function () {
    $board = Board::factory()->create();

    $this->get(route('boards.public', $board))->assertNotFound();
});
