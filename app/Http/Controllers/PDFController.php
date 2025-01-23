<?php

namespace App\Http\Controllers;

use App\Models\FileInfo;
use PDF;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $fileWithVersions = FileInfo::with(["file_versions.user", 'user', 'group'])->find(15);
        $data[] = [
            // 'Id' => $fileWithVersions->id,
            'Name' => $fileWithVersions->name,
            "Owner" => $fileWithVersions->user->name,
            "Group" => $fileWithVersions->group->name,
            "Status" => $fileWithVersions->isFree ? "Reserved" : "availabe",
            "Created at" => $fileWithVersions->created_at,
            "Versions" => $fileWithVersions->file_versions->map(function ($version) {
                return [
                    "Editor" => $version->user->name
                ];
            })->toArray() ?  : "No versions yet",
        ];
        
        $pdf = Pdf::loadView('PDFTemplate', ['data' => $data]);
        return $pdf->download('document.pdf');
    }
}
