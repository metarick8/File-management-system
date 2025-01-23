<?php

namespace App\Policies;

use App\Models\FileInfo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FileInfoPolicy
{
    public function accept(User $user, FileInfo $file)
    {
        //check if file's group is owned by the user
        return $user->groups()->where('id', $file->groupId)->exists();
    }
    public function checkout(User $user)
    {
        //check if this user is the one who reserved it (this obviously ensures that file exists :] )
        return $user->file_versions()->where('fileInfoId', request('fileInfoId'))->where('path', null)->exists();
    }

    public function checkin(User $user)
    {
        //check if ALL files to be reserved are free,accepted and in one of the user's memberships
        return FileInfo::whereIn('id', request('files'))->whereIn('groupId', $user->members()->pluck('groups.id'))->where('accepted', 1)->where('isFree', 1)->lockForUpdate()->count() === count(request('files'));
    }
    public function create(User $user)
    {
        //check if user is a member of the group ; he's uploading a file into
        return $user->members()->where('groupId', request('groupId'))->exists();
    }


}
