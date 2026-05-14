<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatStatusReservasi;

class Reservasi extends Model
{
    use SoftDeletes;

    protected $table = 'reservasi';
    protected $primaryKey = 'id_reservasi';

    protected $fillable = [
        'id_user',
        'id_jadwal',
        'tanggal_reservasi',
        'nomor_antrian',
        'estimasi_jam',
        'status',
    ];

    protected $casts = [
        'tanggal_reservasi' => 'date',
        'estimasi_jam' => 'datetime:H:i:s',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function jadwal()
    {
        return $this->belongsTo(JadwalDokter::class, 'id_jadwal');
    }

    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class, 'id_reservasi');
    }

    public function riwayatStatus()
    {
        return $this->hasMany(RiwayatStatusReservasi::class, 'id_reservasi');
    }

    public function penilaian()
    {
        return $this->hasOne(Penilaian::class, 'id_reservasi');
    }

    protected static function booted()
    {
        static::creating(function ($reservasi) {

            $lastQueue = self::whereDate(
                'tanggal_reservasi',
                $reservasi->tanggal_reservasi
            )->max('nomor_antrian');

            $reservasi->nomor_antrian = ($lastQueue ?? 0) + 1;
        });

        static::updating(function ($reservasi) {

            if ($reservasi->isDirty('status')) {

                $statusBaru = $reservasi->status;

                if (in_array($statusBaru, ['selesai', 'dibatalkan'])) {

                    $sudahAdaRiwayat = RiwayatStatusReservasi::where(
                        'id_reservasi',
                        $reservasi->id_reservasi
                    )->exists();

                    if (! $sudahAdaRiwayat) {

                        RiwayatStatusReservasi::create([

                            'id_reservasi' => $reservasi->id_reservasi,

                            'status_lama' => $reservasi->getOriginal('status'),

                            'status_baru' => $statusBaru,

                            'keterangan' =>
                                'Status reservasi berubah dari ' .
                                $reservasi->getOriginal('status') .
                                ' menjadi ' .
                                $statusBaru,

                            'diubah_oleh' => Auth::user()?->id_user,
                        ]);
                    }
                }
            }
        });
    }
}