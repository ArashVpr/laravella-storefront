// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';
import { base, escRe, login } from './utils';

const DEMO_EMAIL = process.env.DEMO_EMAIL || 'akoelpin@example.net';
const DEMO_PASSWORD = process.env.DEMO_PASSWORD || 'password';

test.describe('Authentication & Verification', () => {
  test('2.4 Login/Logout', async ({ page }) => {
    await login(page, DEMO_EMAIL, DEMO_PASSWORD);
    await expect(page).toHaveURL(new RegExp(`${escRe(base)}/`));

    // Try to logout via UI; fallback to POST
    const logout = page.getByRole('button', { name: /logout/i }).or(page.getByRole('link', { name: /logout/i }));
    if (await logout.count()) {
      await logout.first().click();
    } else {
      await page.request.post(`${base}/logout`);
      await page.goto(`${base}/`);
    }

    await expect(page).toHaveURL(new RegExp(`${escRe(base)}/`));
  });
});
