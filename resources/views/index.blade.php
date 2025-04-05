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
        <x-new-cars />
        <!--/ New Cars -->
      </main>
@endsection
