<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Group;

class FileInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'ownerId',
        'groupId',
        'name',
        'extension',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ownerId', 'id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class, 'groupId', 'id');
    }
    public function file_versions()
    {
        return $this->hasMany(FileVersion::class, 'fileInfoId', 'id');
    }

}
