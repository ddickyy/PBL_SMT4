<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $primaryKey = 'id_permission';

    protected $fillable = [
        'nama_permission',
        'deskripsi',
    ];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_permissions',
            'id_permission',
            'id_user'
        );
    }
}