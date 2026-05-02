<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokter extends Model
{
    use SoftDeletes;

    protected $table = 'dokter';
    protected $primaryKey = 'id_dokter';

    protected $fillable = [
        'id_user',
        'id_spesialisasi',
        'sip_dokter',
        'no_hp',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function spesialisasi()
    {
        return $this->belongsTo(Spesialisasi::class, 'id_spesialisasi');
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalDokter::class, 'id_dokter');
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'id_dokter');
    }
}