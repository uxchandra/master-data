<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-slate-700">LOGIN</h2>
        <p class="text-sm text-slate-500 mt-1">Please enter your credentials to continue</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" class="text-slate-600 font-medium" />
            <x-text-input id="username" class="block mt-1 w-full border-slate-300 focus:border-primary focus:ring-primary" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" placeholder="Enter your username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <x-input-label for="password" :value="__('Password')" class="text-slate-600 font-medium" />

            <x-text-input id="password" class="block mt-1 w-full border-slate-300 focus:border-primary focus:ring-primary"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-primary shadow-sm focus:ring-primary cursor-pointer" name="remember">
                <span class="ml-2 text-sm text-slate-600 group-hover:text-primary transition-colors">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-8">
            <x-primary-button class="w-full justify-center bg-primary hover:bg-sage-700 focus:ring-primary py-3 text-base">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        @if (Route::has('password.request'))
            <div class="mt-4 text-center">
                <a class="underline text-sm text-slate-500 hover:text-primary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>
