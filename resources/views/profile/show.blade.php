<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $user->name }} - Portfolio</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- OG Meta Tags -->
        <meta property="og:title" content="{{ $user->name }} - Portfolio">
        <meta property="og:description" content="{{ $profile?->bio ?? 'Check out my portfolio' }}">
        @if($profile?->avatar)
            <meta property="og:image" content="{{ asset('storage/' . $profile->avatar) }}">
        @endif
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen">
            <!-- Navigation -->
            <nav class="bg-white shadow-sm sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <a href="/" class="text-xl font-bold text-gray-900">Portfolio</a>
                        @auth
                            @if(auth()->user()->id === $user->id)
                                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-700 font-semibold">{{ __('Back to Dashboard') }}</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <section class="bg-gradient-to-r from-blue-600 to-purple-600 py-12 md:py-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row md:items-start gap-8">
                        <!-- Avatar -->
                        <div class="shrink-0 mx-auto md:mx-0">
                            @if($profile?->avatar)
                                <img src="{{ asset('storage/' . $profile->avatar) }}" alt="{{ $user->name }}" class="w-32 h-32 md:w-40 md:h-40 object-cover rounded-full border-4 border-white shadow-lg">
                            @else
                                <div class="w-32 h-32 md:w-40 md:h-40 bg-white rounded-full flex items-center justify-center shadow-lg">
                                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <!-- Details -->
                        <div class="text-white text-center md:text-left flex-1 min-w-0">
                            <h1 class="text-4xl md:text-5xl font-bold mb-2">{{ $user->name }}</h1>
                            @if($profile?->title)
                                <p class="text-xl md:text-2xl text-blue-100 mb-4">{{ $profile->title }}</p>
                            @endif
                            @if($profile?->bio)
                                <div class="text-lg text-blue-50 whitespace-pre-line mt-2">{{ $profile->bio }}</div>
                            @endif
                            <div class="flex flex-wrap gap-3 justify-center md:justify-start mt-6">
                                @if($profile?->is_email_public)
                                    <a href="mailto:{{ $user->email }}" class="inline-flex items-center px-4 py-2 bg-white text-blue-600 rounded-lg font-semibold hover:bg-blue-50">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ __('Email') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main Content -->
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <!-- Stats Section -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $user->skills()->count() }}</div>
                        <div class="text-sm text-gray-600 mt-1">{{ __('Skills') }}</div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $user->experiences()->count() }}</div>
                        <div class="text-sm text-gray-600 mt-1">{{ __('Experiences') }}</div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $user->education()->count() }}</div>
                        <div class="text-sm text-gray-600 mt-1">{{ __('Education') }}</div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                        <div class="text-3xl font-bold text-red-600">{{ $user->projects()->count() }}</div>
                        <div class="text-sm text-gray-600 mt-1">{{ __('Projects') }}</div>
                    </div>
                </div>

                <!-- About Section -->
                @if($profile?->bio)
                    <section class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('About') }}</h2>
                        <div class="bg-white p-8 rounded-lg shadow-sm">
                            <p class="text-gray-700 leading-relaxed">{{ $profile->bio }}</p>
                        </div>
                    </section>
                @endif

                <!-- Skills Section -->
                @if($user->skills()->exists())
                    <section class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('Skills') }}</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($user->skills as $skill)
                                <div class="bg-white p-6 rounded-lg shadow-sm">
                                    <div class="flex justify-between items-start mb-3">
                                        <h3 class="font-semibold text-gray-900">{{ $skill->name }}</h3>
                                        @if($skill->level)
                                            <span class="inline-block px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-full">{{ $skill->level }}</span>
                                        @endif
                                    </div>
                                    @if($skill->category)
                                        <p class="text-sm text-gray-600">{{ $skill->category }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Experiences Section -->
                @if($user->experiences()->exists())
                    <section class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('Experience') }}</h2>
                        <div class="space-y-6">
                            @foreach($user->experiences as $experience)
                                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $experience->role }}</h3>
                                        @if($experience->duration)
                                            <span class="text-sm text-gray-600">{{ $experience->duration }}</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-700 font-medium mb-2">{{ $experience->company }}</p>
                                    @if($experience->description)
                                        <p class="text-gray-600">{{ $experience->description }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Education Section -->
                @if($user->education()->exists())
                    <section class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('Education') }}</h2>
                        <div class="space-y-6">
                            @foreach($user->education as $edu)
                                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-purple-500">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $edu->degree }}</h3>
                                        @if($edu->year)
                                            <span class="text-sm text-gray-600">{{ $edu->year }}</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-700 font-medium">{{ $edu->institute }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Projects Section -->
                @if($user->projects()->exists())
                    <section class="mb-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('Projects') }}</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($user->projects as $project)
                                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-lg transition">
                                    @if($project->image)
                                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="p-6">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $project->title }}</h3>
                                        @if($project->description)
                                            <p class="text-gray-600 mb-4 line-clamp-2">{{ $project->description }}</p>
                                        @endif
                                        @if($project->link)
                                            <a href="{{ $project->link }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-700 font-semibold inline-flex items-center">
                                                {{ __('View Project') }}
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4m-4-4l8-8m0 0H8m8 0v8"></path>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </main>

            <!-- Footer -->
            <footer class="bg-gray-900 text-white mt-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-center text-gray-400">
                    <p>© 2026 Portfolio. All rights reserved.</p>
                </div>
            </footer>
        </div>

        <!-- Chatbot Widget -->
        @include('components.chatbot-widget')
    </body>
</html>
