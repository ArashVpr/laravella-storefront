@props(['bodyClass' => '', 'title' => '', 'metaDescription' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- // CSRF token for security --}}
    <title>{{ $title ? $title . ' | ' . config('app.name') : config('app.name') }}</title>

    {{-- SEO Meta Tags --}}
    <meta name="description"
        content="{{ $metaDescription ?? 'car-hub.xyz is a Laravel-based web application for car management, features, authentication, and more.' }}">
    <link rel="canonical" href="{{ url()->current() }}" />

    {{-- Open Graph Tags --}}
    <meta property="og:title" content="{{ $title ? $title . ' | ' . config('app.name') : config('app.name') }}" />
    <meta property="og:description"
        content="{{ $metaDescription ?? 'car-hub.xyz is a Laravel-based web application for car management, features, authentication, and more.' }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ asset('img/car-png-39071.webp') }}" />

    {{-- Twitter Card Tags --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $title ? $title . ' | ' . config('app.name') : config('app.name') }}" />
    <meta name="twitter:description"
        content="{{ $metaDescription ?? 'car-hub.xyz is a Laravel-based web application for car management, features, authentication, and more.' }}" />
    <meta name="twitter:image" content="{{ asset('img/car-png-39071.webp') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <!-- <link
      href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css"
      rel="stylesheet"
    /> -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- <link rel="stylesheet" href="css/output.css" /> -->
</head>

<body @if ($bodyClass) class="{{ $bodyClass }}" @endif>
    <!-- Skip to main content link for keyboard users -->
    <a href="#main-content" class="skip-link sr-only focus:not-sr-only">Skip to main content</a>

    {{ $slot }}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/scrollReveal.js/4.0.9/scrollreveal.js"
        integrity="sha512-XJgPMFq31Ren4pKVQgeD+0JTDzn0IwS1802sc+QTZckE6rny7AN2HLReq6Yamwpd2hFe5nJJGZLvPStWFv5Kww=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <script src="https://unpkg.com/website-carbon-badges@1.1.3/b.min.js" defer></script>
</body>

</html>
