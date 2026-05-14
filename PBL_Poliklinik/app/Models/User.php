<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'id_role',
        'nama',
        'email',
        'password',
        'foto',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'id_user');
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'id_user');
    }

    public function tendik()
    {
        return $this->hasOne(Tendik::class, 'id_user');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'id_user');
    }

    public function dokter()
    {
        return $this->hasOne(Dokter::class, 'id_user');
    }

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'id_user');
    }

    public function riwayatStatusYangDiubah()
    {
        return $this->hasMany(RiwayatStatusReservasi::class, 'diubah_oleh');
    }

    public function getNameAttribute(): string
    {
        return $this->nama;
    }

    public function getJenisPasienAttribute()
    {
        if ($this->mahasiswa) {
            return 'Mahasiswa';
        }

        if ($this->dosen) {
            return 'Dosen';
        }

        if ($this->tendik) {
            return 'Tendik';
        }

        return '-';
    }

    public function getIdentitasAttribute()
    {
        if ($this->mahasiswa) {
            return $this->mahasiswa->nim;
        }

        if ($this->dosen) {
            return $this->dosen->nidn;
        }

        if ($this->tendik) {
            return $this->tendik->nip;
        }

        return '-';
    }
}