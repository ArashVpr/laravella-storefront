#!/bin/bash
# Quick verification that Lighthouse CI is properly configured

echo "🔍 Lighthouse CI Configuration Verification"
echo "==========================================="
echo ""

# Check files exist
echo "📁 Checking files..."
files=(
  "lighthouserc.json"
  "scripts/lighthouse-ci.sh"
  ".github/workflows/lighthouse-ci.yml"
  "docs/LIGHTHOUSE-CI.md"
  "LIGHTHOUSE-CI-SUMMARY.md"
)

for file in "${files[@]}"; do
  if [ -f "$file" ]; then
    echo "  ✅ $file"
  else
    echo "  ❌ $file (missing)"
    exit 1
  fi
done

echo ""
echo "📦 Checking dependencies..."

# Check @lhci/cli is installed
if npm list @lhci/cli --depth=0 &>/dev/null; then
  version=$(npm list @lhci/cli --depth=0 | grep @lhci/cli | sed 's/.*@//')
  echo "  ✅ @lhci/cli@$version"
else
  echo "  ❌ @lhci/cli not installed"
  echo "  Run: npm install --save-dev @lhci/cli"
  exit 1
fi

echo ""
echo "🌐 Checking Chrome/Chromium..."

# Check Chrome path from config
CHROME_PATH=$(jq -r '.ci.collect.chromePath' lighthouserc.json)
if [ -f "$CHROME_PATH" ]; then
  version=$("$CHROME_PATH" --version 2>/dev/null || echo "unknown")
  echo "  ✅ $version"
  echo "  📍 $CHROME_PATH"
else
  echo "  ❌ Chrome not found at: $CHROME_PATH"
  echo "  Run: npx playwright install chromium"
  exit 1
fi

echo ""
echo "🧪 Checking server..."

if curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8000 | grep -q "200"; then
  echo "  ✅ Laravel server running on http://127.0.0.1:8000"
else
  echo "  ⚠️  Server not responding"
  echo "  Start with: php artisan serve"
  echo "  (Tests will fail without server)"
fi

echo ""
echo "✅ Configuration verified!"
echo ""
echo "💡 Run tests with:"
echo "   bash scripts/lighthouse-ci.sh"
echo ""
