// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Car Details Page', () => {
  test('5.1 Render Details and Specs', async ({ page }) => {
    // Open first car detail from home
    await page.goto(`${base}/`);
    const firstCard = page.locator('.car-items-listing .car-item').first();
    await expect(firstCard).toBeVisible();
    await firstCard.locator('a').click();

    await expect(page).toHaveURL(/\/car\/\d+\/?$/);

    // Main image, title, price
    await expect(page.locator('#activeImage.car-active-image')).toBeVisible();
    await expect(page.locator('h1.car-details-page-title')).toBeVisible();
    await expect(page.locator('.car-details-price')).toBeVisible();

    // Specs table present with expected rows
    const specs = page.locator('table.car-details-table');
    await expect(specs).toBeVisible();
    await expect(specs.getByText('Maker')).toBeVisible();
    await expect(specs.getByText('Model')).toBeVisible();
    await expect(specs.getByText('Year')).toBeVisible();

    // Structured data script exists
    await expect(page.locator('script[type="application/ld+json"]')).toHaveCount(1);
  });
});
