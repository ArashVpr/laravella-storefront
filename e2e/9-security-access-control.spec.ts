// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Security & Access Control', () => {
  test('9.1 Guest/Unverified access control checks', async ({ page }) => {
    // Guest visiting /car/create should redirect to login
    const res1 = await page.goto(`${base}/car/create`);
    expect(res1).toBeTruthy();
    // Laravel usually 302 then lands on /login
    await expect(page).toHaveURL(new RegExp(`${base.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&')}/login`));

    // Guest XHR to watchlist should be rejected (401/302)
    const xhr = await page.request.post(`${base}/watchlist/1`);
    expect([200, 201, 204]).not.toContain(xhr.status());

    // Unverified user is hard to simulate here; covered in watchlist test which tolerates notice redirect
  });
});
