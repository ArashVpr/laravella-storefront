@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
<!-- Home Slider -->
<x-hero-slider />
<!--/ Home Slider -->
<main>
    <!-- Find a car form -->
    <x-search-car />
    <!--/ Find a car form -->

    <!-- New Cars -->
    <!-- x-new-cars /> -->
    <!--/ New Cars -->

    <section>
        <div class="container">
            <h2>Latest Added Cars</h2>
            <div class="car-items-listing">
                @foreach($cars as $car)
                <x-car-items :$car />
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection
