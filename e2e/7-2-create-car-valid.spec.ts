// spec: docs/test-plan.md
// seed: seed.spec.ts

import { test, expect } from '@playwright/test';

const base = process.env.BASE_URL || 'https://car-hub.xyz';
const isLive = /car-hub\.xyz$/.test(new URL(base).host);
const DEMO_EMAIL = process.env.DEMO_EMAIL || 'akoelpin@example.net';
const DEMO_PASSWORD = process.env.DEMO_PASSWORD || 'password';

(test.skip(isLive, 'Mutative flow disabled on live'), test)('7.2 Create Car — Valid (Staging/Local Only)', async ({ page }) => {
  // Login
  await page.goto(`${base}/login`);
  await page.getByPlaceholder('Your Email').fill(DEMO_EMAIL);
  await page.getByPlaceholder('Your Password').fill(DEMO_PASSWORD);
  await page.getByRole('button', { name: 'Login' }).click();

  // Navigate to create
  await page.goto(`${base}/car/create`);
  await expect(page).toHaveURL(`${base}/car/create`);

  // Fill minimal required fields using first available options
  const form = page.locator('form.add-new-car-form');
  await expect(form).toBeVisible();

  async function selectFirst(sel: string) {
    const el = form.locator(sel);
    const options = el.locator('option[value]:not([value=""])');
    await el.selectOption({ value: await options.first().getAttribute('value')! });
  }

  await selectFirst('select#makerSelect');
  await selectFirst('select#modelSelect');
  await form.locator('input[name="year"]').fill('2018');
  await selectFirst('select[name="car_type_id"]');
  await form.locator('input[name="price"]').fill('12000');
  await form.locator('input[name="vin"]').fill('1HGCM82633A004352');
  await form.locator('input[name="mileage"]').fill('45000');
  await selectFirst('select[name="fuel_type_id"]');
  await selectFirst('select#citySelect');
  await form.locator('input[name="address"]').fill('123 Main St');
  await form.locator('input[name="phone"]').fill('5551234567');
  await form.locator('textarea[name="description"]').fill('E2E Test Car');

  // Submit
  await form.getByRole('button', { name: 'Submit' }).click();

  // Expect redirect to my cars
  await expect(page).toHaveURL(new RegExp(`${base.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&')}/car`));
});
