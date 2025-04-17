<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Repositories\GroupRepository;

class InvitationRepository
{
    protected $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    public function invite(int $memberId, int $groupId)
    {
        // $invitation = DB::table("invitations")->where([
        //     "userId" => $memberId,
        //     "groupId" => $groupId,
        // ])->first();
        // if($invitation)
        //     $invitation->update([
        //         "status" => "pending"
        //     ]);
        // else
        //     DB::table("invitations")->insert([
        //         "userId" => $memberId,
        //         "groupId" => $groupId,
        //         "status" => "pending"
        //     ]);

        DB::table("invitations")->insert([
            "userId" => $memberId,
            "groupId" => $groupId,
            "status" => "pending",
            "created_at" => Carbon::now()
        ]);
        return true;
    }
    // public function accept(bool $accept, $groupId)
    // {
    //     $invitationResponse = DB::table("invitation")->where([
    //         "groupId" => $groupId,
    //         "userId" => auth()->id(),
    //         "status" => "pending"
    //     ])->first();
    //     if ($accept)
    //     {
    //         $invitationResponse->update([
    //             "status" => "accepted"
    //         ]);
    //         $this->groupRepository->joinGroup($groupId);
    //     }
    //     else
    //         $invitationResponse->update([
    //             "status" => "refused"
    //         ]);

    // }

    public function accept(bool $accept, int $invitationId, int $groupId)
    {

        if ($accept) {
            $response = "accepted";
            // $this->groupRepository->joinGroup($groupId);
            DB::table("members")->insert([
                "userId" => auth()->id(),
                "groupId" => $groupId,
                "created_at" => Carbon::now()
            ]);
        } else
            $response = "refused";

        DB::table("invitations")->where("id", $invitationId)
            ->update([
                "status" => $response,
                "updated_at" => Carbon::now()
            ]);
    }

    public function getAllForUser(int $id)
    {
        return $invitations = DB::table("invitations")->where([['userId', $id], ['status', "pending"]])->get();
        // if ($invitations->isEmpty())
        //     return null;
        // foreach ($invitations as $invitation)
        //     //$invitations[] = DB::table('invitations')->where('id', $invitation->groupId)->first();
        // return $invitations;
    }
}
