// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Car Browsing & Search', () => {
  test('4.1 Search With Filters (Happy Path)', async ({ page }) => {
    await page.goto(`${base}/car/search`);

    const form = page.locator('form.find-a-car-form');
    await expect(form).toBeVisible();

    const maker = form.locator('select#makerSelect');
    const model = form.locator('select#modelSelect');
    const type = form.locator('select[name="car_type_id"]');
    const fuel = form.locator('select[name="fuel_type_id"]');

    // Select first non-empty options where available
    async function selectFirstNonEmpty(sel: typeof maker) {
      const options = sel.locator('option[value]:not([value=""])');
      if ((await options.count()) > 0) {
        const val = await options.first().getAttribute('value');
        await sel.selectOption({ value: val! });
      }
    }

    await selectFirstNonEmpty(maker);
    await selectFirstNonEmpty(model);
    await selectFirstNonEmpty(type);
    await selectFirstNonEmpty(fuel);

    await form.locator('input[name="year_from"]').fill('2000');
    await form.locator('input[name="year_to"]').fill('2025');
    await form.locator('input[name="price_from"]').fill('1000');
    await form.locator('input[name="price_to"]').fill('999999');

    await form.getByRole('button', { name: /Search/ }).click();

    // Results visible and persist across pagination
    const list = page.locator('.search-cars-results .car-items-listing');
    await expect(list).toBeVisible();

    const foundText = page.getByText('Found', { exact: false });
    await expect(foundText.first()).toBeVisible();

    // Try go to page 2 if pagination exists
    const next = page.getByRole('link', { name: /Next|›|»/ });
    if (await next.count()) {
      await next.first().click();
      await expect(list).toBeVisible();
    }
  });
});
