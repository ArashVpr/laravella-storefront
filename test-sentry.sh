#!/bin/bash

echo "🔍 Sentry Error Tracking - Test Suite"
echo "======================================"
echo ""
echo "⚠️  NOTE: Make sure to set SENTRY_LARAVEL_DSN in your .env file"
echo "    Get your DSN from: https://sentry.io/settings/projects/"
echo ""

# Check if Sentry is configured
if grep -q "SENTRY_LARAVEL_DSN=https://" .env 2>/dev/null; then
    echo "✅ Sentry DSN found in .env"
else
    echo "❌ Sentry DSN not configured in .env"
    echo ""
    echo "To configure Sentry:"
    echo "  1. Sign up at https://sentry.io"
    echo "  2. Create a new Laravel project"
    echo "  3. Copy the DSN"
    echo "  4. Add to .env: SENTRY_LARAVEL_DSN=your_dsn_here"
    echo ""
    echo "For testing without a real DSN, you can still see the routes work"
    echo "(errors just won't be sent to Sentry)"
    echo ""
fi

BASE_URL="http://localhost:8000"

echo ""
echo "📋 Available Test Endpoints:"
echo "----------------------------"
echo ""
echo "1. Simple Exception:"
echo "   curl $BASE_URL/sentry-test/exception"
echo ""
echo "2. PHP Error:"
echo "   curl $BASE_URL/sentry-test/error"
echo ""
echo "3. PHP Warning:"
echo "   curl $BASE_URL/sentry-test/warning"
echo ""
echo "4. Breadcrumbs Test:"
echo "   curl $BASE_URL/sentry-test/breadcrumbs"
echo ""
echo "5. Context & User Info:"
echo "   curl $BASE_URL/sentry-test/context"
echo ""
echo "6. Performance Tracing:"
echo "   curl $BASE_URL/sentry-test/performance"
echo ""
echo "7. Capture Message:"
echo "   curl $BASE_URL/sentry-test/capture-message"
echo ""

# Function to test endpoint
test_endpoint() {
    local name=$1
    local endpoint=$2
    
    echo "Testing: $name"
    echo "URL: $BASE_URL$endpoint"
    
    response=$(curl -s -w "\n%{http_code}" "$BASE_URL$endpoint" 2>&1 || echo "ERROR")
    http_code=$(echo "$response" | tail -n1)
    body=$(echo "$response" | sed '$d')
    
    if [[ $http_code == "500" ]] || [[ $body == *"Exception"* ]] || [[ $body == *"Error"* ]]; then
        echo "✅ Error triggered (expected)"
    elif [[ $http_code == "200" ]]; then
        echo "✅ Success: $body"
    else
        echo "⚠️  Response: $body"
    fi
    
    echo ""
}

# Ask if user wants to run tests
read -p "Do you want to run the test suite? (y/n) " -n 1 -r
echo ""

if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo ""
    echo "🧪 Running Tests..."
    echo "=================="
    echo ""
    
    # Make sure server is running
    if ! curl -s "$BASE_URL" > /dev/null 2>&1; then
        echo "❌ Laravel development server not running!"
        echo "   Start it with: php artisan serve"
        exit 1
    fi
    
    test_endpoint "Capture Message" "/sentry-test/capture-message"
    sleep 1
    
    test_endpoint "Breadcrumbs" "/sentry-test/breadcrumbs"
    sleep 1
    
    test_endpoint "Performance Tracing" "/sentry-test/performance"
    sleep 1
    
    echo "⚠️  The following tests will trigger errors (expected):"
    echo ""
    
    test_endpoint "Simple Exception" "/sentry-test/exception"
    sleep 1
    
    test_endpoint "Context & User Info" "/sentry-test/context"
    sleep 1
    
    echo "✅ Test suite complete!"
    echo ""
    echo "📊 Check your Sentry dashboard at: https://sentry.io"
    echo "   - Issues tab: See captured exceptions"
    echo "   - Performance tab: View transaction traces"
    echo "   - Breadcrumbs: See user actions before errors"
else
    echo ""
    echo "💡 Test manually by visiting the URLs above in your browser"
    echo "   or start the dev server: php artisan serve"
fi

echo ""
echo "📖 For more info, see: SENTRY-ERROR-TRACKING.md"
