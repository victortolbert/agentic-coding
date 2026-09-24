<?php

use App\Models\Board;
use App\Models\Pin;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

describe('index', function () {
    test('guests are sent to log in', function () {
        $this->get(route('boards.index'))->assertRedirect(route('login'));
    });

    test('lists your boards and not anyone else\'s', function () {
        $user = User::factory()->create();
        Board::factory()->for($user, 'owner')->create(['title' => 'Mine']);
        Board::factory()->create(['title' => 'Theirs']);

        $this->actingAs($user)
            ->get(route('boards.index'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('boards/Index')
                ->has('boards', 1)
                ->where('boards.0.title', 'Mine'));
    });
});

describe('store', function () {
    test('creates a board for you', function () {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('boards.store'), ['title' => 'Spring campaign', 'description' => 'Warm, grainy, outdoors'])
            ->assertRedirect();

        expect($user->boards()->sole())
            ->title->toBe('Spring campaign')
            ->description->toBe('Warm, grainy, outdoors');
    });

    test('a board needs a title', function () {
        $this->actingAs(User::factory()->create())
            ->post(route('boards.store'), ['title' => ''])
            ->assertSessionHasErrors('title');

        expect(Board::query()->count())->toBe(0);
    });
});

describe('show, edit and update', function () {
    test('the owner sees the board and its pins', function () {
        $board = Board::factory()->has(Pin::factory()->count(2))->create();

        $this->actingAs($board->owner)
            ->get(route('boards.show', $board))
            ->assertInertia(fn (Assert $page) => $page
                ->component('boards/Show')
                ->where('board.title', $board->title)
                ->has('pins', 2));
    });

    test('the owner can update the board', function () {
        $board = Board::factory()->create();

        $this->actingAs($board->owner)
            ->put(route('boards.update', $board), ['title' => 'Renamed'])
            ->assertRedirect(route('boards.show', $board));

        expect($board->fresh()->title)->toBe('Renamed');
    });

    test('anyone else gets 403', function () {
        $board = Board::factory()->create(['title' => 'Private']);
        $this->actingAs(User::factory()->create());

        $this->get(route('boards.show', $board))->assertForbidden();
        $this->get(route('boards.edit', $board))->assertForbidden();
        $this->put(route('boards.update', $board), ['title' => 'Mine now'])->assertForbidden();

        expect($board->fresh()->title)->toBe('Private');
    });
});
