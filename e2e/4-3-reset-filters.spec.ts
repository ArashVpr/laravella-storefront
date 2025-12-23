// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Car Browsing & Search', () => {
  test.fixme('4.3 Reset Filters', async ({ page }) => {
    // FIXME: Reset button appears to reload the page but doesn't clear previously filled values
    // The form retains year_from=2010 etc. after clicking Reset
    await page.goto(`${base}/car/search`);

    const form = page.locator('form.find-a-car-form');
    await expect(form).toBeVisible();

    await form.locator('input[name="year_from"]').fill('2010');
    await form.locator('input[name="year_to"]').fill('2011');
    await form.locator('input[name="price_from"]').fill('1');
    await form.locator('input[name="price_to"]').fill('2');

    await form.getByRole('button', { name: /Reset/ }).click();

    // Wait for navigation or form update after reset
    await page.waitForLoadState('networkidle');

    await expect(form.locator('input[name="year_from"]')).toHaveValue('');
    await expect(form.locator('input[name="year_to"]')).toHaveValue('');
    await expect(form.locator('input[name="price_from"]')).toHaveValue('');
    await expect(form.locator('input[name="price_to"]')).toHaveValue('');
  });
});
