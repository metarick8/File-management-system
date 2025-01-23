<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'ownerId',
        'randomString'
    ];
    protected $appends = [
        'totalMembers'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ownerId', 'id');
    }
    public function members()
    {
        return $this->belongsToMany(User::class, 'members', 'groupId', 'userId');
    }
    public function invitations()
    {
        return $this->belongsToMany(User::class, 'invitations', 'groupId', 'userId');
    }
    public function file_infos()
    {
        return $this->hasMany(FileInfo::class, 'groupId', 'id');
    }
    public function gettotalMembersAttribute()
    {
        $totalMembers = DB::table("members")->where("groupId", $this->id)->count();
        if ($totalMembers != null)
            return DB::table("members")->where("groupId", $this->id)->count();
        return 0;
    }
}
