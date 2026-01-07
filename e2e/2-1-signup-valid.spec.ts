// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const isLive = /car-hub\.xyz$/.test(new URL(base).host);

(test.skip(isLive, 'Mutative flow disabled on live'), test)('2.1 Signup (Valid)', async ({ page }) => {
  await page.goto(`${base}/signup`);

  const unique = Math.random().toString(36).slice(2, 8);
  const email = `e2e_${unique}@example.com`;
  const phone = `555${Date.now()}`.slice(0, 11);

  await page.getByPlaceholder('John Doe').fill(`E2E User ${unique}`);
  await page.getByPlaceholder('you@example.com').fill(email);
  await page.getByPlaceholder('+1 (555) 000-0000').fill(phone);
  await page.getByPlaceholder('••••••••').fill('Str0ngP@ss!');
  await page.getByPlaceholder('••••••••').fill('Str0ngP@ss!');
  await page.getByRole('button', { name: 'Register' }).click();

  await expect(page).toHaveURL(new RegExp(`${base.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&')}/`));
});
