<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Selamat datang') }} {{Auth::user()->name}} {{ __('di linknya.gan/') }}{{Auth::user()->page_name}} {{ __('dashboard') }}
        </h2>
    </x-slot>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div class="py-12" style="background-color: #FCF8F3" x-data="{ showEditModal: false, currentLink: {} }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Add Link Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6" style="background-color: #AEDADD">
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
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="background-color: #DB996C">
                                Save Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Links List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" style="background-color: #AEDADD">
                    <h3 class="text-lg font-medium mb-4">Your Links</h3>
                    <div class="space-y-6">
                        @foreach(Auth::user()->links as $link)
                            <div class="border rounded-lg p-4 bg-gray-50" style="background-color: #FCF8F3">
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
                                                        <p class="text-sm text-white-500 mt-1">{{ $link->description }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="flex flex-col items-center justify-center ml-4 space-y-2">
                                        <button @click="showEditModal = true; currentLink = {
                                            id: '{{ $link->id }}',
                                            title: '{{ addslashes($link->title) }}',
                                            url: '{{ $link->url }}',
                                            description: '{{ addslashes($link->description) }}',
                                            image: '{{ $link->image }}'
                                        }"
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

        <!-- Edit Modal -->
        <template x-teleport="body">
            <div x-show="showEditModal"
                x-cloak
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.away="showEditModal = false" style="background-color: #AEDADD">
                    <h2 class="text-xl font-bold mb-4">Edit Link</h2>
                    <form x-bind:action="'/links/' + currentLink.id" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label for="edit-title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="edit-title" 
                                x-model="currentLink.title"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500" 
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="edit-url" class="block text-sm font-medium text-gray-700">URL</label>
                            <input type="url" name="url" id="edit-url" 
                                x-model="currentLink.url"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500" 
                                required>
                        </div>
                        <div class="mb-4">
                            <label for="edit-description" class="block text-sm font-medium text-gray-700">Description</label>
                            <input type="text" name="description" id="edit-description" 
                                x-model="currentLink.description"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500">
                        </div>
                        <div class="mb-4">
                            <label for="edit-image" class="block text-sm font-medium text-gray-700">Image URL</label>
                            <input type="url" name="image" id="edit-image" 
                                x-model="currentLink.image"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500">
                        </div>
                        <div class="flex justify-end">
                            <button type="button" @click="showEditModal = false" 
                                class="mr-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                                Cancel
                            </button>
                            <button type="submit" 
                                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>