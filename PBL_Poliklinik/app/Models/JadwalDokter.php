<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalDokter extends Model
{
    use SoftDeletes;

    protected $table = 'jadwal_dokter';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_dokter',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'durasi_menit',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }

    public function kuotaHarian()
    {
        return $this->hasMany(KuotaHarian::class, 'id_jadwal');
    }

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'id_jadwal');
    }
}