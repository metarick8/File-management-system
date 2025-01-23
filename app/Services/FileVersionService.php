<?php

namespace App\Services;

use App\Models\FileInfo;
use App\Models\FileVersion;
use App\Models\Group;
use App\Models\User;

class FileVersionService
{
    public function index()
    {
        $user = auth()->user();

        $editedFiles = $user->edited_files()->with([
            'file_info',
            'file_info.group'
        ])->get();

        $result = [];

        foreach ($editedFiles as $fileVersion) {
            $result[] = [
                'fileName' => $fileVersion->file_info->name,
                'versionNumber' => $fileVersion->version_number,
                'groupName' => $fileVersion->file_info->group->name
            ];
        }

        return $result;
        return response()->json($result);


        $files = null;
        if (auth()->user()->id === $group->ownerId)
            //Group::with('file_infos.file_versions')
            $files = FileInfo::with('file_versions', 'group')->where('groupId', $group->id)->get();
        else
            $files = FileInfo::filter(['accepted' => 1])->where('groupId', $group->id)->get();
        return response()->json(['data' => $files]);
    }

    public function notifications()
    {
        $groups = auth()->user()->members()
            ->with('file_infos.file_versions')
            ->get();
        $result = [];
        foreach ($groups as $group) {
            foreach ($group->file_infos as $file_info) {
                $versions = $file_info->file_versions;
                $result[] = [
                    'group' => $group->name,
                    'file' => $file_info->name,
                    'versions' => $versions->map(function ($version) {
                        return [
                            'created_at' => $version->created_at,
                        ];
                    })->toArray(),
                ];
            }
        }
        usort($result, function ($a, $b) {
            $aCreatedAt = isset($a['versions'][0]['created_at']) ? strtotime($a['versions'][0]['created_at']) : 0;
            $bCreatedAt = isset($b['versions'][0]['created_at']) ? strtotime($b['versions'][0]['created_at']) : 0;

            return $bCreatedAt - $aCreatedAt;
        });
        return $result;
    }
}
