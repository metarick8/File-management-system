<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadFileController extends Controller
{
    public function __invoke()
    {
        return Storage::disk('local')->download();
    }
}
