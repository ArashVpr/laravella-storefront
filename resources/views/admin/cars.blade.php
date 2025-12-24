@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <h1 class="text-2xl font-semibold">Cars</h1>

    <div class="mt-6 bg-white dark:bg-gray-800 rounded shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                @foreach ($cars as $car)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $car->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $car->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ optional($car->user)->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ money($car->price) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $cars->links() }}</div>
</div>
@endsection
