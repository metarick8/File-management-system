<?php

namespace App\Services;

use App\Repositories\GroupRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class GroupService
{
    protected $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
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
        return $group;
    }

    public function getGroupsForUser()
    {
        $userId = auth()->id();
        $groups = $this->groupRepository->getGroups($userId);

        return $groups;
    }
}
