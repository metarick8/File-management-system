<?php

namespace App\Policies;

use App\Models\FileInfo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FileInfoPolicy
{
    public function accept(User $user, FileInfo $file)
    {
        return $user->groups()->where('id', $file->groupId)->exists();
    }
}
