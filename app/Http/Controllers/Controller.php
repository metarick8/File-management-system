<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function failedResponse($data = '', $message = '', $code = 400 )
    {
        return [
            "data" => $data,
            "message" => $message,
            "code request" => $code
        ];
    }
}
