@section('title', 'Home Page')

<x-app>
    <!-- Home Slider -->
    <x-hero-slider />
    <!--/ Home Slider -->
    <main>
        <!-- Find a car form -->
        <x-search-car />
        <!--/ Find a car form -->

        <!-- New Cars -->
        <x-new-cars :$cars />
        <!--/ New Cars -->
    </main>
</x-app>
