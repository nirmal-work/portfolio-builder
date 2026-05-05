<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::findOrCreate('Admin');
        Role::findOrCreate('User');

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'username' => User::generateUniqueUsername('Admin User'),
                'slug' => User::generateUniqueSlug('Admin User'),
                'password' => bcrypt('password'),
            ]
        );

        $admin->assignRole('Admin');

        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Standard User',
                'username' => User::generateUniqueUsername('Standard User'),
                'slug' => User::generateUniqueSlug('Standard User'),
                'password' => bcrypt('password'),
            ]
        );

        $user->assignRole('User');
    }
}
