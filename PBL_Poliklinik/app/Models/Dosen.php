<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dosen extends Model
{
    use SoftDeletes;

    protected $table = 'dosen';
    protected $primaryKey = 'id_dosen';

    protected $fillable = [
        'id_user',
        'id_jurusan',
        'nidn',
        'no_hp',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan');
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}