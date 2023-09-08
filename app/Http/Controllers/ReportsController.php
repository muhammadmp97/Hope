<?php

namespace App\Http\Controllers;

use App\Actions\Report\ReportAction;
use App\Http\Requests\CreateReportRequest;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(CreateReportRequest $request, ReportAction $reportAction)
    {
        $reportAction->execute($request->user(), $request->all());

        return $this->created();
    }
}
