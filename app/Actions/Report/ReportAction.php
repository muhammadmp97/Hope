<?php

namespace App\Actions\Report;

use App\Models\Report;
use App\Models\User;

class ReportAction
{
    public function execute(User $reporterUser, array $data): Report
    {
        return Report::create([
            'reporter_id' => $reporterUser->id,
            'reportable_id' => $data['reportable_id'],
            'reportable_type' => $data['reportable_type'],
            'text' => $data['text'],
        ]);
    }
}
