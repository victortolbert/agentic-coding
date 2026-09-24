<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Inertia\Inertia;
use Inertia\Response;

/**
 * The Public board row of docs/resources.md: what a client sees through the
 * link. Found by share token, never by id, and it sends nothing that
 * identifies the owner or edits the board.
 */
class PublicBoardsController extends Controller
{
    public function show(Board $board): Response
    {
        return Inertia::render('public-boards/Show', [
            'board' => $board->only(['title', 'description']),
            'pins' => $board->pins()->latest()->get(['id', 'image_url', 'note']),
        ]);
    }
}
