// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';

test.describe('Automation Notes (CSRF & OAuth)', () => {
  test('14.1 CSRF enforced for POST without cookie', async ({ request }) => {
    // Attempt to POST to a protected endpoint without session/CSRF cookie
    const res = await request.post(`${base}/logout`);
    expect([401, 419, 302]).toContain(res.status());
  });

  test('14.2 OAuth redirect endpoints accessible', async ({ page }) => {
    await page.goto(`${base}/login`);

    const google = page.getByRole('link', { name: /google/i }).or(page.getByRole('button', { name: /google/i }));
    if (await google.count()) {
      const [nav] = await Promise.all([
        page.waitForNavigation({ url: /google|accounts\.google\.com/ }),
        google.first().click(),
      ]);
      expect(nav?.url()).toMatch(/google|accounts\.google\.com/);
    }
  });
});
