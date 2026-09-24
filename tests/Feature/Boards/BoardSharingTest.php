<?php

use App\Models\Board;
use App\Models\Pin;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

describe('sharing', function () {
    test('the owner can share a board, which gives it a link', function () {
        $board = Board::factory()->create();

        $this->actingAs($board->owner)
            ->post(route('shared-boards.store'), ['board_id' => $board->id])
            ->assertRedirect(route('boards.show', $board));

        expect($board->fresh()->isShared())->toBeTrue();
    });

    test('nobody else can share it or stop it being shared', function () {
        $board = Board::factory()->shared()->create();
        $token = $board->share_token;
        $this->actingAs(User::factory()->create());

        $this->post(route('shared-boards.store'), ['board_id' => $board->id])->assertForbidden();
        $this->delete(route('shared-boards.destroy', $board))->assertForbidden();

        expect($board->fresh()->share_token)->toBe($token);
    });
});

describe('the client\'s page', function () {
    test('a guest with the link sees the board', function () {
        $board = Board::factory()->shared()->has(Pin::factory()->count(2))->create();

        $this->get(route('public-boards.show', $board->share_token))
            ->assertInertia(fn (Assert $page) => $page
                ->component('public-boards/Show')
                ->where('board.title', $board->title)
                ->has('pins', 2));
    });

    test('a stranger with the board\'s id and no link sees nothing', function () {
        $board = Board::factory()->shared()->create();

        $this->get(route('boards.show', $board))->assertRedirect(route('login'));
        $this->get(route('public-boards.show', (string) $board->id))->assertNotFound();
    });

    test('a turned-off link stops working', function () {
        $board = Board::factory()->shared()->create();
        $token = $board->share_token;

        $this->actingAs($board->owner)->delete(route('shared-boards.destroy', $board));
        auth()->logout();

        $this->get(route('public-boards.show', $token))->assertNotFound();
    });

    test('sharing again makes a new link, and the old one stays dead', function () {
        $board = Board::factory()->shared()->create();
        $oldToken = $board->share_token;

        $this->actingAs($board->owner)->delete(route('shared-boards.destroy', $board));
        $this->actingAs($board->owner)->post(route('shared-boards.store'), ['board_id' => $board->id]);
        auth()->logout();

        expect($board->fresh()->share_token)->not->toBe($oldToken);
        $this->get(route('public-boards.show', $oldToken))->assertNotFound();
    });

    test('the client never sees the owner or anything that edits the board', function () {
        $board = Board::factory()->shared()->has(Pin::factory())->create();

        $response = $this->get(route('public-boards.show', $board->share_token));

        $response->assertInertia(fn (Assert $page) => $page
            ->has('board', fn (Assert $board) => $board->hasAll(['title', 'description']))
            ->has('pins.0', fn (Assert $pin) => $pin->hasAll(['id', 'image_url', 'note'])));
        expect($response->getContent())
            ->not->toContain($board->owner->email)
            ->not->toContain($board->owner->name);
    });
});
