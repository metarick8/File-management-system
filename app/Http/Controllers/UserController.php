<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Traits\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Response;

    protected $userService;

    public function __construct(UserService $userService)
    {
        //needs handling
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
}
