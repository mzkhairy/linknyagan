<!-- resources/views/auth/register.blade.php -->
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Page Name -->
        <div class="mt-4">
            <x-input-label for="page_name" :value="__('Page Name')" />
            <div class="flex items-center">
                <span class="text-gray-500 bg-gray-100 px-3 py-2 rounded-l-md border border-r-0 border-gray-300">
                    linknya.gan/
                </span>
                <x-text-input 
                    id="page_name" 
                    class="block mt-0 w-full rounded-l-none" 
                    type="text" 
                    name="page_name" 
                    :value="old('page_name', request('page_name'))" 
                    required 
                    readonly 
                    style="background-color: #f3f4f6;"
                />
            </div>
            <x-input-error :messages="$errors->get('page_name')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Password Confirmation')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4" style="background-color: #DB996C">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>