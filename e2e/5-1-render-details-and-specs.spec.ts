// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Car Details Page', () => {
  test('5.1 Render Details and Specs', async ({ page }) => {
    // Open first car detail from home
    await page.goto(`${base}/`);
    const firstCard = page.locator('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-4 .group').first();
    await expect(firstCard).toBeVisible();
    await firstCard.locator('a').click();

    await expect(page).toHaveURL(/\/car\/\d+\/?$/);

    // Main image, title, price
    await expect(page.locator('img[alt*="car"]').first()).toBeVisible();
    await expect(page.locator('h1').filter({ hasText: /\d{4}/ })).toBeVisible(); // Car title with year
    await expect(page.locator('.text-3xl.font-bold.text-primary')).toBeVisible();

    // Features section present
    await expect(page.getByRole('heading', { name: 'Features & Options' })).toBeVisible();
    await expect(page.locator('ul.grid')).toBeVisible();

    // Structured data script exists
    await expect(page.locator('script[type="application/ld+json"]')).toHaveCount(1);
  });
});
