// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const DEMO_EMAIL = process.env.DEMO_EMAIL || 'akoelpin@example.net';
const DEMO_PASSWORD = process.env.DEMO_PASSWORD || 'password';

test.describe('Seller Dashboard — My Cars', () => {
  test('7.1 List My Cars', async ({ page }) => {
    await page.goto(`${base}/login`);
    await page.getByPlaceholder('Your Email').fill(DEMO_EMAIL);
    await page.getByPlaceholder('Your Password').fill(DEMO_PASSWORD);
    await page.getByRole('button', { name: 'Login' }).click();

    await page.goto(`${base}/car`);
    await expect(page).toHaveURL(`${base}/car`);

    await expect(page.getByRole('heading', { name: 'My Cars' })).toBeVisible();
    await expect(page.locator('table.table')).toBeVisible();
  });
});
