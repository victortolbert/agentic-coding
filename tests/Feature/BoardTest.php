<?php

use App\Models\Board;
use App\Models\Pin;
use App\Models\User;

test('a board belongs to its owner and holds pins', function () {
    $board = Board::factory()->has(Pin::factory()->count(2))->create();

    expect($board->owner)->toBeInstanceOf(User::class)
        ->and($board->owner->boards->pluck('id')->all())->toBe([$board->id])
        ->and($board->pins)->toHaveCount(2);
});

test('a board is shared only while it has a share token', function () {
    expect(Board::factory()->create()->isShared())->toBeFalse()
        ->and(Board::factory()->shared()->create()->isShared())->toBeTrue();
});

test('the share token never leaves the model by accident', function () {
    $board = Board::factory()->shared()->create();

    expect($board->toArray())->not->toHaveKey('share_token');
});

test('deleting a board takes its pins with it', function () {
    $board = Board::factory()->has(Pin::factory()->count(3))->create();

    $board->delete();

    expect(Pin::query()->count())->toBe(0);
});
