<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = 'roles';
    protected $primaryKey = 'id_role';

    protected $fillable = [
        'nama_role',
        'deskripsi',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_role');
    }

    public function permissions()
{
    return $this->belongsToMany(
        Permission::class,
        'role_permissions',
        'id_role',
        'id_permission'
    );
}
}