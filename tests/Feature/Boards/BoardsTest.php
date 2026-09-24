<?php

use App\Models\Board;
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
