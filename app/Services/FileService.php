<?php

namespace App\Services;

use App\Http\Requests\FileCheckOutRequest;
use App\Http\Requests\FileInfoRequest;
use App\Http\Requests\FileRequest;
use App\Models\FileInfo;
use App\Models\FileVersion;
use App\Models\Group;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
            return response()->json(['message' => 'File uploaded successfully!'], 200);
        } catch (Throwable $th) {
            DB::rollBack();

            //to prevent orphaned files
            if ($file && Storage::disk('local')->exists($file))
                Storage::disk('local')->delete($file);
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    public function index(Group $group)
    {
        $files = null;
        if (auth()->user()->id === $group->ownerId)
            $files = FileInfo::filter(request(['accepted']))->where('groupId', $group->id)->get();
        else
            $files = FileInfo::filter(['accepted' => 1])->where('groupId', $group->id)->get();
        return response()->json(['data' => $files]);
    }
    public function accept($file)
    {
        DB::beginTransaction();
        try {
            $file->update(['accepted' => true]);
            DB::commit();
            return response()->json(['message' => 'File accepted successfully'], 200);
        } catch (Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    public function reserve($files)
    {
        // DB::statement('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ');
        DB::beginTransaction();
        try {

            Gate::authorize('checkin', FileInfo::class);
        } catch (Throwable $th) {
            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 403);
        }

        // sleep(10);
        try {
            //this step is primarily added to avoid race condition!
            FileInfo::whereIn('id', $files)->update(['isFree' => 0]);
            auth()->user()->edited_files()->attach($files);
            DB::commit();
            return response()->json(['message' => 'Reserved successfully'], 200);
        } catch (Throwable $th) {

            DB::rollback();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    public function release($request, FileInfo $file)
    {
        DB::beginTransaction();
        $stored_file = null;
        try {
            $name = pathinfo($request->file('file')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            // $fullname = $request->file('file')->getClientOriginalName();

            if ($name . '.' . $extension !== $file->name . '.' . $file->extension)
                return response()->json(['message' => "uploaded file name or extension doesn't match original file name or extension"], 422);

            $file_version = FileVersion::where('fileInfoId', $request->fileInfoId)->where('path', null)->first();
            $stored_file = $request->file('file')->store();
            $file_version->update(['path' => $stored_file]);
            $file->update(['isFree' => 1]);

            DB::commit();
            return response()->json(['message' => 'File Updated successfully'], 200);
        } catch (Throwable $th) {
            DB::rollback();

            //to prevent orphaned files
            if ($stored_file && Storage::disk('local')->exists($stored_file))
                Storage::disk('local')->delete($file);
            return response()->json(['message' => $th->getMessage(), 500]);
        }
    }

    public function notifications()
    {
        return FileInfo::where('accepted', 0)
            ->whereIn('groupId', auth()->user()->groups()->pluck('id'))
            ->with('group.user')
            ->get()
            ->map(function ($file) {
                return [
                    'id' => $file->id,
                    'name' => $file->name,
                    'accepted' => $file->accepted,
                    'created_at' => $file->created_at,
                    'owner' => $file->group->user->name ?? null,
                    'group' => $file->group->name ?? null,
                ];
            });
    }

    public function show(int $id)
    {
        // working
        return FileInfo::with("file_versions")->find($id);
    }
}
