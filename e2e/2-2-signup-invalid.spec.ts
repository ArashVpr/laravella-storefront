// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Authentication & Verification', () => {
  test('2.2 Signup (Invalid Inputs)', async ({ page }) => {
    await page.goto(`${base}/signup`);

    // Submit empty form
    await page.getByRole('button', { name: 'Register' }).click();
    await page.waitForLoadState('networkidle');

    // Expect any error message visible (use .first() to avoid strict mode violation)
    await expect(page.locator('.error-message').first()).toBeVisible();

    // Weak password and duplicate email
    await page.getByPlaceholder('Name').fill('E2E Invalid');
    await page.getByPlaceholder('Your Email').fill('akoelpin@example.net');
    await page.getByPlaceholder('Phone').fill('123');
    await page.getByPlaceholder('Your Password').fill('weak');
    await page.getByPlaceholder('Repeat Password').fill('weak');
    await page.getByRole('button', { name: 'Register' }).click();
    await page.waitForLoadState('networkidle');

    await expect(page.locator('.error-message').first()).toBeVisible();
  });
});
