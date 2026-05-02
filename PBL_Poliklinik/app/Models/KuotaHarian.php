<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KuotaHarian extends Model
{
    use SoftDeletes;

    protected $table = 'kuota_harian';
    protected $primaryKey = 'id_kuota';

    protected $fillable = [
        'id_jadwal',
        'tanggal',
        'kuota_terisi',
        'kuota_maksimal',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function jadwal()
    {
        return $this->belongsTo(JadwalDokter::class, 'id_jadwal');
    }
}