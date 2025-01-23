<?php

namespace App\Http\Controllers;

use App\Models\FileInfo;
use Illuminate\Http\Request;
use App\Traits\Response;
use Illuminate\Support\Facades\Storage;
use PDF;

class DownloadFileController extends Controller
{
    // use Response;
    public function __invoke($id)
    {
        $fileInfo = FileInfo::where("id", $id)->first();
        return Storage::disk('local')->download(FileInfo::first()->path);
    }

    public function generateFilePDF($data)
    {
        $pdf = Pdf::loadView('PDF_File_Template', ['data' => $data]);
        return $pdf->download('document.pdf');
    }

    public function generateGroupPDF($data)
    {
        $pdf = Pdf::loadView('PDF_Group_Template', ['data' => $data]);
        return $pdf->download('Group report.pdf');
    }
}
// return $this->success([
//     "file" => $file,
//     "test" => 'test'
// ], '');
