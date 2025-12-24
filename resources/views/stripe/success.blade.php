<x-app title="Payment Successful">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-3xl mx-auto">
            <!-- Success Card -->
            <div class="bg-white rounded-lg shadow-xl p-8 text-center border-t-4 border-green-500">
                <!-- Success Icon with Animation -->
                <div class="mb-6">
                    <div class="mx-auto h-20 w-20 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Success Message -->
                <h1 class="text-4xl font-bold text-gray-900 mb-3">🎉 Payment Successful!</h1>
                <p class="text-xl text-gray-600 mb-2">
                    Your listing is now <span class="font-bold text-orange-600">FEATURED</span>
                </p>
                <p class="text-sm text-gray-500 mb-8">
                    Stand out from the competition for the next {{ config('stripe.featured_listing.duration_days') }} days
                </p>

                <!-- Payment Details Card -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 mb-6 shadow-inner">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center justify-center">
                        <svg class="h-5 w-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Payment Details
                    </h2>
                    <dl class="space-y-3 text-left">
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <dt class="text-gray-600 font-medium">Car Listing:</dt>
                            <dd class="text-gray-900 font-semibold">{{ $car->getTitle() }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <dt class="text-gray-600 font-medium">Amount Paid:</dt>
                            <dd class="text-2xl font-bold text-green-600">{{ $payment->formatted_amount }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <dt class="text-gray-600 font-medium">Payment Date:</dt>
                            <dd class="text-gray-900 font-medium">{{ $payment->paid_at->format('M d, Y \\a\\t g:i A') }}</dd>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <dt class="text-gray-600 font-medium">Featured Until:</dt>
                            <dd class="text-gray-900 font-medium">{{ $car->featured_until->format('M d, Y \\a\\t g:i A') }}</dd>
                        </div>
                        <div class="flex justify-between items-start py-2">
                            <dt class="text-gray-600 font-medium">Transaction ID:</dt>
                            <dd class="text-gray-900 font-mono text-xs break-all max-w-xs">{{ $payment->stripe_payment_intent_id }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Featured Badge Preview -->
                <div class="bg-gradient-to-r from-orange-50 to-yellow-50 border-2 border-orange-300 rounded-xl p-6 mb-6">
                    <div class="flex items-center justify-center space-x-3 mb-3">
                        <svg class="h-7 w-7 text-orange-500 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-orange-600 font-bold text-xl uppercase tracking-wide">Featured Listing</span>
                        <svg class="h-7 w-7 text-orange-500 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <h3 class="text-orange-900 font-semibold mb-2">What You Get:</h3>
                    <ul class="text-left text-orange-800 text-sm space-y-2 max-w-md mx-auto">
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-orange-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span><strong>Top Placement:</strong> Appears first in search results</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-orange-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span><strong>Premium Badge:</strong> Eye-catching featured badge on listing</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-orange-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span><strong>Homepage Spotlight:</strong> Featured in special section on homepage</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-orange-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span><strong>Increased Views:</strong> Up to 5x more visibility than standard listings</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-6">
                    <a href="{{ route('car.show', $car) }}" 
                       class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-lg text-white bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-700 hover:to-orange-600 transition-all transform hover:scale-105 shadow-lg">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View Your Featured Listing
                    </a>
                    <a href="{{ route('car.index') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-300 text-base font-semibold rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all shadow-md">
                        <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        All My Listings
                    </a>
                </div>

                <!-- Additional Actions -->
                <div class="pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600 mb-3">Want to boost another listing?</p>
                    <a href="{{ route('car.index') }}" class="text-orange-600 hover:text-orange-700 font-semibold text-sm underline">
                        Promote More Cars →
                    </a>
                </div>
            </div>

            <!-- Receipt Notice -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
                <div class="flex items-start">
                    <svg class="h-6 w-6 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-left">
                        <p class="text-sm font-semibold text-blue-900">Receipt Sent</p>
                        <p class="text-sm text-blue-700 mt-1">
                            A payment receipt has been sent to <span class="font-medium">{{ auth()->user()->email }}</span>. 
                            Need help? <a href="mailto:support@car-hub.xyz" class="underline hover:text-blue-900">Contact support</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
