// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

function escapeRegex(s: string) {
  return s.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&');
}

test.describe('Car Details Page', () => {
  test('5.5 Reveal Phone Number', async ({ page }) => {
    // Go to a car details page
    await page.goto(`${base}/`);
    const first = page.locator('.car-items-listing .car-item').first();
    await first.locator('a').click();
    await expect(page).toHaveURL(/\/car\/\d+\/?$/);

    const phoneLink = page.locator('a.car-details-phone');
    await expect(phoneLink).toBeVisible();

    const masked = await phoneLink.textContent();

    // Click the view full number trigger
    const trigger = page.locator('.car-details-phone-view');
    if (await trigger.count()) {
      await trigger.first().click();
      // The phone value should change or contain digits beyond mask
      await expect(phoneLink).toContainText(/\d/);
      if (masked) {
        await expect(phoneLink).not.toHaveText(new RegExp(escapeRegex(masked.trim())));
      }
    }
  });
});
