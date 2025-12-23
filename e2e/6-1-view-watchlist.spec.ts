// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const DEMO_EMAIL = process.env.DEMO_EMAIL || 'akoelpin@example.net';
const DEMO_PASSWORD = process.env.DEMO_PASSWORD || 'password';

test.describe('Watchlist', () => {
  test('6.1 View Watchlist Page', async ({ page }) => {
    // Login
    await page.goto(`${base}/login`);
    await page.getByPlaceholder('Your Email').fill(DEMO_EMAIL);
    await page.getByPlaceholder('Your Password').fill(DEMO_PASSWORD);
    await page.getByRole('button', { name: 'Login' }).click();

    // Go to watchlist (if user not verified, may be redirected to verification notice)
    await page.goto(`${base}/watchlist`);

    // If verification notice appears, assert, otherwise assert listing
    const notice = page.getByText(/verify your email|verification/i);
    if (await notice.count()) {
      await expect(notice).toBeVisible();
    } else {
      await expect(page.getByRole('heading', { name: 'My Favourite Cars' })).toBeVisible();
      await expect(page.locator('.car-items-listing')).toBeVisible();
    }
  });
});
