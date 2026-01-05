@props(['title' => ''])

<x-app :title="$title">
    @yield('content')
</x-app>
