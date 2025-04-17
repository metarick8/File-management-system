<?php

namespace App\Http\Controllers;

use App\Services\InvitationService;
use App\Traits\Response;
use Exception;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    use Response;
    protected $invitationService;

    public function __construct(InvitationService $invitationService)
    {
        $this->middleware('auth:api');
        $this->invitationService = $invitationService;
    }
    public function sendInvite(Request $request)
    {
        $members = $this->invitationService->invite($request->all());
        if (is_array($members))
            if ($members["code request"] != 200)
                return $this->error($members["data"], $members["message"], $members["code request"]);
        return $this->success('', "Invitation has been sent");
    }
    public function invitationResponse(Request $request)
    {
<<<<<<< HEAD
=======
    
>>>>>>> test
        $response = $this->invitationService->invitationValidation($request->all());
        if (is_array($response))
            if ($response["code request"] != 200)
                return $this->error($response["data"], $response["message"], $response["code request"]);
        return $this->success('', "Invitation response has been saved");
    }

<<<<<<< HEAD
    public function show()
    {
        $invitations = $this->invitationService->show();
        if (empty($invitations))
            return $this->success('', "You don't have any invitations yet");
        return $this->success([
                 "invitations" => $invitations
=======
    public function showInvitationsForUser()
    {
        //throw new Exception("run time");
        $invitations = $this->invitationService->getInvitationsForUser();
        if (empty($invitations))
            return $this->success('', "You don't have any invitations yet");
        return $this->success([
            "invitations" => $invitations
>>>>>>> test
        ], 'Invitations for this user');
    }
}
