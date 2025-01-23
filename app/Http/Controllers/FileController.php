<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileCheckInRequest;
use App\Http\Requests\FileCheckOutRequest;
use App\Http\Requests\FileInfoRequest;
use App\Http\Requests\FileRequest;
use App\Models\FileInfo;
use App\Models\Group;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FileController extends Controller
{

    public function store(FileInfoRequest $request, FileService $fileService)
    {
        $this->authorize('create', FileInfo::class);
        return $fileService->store($request);
    }
    public function index(Group $group, FileService $fileService)
    {
        return $fileService->index($group);
    }

    public function checkin(FileCheckInRequest $request, FileService $fileService)
    {

        return $fileService->reserve($request['files']);
    }
    public function checkout(FileCheckOutRequest $request, FileService $fileService)
    {
        $this->authorize('checkout', FileInfo::class);
        return $fileService->release($request, FileInfo::find($request->fileInfoId));
    }
    public function accept(FileInfo $file, FileService $fileService)
    {
        $this->authorize('accept', $file);

        if ($file->accepted)
            return response()->json(['message' => "File already accepted"], 422);

        //validate naming collision
        if (FileInfo::where('groupId', $file->groupId)->where('name', $file->name)
            ->where('extension', $file->extension)->where('accepted', 1)->exists()
        ) {
            return response()->json(['message' => 'File cannot be accepted because of naming collision'], 422);
        }
        return $fileService->accept($file);
    }
    public function showQuery()
    {
        // $fileIDs = [1, 3, 4];
        // return FileInfo::whereIn('id', $fileIDs)->file_versions()->tosql();
        // return auth()->user()->members()->whereHas('file_infos', fn($query) => $query->where('id', 3)->where('accepted', 1))->tosql();
        // return FileInfo::whereIn('id', $fileIDs)->whereHas('groups',fn($query) => $query->where('id',));
        // return auth()->user()->members()->whereHas('file_infos', fn($query) => $query->whereIn('id', $fileIDs)->where('accepted', 1)->count())->tosql();

    }
}
