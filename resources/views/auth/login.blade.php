<x-app title="Login" bodyClass="bg-gray-50 h-full">
    <div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <div class="px-8 py-10">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('Welcome Back') }}</h2>
                    <p class="mt-2 text-sm text-gray-500">{{ __('Sign in to your account') }}</p>
                </div>

                @if(session('error'))
                <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-6 flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>{{ session('error') }}</p>
                </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email Address') }}</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                            placeholder="{{ __('you@example.com') }}">
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <!-- Demo Credential Hint -->
                        <div class="mt-2 text-xs bg-gray-50 text-gray-500 p-2 rounded-lg border border-gray-100 inline-block">
                            <span class="font-semibold">{{ __('Demo:') }}</span> akoelpin@example.net
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                            <a href="{{ route('password.forgot') }}" class="text-sm font-medium text-primary hover:text-primary-hover">{{ __('Forgot password?') }}</a>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                            placeholder="{{ __('••••••••') }}">
                        @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <!-- Demo Credential Hint -->
                        <div class="mt-2 text-xs bg-gray-50 text-gray-500 p-2 rounded-lg border border-gray-100 inline-block">
                            <span class="font-semibold">{{ __('Demo:') }}</span> password
                        </div>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-primary/30 text-sm font-bold text-white bg-primary hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all">
                        {{ __('Sign in') }}
                    </button>
                </form>

                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">{{ __('Or continue with') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <a href="{{ route('login.oauth', 'google') }}" class="w-full flex items-center justify-center gap-2 px-4 py-2 border border-gray-200 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            <img src="/img/google.png" alt="Google" class="h-5 w-5">
                            {{ __('Google') }}
                        </a>
                        <button disabled class="w-full opacity-50 cursor-not-allowed flex items-center justify-center gap-2 px-4 py-2 border border-gray-200 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white">
                            <img src="/img/facebook.png" alt="Facebook" class="h-5 w-5">
                            {{ __('Facebook') }}
                        </button>
                    </div>
                </div>

                <p class="mt-8 text-center text-sm text-gray-600">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('signup') }}" class="font-bold text-primary hover:text-primary-hover transition-colors">{{ __('Sign up') }}</a>
                </p>
            </div>
        </div>
    </div>
</x-app>