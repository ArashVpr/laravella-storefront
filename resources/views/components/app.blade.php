@props(['title' => ''])

<x-base :$title>
    @include('layouts.partials.header')
        {{ $slot }}
    <footer></footer>
</x-base>
