#!/bin/bash

# Startup script for Laravel Laravella Storefront with Real-Time Features
# This script starts all required services for development

set -e

echo "🚀 Starting Laravella Storefront Services"
echo "=========================================="
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "❌ .env file not found!"
    echo "Please copy .env.example to .env and configure it first."
    exit 1
fi

# Check if Reverb is configured
if ! grep -q "REVERB_APP_KEY" .env; then
    echo "⚠️  Warning: Reverb not configured in .env"
    echo "Real-time features may not work properly."
    echo ""
fi

# Function to kill background processes on exit
cleanup() {
    echo ""
    echo "🛑 Stopping services..."
    jobs -p | xargs -r kill 2>/dev/null
    exit 0
}

trap cleanup SIGINT SIGTERM

# Start Reverb WebSocket Server
echo "📡 Starting Reverb WebSocket Server (port 8080)..."
php artisan reverb:start --debug &
REVERB_PID=$!
sleep 2

# Start Queue Worker
echo "⚙️  Starting Queue Worker..."
php artisan queue:work --verbose &
QUEUE_PID=$!
sleep 1

# Start Vite Dev Server
echo "🎨 Starting Vite Dev Server..."
npm run dev &
VITE_PID=$!
sleep 2

echo ""
echo "✅ All services started successfully!"
echo ""
echo "📋 Running Services:"
echo "  - Reverb WebSocket: http://localhost:8080 (PID: $REVERB_PID)"
echo "  - Queue Worker: Running (PID: $QUEUE_PID)"
echo "  - Vite Dev Server: http://localhost:5173 (PID: $VITE_PID)"
echo ""
echo "🌐 Application: http://localhost (ensure your web server is running)"
echo ""
echo "💡 Tips:"
echo "  - Test real-time: ./test-realtime.sh"
echo "  - View logs: tail -f storage/logs/laravel.log"
echo "  - Stop all: Press Ctrl+C"
echo ""
echo "📖 Documentation:"
echo "  - Quick Start: docs/QUICK-START-REALTIME.md"
echo "  - Full Docs: REAL-TIME-FEATURES.md"
echo ""
echo "Press Ctrl+C to stop all services..."
echo ""

# Wait for all background processes
wait
