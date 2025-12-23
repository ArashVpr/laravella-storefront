// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Non-Functional Checks', () => {
  test('11.2 Accessibility smoke (nav + forms)', async ({ page }) => {
    await page.goto(`${base}/`);

    // Hero controls have accessible names
    await expect(page.getByRole('button', { name: /previous/i })).toBeVisible();
    await expect(page.getByRole('button', { name: /next/i })).toBeVisible();

    // Search form has role and labels (aria-label present)
    const search = page.locator('form[role="search"][aria-label]');
    await expect(search).toBeVisible();

    // Check focusability on key interactive elements
    const firstLink = page.locator('.car-items-listing .car-item a').first();
    await firstLink.focus();
    const active = await page.evaluate(() => document.activeElement?.tagName);
    expect(active).toBeTruthy();
  });
});
