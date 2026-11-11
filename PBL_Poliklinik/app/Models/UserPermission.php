<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $table = 'user_permissions';

    protected $fillable = [
        'id_user',
        'id_permission',
    ];

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user'
        );
    }

    public function permissions()
    {
        return $this->belongsTo(Permission::class,'id_permission');
    }
}