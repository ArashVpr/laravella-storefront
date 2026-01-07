<x-app title="My Cars">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">My Garage</h1>
            <a href="{{ route('car.create') }}" class="bg-primary hover:bg-primary-hover text-white font-bold py-2 px-6 rounded-xl transition-all shadow-lg shadow-primary/30 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Sell a Car
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($cars->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-500 font-semibold tracking-wider">
                                <th class="p-6">Vehicle</th>
                                <th class="p-6">Added</th>
                                <th class="p-6">Price</th>
                                <th class="p-6">Status</th>
                                <th class="p-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($cars as $car)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="p-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-20 h-14 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0 relative">
                                                <img src="{{ $car->primaryImage?->getUrl() ?? '/img/no-image.png' }}" class="w-full h-full object-cover">
                                                @if($car->isFeatured()) 
                                                    <div class="absolute top-0 right-0 bg-yellow-400 w-3 h-3 rounded-bl-md z-10" title="Featured"></div>
                                                @endif
                                            </div>
                                            <div>
                                                <a href="{{ route('car.show', $car) }}" class="font-bold text-gray-900 hover:text-primary transition-colors block">
                                                    {{ $car->getTitle() }}
                                                </a>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ $car->details_completed ? 'Details Complete' : 'Details Incomplete' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6 text-sm text-gray-600">
                                        {{ $car->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="p-6 font-bold text-gray-900">
                                        ${{ number_format($car->price) }}
                                    </td>
                                    <td class="p-6">
                                        @if($car->published_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Draft
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-6">
                                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('car.edit', $car) }}" class="p-2 text-gray-400 hover:text-primary hover:bg-primary-50 rounded-lg transition-all" title="Edit">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form action="{{ route('car.destroy', $car) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this car?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Delete">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $cars->links() }}
                </div>
            @else
                <div class="text-center py-16 px-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                         <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No cars listed yet</h3>
                    <p class="text-gray-500 mb-6 max-w-sm mx-auto">It looks like you haven't listed any cars for sale yet. Get started today!</p>
                    <a href="{{ route('car.create') }}" class="inline-flex items-center gap-2 bg-primary hover:bg-primary-hover text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-primary/30">
                        Sell Your Car
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app>
