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

    // 2. Observe hero slider and search form presence.
    await expect(page.locator('section.hero-slider')).toBeVisible();
    await expect(page.locator('form[role="search"][aria-label="Search for cars"]')).toBeVisible();

    // 3. Verify "New Cars" list renders up to 30 recent items.
    await expect(page.getByRole('heading', { name: 'Latest Added Cars' })).toBeVisible();

    const cards = page.locator('.car-items-listing .car-item');
    const cardCount = await cards.count();
    expect(cardCount, 'should render at least one car card').toBeGreaterThan(0);
    expect(cardCount, 'should render no more than 30 items').toBeLessThanOrEqual(30);

    const firstCard = cards.first();
    await expect(firstCard.locator('img.car-item-img')).toBeVisible();
    await expect(firstCard.locator('.car-item-title')).toBeVisible();
    await expect(firstCard.locator('.car-item-price')).toBeVisible();
    await expect(firstCard.locator('small.text-muted')).toBeVisible();

    await expect(page.locator('nav[aria-label*="Pagination"]')).toHaveCount(0);

    expect(consoleErrors, `Console errors found on home: \n${consoleErrors.join('\n')}`).toHaveLength(0);
  });
});
