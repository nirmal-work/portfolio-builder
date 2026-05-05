<?php

namespace App\Http\Controllers;

use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SocialLinkController extends Controller
{
    public function index(Request $request): View
    {
        $socialLinks = $request->user()->socialLinks()->paginate(10);
        return view('social-links.index', compact('socialLinks'));
    }

    public function create(): View
    {
        return view('social-links.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'platform' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url'],
        ]);

        $request->user()->socialLinks()->create($validated);

        return redirect()->route('social-links.index')->with('success', 'Social link added successfully');
    }

    public function edit(SocialLink $socialLink): View
    {
        $this->authorize('update', $socialLink);
        return view('social-links.edit', compact('socialLink'));
    }

    public function update(Request $request, SocialLink $socialLink): RedirectResponse
    {
        $this->authorize('update', $socialLink);

        $validated = $request->validate([
            'platform' => ['required', 'string', 'max:255'],
            'url' => ['required', 'url'],
        ]);

        $socialLink->update($validated);

        return redirect()->route('social-links.index')->with('success', 'Social link updated successfully');
    }

    public function destroy(SocialLink $socialLink): RedirectResponse
    {
        $this->authorize('delete', $socialLink);
        $socialLink->delete();

        return redirect()->route('social-links.index')->with('success', 'Social link deleted successfully');
    }
}
