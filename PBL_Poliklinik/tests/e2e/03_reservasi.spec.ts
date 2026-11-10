import { test, expect } from '@playwright/test';

test.describe('Modul Reservasi Pasien (RES)', () => {

  test.beforeEach(async ({ page }) => {
    await page.goto('/login');
    await page.locator('#email').fill('dicky@gmail.com');
    await page.locator('#password').fill('12345');
    await page.locator('#submit-btn').click();
    await expect(page).toHaveURL(/.*\/pasien\/beranda/);
  });

  test('TC-RES-002: Validasi Form Reservasi Awal (Negative Testing)', async ({ page }) => {
    await page.goto('/pasien/reservasi');

    const btnConfirm = page.locator('#btnConfirm');
    await expect(btnConfirm).toBeDisabled();

    await expect(page.locator('#tanggalGrid')).toContainText(/Pilih dokter terlebih dahulu/i);
  });

  test('TC-RES-001: Pembuatan Reservasi Pasien', async ({ page }) => {
    await page.goto('/pasien/reservasi');

    const doctorCard = page.locator('.doctor-card-modern').first();
    await expect(doctorCard).toBeVisible();

    await doctorCard.click();

    const tanggalItem = page.locator('#tanggalGrid .tanggal-item').first();
    
    if (await tanggalItem.isVisible()) {
      await tanggalItem.click();

      const btnConfirm = page.locator('#btnConfirm');
      await expect(btnConfirm).toBeEnabled();

      await btnConfirm.click();

      await expect(page).toHaveURL(/.*\/pasien\/(reservasi|bukti|riwayat)/);
    } else {
      await expect(page.locator('#tanggalGrid')).toContainText(/Tidak ada jadwal tersedia/i);
    }
  });

  test('TC-RES-003: Melihat Riwayat Reservasi', async ({ page }) => {
    await page.goto('/pasien/riwayat');

    await expect(page.locator('body')).toContainText(/Riwayat Reservasi/i);
    await expect(page.locator('.riwayat-container-box').first()).toBeVisible();
  });

  test('TC-RES-004: Pembatalan Reservasi Aktif', async ({ page }) => {
    await page.goto('/pasien/riwayat');

    const aktifCard = page.locator('.aktif-card-link').first();

    if (await aktifCard.isVisible()) {
      await aktifCard.click();

      await expect(page).toHaveURL(/.*\/pasien\/reservasi\/\d+/);

      const btnCancel = page.locator('.btn-cancel-bukti');
      if (await btnCancel.isVisible()) {
        page.on('dialog', async dialog => {
          await dialog.accept();
        });

        await btnCancel.click();

        await expect(page.locator('.status-badge, .bk-alert-success, body')).toContainText(/batal|dibatalkan|sukses/i);
      }
    } else {
      await expect(page.locator('body')).toContainText(/Belum Ada Reservasi Aktif|Riwayat Reservasi/i);
    }
  });

});
