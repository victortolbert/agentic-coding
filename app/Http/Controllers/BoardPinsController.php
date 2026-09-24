<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePinRequest;
use App\Http\Requests\UpdatePinRequest;
use App\Models\Board;
use App\Models\Pin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

/**
 * The Pin row of docs/resources.md. A pin is only ever seen on its board, so
 * there is no index, show, create or edit: pinning is a form on the board.
 */
class BoardPinsController extends Controller
{
    public function store(StorePinRequest $request, Board $board): RedirectResponse
    {
        Gate::authorize('update', $board);

        $board->pins()->create($request->validated());

        return to_route('boards.show', $board);
    }

    public function update(UpdatePinRequest $request, Pin $pin): RedirectResponse
    {
        Gate::authorize('update', $pin->board);

        $pin->update($request->validated());

        return to_route('boards.show', $pin->board);
    }

    public function destroy(Pin $pin): RedirectResponse
    {
        Gate::authorize('update', $pin->board);

        $pin->delete();

        return to_route('boards.show', $pin->board);
    }
}
