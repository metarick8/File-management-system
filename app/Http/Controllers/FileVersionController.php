<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileVersionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            ''
        ]);

        //if file exists and I am the reserver then add this file


        // if file exists and I am not the reserver


        //if file doesn't exist


    }
    public function reserve() {}
    public function release() {}
}
