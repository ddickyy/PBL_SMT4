import { test, expect } from '@playwright/test';

test.describe('Modul Autentikasi & Keamanan (AUTH)', () => {

  test('TC-AUTH-001: Login Pasien Sukses', async ({ page }) => {
    await page.goto('/login');

    await page.locator('#email').fill('dicky@gmail.com');
    await page.locator('#password').fill('12345');
    await page.locator('#submit-btn').click();

    await expect(page).toHaveURL(/.*\/pasien\/beranda/);
    await expect(page.locator('body')).toContainText(/Dicky|Layanan Kesehatan/i);
  });

  test('TC-AUTH-002: Login Dokter Sukses', async ({ page }) => {
    await page.goto('/login');

    await page.locator('#email').fill('satra@poliklinik.com');
    await page.locator('#password').fill('123456789');
    await page.locator('#submit-btn').click();

    await expect(page).toHaveURL(/.*\/dokter\/beranda/);
  });

  test('TC-AUTH-003: Proteksi Login Admin di Form Publik', async ({ page }) => {
    await page.goto('/login');

    await page.locator('#email').fill('admin@gmail.com');
    await page.locator('#password').fill('12345');
    await page.locator('#submit-btn').click();

    await expect(page).toHaveURL(/.*\/login/);
    await expect(page.locator('.text-error').first()).toContainText('Silakan login melalui panel admin.');
  });

  test('TC-AUTH-004: Login Kredensial Salah (Negative Testing)', async ({ page }) => {
    await page.goto('/login');

    await page.locator('#email').fill('dicky@gmail.com');
    await page.locator('#password').fill('passwordsalah123');
    await page.locator('#submit-btn').click();

    await expect(page).toHaveURL(/.*\/login/);
    await expect(page.locator('body')).toContainText(/tidak cocok|salah|error/i);
  });

  test('TC-AUTH-005: Proteksi Rute Tertutup (Middleware Guest)', async ({ page }) => {
    await page.goto('/pasien/beranda');
    await expect(page).toHaveURL(/.*\/login/);

    await page.goto('/dokter/beranda');
    await expect(page).toHaveURL(/.*\/login/);
  });

  test('TC-AUTH-006: Logout Akun Pasien Berhasil', async ({ page }) => {
    await page.goto('/login');
    await page.locator('#email').fill('dicky@gmail.com');
    await page.locator('#password').fill('12345');
    await page.locator('#submit-btn').click();
    await expect(page).toHaveURL(/.*\/pasien\/beranda/);

    await page.locator('.profile-trigger').click();
    await page.locator('.logout-item').click();

    await expect(page).toHaveURL(/.*\/login/);
    await page.goto('/pasien/beranda');
    await expect(page).toHaveURL(/.*\/login/);
  });

});
