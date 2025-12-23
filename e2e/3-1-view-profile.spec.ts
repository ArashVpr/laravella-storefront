// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const DEMO_EMAIL = process.env.DEMO_EMAIL || 'akoelpin@example.net';
const DEMO_PASSWORD = process.env.DEMO_PASSWORD || 'password';

test.describe('Profile Management', () => {
  test('3.1 View Profile', async ({ page }) => {
    await page.goto(`${base}/login`);
    await page.getByPlaceholder('Your Email').fill(DEMO_EMAIL);
    await page.getByPlaceholder('Your Password').fill(DEMO_PASSWORD);
    await page.getByRole('button', { name: 'Login' }).click();

    await page.goto(`${base}/profile`);
    await expect(page).toHaveURL(`${base}/profile`);

    // Check presence of basic fields
    await expect(page.locator('input[name="name"]')).toBeVisible();
    const emailField = page.locator('input[name="email"]');
    if (await emailField.count()) {
      await expect(emailField).toBeVisible();
    }
    await expect(page.locator('input[name="phone"]')).toBeVisible();
  });
});
