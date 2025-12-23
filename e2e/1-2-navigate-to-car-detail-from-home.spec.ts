// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';
import { base, collectConsoleErrors, firstCarCard, escRe } from './utils';

test.describe('Home Page — Listings and Entry Points', () => {
  test('1.2 Navigate to Car Detail From Home', async ({ page }) => {
    const consoleErrors = collectConsoleErrors(page);

    const home = await page.goto(`${base}/`);
    expect(home, 'should load homepage').toBeTruthy();
    expect(home!.ok(), 'HTTP 200 OK expected').toBeTruthy();

    const first = firstCarCard(page);
    await expect(first).toBeVisible();

    await first.locator('a').click();

    await expect(page).toHaveURL(new RegExp(`${escRe(base)}/car/\\d+/?$`));

    await expect(page.locator('h1.car-details-page-title')).toBeVisible();
    await expect(page.locator('.car-details-price')).toBeVisible();
    await expect(page.locator('img.car-active-image#activeImage')).toBeVisible();
    await expect(page.locator('table.car-details-table')).toBeVisible();

    await expect(page.locator('script[type="application/ld+json"]')).toHaveCount(1);

    // Filter out external 503 errors from third-party resources
    const relevantErrors = consoleErrors.filter(err => !err.includes('503'));
    expect(relevantErrors, `Console errors found on detail page: \n${relevantErrors.join('\n')}`).toHaveLength(0);
  });
});
