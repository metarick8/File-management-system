<?php

namespace App\Http\Controllers;

use App\Models\FileInfo;
use App\Services\FileService;
use App\Services\FileVersionService;
use App\Services\InvitationService;
use App\Services\UserService;
use App\Traits\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Response;
    protected $userService;

    public function __construct(UserService $userService,)
    {
        $this->middleware('auth:api');

        $this->userService = $userService;
    }

    public function search(Request $request)
    {
        $response  = $this->userService->find($request->input("name"));
        if (is_array($response))
            return $this->error($response["data"], $response["message"], $response["code request"]);
        else if ($response->isEmpty())
            return $this->success('', "User not found!");
        return $this->success($response, "User/s found");
    }

    public function notifications(InvitationService $invitationService, FileVersionService $fileVersionService, FileService $fileService)
    {

        $filesAcception = $fileService->notifications();
        $filesInfo = $fileVersionService->notifications();
        $invitations = $invitationService->show();

        return $this->success([
            "groupInvitations" => $invitations,
            "fileAcceptations" => $filesAcception,
            "filesInfor" => $filesInfo
        ], 'Invitations for this user');
    }
}
