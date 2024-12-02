<?php

namespace App\Http\Controllers;

use App\Services\GroupService;
use App\Traits\Response;
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
            'description'
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

    public function showGroupsForUser()
    {
        $groups = $this->groupService->getGroupsForUser();
        return $this->success([
            "groups" => $groups
        ], 'Groups for this user');
    }

}
