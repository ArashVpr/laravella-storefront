// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Error Handling & Edge Cases', () => {
  test('10.1 Invalid car id returns 404', async ({ page }) => {
    const res = await page.goto(`${base}/car/999999999`);
    expect(res).toBeTruthy();
    expect(res!.status()).toBe(404);
  });
});
