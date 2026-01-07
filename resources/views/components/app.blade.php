@props(['title' => '', 'bodyClass' => null, 'footerLinks' => ''])

<x-base :$title bodyClass="font-sans antialiased text-gray-900 {{ $bodyClass }}">
    @include('components.announcement-bar')
    @include('layouts.partials.header')

    <main id="main-content" class="min-h-screen">
        @if (session('success') || session('warning'))
            <div class="container mx-auto px-4 mt-6">
                @session('success')
                    <div class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative mb-4 flex items-center gap-3" role="alert">
                         <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endsession

                @session('warning')
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-xl relative mb-4 flex items-center gap-3" role="alert">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <span>{{ session('warning') }}</span>
                    </div>
                @endsession
            </div>
        @endif
        
        {{ $slot }}
    </main>

    @include('layouts.partials.footer')
</x-base>
