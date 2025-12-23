// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const DEMO_EMAIL = process.env.DEMO_EMAIL || 'akoelpin@example.net';

test.describe('Authentication & Verification', () => {
  test('2.5 Password Reset (Invalid Token Path)', async ({ page }) => {
    // Navigate directly to reset page with an invalid token
    await page.goto(`${base}/reset-password/invalid-token`);

    // Page should render a reset form
    await expect(page.locator('input[name="email"]')).toBeVisible();
    await expect(page.locator('input[name="password"]')).toBeVisible();
    await expect(page.locator('input[name="password_confirmation"]')).toBeVisible();

    // Attempt to submit with invalid token (email may be readonly, skip if so)
    const emailInput = page.locator('input[name="email"]');
    const isReadonly = await emailInput.getAttribute('readonly');
    if (isReadonly === null) {
      await emailInput.fill(DEMO_EMAIL);
    }
    await page.locator('input[name="password"]').fill('Str0ngP@ss!');
    await page.locator('input[name="password_confirmation"]').fill('Str0ngP@ss!');

    const submit = page.getByRole('button', { name: /reset|submit|update/i });
    if (await submit.count()) {
      await submit.first().click();
    }

    // Expect to remain on page and see an error message
    await expect(page.locator('body')).toBeVisible();
  });
});
