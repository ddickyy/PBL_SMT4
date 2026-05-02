<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JabatanTendik extends Model
{
    use SoftDeletes;

    protected $table = 'jabatan_tendik';
    protected $primaryKey = 'id_jabatan';

    protected $fillable = [
        'nama_jabatan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function tendik()
    {
        return $this->hasMany(Tendik::class, 'id_jabatan');
    }
}