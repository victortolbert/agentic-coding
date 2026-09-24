<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardRequest;
use App\Http\Requests\UpdateBoardRequest;
use App\Models\Board;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class BoardsController extends Controller
{
    /**
     * The signed-in member's boards, newest first.
     */
    public function index(Request $request): Response
    {
        $boards = $request->user()->boards()
            ->withCount('pins')
            ->latest()
            ->get(['id', 'title', 'description', 'created_at']);

        return Inertia::render('boards/Index', [
            'boards' => $boards,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('boards/Create');
    }

    public function store(StoreBoardRequest $request): RedirectResponse
    {
        $board = $request->user()->boards()->create($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Board created.')]);

        return to_route('boards.show', $board);
    }

    public function show(Board $board): Response
    {
        Gate::authorize('view', $board);

        return Inertia::render('boards/Show', [
            'board' => $board->only(['id', 'title', 'description']),
            'pins' => $board->pins()->latest()->get(['id', 'board_id', 'image_url', 'note']),
            'shareUrl' => $board->isShared() ? route('public-boards.show', $board->share_token) : null,
        ]);
    }

    public function edit(Board $board): Response
    {
        Gate::authorize('update', $board);

        return Inertia::render('boards/Edit', [
            'board' => $board->only(['id', 'title', 'description']),
        ]);
    }

    public function update(UpdateBoardRequest $request, Board $board): RedirectResponse
    {
        Gate::authorize('update', $board);

        $board->update($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Board updated.')]);

        return to_route('boards.show', $board);
    }

    public function destroy(Board $board): RedirectResponse
    {
        Gate::authorize('delete', $board);

        $board->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Board deleted.')]);

        return to_route('boards.index');
    }
}
