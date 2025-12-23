// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

function escRe(s: string) { return s.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&'); }

test.describe('Non-Functional Checks', () => {
  test('11.1 Performance and SEO smoke', async ({ page }) => {
    const start = Date.now();
    const response = await page.goto(`${base}/`);
    expect(response).toBeTruthy();
    // DOM content readiness within a reasonable bound
    await page.waitForLoadState('domcontentloaded', { timeout: 8000 });
    const elapsed = Date.now() - start;
    expect(elapsed).toBeLessThan(8000);

    // Title set via <x-app title="Home Page">
    const title = await page.title();
    expect(title).toMatch(/home/i);

    // Basic caching heuristic: reloading quickly yields identical listing HTML (soft check)
    const listing = page.locator('.car-items-listing');
    await expect(listing).toBeVisible();
    const html1 = await listing.innerHTML();
    await page.reload();
    await expect(listing).toBeVisible();
    const html2 = await listing.innerHTML();
    expect.soft(html2).toBe(html1);

    // Structured data on a car detail (SEO) — open first car
    const first = page.locator('.car-items-listing .car-item').first();
    await first.locator('a').click();
    await expect(page).toHaveURL(new RegExp(`${escRe(base)}/car/\\d+/?$`));
    await expect(page.locator('script[type="application/ld+json"]')).toHaveCount(1);
  });
});
