<?php

namespace App\Repositories;

use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GroupRepository
{
    public function create(array $data)
    {
        $group = Group::create([
            'name' => $data['name'],
            'description' => $data["description"],
            'ownerId' => auth()->id(),
            'randomString' => $data['random']
        ]);

        // DB::table("members")->insert([
        //     "userId" => auth()->id(),
        //     "groupId" => $group->id
        // ]);
        $this->joinGroup($group->id);
        return $group;
    }

    public function getGroups(int $id)
    {
        $members = DB::table("members")->where('userId', $id)->get();
        if ($members->isEmpty())
            return $members;
        foreach ($members as $member)
            $groups[] = Group::where('id', $member->groupId)->get();
        return $groups;
    }
    public function joinGroup(int $groupId)
    {
        DB::table("members")->insert([
            "userId" => auth()->id(),
            "groupId" => $groupId,
            "created_at" => Carbon::now(),

        ]);
    }
}
