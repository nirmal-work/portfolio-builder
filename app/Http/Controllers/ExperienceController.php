<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function index(Request $request): View
    {
        $experiences = $request->user()->experiences()->paginate(10);
        return view('experiences.index', compact('experiences'));
    }

    public function create(): View
    {
        return view('experiences.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $request->user()->experiences()->create($validated);

        return redirect()->route('experiences.index')->with('success', 'Experience added successfully');
    }

    public function edit(Experience $experience): View
    {
        $this->authorize('update', $experience);
        return view('experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience): RedirectResponse
    {
        $this->authorize('update', $experience);

        $validated = $request->validate([
            'company' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $experience->update($validated);

        return redirect()->route('experiences.index')->with('success', 'Experience updated successfully');
    }

    public function destroy(Experience $experience): RedirectResponse
    {
        $this->authorize('delete', $experience);
        $experience->delete();

        return redirect()->route('experiences.index')->with('success', 'Experience deleted successfully');
    }
}
