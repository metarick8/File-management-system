<?php

namespace App\Http\Controllers;

use App\Services\GroupService;
use App\Traits\Response;
use Exception;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    use Response;
    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        //needs handling
        $this->middleware('auth:api');

        $this->groupService = $groupService;
    }

    public function create(Request $request)
    {
        $group = $this->groupService->createGroup($request->only([
            'name',
            'description',
            'users'
        ]));

        //return $group;
        if (empty($group->id))
            return $this->error('', $group, 400);

        // return response()->json([
        //     "message" => "Group created Successfully",
        //     "data" => $group,
        // ], 201);
        return $this->success($group, "Group created Successfully", 201);
    }

    public function listGroupsForUser()
    {
        $groups = $this->groupService->getGroupsForUser();
        if (empty($groups))
            return $this->success('', "You haven't join any group yet");
        return $this->success([
            "groups" => $groups
        ], 'Groups for this user');
    }

    public function show(int $id)
    {
<<<<<<< HEAD
        $group = $this->groupService->get($id);
=======
        $group = $this->groupService->getGroup($id);
>>>>>>> test
        if (empty($group))
            return $this->success('', "Group not found!");
        else
            return $this->success($group, "Group details:");
    }
<<<<<<< HEAD

=======
>>>>>>> test
}
