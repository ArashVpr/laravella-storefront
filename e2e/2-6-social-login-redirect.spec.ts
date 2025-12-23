// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Authentication & Verification', () => {
  test('2.6 Social Login (Redirect Smoke)', async ({ page }) => {
    await page.goto(`${base}/login`);

    // Click Google if present
    const google = page.getByRole('link', { name: /google/i }).or(page.getByRole('button', { name: /google/i }));
    if (await google.count()) {
      const [nav] = await Promise.all([
        page.waitForNavigation({ url: /google|accounts\.google\.com/ }),
        google.first().click()
      ]);
      expect(nav?.url()).toMatch(/google|accounts\.google\.com/);
      await page.goBack();
    }

    // Click Facebook if present
    const fb = page.getByRole('link', { name: /facebook/i }).or(page.getByRole('button', { name: /facebook/i }));
    if (await fb.count()) {
      const [nav2] = await Promise.all([
        page.waitForNavigation({ url: /facebook\.com/ }),
        fb.first().click()
      ]);
      expect(nav2?.url()).toMatch(/facebook\.com/);
    }
  });
});
