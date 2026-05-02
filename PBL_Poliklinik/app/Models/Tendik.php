<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tendik extends Model
{
    use SoftDeletes;

    protected $table = 'tendik';
    protected $primaryKey = 'id_tendik';

    protected $fillable = [
        'id_user',
        'id_jabatan',
        'nip',
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

    public function jabatan()
    {
        return $this->belongsTo(JabatanTendik::class, 'id_jabatan');
    }
}