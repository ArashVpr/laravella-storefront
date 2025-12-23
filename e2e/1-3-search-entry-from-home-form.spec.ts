// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';
import { base, collectConsoleErrors, escRe, selectFirstNonEmpty } from './utils';

function ci(text: string) {
  return new RegExp(text.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'i');
}

test.describe('Home Page — Listings and Entry Points', () => {
  test('1.3 Search Entry From Home Form', async ({ page }) => {
    const consoleErrors = collectConsoleErrors(page);

    const res = await page.goto(`${base}/`);
    expect(res, 'should load homepage').toBeTruthy();
    expect(res!.ok(), 'HTTP 200 OK expected').toBeTruthy();

    const form = page.locator('form[role="search"][aria-label="Search for cars"]');
    await expect(form).toBeVisible();

    const makerSelect = form.locator('select#makerSelect');
    await expect(makerSelect).toBeVisible();

    const makerValue = await selectFirstNonEmpty(makerSelect);
    expect(makerValue, 'Maker options should be available').toBeTruthy();
    const firstOption = makerSelect.locator('option[value]:not([value=""])').first();
    const makerLabel = (await firstOption.textContent())?.trim() || '';

    await form.getByRole('button', { name: /Search/ }).click();

    await expect(page).toHaveURL(new RegExp(`${escRe(base)}/car/search`));
    await expect(page).toHaveURL(new RegExp(`[?&]maker_id=${makerValue}(?:&|$)`));

    await expect(page.getByText('Found', { exact: false })).toBeVisible();

    const cards = page.locator('.search-cars-results .car-items-listing .car-item');
    const count = await cards.count();

    if (count > 0 && makerLabel) {
      const firstTitle = cards.first().locator('.car-item-title');
      await expect(firstTitle).toBeVisible();
      await expect(firstTitle).toHaveText(ci(makerLabel));
    } else {
      await expect(page.getByText('No results found', { exact: false })).toBeVisible();
    }

    // Filter out external 503 errors from third-party resources
    const relevantErrors = consoleErrors.filter(err => !err.includes('503'));
    expect(relevantErrors, `Console errors found: \n${relevantErrors.join('\n')}`).toHaveLength(0);
  });
});
