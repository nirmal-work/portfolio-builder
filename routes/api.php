<?php

use App\Http\Resources\EducationResource;
use App\Http\Resources\ExperienceResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SkillResource;
use App\Http\Resources\SocialLinkResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('profile/{slug}', function ($slug) {
    return Cache::remember("api_profile_{$slug}", 3600, function () use ($slug) {
        $user = User::where('slug', $slug)->firstOrFail();
        $profile = $user->profile;

        if (!$profile) {
            $profile = $user->profile()->firstOrCreate(['user_id' => $user->id]);
        }

        return response()->json([
            'name' => $user->name,
            'email' => $profile->is_email_public ? $user->email : null,
            'profile' => [
                'title' => $profile->title,
                'bio' => $profile->bio,
                'avatar' => $profile->avatar ? asset('storage/' . $profile->avatar) : null,
                'is_email_public' => $profile->is_email_public,
            ],
        ]);
    });
});

Route::get('profile/{slug}/skills', function ($slug) {
    return Cache::remember("api_profile_{$slug}_skills", 3600, function () use ($slug) {
        $user = User::where('slug', $slug)->firstOrFail();
        return SkillResource::collection($user->skills()->get());
    });
});

Route::get('profile/{slug}/experiences', function ($slug) {
    return Cache::remember("api_profile_{$slug}_experiences", 3600, function () use ($slug) {
        $user = User::where('slug', $slug)->firstOrFail();
        return ExperienceResource::collection($user->experiences()->get());
    });
});

Route::get('profile/{slug}/education', function ($slug) {
    return Cache::remember("api_profile_{$slug}_education", 3600, function () use ($slug) {
        $user = User::where('slug', $slug)->firstOrFail();
        return EducationResource::collection($user->education()->get());
    });
});

Route::get('profile/{slug}/projects', function ($slug) {
    return Cache::remember("api_profile_{$slug}_projects", 3600, function () use ($slug) {
        $user = User::where('slug', $slug)->firstOrFail();
        return ProjectResource::collection($user->projects()->get());
    });
});

Route::get('profile/{slug}/social-links', function ($slug) {
    return Cache::remember("api_profile_{$slug}_social_links", 3600, function () use ($slug) {
        $user = User::where('slug', $slug)->firstOrFail();
        return SocialLinkResource::collection($user->socialLinks()->get());
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
