// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const isLive = /car-hub\.xyz$/.test(new URL(base).host);
const DEMO_EMAIL = process.env.DEMO_EMAIL || 'akoelpin@example.net';
const DEMO_PASSWORD = process.env.DEMO_PASSWORD || 'password';

(test.skip(isLive, 'Mutative flow disabled on live'), test)('5.4 Watchlist Toggle — Authenticated + Verified', async ({ page }) => {
  // Login
  await page.goto(`${base}/login`);
  await page.getByPlaceholder('Your Email').fill(DEMO_EMAIL);
  await page.getByPlaceholder('Your Password').fill(DEMO_PASSWORD);
  await page.getByRole('button', { name: 'Login' }).click();

  // Open a car details page
  await page.goto(`${base}/`);
  await page.locator('.car-items-listing .car-item').first().locator('a').click();
  await expect(page).toHaveURL(/\/car\/\d+\/?$/);

  const heart = page.locator('button.btn-heart');
  await expect(heart).toBeVisible();

  // Add to watchlist
  const addResPromise = page.waitForResponse((r) => /\/watchlist\//.test(r.url()));
  await heart.click();
  const addRes = await addResPromise;
  expect(addRes.status()).toBe(200);

  // Remove from watchlist
  const remResPromise = page.waitForResponse((r) => /\/watchlist\//.test(r.url()));
  await heart.click();
  const remRes = await remResPromise;
  expect(remRes.status()).toBe(200);
});
