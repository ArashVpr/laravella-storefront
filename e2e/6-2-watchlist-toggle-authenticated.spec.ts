// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const isLive = /car-hub\.xyz$/.test(new URL(base).host);
const DEMO_EMAIL = process.env.DEMO_EMAIL || 'akoelpin@example.net';
const DEMO_PASSWORD = process.env.DEMO_PASSWORD || 'password';

(test.skip(isLive, 'Mutative flow disabled on live'), test)('6.2 Add/Remove From Watchlist (Authenticated + Verified)', async ({ page }) => {
  // Login
  await page.goto(`${base}/login`);
  await page.getByPlaceholder('Your Email').fill(DEMO_EMAIL);
  await page.getByPlaceholder('Your Password').fill(DEMO_PASSWORD);
  await page.getByRole('button', { name: 'Login' }).click();

  // Go to home and open first car detail
  await page.goto(`${base}/`);
  const first = page.locator('.car-items-listing .car-item').first();
  await first.locator('a').click();
  await expect(page).toHaveURL(/\/car\/\d+\/?$/);

  // Toggle heart
  const heart = page.locator('button.btn-heart');
  await expect(heart).toBeVisible();
  await heart.click();

  // Navigate to watchlist
  await page.goto(`${base}/watchlist`);
  await expect(page.getByRole('heading', { name: 'My Favourite Cars' })).toBeVisible();

  // Toggle again from details to remove
  await page.goto(`${base}/`);
  await page.locator('.car-items-listing .car-item').first().locator('a').click();
  await heart.click();
});
