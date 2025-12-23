// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Static & Utility Pages', () => {
  test('8.1 Legal Pages', async ({ page }) => {
    // Privacy
    await page.goto(`${base}/privacy`);
    await expect(page).toHaveURL(`${base}/privacy`);
    await expect(page.locator('body')).toBeVisible();
    // Cookies
    await page.goto(`${base}/cookies`);
    await expect(page).toHaveURL(`${base}/cookies`);
    await expect(page.locator('body')).toBeVisible();
    // Mentions légales
    await page.goto(`${base}/mentions-legales`);
    await expect(page).toHaveURL(`${base}/mentions-legales`);
    await expect(page.locator('body')).toBeVisible();
  });
});
