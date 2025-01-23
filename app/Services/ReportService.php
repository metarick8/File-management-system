<?php

namespace App\Services;

use App\Models\FileInfo;
use App\Models\Group;

class ReportService
{
    public function file(int $id)
    {
        $fileWithVersions = FileInfo::with(["file_versions.user", 'user', 'group'])->find($id);
        $count = 0;
        $result[] = [
            'Name' => $fileWithVersions->name,
            "Owner" => $fileWithVersions->user->name,
            "Group" => $fileWithVersions->group->name,
            "Status" => $fileWithVersions->isFree ? "Reserved" : "Available",
            "Created at" => $fileWithVersions->created_at,
            "Versions" => $fileWithVersions->file_versions->map(function ($version) use (&$count) {
                $count++;
                return [
                    "Editor" => $version->user->name,
                    "Version num" => $count,
                ];
            })->all(),
        ];
        return $result;
    }

    public function group(int $id)
    {
        $groupWithMembers = Group::with(['members.file_infos.file_versions',])->find($id);
        $result = [];

        if ($groupWithMembers instanceof \Illuminate\Database\Eloquent\Model) {
            $result[] = [
                'Name' => $groupWithMembers->name ?? '',
                'Description' => $groupWithMembers->description ?? '',
                'Group' => $groupWithMembers->group->name ?? '',
                'Created at' => $groupWithMembers->created_at ?? '',
                'Members' => $groupWithMembers->members ? $groupWithMembers->members->map(function ($member) {
                    return [
                        'Name' => $member->name ?? '',
                        'Email' => $member->email ?? '',
                        'Files edited' => $member->file_infos ? $member->file_infos->map(function ($file) {
                            $count = 0;
                            return [
                                'Name' => $file->name ?? '',
                                'Owner' => $file->user->name ?? '',
                                'Status' => $file->isFree ? "Reserved" : "Available",
                                'Created at' => $file->created_at ?? '',
                                'Versions' => $file->file_versions ? $file->file_versions->map(function ($version) use (&$count) {
                                    return ['Version num' => ++$count];
                                })->toArray() : null,
                            ];
                        })->toArray() : [],
                    ];
                })->toArray() : [],
            ];
        }

        return $result;
    }
}
