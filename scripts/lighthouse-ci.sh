#!/bin/bash
# Lighthouse CI Test Script
# Runs Lighthouse audits on key pages with performance budgets

set -e

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}🚀 Starting Lighthouse CI Performance Audit${NC}\n"

# Configuration
CHROME_PATH="${CHROME_PATH:-/root/.cache/ms-playwright/chromium-1194/chrome-linux/chrome}"
CHROME_FLAGS="--no-sandbox --disable-gpu --disable-dev-shm-usage --headless=new"
SERVER_URL="${SERVER_URL:-http://127.0.0.1:8000}"

# Pages to audit
PAGES=(
  "$SERVER_URL"
  "$SERVER_URL/car/search"
  "$SERVER_URL/login"
  "$SERVER_URL/register"
)

# Performance budgets
MIN_PERFORMANCE=70
MIN_ACCESSIBILITY=90
MIN_BEST_PRACTICES=90
MIN_SEO=90

echo "Configuration:"
echo "  Chrome Path: $CHROME_PATH"
echo "  Server URL: $SERVER_URL"
echo "  Min Performance: ${MIN_PERFORMANCE}%"
echo "  Min Accessibility: ${MIN_ACCESSIBILITY}%"
echo "  Min Best Practices: ${MIN_BEST_PRACTICES}%"
echo "  Min SEO: ${MIN_SEO}%"
echo ""

# Check if Chrome exists
if [ ! -f "$CHROME_PATH" ]; then
    echo -e "${RED}❌ Chrome not found at: $CHROME_PATH${NC}"
    echo "Install with: npx playwright install chromium"
    exit 1
fi

# Check if server is running
if ! curl -s -o /dev/null -w "%{http_code}" "$SERVER_URL" | grep -q "200"; then
    echo -e "${YELLOW}⚠️  Server not responding at $SERVER_URL${NC}"
    echo "Start server with: php artisan serve"
    exit 1
fi

echo -e "${GREEN}✅ Prerequisites checked${NC}\n"

# Create reports directory
mkdir -p lighthouse-reports
TIMESTAMP=$(date +%Y%m%d-%H%M%S)

# Track overall pass/fail
FAILED=0

# Run Lighthouse on each page
for PAGE in "${PAGES[@]}"; do
    PAGE_NAME=$(echo "$PAGE" | sed 's|http://||' | sed 's|/|-|g' | sed 's|:|-|g')
    OUTPUT_FILE="lighthouse-reports/report-${PAGE_NAME}-${TIMESTAMP}.json"
    
    echo -e "${GREEN}📊 Auditing: $PAGE${NC}"
    
    # Run Lighthouse
    CHROME_PATH="$CHROME_PATH" npx lighthouse "$PAGE" \
        --chrome-flags="$CHROME_FLAGS" \
        --only-categories=performance,accessibility,best-practices,seo \
        --output=json \
        --output-path="$OUTPUT_FILE" \
        --quiet
    
    # Extract scores
    PERF=$(jq -r '.categories.performance.score * 100' "$OUTPUT_FILE")
    ACCESS=$(jq -r '.categories.accessibility.score * 100' "$OUTPUT_FILE")
    BEST=$(jq -r '.categories["best-practices"].score * 100' "$OUTPUT_FILE")
    SEO=$(jq -r '.categories.seo.score * 100' "$OUTPUT_FILE")
    
    # Print results
    echo "  Performance: ${PERF}%"
    echo "  Accessibility: ${ACCESS}%"
    echo "  Best Practices: ${BEST}%"
    echo "  SEO: ${SEO}%"
    
    # Check budgets
    if (( $(echo "$PERF < $MIN_PERFORMANCE" | bc -l) )); then
        echo -e "  ${RED}❌ Performance score below threshold${NC}"
        FAILED=1
    fi
    
    if (( $(echo "$ACCESS < $MIN_ACCESSIBILITY" | bc -l) )); then
        echo -e "  ${RED}❌ Accessibility score below threshold${NC}"
        FAILED=1
    fi
    
    if (( $(echo "$BEST < $MIN_BEST_PRACTICES" | bc -l) )); then
        echo -e "  ${RED}❌ Best Practices score below threshold${NC}"
        FAILED=1
    fi
    
    if (( $(echo "$SEO < $MIN_SEO" | bc -l) )); then
        echo -e "  ${RED}❌ SEO score below threshold${NC}"
        FAILED=1
    fi
    
    echo ""
done

echo -e "${GREEN}📁 Reports saved to: lighthouse-reports/${NC}\n"

if [ $FAILED -eq 0 ]; then
    echo -e "${GREEN}✅ All audits passed!${NC}"
    exit 0
else
    echo -e "${RED}❌ Some audits failed to meet budgets${NC}"
    exit 1
fi
