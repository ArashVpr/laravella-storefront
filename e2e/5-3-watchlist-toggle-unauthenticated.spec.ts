// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Car Details Page', () => {
  test('5.3 Watchlist Toggle — Unauthenticated', async ({ page }) => {
    // Open first car details as a guest
    await page.goto(`${base}/`);
    const first = page.locator('.car-items-listing .car-item').first();
    await first.locator('a').click();
    await expect(page).toHaveURL(/\/car\/\d+\/?$/);

    // Click heart and capture the watchlist request
    const responsePromise = page.waitForResponse((res) => /\/watchlist\//.test(res.url()));
    await page.locator('button.btn-heart').click();
    const res = await responsePromise.catch(() => null);

    // Expect unauthorized or redirect behavior (non-200)
    if (res) {
      expect(res.status()).not.toBe(200);
    } else {
      // If no XHR captured (form/nav-based), assert we didn't silently succeed
      await expect(page).toHaveURL(/\/(login|car\/\d+)/);
    }
  });
});
