<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                {{ __('Edit Profile') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Skills Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-lg font-bold text-gray-900">{{ $stats['skills'] }}</p>
                                <p class="text-sm text-gray-600">{{ __('Skills') }}</p>
                            </div>
<a href="{{ route('skills.create') }}" class="text-blue-600 hover:text-blue-700">
                                 <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                 </svg>
                             </a>
                        </div>
                    </div>
                </div>

                <!-- Experiences Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-lg font-bold text-gray-900">{{ $stats['experiences'] }}</p>
                                <p class="text-sm text-gray-600">{{ __('Experiences') }}</p>
                            </div>
<a href="{{ route('experiences.create') }}" class="text-green-600 hover:text-green-700">
                                 <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                 </svg>
                             </a>
                        </div>
                    </div>
                </div>

                <!-- Education Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-lg font-bold text-gray-900">{{ $stats['education'] }}</p>
                                <p class="text-sm text-gray-600">{{ __('Education') }}</p>
                            </div>
<a href="{{ route('education.create') }}" class="text-purple-600 hover:text-purple-700">
                                 <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                 </svg>
                             </a>
                        </div>
                    </div>
                </div>

                <!-- Projects Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-lg font-bold text-gray-900">{{ $stats['projects'] }}</p>
                                <p class="text-sm text-gray-600">{{ __('Projects') }}</p>
                            </div>
<a href="{{ route('projects.create') }}" class="text-red-600 hover:text-red-700">
                                 <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                 </svg>
                             </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
                <!-- Profile Preview -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Profile Information') }}</h3>
                        <div class="space-y-3">
                            <p><strong class="text-gray-700">{{ __('Name:') }}</strong> {{ $user->name }}</p>
                            <p><strong class="text-gray-700">{{ __('Email:') }}</strong> {{ $user->email }}</p>
                            <p><strong class="text-gray-700">{{ __('Username:') }}</strong> <code class="bg-gray-100 px-2 py-1 rounded">{{ $user->username }}</code></p>
                            <p><strong class="text-gray-700">{{ __('Profile URL:') }}</strong></p>
                            <p class="text-sm bg-gray-50 p-2 rounded">
                                <a href="{{ route('profile.public', $user->slug) }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{ route('profile.public', $user->slug) }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Portfolio Notes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Quick Tips') }}</h3>
                        <ul class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start">
                                <span class="text-blue-600 mr-3">✓</span>
                                <span>{{ __('Complete your profile to attract more visitors') }}</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-green-600 mr-3">✓</span>
                                <span>{{ __('Add skills to showcase your expertise') }}</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-purple-600 mr-3">✓</span>
                                <span>{{ __('Create project entries with links and images') }}</span>
                            </li>
                            <li class="flex items-start">
                                <span class="text-red-600 mr-3">✓</span>
                                <span>{{ __('Share your profile URL to showcase your work') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Shortcuts to Manage Content -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Manage Your Content') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('skills.index') }}" class="block p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition">
                            <div class="font-semibold text-blue-900">{{ __('Manage Skills') }}</div>
                            <p class="text-sm text-blue-700 mt-1">{{ __('Add, edit, or remove skills') }}</p>
                        </a>
                        <a href="{{ route('experiences.index') }}" class="block p-4 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition">
                            <div class="font-semibold text-green-900">{{ __('Manage Experience') }}</div>
                            <p class="text-sm text-green-700 mt-1">{{ __('Track your career') }}</p>
                        </a>
                        <a href="{{ route('education.index') }}" class="block p-4 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition">
                            <div class="font-semibold text-purple-900">{{ __('Manage Education') }}</div>
                            <p class="text-sm text-purple-700 mt-1">{{ __('Add your degrees') }}</p>
                        </a>
                        <a href="{{ route('projects.index') }}" class="block p-4 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition">
                            <div class="font-semibold text-red-900">{{ __('Manage Projects') }}</div>
                            <p class="text-sm text-red-700 mt-1">{{ __('Showcase your work') }}</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
