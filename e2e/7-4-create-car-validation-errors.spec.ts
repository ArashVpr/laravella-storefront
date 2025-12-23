// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const isLive = /car-hub\.xyz$/.test(new URL(base).host);
const DEMO_EMAIL = process.env.DEMO_EMAIL || 'akoelpin@example.net';
const DEMO_PASSWORD = process.env.DEMO_PASSWORD || 'password';

(test.skip(isLive, 'Mutative flow disabled on live'), test)('7.4 Create Car — Validation Errors', async ({ page }) => {
  // Login
  await page.goto(`${base}/login`);
  await page.getByPlaceholder('Your Email').fill(DEMO_EMAIL);
  await page.getByPlaceholder('Your Password').fill(DEMO_PASSWORD);
  await page.getByRole('button', { name: 'Login' }).click();

  await page.goto(`${base}/car/create`);
  const form = page.locator('form.add-new-car-form');
  await expect(form).toBeVisible();

  // Submit with empty/invalid data
  await form.getByRole('button', { name: 'Submit' }).click();

  // Expect error messages
  await expect(page.locator('.error-message')).toBeVisible();
});
