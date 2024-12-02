<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function find(string $query)
    {
        $queryResult = User::where('name', 'like', '%' . $query . '%')
        ->where(function($query) {
            $query->where('id', '<>', auth()->id())
                ->orWhereNull('id');
        })
        ->get();
        return $queryResult;
    }
}
