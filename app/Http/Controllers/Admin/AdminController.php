<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_portfolios' => User::has('profile')->count(),
            'total_projects' => User::withCount('projects')->get()->sum('projects_count'),
        ];

        $users = User::with('roles')
            ->paginate(15);

        return view('admin.index', compact('stats', 'users'));
    }
}
