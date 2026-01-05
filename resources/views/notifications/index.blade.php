<x-app title="Notifications">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
                @if($notifications->where('read_at', null)->count() > 0)
                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                            Mark All as Read
                        </button>
                    </form>
                @endif
            </div>

            <!-- Notifications List -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @forelse($notifications as $notification)
                    <div class="border-b border-gray-200 hover:bg-gray-50 transition-colors {{ is_null($notification->read_at) ? 'bg-blue-50' : '' }}">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <!-- Notification Icon & Content -->
                                    <div class="flex items-start space-x-4">
                                        @php
                                            $type = $notification->data['type'] ?? 'general';
                                            $iconConfig = match($type) {
                                                'price_drop' => ['bg' => 'bg-green-100', 'text' => 'text-green-600', 'icon' => 'M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z'],
                                                'payment_successful' => ['bg' => 'bg-green-100', 'text' => 'text-green-600', 'icon' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'],
                                                'featured_expiring' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-600', 'icon' => 'M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z'],
                                                'car_inquiry' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'icon' => 'M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z'],
                                                default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => 'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z'],
                                            };
                                        @endphp
                                        
                                        <div class="flex-shrink-0">
                                            <div class="h-12 w-12 rounded-full {{ $iconConfig['bg'] }} flex items-center justify-center">
                                                <svg class="h-6 w-6 {{ $iconConfig['text'] }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="{{ $iconConfig['icon'] }}" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="flex-1">
                                            <p class="text-base text-gray-900 {{ is_null($notification->read_at) ? 'font-semibold' : '' }}">
                                                {{ $notification->data['message'] ?? 'New notification' }}
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                            @if(isset($notification->data['url']))
                                                <a href="{{ $notification->data['url'] }}" class="inline-block mt-2 text-sm text-orange-600 hover:text-orange-700 font-medium">
                                                    View Details →
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="ml-4 flex items-center space-x-2">
                                    @if(is_null($notification->read_at))
                                        <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900" title="Mark as read">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-700" title="Delete">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No notifications</h3>
                        <p class="mt-2 text-sm text-gray-500">You're all caught up!</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="mt-6">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app>
