<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileCheckInRequest;
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
    public function index(Group $group, FileService $fileService)
    {
        return $fileService->index($group);
    }
    public function checkin(FileCheckInRequest $request, FileService $fileService)
    {
        return $fileService->reserve($request['files']);
    }
    public function accept(FileInfo $file, FileService $fileService)
    {
        $this->authorize('accept', $file);
        if ($file->accepted)
            return response()->json(['message' => "File already accepted"], 422);
        return $fileService->accept($file);
    }
}
