import { expect, Page, Locator } from '@playwright/test';

export const base = process.env.BASE_URL || 'https://car-hub.xyz';
export const isLive = /car-hub\.xyz$/.test(new URL(base).host);

export function escRe(s: string) {
  return s.replace(/[-/\\^$*+?.()|[\]{}]/g, '\\$&');
}

export function collectConsoleErrors(page: Page) {
  const errors: string[] = [];
  page.on('console', (msg) => { if (msg.type() === 'error') errors.push(msg.text()); });
  return errors;
}

export async function login(page: Page, email: string, password: string) {
  await page.goto(`${base}/login`);
  await page.getByPlaceholder('Your Email').fill(email);
  await page.getByPlaceholder('Your Password').fill(password);
  await page.getByRole('button', { name: 'Login' }).click();
}

export async function selectFirstNonEmpty(select: Locator) {
  const options = select.locator('option[value]:not([value=""])');
  if ((await options.count()) > 0) {
    const val = await options.first().getAttribute('value');
    await select.selectOption({ value: val! });
    return val;
  }
  return undefined;
}

export function firstCarCard(page: Page) {
  return page.locator('.car-items-listing .car-item').first();
}
