<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EducationController extends Controller
{
    public function index(Request $request): View
    {
        $education = $request->user()->education()->paginate(10);
        return view('education.index', compact('education'));
    }

    public function create(): View
    {
        return view('education.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'institute' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'year' => ['nullable', 'string', 'max:255'],
        ]);

        $request->user()->education()->create($validated);

        return redirect()->route('education.index')->with('success', 'Education added successfully');
    }

    public function edit(Education $education): View
    {
        $this->authorize('update', $education);
        return view('education.edit', compact('education'));
    }

    public function update(Request $request, Education $education): RedirectResponse
    {
        $this->authorize('update', $education);

        $validated = $request->validate([
            'institute' => ['required', 'string', 'max:255'],
            'degree' => ['required', 'string', 'max:255'],
            'year' => ['nullable', 'string', 'max:255'],
        ]);

        $education->update($validated);

        return redirect()->route('education.index')->with('success', 'Education updated successfully');
    }

    public function destroy(Education $education): RedirectResponse
    {
        $this->authorize('delete', $education);
        $education->delete();

        return redirect()->route('education.index')->with('success', 'Education deleted successfully');
    }
}
