<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Add Link Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Add New Link</h3>
                    <form action="{{ route('links.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" id="title" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror"
                                    value="{{ old('title') }}">
                                @error('title')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                                <input type="url" name="url" id="url" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('url') border-red-500 @enderror"
                                    value="{{ old('url') }}">
                                @error('url')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" name="description" id="description" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    value="{{ old('description') }}">
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Image URL</label>
                                <input type="url" name="image" id="image" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    value="{{ old('image') }}">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" 
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Links List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Your Links</h3>
                    <div class="space-y-6">
                        @foreach(Auth::user()->links as $link)
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <div class="flex items-center">
                                    <div class="flex-grow">
                                        <a href="{{ $link->url }}" target="_blank" class="block">
                                            <div class="flex space-x-4 items-center">
                                                @if($link->image)
                                                    <img src="{{ $link->image }}" alt="{{ $link->title }}" 
                                                        class="w-20 h-20 object-contain rounded"
                                                        onerror="this.style.display='none'">
                                                @endif
                                                <div>
                                                    <h4 class="font-medium text-lg">{{ $link->title }}</h4>
                                                    <p class="text-sm text-blue-600 hover:underline break-words">{{ $link->url }}</p>
                                                    @if($link->description)
                                                        <p class="text-sm text-gray-500 mt-1">{{ $link->description }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="flex flex-col items-center justify-center ml-4 space-y-2">
                                        <button onclick="showEdit('{{ $link->id }}')" 
                                            class="bg-indigo-600 text-white px-2 py-1 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                            Edit
                                        </button>
                                        <form action="{{ route('links.destroy', $link) }}" method="POST" class="inline" 
                                            onsubmit="return confirm('Are you sure you want to delete this link?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
