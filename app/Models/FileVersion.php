<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'editorId',
        'fileInfoId'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'editorId', 'id');
    }
    public function file_info()
    {
        return $this->belongsTo(FileInfo::class, 'fileInfoId', 'id');
    }
    public function file()
    {
        return $this->hasOne(File::class, 'versionId', 'id');
    }
}
