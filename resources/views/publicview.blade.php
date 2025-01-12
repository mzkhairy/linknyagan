<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $user->name }}'s Links</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}'s Links</h1>
            @if($user->description)
                <p class="text-gray-600 mt-2">{{ $user->description }}</p>
            @endif
        </div>

        <div class="space-y-6">
            @foreach($user->links as $link)
                <div class="border rounded-lg p-4 bg-white shadow-sm hover:shadow-md transition duration-200">
                    <a href="{{ $link->url }}" target="_blank" class="block">
                        <div class="flex space-x-4 items-center">
                            @if($link->image)
                                <img src="{{ $link->image }}" 
                                     alt="{{ $link->title }}" 
                                     class="w-20 h-20 object-contain rounded"
                                     onerror="this.style.display='none'">
                            @endif
                            <div class="flex-grow">
                                <h4 class="font-medium text-lg text-gray-900">{{ $link->title }}</h4>
                                @if($link->description)
                                    <p class="text-gray-600 text-sm mt-1">{{ $link->description }}</p>
                                @endif
                                <p class="text-sm text-blue-600 hover:underline break-words mt-1">{{ $link->url }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Optional: Add a footer with a link back to your main site --}}
        <div class="text-center mt-8 text-sm text-gray-500">
            <a href="{{ url('/') }}" class="hover:text-gray-700">Create your own link page</a>
        </div>
    </div>
</body>
</html>