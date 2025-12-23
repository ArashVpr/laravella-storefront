// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

const sorts = [
  'price', '-price', 'year', '-year', 'mileage', '-mileage', 'created_at', '-created_at'
];

test.describe('Car Browsing & Search', () => {
  test('4.2 Sorting', async ({ page }) => {
    await page.goto(`${base}/car/search`);
    const dropdown = page.locator('select.sort-dropdown');
    await expect(dropdown).toBeVisible();

    for (const v of sorts) {
      await dropdown.selectOption({ value: v });
      // List remains visible; first card visible
      const cards = page.locator('.search-cars-results .car-items-listing .car-item');
      await expect(cards.first()).toBeVisible();
    }
  });
});
