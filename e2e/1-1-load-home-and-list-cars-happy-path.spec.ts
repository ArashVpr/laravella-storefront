// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';
import { base, collectConsoleErrors } from './utils';

test.describe('Home Page — Listings and Entry Points', () => {
  test('1.1 Load Home and List Cars (Happy Path)', async ({ page }) => {
    const consoleErrors = collectConsoleErrors(page);

    // 1. Navigate to `/`.
    const response = await page.goto(`${base}/`);
    expect(response, 'should load homepage').toBeTruthy();
    expect(response!.ok(), 'HTTP 200 OK expected').toBeTruthy();

    // 2. Observe hero section and search link presence.
    await expect(page.getByRole('heading', { name: 'Find Your Dream Ride' })).toBeVisible();
    await expect(page.getByRole('link', { name: 'Search' })).toBeVisible();

    // 3. Verify "Latest Arrivals" section renders cars.
    await expect(page.getByRole('heading', { name: 'Latest Arrivals' })).toBeVisible();

    const cards = page.locator('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-4 .group');
    const cardCount = await cards.count();
    expect(cardCount, 'should render at least one car card').toBeGreaterThan(0);
    expect(cardCount, 'should render no more than 30 items').toBeLessThanOrEqual(30);

    const firstCard = cards.first();
    await expect(firstCard.locator('img')).toBeVisible();
    await expect(firstCard.locator('.font-bold')).toBeVisible();
    await expect(firstCard.locator('.text-primary')).toBeVisible();
    await expect(firstCard.locator('.text-gray-400')).toBeVisible();

    await expect(page.locator('nav[aria-label*="Pagination"]')).toHaveCount(0);

    expect(consoleErrors, `Console errors found on home: \n${consoleErrors.join('\n')}`).toHaveLength(0);
  });
});
