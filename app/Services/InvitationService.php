<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\User;
use App\Repositories\InvitationRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvitationService
{
    protected $invitationRepository;

    public function __construct(InvitationRepository $invitationRepository)
    {
        $this->invitationRepository = $invitationRepository;
    }


    public function invite(array $data)
    {
        $validator = Validator::make($data, [
            "groupId" => "required | integer",
            "members" => "required | array",
            "members.*" => "integer"
        ]);

        if ($validator->fails())
            return [
                "data" => '',
                "message" => $validator->errors()->first(),
                "code request" => 400
            ];

        $groupId = $data["groupId"];
        $group = Group::find($groupId);
        if (empty($group))
            return [
                "data" => $groupId,
                "message" => "Invalid group id",
                "code request" => 400
            ];
        if ($group->ownerId != auth()->id())
            return [
                "data" => auth()->id(),
                "message" => "The user is not admin of this group",
                "code request" => 400
            ];
        foreach ($data["members"] as $memberId) {
            if (auth()->id() == $memberId)
                return [
                    "data" => '',
                    "message" => "You can't invite yourself to the group",
                    "code request" => 400
                ];
            $user = User::find($memberId);
            if (empty($user))
                return [
                    "data" => $memberId,
                    "message" => "Invalid user id",
                    "code request" => 400
                ];
            if (DB::table("members")->where([
                "userId" => $memberId,
                "groupId" => $groupId
            ])->exists())
                return [
                    "data" => $memberId,
                    "message" => "This user already in the group",
                    "code request" => 400
                ];
            else
                $this->invitationRepository->invite($memberId, $groupId);
        }
    }

    public function invitationValidation(array $data)
    {
        $validator = Validator::make($data, [
            "response" => "required | boolean",
            "id" => "required | integer"
        ]);

        if ($validator->fails())
            return [
                "data" => '',
                "message" => $validator->errors()->first(),
                "code request" => 400
            ];
        $invitationRow = DB::table("invitations")
            ->where("id", $data["id"])
            ->first();
        if (empty($invitationRow))
            return [
                "data" => $data["id"],
                "message" => "Invalid id",
                "code request" => 400
            ];
        else if ($invitationRow->status != "pending")
            return [
                "data" => $data["id"],
                "message" => "The user already responded to this invitation",
                "code request" => 400
            ];
        $this->invitationRepository->accept($data["response"], $invitationRow->id, $invitationRow->groupId);
    }
}
