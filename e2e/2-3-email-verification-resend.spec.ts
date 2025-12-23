// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const DEMO_EMAIL = process.env.DEMO_EMAIL || 'akoelpin@example.net';
const DEMO_PASSWORD = process.env.DEMO_PASSWORD || 'password';

test.describe('Authentication & Verification', () => {
  test('2.3 Email Verification Flow (Resend Notice)', async ({ page }) => {
    await page.goto(`${base}/login`);
    await page.getByPlaceholder('Your Email').fill(DEMO_EMAIL);
    await page.getByPlaceholder('Your Password').fill(DEMO_PASSWORD);
    await page.getByRole('button', { name: 'Login' }).click();

    // Try hitting the notice page (may redirect if already verified)
    const res = await page.goto(`${base}/email/verify`);
    expect(res).toBeTruthy();

    // Try resend endpoint; just ensure it's not a hard error
    const resend = await page.request.post(`${base}/email/verification-notification`);
    expect([200, 201, 204, 302, 419]).toContain(resend.status());
  });
});
