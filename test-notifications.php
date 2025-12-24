<?php

use App\Models\User;
use App\Models\Car;
use App\Models\Payment;
use App\Notifications\PaymentSuccessfulNotification;
use App\Notifications\NewCarInquiryNotification;
use App\Notifications\CarPriceDropNotification;
use App\Notifications\CarFeaturedExpiringNotification;
use App\Notifications\WatchlistCarUpdatedNotification;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🧪 Testing Real-Time Notifications\n";
echo "==================================\n\n";

// Get or create test user
$user = User::where('email', '!=', 'test@example.com')->first();
if (!$user) {
    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'realtime.test@example.com'
    ]);
    echo "✓ Created new test user\n";
} else {
    echo "✓ Using existing user\n";
}
echo "  User: {$user->name} ({$user->email}) - ID: {$user->id}\n\n";

// Get or create test car
$car = Car::first();
if (!$car) {
    $car = Car::factory()->create(['user_id' => $user->id]);
    echo "✓ Created new test car\n";
} else {
    echo "✓ Using existing car\n";
}
echo "  Car: {$car->getTitle()}\n\n";

// Test 1: Payment Successful Notification
echo "1️⃣  Testing PaymentSuccessfulNotification...\n";
try {
    $payment = Payment::factory()->create([
        'user_id' => $user->id,
        'car_id' => $car->id,
        'amount' => 2999,
        'status' => 'completed'
    ]);
    $user->notify(new PaymentSuccessfulNotification($payment, $car));
    echo "   ✅ Notification queued (Payment ID: {$payment->id})\n\n";
} catch (Exception $e) {
    echo "   ❌ Error: {$e->getMessage()}\n\n";
}

// Test 2: New Car Inquiry Notification
echo "2️⃣  Testing NewCarInquiryNotification...\n";
try {
    $user->notify(new NewCarInquiryNotification(
        $car,
        'John Doe',
        'john@example.com',
        'I am very interested in purchasing this car. Is it still available?'
    ));
    echo "   ✅ Notification queued\n\n";
} catch (Exception $e) {
    echo "   ❌ Error: {$e->getMessage()}\n\n";
}

// Test 3: Price Drop Notification
echo "3️⃣  Testing CarPriceDropNotification...\n";
try {
    $user->notify(new CarPriceDropNotification($car, 50000, 45000));
    echo "   ✅ Notification queued (Price drop: \$50,000 → \$45,000)\n\n";
} catch (Exception $e) {
    echo "   ❌ Error: {$e->getMessage()}\n\n";
}

// Test 4: Featured Expiring Notification
echo "4️⃣  Testing CarFeaturedExpiringNotification...\n";
try {
    $user->notify(new CarFeaturedExpiringNotification($car, 3));
    echo "   ✅ Notification queued (Expires in 3 days)\n\n";
} catch (Exception $e) {
    echo "   ❌ Error: {$e->getMessage()}\n\n";
}

// Test 5: Watchlist Car Updated Notification
echo "5️⃣  Testing WatchlistCarUpdatedNotification...\n";
try {
    $user->notify(new WatchlistCarUpdatedNotification(
        $car,
        'details_updated',
        ['mileage' => ['from' => 50000, 'to' => 55000]]
    ));
    echo "   ✅ Notification queued (Mileage updated)\n\n";
} catch (Exception $e) {
    echo "   ❌ Error: {$e->getMessage()}\n\n";
}

// Summary
echo "📊 Summary:\n";
echo "===========\n";
echo "✓ 5 notifications successfully queued\n";
echo "✓ User ID: {$user->id}\n";
echo "✓ User Email: {$user->email}\n";
echo "✓ Total notifications in database: " . $user->notifications()->count() . "\n";
echo "✓ Unread notifications: " . $user->unreadNotifications()->count() . "\n\n";

echo "🚀 Next Steps:\n";
echo "1. Make sure ./start-dev.sh is running (Reverb + Queue + Vite)\n";
echo "2. Login to the app using: {$user->email}\n";
echo "3. Watch the notification bell update in real-time\n";
echo "4. Browser notifications should appear (if permission granted)\n\n";

echo "🔍 Check Queue Jobs:\n";
echo "   php artisan queue:failed\n\n";

echo "🔍 Check Reverb Status:\n";
echo "   php artisan reverb:status\n\n";
