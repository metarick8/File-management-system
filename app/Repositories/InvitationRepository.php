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
        DB::table("invitations")->insert([
            "userId" => $memberId,
            "groupId" => $groupId,
            "status" => "pending",
            "created_at" => Carbon::now()
        ]);
        return true;
    }

    public function accept(bool $accept, int $invitationId, int $groupId)
    {
<<<<<<< HEAD
        if ($accept)
        {
=======

        if ($accept) {
>>>>>>> test
            $response = "accepted";
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

<<<<<<< HEAD
=======
    public function getAllForUser(int $id)
    {
        return $invitations = DB::table("invitations")->where([['userId', $id], ['status', "pending"]])->get();
        // if ($invitations->isEmpty())
        //     return null;
        // foreach ($invitations as $invitation)
        //     //$invitations[] = DB::table('invitations')->where('id', $invitation->groupId)->first();
        // return $invitations;
    }
>>>>>>> test
}
