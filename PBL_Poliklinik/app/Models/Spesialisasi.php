<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spesialisasi extends Model
{
    use SoftDeletes;

    protected $table = 'spesialisasi';
    protected $primaryKey = 'id_spesialisasi';

    protected $fillable = [
        'nama_spesialisasi',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function dokter()
    {
        return $this->hasMany(Dokter::class, 'id_spesialisasi');
    }
}