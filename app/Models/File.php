<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'versionId',
        'file'
    ];

    public function file_version()
    {
        return $this->belongsTo(FileVersion::class, 'versionId', 'id');
    }


}
