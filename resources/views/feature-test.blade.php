<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Feature Flags Test - Laravella</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-6">Feature Flags Test Page</h1>
            
            @if($user)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">User Information</h2>
                    <div class="space-y-2">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Premium Status:</strong> 
                            <span class="px-2 py-1 rounded {{ $user->is_premium ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $user->is_premium ? 'Premium' : 'Free' }}
                            </span>
                        </p>
                        <p><strong>Listed Cars:</strong> {{ $user->cars()->count() }}</p>
                    </div>
                    <button id="togglePremium" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Toggle Premium Status
                    </button>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <p class="text-yellow-800">
                        <strong>Note:</strong> You are not logged in. 
                        <a href="{{ route('login') }}" class="underline">Login</a> to see user-scoped features.
                    </p>
                </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Global Features -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Global Features</h2>
                    <div class="space-y-3">
                        @foreach(['real-time-chat', 'webp-images', 'new-car-ui'] as $feature)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                <span class="font-medium">{{ str_replace('-', ' ', ucwords($feature, '-')) }}</span>
                                <span class="px-2 py-1 rounded text-sm {{ $features[$feature] ?? false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $features[$feature] ?? false ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- User-Scoped Features -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">User Features</h2>
                    @if($user)
                        <div class="space-y-3">
                            @foreach(['enhanced-search', 'premium-watchlist', 'seller-analytics'] as $feature)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                    <span class="font-medium">{{ str_replace('-', ' ', ucwords($feature, '-')) }}</span>
                                    <span class="px-2 py-1 rounded text-sm {{ $userFeatures[$feature] ?? false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $userFeatures[$feature] ?? false ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">Login to see user-scoped features</p>
                    @endif
                </div>
            </div>
            
            <!-- Feature Descriptions -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h2 class="text-xl font-semibold mb-4">Feature Descriptions</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="font-semibold text-blue-600">Enhanced Search</h3>
                        <p class="text-gray-600">AI-powered search with suggestions (Premium users only)</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-blue-600">New Car UI</h3>
                        <p class="text-gray-600">Modern car listing interface (50% gradual rollout)</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-blue-600">Premium Watchlist</h3>
                        <p class="text-gray-600">Unlimited cars in watchlist (Premium users only)</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-blue-600">Seller Analytics</h3>
                        <p class="text-gray-600">Advanced analytics dashboard (Users with 3+ listed cars)</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-blue-600">Real-time Chat</h3>
                        <p class="text-gray-600">Chat feature for car inquiries (Available to all)</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-blue-600">WebP Images</h3>
                        <p class="text-gray-600">Modern image format for better performance (Available to all)</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 text-center">
                <a href="/" class="text-blue-500 hover:underline">Back to Home</a>
            </div>
        </div>
    </div>
    
    @if($user)
    <script>
        document.getElementById('togglePremium').addEventListener('click', async () => {
            const btn = document.getElementById('togglePremium');
            btn.disabled = true;
            btn.textContent = 'Processing...';
            
            try {
                const response = await fetch('{{ route('feature.toggle-premium') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Error: ' + (data.error || 'Unknown error'));
                    btn.disabled = false;
                    btn.textContent = 'Toggle Premium Status';
                }
            } catch (error) {
                alert('Error: ' + error.message);
                btn.disabled = false;
                btn.textContent = 'Toggle Premium Status';
            }
        });
    </script>
    @endif
</body>
</html>
