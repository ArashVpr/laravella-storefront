@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <h1 class="text-2xl font-semibold">Admin Dashboard</h1>

    <div class="mt-6 grid grid-cols-2 gap-4">
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-sm text-gray-500">Users</div>
            <div class="text-3xl font-bold">{{ $usersCount }}</div>
        </div>

        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-sm text-gray-500">Cars</div>
            <div class="text-3xl font-bold">{{ $carsCount }}</div>
        </div>
    </div>

    <div class="mt-8">
        <a href="{{ route('admin.users') }}" class="text-blue-600">Manage Users</a> •
        <a href="{{ route('admin.cars') }}" class="text-blue-600">Manage Cars</a>
    </div>
</div>
@endsection
