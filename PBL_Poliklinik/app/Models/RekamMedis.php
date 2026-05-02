<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekamMedis extends Model
{
    use SoftDeletes;

    protected $table = 'rekam_medis';
    protected $primaryKey = 'id_rekam';

    protected $fillable = [
        'id_reservasi',
        'id_dokter',
        'diagnosis',
        'catatan',
        'tanggal_periksa',
    ];

    protected $casts = [
        'tanggal_periksa' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'id_dokter');
    }
}