<?php

namespace App\Filament\Resources\RiwayatStatusReservasis\Schemas;

use App\Models\RiwayatStatusReservasi;
use Dom\Text;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RiwayatStatusReservasiInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Informasi Riwayat Status Reservasi')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->description('Informasi utama mengenai riwayat status reservasi.')
                    ->schema([

                        Section::make('Data Reservasi')
                            ->icon('heroicon-o-information-circle')
                            ->compact()
                            ->schema([
                                TextEntry::make('reservasi.id_reservasi')
                                    ->label('ID Reservasi')
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('reservasi.user.nama')
                                    ->label('Pasien')
                                    ->badge()
                                    ->color('success'),

                                TextEntry::make('reservasi.tanggal_reservasi')
                                    ->label('Tanggal Reservasi')
                                    ->date('d F Y')
                                    ->icon('heroicon-o-calendar-days'),

                                TextEntry::make('reservasi.nomor_antrian')
                                    ->label('Nomor Antrian')
                                    ->badge()
                                    ->color('danger'),
                            ])
                            ->columnSpan(1),

                        Section::make('Data Dokter')
                            ->icon('heroicon-o-user-circle')
                            ->compact()
                            ->schema([
                                TextEntry::make('reservasi.jadwal.dokter.user.nama')
                                    ->label('Nama Dokter')
                                    ->badge()
                                    ->color('success'),

                                TextEntry::make('reservasi.jadwal.dokter.sip_dokter')
                                    ->label('SIP Dokter')
                                    ->badge()
                                    ->color('warning'),

                                TextEntry::make('reservasi.jadwal.dokter.spesialisasi.nama_spesialisasi')
                                    ->label('Spesialisasi')
                                    ->badge()
                                    ->color('warning'),

                                TextEntry::make('reservasi.jadwal.hari')
                                    ->label('Hari Praktik')
                                    ->badge()
                                    ->color('warning'),
                            ])
                            ->columnSpan(1),

                        Section::make('Data Rekam Medis')
                            ->icon('heroicon-o-document-text')
                            ->collapsible()
                            ->schema([

                                TextEntry::make('reservasi.rekamMedis.tanggal_periksa')
                                    ->label('Tanggal Periksa')
                                    ->placeholder('-')
                                    ->date('d F Y'),

                                TextEntry::make('reservasi.rekamMedis.diagnosis')
                                    ->label('Diagnosis')
                                    ->markdown()
                                    ->placeholder('-')
                                    ->columnSpanFull(),

                                TextEntry::make('reservasi.rekamMedis.catatan')
                                    ->label('Catatan Tambahan')
                                    ->placeholder('-')
                                    ->markdown()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        Section::make('Penilaian Pasien')
                            ->icon('heroicon-o-star')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                TextEntry::make('reservasi.penilaian.kritik')
                                    ->label('Kritik')
                                    ->placeholder('-')
                                    ->markdown(),

                                TextEntry::make('reservasi.penilaian.saran')
                                    ->label('Saran')
                                    ->placeholder('-')
                                    ->markdown(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        Section::make('Riwayat Status')
                            ->icon('heroicon-o-clock')
                            ->compact()
                            ->schema([

                                TextEntry::make('reservasi.status')
                                    ->label('Status Lama')
                                    ->badge(),

                                TextEntry::make('status_baru')
                                    ->label('Status Baru')
                                    ->badge(),

                                TextEntry::make('created_at')
                                    ->label('Tanggal Perubahan')
                                    ->dateTime('d F Y, H:i'),
                            ])
                            ->columnSpan(1),

                        Section::make('Metadata')
                            ->icon('heroicon-o-identification')
                            ->compact()
                            ->schema([

                                TextEntry::make('diubah_oleh')
                                    ->label('Diubah Oleh')
                                    ->numeric(),
                            ])
                            ->columnSpan(1),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
