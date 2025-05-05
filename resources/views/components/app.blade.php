@props(['title' => '', 'bodyClass' => null, 'footerLinks' => ''])

<x-base :$title :$bodyClass>
    @include('layouts.partials.header')

    @session('success')
        <div class="container my-large">
            <div class="success-message">
                {{ session('success') }}
            </div>
        </div>
    @endsession

    @session('warning')
        <div class="container my-large">
            <div class="warning-message">
                {{ session('warning') }}
            </div>
        </div>
    @endsession

    {{ $slot }}

    @include('layouts.partials.footer')
</x-base>
