<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        
        $profile = $user->profile()->firstOrCreate(
            ['user_id' => $user->id],
            ['is_email_public' => false]
        );

        $stats = [
            'skills' => $user->skills()->count(),
            'experiences' => $user->experiences()->count(),
            'education' => $user->education()->count(),
            'projects' => $user->projects()->count(),
        ];

        return view('dashboard.index', compact('user', 'profile', 'stats'));
    }
}
