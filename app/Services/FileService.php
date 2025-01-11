<?php

namespace App\Services;

use App\Http\Requests\FileInfoRequest;
use App\Http\Requests\FileRequest;
use App\Models\FileInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class FileService
{
    public function createFile(array $data) {}
    public function doSomething()
    {
        return 'from service';
    }
    public function store(FileInfoRequest $request)
    {
        DB::beginTransaction();
        $file = null;
        try {
            $file = $request->file('file')->store();
            FileInfo::create([
                'name' => $request->name,
                'extension' => $request->file->extension(),
                'groupId' => $request->groupId,
                'ownerId' => auth()->user()->id,
                'path' => $file
            ]);
            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();
            if ($file && Storage::disk('local')->exists($file))
                Storage::disk('local')->delete($file);
            return response()->json(['error' => $th->getMessage()]);
        }
    }
    public function reserve() {}
    public function release() {}
}
