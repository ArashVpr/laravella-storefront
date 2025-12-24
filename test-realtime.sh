#!/bin/bash

# Test script for real-time notifications
# This script demonstrates how to test the real-time notification system

echo "🚀 Real-Time Notification Test Script"
echo "======================================="
echo ""

# Check if .env has Reverb configured
if ! grep -q "REVERB_APP_KEY" .env; then
    echo "⚠️  Reverb not configured in .env file"
    echo "Please add the following to your .env:"
    echo ""
    echo "REVERB_APP_ID=870283"
    echo "REVERB_APP_KEY=29ac0a289700817380a28d672c9b0602"
    echo "REVERB_APP_SECRET=e8cfe7aa54e4a46cd90babe4ef48276571c1db16faff47eb8a0738810dec0c00"
    echo "REVERB_HOST=localhost"
    echo "REVERB_PORT=8080"
    echo "REVERB_SCHEME=http"
    echo "BROADCAST_CONNECTION=reverb"
    echo ""
    echo "VITE_REVERB_APP_KEY=\"\${REVERB_APP_KEY}\""
    echo "VITE_REVERB_HOST=\"\${REVERB_HOST}\""
    echo "VITE_REVERB_PORT=\"\${REVERB_PORT}\""
    echo "VITE_REVERB_SCHEME=\"\${REVERB_SCHEME}\""
    echo ""
    exit 1
fi

echo "✅ Reverb configuration found"
echo ""

# Instructions
echo "📋 Testing Steps:"
echo "================="
echo ""
echo "1. Start Reverb WebSocket Server (Terminal 1):"
echo "   php artisan reverb:start --debug"
echo ""
echo "2. Start Queue Worker (Terminal 2):"
echo "   php artisan queue:work --verbose"
echo ""
echo "3. Send Test Notification (Terminal 3):"
echo "   php artisan tinker"
echo ""
echo "   Then run in Tinker:"
echo "   \$user = App\\Models\\User::first();"
echo "   \$car = App\\Models\\Car::first();"
echo "   \$payment = App\\Models\\Payment::factory()->create(['user_id' => \$user->id, 'car_id' => \$car->id]);"
echo "   \$user->notify(new App\\Notifications\\PaymentSuccessfulNotification(\$payment, \$car));"
echo ""
echo "4. In Browser:"
echo "   - Login as the user"
echo "   - Grant notification permission when prompted"
echo "   - Watch notification bell update in real-time"
echo "   - Browser notification should appear"
echo ""
echo "5. Verify in Browser Console:"
echo "   console.log(window.Echo);"
echo "   Echo.connector.pusher.connection.state; // Should show 'connected'"
echo ""
echo "🔍 Troubleshooting:"
echo "==================="
echo "- Check Reverb is running: curl http://localhost:8080"
echo "- Check queue worker: php artisan queue:failed"
echo "- Check logs: tail -f storage/logs/laravel.log"
echo ""
