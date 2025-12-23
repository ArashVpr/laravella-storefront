// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Car Browsing & Search', () => {
  test('4.4 No Results State', async ({ page }) => {
    await page.goto(`${base}/car/search`);

    const form = page.locator('form.find-a-car-form');
    await expect(form).toBeVisible();

    await form.locator('input[name="year_from"]').fill('2090');
    await form.locator('input[name="year_to"]').fill('1990');

    await form.getByRole('button', { name: /Search/ }).click();

    await expect(page.getByText('No results found')).toBeVisible();
  });
});
