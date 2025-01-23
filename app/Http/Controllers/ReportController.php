<?php

namespace App\Http\Controllers;

use App\Models\FileInfo;
use App\Models\FileVersion;
use App\Models\Group;
use App\Services\ReportService;
use App\Traits\Response;
use Illuminate\Http\Request;


class ReportController extends Controller
{
    use Response;
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        //$this->middleware('auth:api');
        $this->reportService = $reportService;
    }

    public function indexFile(FileInfo $file)
    {
        $data = $this->reportService->file($file->id);
        return app()[DownloadFileController::class]->generateFilePDF($data);
    }

    public function indexGroup(Group $group)
    {
        //this function will return all the members of this group and each member what did he edit in file versions

        return $data = $this->reportService->group($group->id);
        return app()[DownloadFileController::class]->generateGroupPDF($data);
    }

    public function export() {}
}
