<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Experience') }}
            </h2>
            <a href="{{ route('experiences.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                {{ __('Add Experience') }}
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

            @if ($experiences->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-gray-600 mb-4">{{ __('No experience added yet.') }}</p>
                    <a href="{{ route('experiences.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        {{ __('Add Your First Experience') }}
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($experiences as $experience)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6 border-l-4 border-green-500">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $experience->role }}</h3>
                                        <p class="text-gray-700 font-medium">{{ $experience->company }}</p>
                                        @if($experience->duration)
                                            <p class="text-sm text-gray-600 mt-1">{{ $experience->duration }}</p>
                                        @endif
                                        @if($experience->description)
                                            <p class="text-gray-600 mt-2">{{ $experience->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex gap-2 mt-4">
                                    <a href="{{ route('experiences.edit', $experience) }}" class="flex-1 text-center px-4 py-2 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-sm font-semibold">
                                        {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('experiences.destroy', $experience) }}" method="POST" class="flex-1">
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

                @if($experiences->hasPages())
                    <div class="mt-6">
                        {{ $experiences->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
