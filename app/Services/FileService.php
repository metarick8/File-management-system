<?php

namespace App\Services;

use App\Http\Requests\FileInfoRequest;
use App\Http\Requests\FileRequest;
use App\Models\FileInfo;
use App\Models\Group;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class FileService
{
    public function store(FileInfoRequest $request)
    {
        DB::beginTransaction();
        $file = null;
        try {

            $file = $request->file('file')->store();
            FileInfo::create([
                'name' => $request->name,
                'extension' => $request->file->getClientOriginalExtension(),
                'groupId' => $request->groupId,
                'ownerId' => $request->user()->id,
                'path' => $file
            ]);
            DB::commit();
            return response()->json(['message' => 'File uploaded successfully!']);
        } catch (Throwable $th) {
            DB::rollBack();
            if ($file && Storage::disk('local')->exists($file))
                Storage::disk('local')->delete($file);
            return response()->json(['message' => $th->getMessage()]);
        }
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
    public function accept($file)
    {
        if (FileInfo::where('groupId', $file->groupId)->where('name', $file->name)
            ->where('extension', $file->extension)->where('accepted', 1)->exists()
        ) {
            return response()->json(['message' => 'File cannot be accepted because of naming collision'], 422);
        }
        DB::beginTransaction();
        try {
            $file->update(['accepted' => true]);
            DB::commit();
            return response()->json(['message' => 'File accepted successfully'], 200);
        } catch (Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()]);
        }
    }
    public function reserve($files)
    {
        DB::beginTransaction();
        try {
            auth()->user()->edited_files()->sync($files);
            DB::commit();
        } catch (Throwable $th) {

            DB::rollback();
            return response()->json(['error' => $th->getMessage()]);
        }
    }
    public function release() {}
}
