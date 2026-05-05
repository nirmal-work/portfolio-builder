<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Social Links') }}
            </h2>
            <a href="{{ route('social-links.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                {{ __('Add Social Link') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($socialLinks->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-gray-600 mb-4">{{ __('No social links added yet.') }}</p>
                    <a href="{{ route('social-links.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        {{ __('Add Your First Social Link') }}
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($socialLinks as $link)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $link->platform }}</h3>
                                <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-700 break-all mb-4 block text-sm">
                                    {{ $link->url }}
                                </a>
                                <div class="flex gap-2 mt-4">
                                    <a href="{{ route('social-links.edit', $link) }}" class="flex-1 text-center px-4 py-2 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm font-semibold">
                                        {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('social-links.destroy', $link) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('{{ __('Are you sure?') }}')" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200 text-sm font-semibold">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($socialLinks->hasPages())
                    <div class="mt-6">
                        {{ $socialLinks->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
