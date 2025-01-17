<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LinkNyagan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen" style="background-color: #FCF8F3  ;">
        <!-- Header -->
        <header class="shadow" style="background-color: #AEDADD;">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <!-- Logo -->
                    <div>
                        <a href="/" class="flex items-center">
                            <img src="/images/logo.png" alt="LinkNyagan Logo" class="h-20 w-auto">
                        </a>
                    </div>
                    @if (Route::has('login'))
                        <div>
                            @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm text-white px-4 py-2 rounded-md shadow-md transition-all" style="background-color: #DB996C;">
                                Dashboard
                            </a>
                            @else
                                <a href="{{ route('login') }}" 
                                style="background-color: #DB996C; color: #ffffff; border-radius: 0.375rem; padding: 0.5rem 1rem; text-decoration: none; display: inline-block; text-align: center; font-size: 0.875rem; font-weight: 500; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); transition: background-color 0.2s ease;" 
                                onmouseover="this.style.backgroundColor='#2980b9';" 
                                onmouseout="this.style.backgroundColor='#3498db';"
                            >
                                Login
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Bagikan Semua Tautan Anda di Satu Tempat
                </h2>
                <p class="mt-4 text-lg text-black-500">
                    Ciptakan halaman unik untuk menampilkan semua tautan penting Anda di satu tempat yang mudah diakses. 
                    Ideal untuk profil media sosial, portofolio, atau arsip tautan Anda. 
                    Bergabunglah sekarang dan permudah cara Anda berbagi kehadiran dirimu secara online!
                </p>
            </div>

            <!-- Page Name Checker Form -->
            <div class="max-w-2xl mx-auto" x-data="pageNameChecker()">
                <div class="shadow-sm rounded-lg p-6" style="background-color: #AEDADD;">
                    <div class="mb-4" style="background: #  ">
                        <label for="page_name" class="block text-sm font-medium text-gray-700 mb-2">Choose your unique link</label>
                        <div class="flex items-center">
                            <span style="color: #000000; background-color: #FBFBFB;" class="px-3 py-2 rounded-l-md border border-r-0 border-gray-300">
                                linknya.gan/
                            </span>
                            <input 
                                type="text" 
                                name="page_name" 
                                id="page_name"
                                x-model="pageName"
                                @input="checkAvailability"
                                class="flex-1 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-r-md"
                                placeholder="apa nama pagemu?"
                            >
                        </div>
                        <!-- Availability Message -->
                        <div class="mt-2 text-sm" :class="messageClass" x-text="message"></div>
                    </div>

                    <div class="flex justify-end">
                        <a 
                            :href="isAvailable ? registerUrl : '#'"
                            @click="handleRegisterClick"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition-opacity"
                            :class="{ 'opacity-50 cursor-not-allowed': !isAvailable }"
                            x-bind:disabled="!isAvailable"
                            :style="{ backgroundColor: isAvailable ? '#DB996C' : '#DB996C', borderColor: isAvailable ? '#DB996C' : '#DB996C' }"
                            >
                            Register with this name
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function pageNameChecker() {
            return {
                pageName: '',
                isAvailable: false,
                message: '',
                messageClass: '',
                timeout: null,

                get registerUrl() {
                    return `/register?page_name=${this.pageName}`;
                },

                handleRegisterClick(event) {
                    if (!this.isAvailable) {
                        event.preventDefault();
                        return;
                    }
                    window.location.href = this.registerUrl;
                },

                checkAvailability() {
                    if (this.timeout) {
                        clearTimeout(this.timeout);
                    }

                    if (!this.pageName) {
                        this.message = 'Page name is required';
                        this.messageClass = 'text-red-600';
                        this.isAvailable = false;
                        return;
                    }

                    this.timeout = setTimeout(() => {
                        fetch(`/check-page-name/${this.pageName}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.isAvailable = data.available;
                            this.message = data.message;
                            this.messageClass = data.available ? 'text-green-600' : 'text-red-600';
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.message = 'Error checking availability';
                            this.messageClass = 'text-red-600';
                            this.isAvailable = false;
                        });
                    }, 300);
                }
            }
        }
    </script>
</body>
</html>