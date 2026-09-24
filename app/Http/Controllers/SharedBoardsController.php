<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSharedBoardRequest;
use App\Models\Board;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

/**
 * The Shared board row of docs/resources.md. Sharing adds a board to the set
 * of shared boards (`store`); turning the link off removes it (`destroy`).
 */
class SharedBoardsController extends Controller
{
    public function store(StoreSharedBoardRequest $request): RedirectResponse
    {
        $board = Board::query()->findOrFail($request->integer('board_id'));

        Gate::authorize('update', $board);

        $board->share();

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Link created.')]);

        return to_route('boards.show', $board);
    }

    public function destroy(Board $board): RedirectResponse
    {
        Gate::authorize('update', $board);

        $board->stopSharing();

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Link turned off.')]);

        return to_route('boards.show', $board);
    }
}
