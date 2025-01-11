<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileInfoRequest;
use App\Http\Requests\FileRequest;
use App\Models\FileInfo;
use App\Models\Group;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{

    public function store(FileInfoRequest $request, FileService $fileService)
    {
        return $fileService->store($request);
    }
    public function index(Group $group)
    {
        $files = null;
        if (auth()->user()->id === $group->ownerId)
            $files = FileInfo::filter(request(['accepted']))->where('groupId', $group->id)->get();
        else
            $files = FileInfo::filter(['accepted' => 1])->where('groupId', $group->id)->get();

        return $files;
    }
}
