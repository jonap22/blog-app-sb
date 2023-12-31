<?php

namespace App\Http\Controllers;

use App\Models\Micropost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MicropostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Microposts/Index', [
            'microposts' => Micropost::with('user:id,name')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $request->user()->microposts()->create($validated);

        return redirect(route('microposts.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Micropost $micropost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Micropost $micropost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Micropost $micropost): RedirectResponse
    {
        $this->authorize('update', $micropost);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $micropost->update($validated);

        return redirect(route('microposts.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Micropost $micropost): RedirectResponse
    {
        $this->authorize('delete', $micropost);

        $micropost->delete();

        return redirect(route('microposts.index'));
    }
}
