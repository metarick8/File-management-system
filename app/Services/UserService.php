<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function find($name)
    {

        $validator = Validator::make(
            ["name" => $name],
            [
                "name" => "required | string | max:255"
            ]
        );
        if ($validator->fails())
            return [
                "data" => '',
                "message" => $validator->errors()->first(),
                "code request" => 400
            ];
            return $this->userRepository->find($name);
    }
}
