@extends('layouts.base')
    

    @section('childContent')
        @include('layouts.partials.header')
        @yield('content')
        <footer></footer>
    @endsection
    

