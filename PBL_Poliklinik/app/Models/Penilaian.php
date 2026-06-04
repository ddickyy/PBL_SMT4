<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penilaian extends Model
{
    use SoftDeletes;

    protected $table = 'penilaian';
    protected $primaryKey = 'id_penilaian';

    protected $fillable = [
        'id_reservasi',
        'kritik',
        'saran',
        'viewed',
    ];

    protected $attributes = [
        'viewed' => false,
    ];

    protected $casts = [
        'viewed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi');
    }
}