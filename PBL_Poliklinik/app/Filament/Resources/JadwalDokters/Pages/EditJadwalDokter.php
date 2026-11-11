<?php

namespace App\Filament\Resources\JadwalDokters\Pages;

use App\Filament\Resources\JadwalDokters\JadwalDokterResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use App\Models\KuotaHarian;

class EditJadwalDokter extends EditRecord
{
    protected static string $resource =
        JadwalDokterResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl(
            'view',
            ['record' => $this->record]
        );
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $jadwal = $this->record;

        KuotaHarian::where(
            'id_jadwal',
            $jadwal->id_jadwal
        )
        ->whereDate('tanggal', '>=', now())
        ->update([
            'kuota_maksimal' =>
                $this->data['kuota_maksimal'],
        ]);
    }

    protected function mutateFormDataBeforeFill(
        array $data
    ): array
    {
        $kuota = KuotaHarian::where(
            'id_jadwal',
            $this->record->id_jadwal
        )->first();

        $data['kuota_maksimal'] =
            $kuota?->kuota_maksimal;

        return $data;
    }
}