<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'members', 'userId', 'groupId');
    }

    public function file_infos()
    {
        return $this->hasMany(FileInfo::class, 'ownerId', 'id');
    }
    public function file_versions()
    {
        return $this->hasMany(FileVersion::class, 'editorId', 'id');
    }
    public function members()
    {
        return $this->belongsToMany(Group::class, 'members', 'userId');
    }
}
