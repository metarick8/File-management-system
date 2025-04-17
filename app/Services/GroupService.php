<?php

namespace App\Services;

use App\Models\Group;
use App\Repositories\GroupRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class GroupService
{
    protected $groupRepository;
    protected $invitationService;
    public function __construct(GroupRepository $groupRepository, InvitationService $invitationService)
    {
        $this->groupRepository = $groupRepository;
        $this->invitationService = $invitationService;
    }

    public function createGroup(array $data)
    {
        //Logic
        $validator = Validator::make($data, [
            'name' => 'required | string | max:255',
            "description" => 'required | string | max:255'
        ]);
        if ($validator->fails()) {
            //$validator->errors();
            return $validator->errors()->first();
            //return $this->error('',$validator->errors(), 400);
            //needs handling
            //return $this->error(["name" => $data["name"]], "The name you entered    for the group is wrong", 401);
            //throw new \InvalidArgumentException($validator->errors()->first());
        }
        $random = Str::random(10);
        $data['random'] = $random;
        $group = $this->groupRepository->create($data);
        $data['groupId'] = $group->id;
        if (!empty($data["users"]))
            if (is_array($data["users"])) {
                $data["members"] = $data["users"];
                $this->invitationService->invite($data);
            }
        return $group;
    }

    public function getGroupsForUser()
    {
        $userId = auth()->id();
        $groups = $this->groupRepository->getAllForUser($userId);

        return $groups;
    }
<<<<<<< HEAD
    public function get(int $groupId)
=======

    public function getGroup(int $groupId)
>>>>>>> test
    {
        $data["id"] = $groupId;
        $validator = Validator::make($data, [
            "id" => "required | integer",
        ]);

        if ($validator->fails())
            return $validator->errors()->first();

        return $this->groupRepository->get($groupId);
    }
}
