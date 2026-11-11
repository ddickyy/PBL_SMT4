import { test, expect } from '@playwright/test';

test.describe('Modul Registrasi Pasien Baru (REG)', () => {

  test('TC-REG-001: Navigasi Pemilihan Peran', async ({ page }) => {
    await page.goto('/login');

    await page.getByRole('link', { name: /Daftar Sekarang/i }).click();
    await expect(page).toHaveURL(/.*\/daftar\/role/);
    await expect(page.locator('body')).toContainText('Pilih identitas Anda');

    await page.getByRole('link', { name: /Pilih Mahasiswa/i }).click();
    await expect(page).toHaveURL(/.*\/daftar\/mahasiswa/);
    await expect(page.locator('body')).toContainText('Buat Akun Mahasiswa');
  });

  test('TC-REG-002: Registrasi Mahasiswa Lengkap', async ({ page }) => {
    await page.goto('/daftar/mahasiswa');

    const timestamp = Date.now().toString().slice(-6);
    const nimUnik = `22417${timestamp}`;
    const emailUnik = `mhs${timestamp}@polinema.ac.id`;

    await page.locator('input[name="nim"]').fill(nimUnik);
    await page.locator('input[name="nama"]').fill('Mahasiswa Playwright Tester');
    await page.locator('input[name="email"]').fill(emailUnik);

    const prodiSelect = page.locator('select[name="id_prodi"]');
    await prodiSelect.selectOption({ index: 1 });

    await page.locator('input[name="password"]').fill('rahasia123');
    await page.locator('input[name="password_confirmation"]').fill('rahasia123');
    await page.locator('input[name="no_hp"]').fill('081234567890');

    await page.locator('button[type="submit"]').click();

    await expect(page).toHaveURL(/.*\/login/);
    await expect(page.locator('.alert-success').first()).toContainText(/Registrasi mahasiswa berhasil/i);
  });

  test('TC-REG-003: Validasi Email Duplikat (Negative Testing)', async ({ page }) => {
    await page.goto('/daftar/mahasiswa');

    const timestamp = Date.now().toString().slice(-6);
    await page.locator('input[name="nim"]').fill(`99917${timestamp}`);
    await page.locator('input[name="nama"]').fill('Duplikat Tester');
    await page.locator('input[name="email"]').fill('dicky@gmail.com');

    const prodiSelect = page.locator('select[name="id_prodi"]');
    await prodiSelect.selectOption({ index: 1 });

    await page.locator('input[name="password"]').fill('rahasia123');
    await page.locator('input[name="password_confirmation"]').fill('rahasia123');
    await page.locator('input[name="no_hp"]').fill('081234567890');

    await page.locator('button[type="submit"]').click();

    await expect(page).toHaveURL(/.*\/daftar\/mahasiswa/);
    await expect(page.locator('.alert-error').first()).toContainText(/telah digunakan|sudah terdaftar|already been taken/i);
  });

});
