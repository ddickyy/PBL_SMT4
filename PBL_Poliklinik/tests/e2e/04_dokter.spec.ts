import { test, expect } from '@playwright/test';

test.describe('Modul Pelayanan Dokter (DOK)', () => {

  test.beforeEach(async ({ page }) => {
    await page.goto('/login');
    await page.locator('#email').fill('satra@poliklinik.com');
    await page.locator('#password').fill('123456789');
    await page.locator('#submit-btn').click();
    await expect(page).toHaveURL(/.*\/dokter\/beranda/);
  });

  test('TC-DOK-001: Akses Daftar Antrean Pasien', async ({ page }) => {
    await page.goto('/dokter/pasien');

    await expect(page.locator('body')).toContainText(/Daftar Antrean Pasien|Daftar Tunggu/i);
    await expect(page.locator('.dp-table-wrap')).toBeVisible();
  });

  test('TC-DOK-002: Pengisian Rekam Medis & Diagnosa Pasien', async ({ page }) => {
    await page.goto('/dokter/pasien');

    const firstPatientRow = page.locator('#dpTableBody tr.dp-tr').first();

    if (await firstPatientRow.isVisible()) {
      await firstPatientRow.click();

      await expect(page).toHaveURL(/.*\/dokter\/pasien\/\d+/);
      await expect(page.locator('body')).toContainText(/Informasi Lengkap Pasien/i);

      const diagnosisInput = page.locator('#diagnosis');
      const catatanInput = page.locator('#catatan');

      await diagnosisInput.fill('Faringitis Akut (E2E Test Verified)');
      await catatanInput.fill('Paracetamol 500mg 3x1 setelah makan, istirahat cukup.');

      await page.locator('button.det-save-btn').click();

      await expect(page.locator('.det-alert-success').first()).toContainText(/berhasil|tersimpan|sukses/i);
    } else {
      await expect(page.locator('.dp-table-wrap')).toBeVisible();
    }
  });

});
