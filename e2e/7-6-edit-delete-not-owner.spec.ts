// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect, request } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const isLive = /car-hub\.xyz$/.test(new URL(base).host);

(test.skip(isLive, 'Mutative flow disabled on live'), test)('7.6 Edit/Delete — Not Owner (Negative)', async ({ page }) => {
  // This test assumes an existing car id not owned by the logged-in user in staging/local.
  // We'll probe a high id and expect 403 on edit or delete endpoints if they exist.
  const editRes = await page.request.get(`${base}/car/1/edit`);
  expect([401, 403, 302]).toContain(editRes.status());

  const delRes = await page.request.delete(`${base}/car/1`);
  expect([401, 403]).toContain(delRes.status());
});
