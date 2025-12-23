// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const isLive = /car-hub\.xyz$/.test(new URL(base).host);

(test.skip(isLive, 'Mutative flow disabled on live'), test)('7.3 Create Car — Missing Phone On Profile (Gate)', async ({ page }) => {
  // This scenario requires a user without phone; prepare that user in staging/local
  // Navigate to create and expect redirect to profile with warning
  const res = await page.goto(`${base}/car/create`);
  expect(res).toBeTruthy();
  // Should redirect to profile
  await expect(page).toHaveURL(new RegExp(`${base.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&')}/profile`));
});
