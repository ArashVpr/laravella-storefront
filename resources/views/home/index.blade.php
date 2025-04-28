<x-app title="Home Page">
    @session('success')
        <div class="container my-large">
            <div class="success-message">
                {{ session('success') }}
            </div>
        </div>
    @endsession
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
