// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Car Details Page', () => {
  test('5.2 Carousel Navigation', async ({ page }) => {
    // Navigate to first car detail
    await page.goto(`${base}/`);
    const firstCard = page.locator('.car-items-listing .car-item').first();
    await firstCard.locator('a').click();

    await expect(page).toHaveURL(/\/car\/\d+\/?$/);

    const active = page.locator('#activeImage');
    await expect(active).toBeVisible();

    // Click next and prev arrows
    const next = page.locator('button#nextButton');
    const prev = page.locator('button#prevButton');

    if (await next.isVisible()) {
      await next.click();
      await expect(active).toBeVisible();
    }
    if (await prev.isVisible()) {
      await prev.click();
      await expect(active).toBeVisible();
    }

    // Click thumbnail if exists
    const thumb = page.locator('.car-image-thumbnails img').first();
    if (await thumb.count()) {
      await thumb.click();
      await expect(active).toBeVisible();
    }
  });
});
