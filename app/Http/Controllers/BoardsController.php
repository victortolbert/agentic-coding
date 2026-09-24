<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $request->user()->boards()->create($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Board created.')]);

        return to_route('boards.index');
    }
}
