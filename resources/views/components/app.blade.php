@props(['title' => '', 'bodyClass' => null, 'footerLinks' => ''])

<x-base :$title :$bodyClass>
    @include('components.announcement-bar')
    @include('layouts.partials.header')

    @if (session('success') || session('warning'))
        <section class="container my-large" role="alert" aria-live="polite">
            @session('success')
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endsession

            @session('warning')
                <div class="warning-message">
                    {{ session('warning') }}
                </div>
            @endsession
        </section>
    @endif

    <main id="main-content" role="main">
        {{ $slot }}
    </main>

    @include('layouts.partials.footer')
</x-base>
