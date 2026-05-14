<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiwayatStatusReservasi extends Model
{
    use SoftDeletes;

    protected $table = 'riwayat_status_reservasi';
    protected $primaryKey = 'id_riwayat';

    protected $fillable = [
        'id_reservasi',
        'diubah_oleh',
        'status_lama',
        'status_baru',
        'keterangan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'diubah_oleh');
    }
}