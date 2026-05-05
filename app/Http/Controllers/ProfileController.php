<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $profile = $user->profile()->firstOrCreate(
            ['user_id' => $user->id],
            ['is_email_public' => false]
        );

        return view('profile.edit', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // Update user data
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'] ?? $user->username,
        ]);

        // Handle email verification reset
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Update or create profile
        $profile = $user->profile()->firstOrCreate(['user_id' => $user->id]);

        $profileData = [
            'title' => $validated['title'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'is_email_public' => $validated['is_email_public'] ?? false,
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }

            // Store new avatar
            $profileData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $profile->update($profileData);

        // Invalidate cache
        Cache::forget("portfolio_{$user->slug}");
        Cache::forget("api_profile_{$user->slug}");
        Cache::forget("api_profile_{$user->slug}_skills");
        Cache::forget("api_profile_{$user->slug}_experiences");
        Cache::forget("api_profile_{$user->slug}_education");
        Cache::forget("api_profile_{$user->slug}_projects");
        Cache::forget("api_profile_{$user->slug}_social_links");

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Display public profile.
     */
    public function show(string $slug): View
    {
        $user = Cache::remember("portfolio_{$slug}", 3600, function () use ($slug) {
            return User::where('slug', $slug)->firstOrFail();
        });

        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->firstOrCreate(
                ['user_id' => $user->id],
                ['is_email_public' => false]
            );
        }

        return view('profile.show', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
