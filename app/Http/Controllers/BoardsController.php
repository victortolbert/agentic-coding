<?php

namespace App\Http\Controllers;

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
}
