import { test, expect } from '@playwright/test';

test('has title', async ({ page }) => {
  await page.goto('/');

  await expect(page).toHaveTitle(/| Starter Kit/);
});

test('has cookie banner', async ({ page }) => {
  await page.goto('/');

  await expect(
    page.getByText('Information about cookies on this website'),
  ).toBeVisible();
});
