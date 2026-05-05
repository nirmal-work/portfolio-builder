<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 text-white">
        <header class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-lg font-bold">Portfolio SaaS</span>
                    <span class="text-sm text-blue-100">One platform for developer portfolios with AI assistant</span>
                </div>
                <div class="space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-white text-blue-700 px-4 py-2 rounded-md font-semibold hover:bg-blue-50">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-blue-700 px-4 py-2 rounded-md font-semibold hover:bg-blue-50">Login</a>
                        <a href="{{ route('register') }}" class="border border-white text-white px-4 py-2 rounded-md font-semibold hover:bg-white hover:text-blue-700 transition">Register</a>
                    @endauth
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
            <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight mb-4">Build your portfolio with zero setup</h1>
            <p class="max-w-2xl mx-auto text-lg sm:text-xl text-blue-100 mb-8">Create a polished public portfolio, showcase skills, projects, experience and get AI-powered portfolio assistant all in one SaaS platform.</p>

            <div class="flex flex-wrap justify-center gap-4">
                @guest
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-blue-700 font-semibold rounded-md shadow-sm hover:bg-blue-50">Start for Free</a>
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 border border-white text-white font-semibold rounded-md hover:bg-white hover:text-blue-700 transition">Login</a>
                @else
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-blue-700 font-semibold rounded-md shadow-sm hover:bg-blue-50">Go to Dashboard</a>
                @endguest
            </div>

            <section class="mt-20 grid gap-6 md:grid-cols-3">
                <div class="bg-white/10 p-6 rounded-xl border border-white/20">
                    <h3 class="text-xl font-semibold mb-2">Portfolio Builder</h3>
                    <p>Create structured portfolios fast with profile, skills, experience, education, projects and social links.</p>
                </div>
                <div class="bg-white/10 p-6 rounded-xl border border-white/20">
                    <h3 class="text-xl font-semibold mb-2">Secure Authentication</h3>
                    <p>Breeze-backed auth, role permissions, dashboard and admin panel included.</p>
                </div>
                <div class="bg-white/10 p-6 rounded-xl border border-white/20">
                    <h3 class="text-xl font-semibold mb-2">AI Assistant</h3>
                    <p>AI chatbot answers profile questions using your data. Set OPENAI_API_KEY in .env.</p>
                </div>
            </section>
        </main>
    </div>
</x-app-layout>