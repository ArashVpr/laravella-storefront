// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const DEMO_EMAIL = process.env.DEMO_EMAIL || 'akoelpin@example.net';
const DEMO_PASSWORD = process.env.DEMO_PASSWORD || 'password';

// A compact smoke that walks core browse -> view flow, and login

test.describe('Acceptance Criteria Smoke', () => {
  test('15.1 Guest browse and view', async ({ page }) => {
    await page.goto(`${base}/`);
    await expect(page.locator('section.hero-slider')).toBeVisible();
    const first = page.locator('.car-items-listing .car-item').first();
    await first.locator('a').click();
    await expect(page).toHaveURL(/\/car\/\d+\/?$/);
    await expect(page.locator('#activeImage')).toBeVisible();
  });

  test('15.2 Login and reach dashboard area', async ({ page }) => {
    await page.goto(`${base}/login`);
    await page.getByPlaceholder('Your Email').fill(DEMO_EMAIL);
    await page.getByPlaceholder('Your Password').fill(DEMO_PASSWORD);
    await page.getByRole('button', { name: 'Login' }).click();

    // Check access to an authenticated page
    await page.goto(`${base}/car`);
    await expect(page.getByRole('heading', { name: 'My Cars' })).toBeVisible();
  });
});
