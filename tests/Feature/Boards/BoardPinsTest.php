<?php

use App\Models\Board;
use App\Models\Pin;
use App\Models\User;

describe('store', function () {
    test('pins an image URL, with an optional note, to your own board', function () {
        $board = Board::factory()->create();

        $this->actingAs($board->owner)
            ->post(route('boards.pins.store', $board), [
                'image_url' => 'https://example.com/specimen.jpg',
                'note' => 'The italic, not the roman',
            ])
            ->assertRedirect(route('boards.show', $board));

        expect($board->pins()->sole())
            ->image_url->toBe('https://example.com/specimen.jpg')
            ->note->toBe('The italic, not the roman');
    });

    test('the image URL must be an http or https URL', function (string $url) {
        $board = Board::factory()->create();

        $this->actingAs($board->owner)
            ->post(route('boards.pins.store', $board), ['image_url' => $url])
            ->assertSessionHasErrors('image_url');

        expect($board->pins()->count())->toBe(0);
    })->with(['not a url', 'javascript:alert(1)', 'ftp://example.com/a.jpg']);

    test('the note is at most 140 characters', function () {
        $board = Board::factory()->create();

        $this->actingAs($board->owner)
            ->post(route('boards.pins.store', $board), [
                'image_url' => 'https://example.com/a.jpg',
                'note' => str_repeat('a', 141),
            ])
            ->assertSessionHasErrors('note');
    });

    test('nobody can pin to someone else\'s board', function () {
        $board = Board::factory()->create();

        $this->actingAs(User::factory()->create())
            ->post(route('boards.pins.store', $board), ['image_url' => 'https://example.com/a.jpg'])
            ->assertForbidden();

        expect($board->pins()->count())->toBe(0);
    });
});

describe('update', function () {
    test('the owner can change a pin\'s note', function () {
        $pin = Pin::factory()->create(['note' => 'Before']);

        $this->actingAs($pin->board->owner)
            ->put(route('pins.update', $pin), ['note' => 'After'])
            ->assertRedirect(route('boards.show', $pin->board));

        expect($pin->fresh()->note)->toBe('After');
    });

    test('anyone else gets 403 and the note stays', function () {
        $pin = Pin::factory()->create(['note' => 'Before']);

        $this->actingAs(User::factory()->create())
            ->put(route('pins.update', $pin), ['note' => 'After'])
            ->assertForbidden();

        expect($pin->fresh()->note)->toBe('Before');
    });
});

describe('destroy', function () {
    test('the owner can take a pin off the board', function () {
        $pin = Pin::factory()->create();

        $this->actingAs($pin->board->owner)
            ->delete(route('pins.destroy', $pin))
            ->assertRedirect(route('boards.show', $pin->board));

        expect(Pin::query()->count())->toBe(0);
    });

    test('anyone else gets 403 and the pin stays', function () {
        $pin = Pin::factory()->create();

        $this->actingAs(User::factory()->create())
            ->delete(route('pins.destroy', $pin))
            ->assertForbidden();

        expect($pin->fresh())->not->toBeNull();
    });
});
