<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'memberCount',
        'ownerId',
        'randomString'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ownerId', 'id');
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'members', 'groupId');
    }
    public function file_infos()
    {
        return $this->hasMany(FileInfo::class, 'groupId', 'id');
    }

}
