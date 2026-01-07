// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Car Browsing & Search', () => {
  test('4.1 Search With Filters (Happy Path)', async ({ page }) => {
    await page.goto(`${base}/car/search`);

    // Select filters in the sidebar
    const makerSelect = page.locator('select').filter({ hasText: 'All Makes' });
    const priceFromInput = page.locator('input[placeholder="Min"]');
    const priceToInput = page.locator('input[placeholder="Max"]');
    const yearFromInput = page.locator('input[placeholder="From"]');
    const yearToInput = page.locator('input[placeholder="To"]');

    // Select first maker if available
    const makerOptions = makerSelect.locator('option[value]:not([value=""])');
    if ((await makerOptions.count()) > 0) {
      const firstMakerValue = await makerOptions.first().getAttribute('value');
      await makerSelect.selectOption({ value: firstMakerValue! });
    }

    // Fill price and year filters
    await priceFromInput.fill('1000');
    await priceToInput.fill('999999');
    await yearFromInput.fill('2000');
    await yearToInput.fill('2025');

    // Results visible and persist across pagination
    const resultsGrid = page.locator('.grid.grid-cols-1.sm\\:grid-cols-2.lg\\:grid-cols-3');
    await expect(resultsGrid).toBeVisible();

    const foundText = page.getByText('Found', { exact: false });
    await expect(foundText.first()).toBeVisible();

    // Try go to page 2 if pagination exists
    const next = page.getByRole('link', { name: /Next|›|»/ });
    if (await next.count()) {
      await next.first().click();
      await expect(resultsGrid).toBeVisible();
    }
  });
});
