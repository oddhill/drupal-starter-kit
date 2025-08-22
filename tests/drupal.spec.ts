import { test, expect } from '@playwright/test';

test('has title', async ({ page }) => {
  await page.goto('/');

  await expect(page).toHaveTitle(/| Starter Kit/);
});

test('no front page content', async ({ page }) => {
  await page.goto('/');

  await expect(
    page.getByText('No front page content has been created yet.'),
  ).toBeVisible();
});
