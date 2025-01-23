<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mockery\Undefined;


class FileInfo extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'ownerId',
    //     'groupId',
    //     'name',
    //     'extension',
    //     'status'
    // ];
    protected $guarded = [];

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
    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['accepted'] ?? false,
            fn($query, $accepted) =>
            $query->where('accepted', $accepted)
        );
    }
    // public function getPathAttribute($value)
    // {
    //     return $this->name . '.' . $this->extension;
    // }
}
