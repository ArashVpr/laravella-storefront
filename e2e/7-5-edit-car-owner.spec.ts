// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const isLive = /car-hub\.xyz$/.test(new URL(base).host);
const DEMO_EMAIL = process.env.DEMO_EMAIL || 'akoelpin@example.net';
const DEMO_PASSWORD = process.env.DEMO_PASSWORD || 'password';

(test.skip(isLive, 'Mutative flow disabled on live'), test)('7.5 Edit Car — Owner', async ({ page }) => {
  // Login
  await page.goto(`${base}/login`);
  await page.getByPlaceholder('Your Email').fill(DEMO_EMAIL);
  await page.getByPlaceholder('Your Password').fill(DEMO_PASSWORD);
  await page.getByRole('button', { name: 'Login' }).click();

  // Visit My Cars and open first edit page
  await page.goto(`${base}/car`);
  const editLink = page.getByRole('link', { name: /edit/i }).first();
  await editLink.click();

  await expect(page).toHaveURL(/\/car\/\d+\/edit/);

  const form = page.locator('form.add-new-car-form');
  await expect(form).toBeVisible();
  await form.locator('input[name="price"]').fill('12345');
  await form.getByRole('button', { name: 'Submit' }).click();

  // Expect redirect back to My Cars
  await expect(page).toHaveURL(new RegExp(`${base.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&')}/car`));
});
