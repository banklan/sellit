<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Report;

class SellerReportController extends Controller
{
    public function reportSeller($id, Request $request)
    {
        $reporter = Auth::id();
        $reportee = intval($id);

        $this->validate($request, [
            'report' => 'required|max:500'
        ]);

        $report = new Report;
        $report->reporter_id = $reporter;
        $report->reportee_id = $reportee;
        $report->report = $request->report;
        $report->status = 0;
        $report->save();

        $new = Report::findOrFail($report->id);

        return response()->json($new, 200);
    }

    public function getReports($id)
    {
        $reports = Report::where(['reportee_id' => $id, 'status' => 1])->latest()->get();

        return response()->json($reports, 200);
    }

    public function update(Request $request, $id)
    {
    	$report = Report::findOrFail($id);

    	$this->validate($request, [
    		'report' => 'required|max:400'
    	]);

    	$report->update([
    		$report->report = $request->report
    	]);

    	return response()->json($report, 200);
    }

    public function destroy($id)
    {
    	$report = Report::findOrFail($id)->delete();

    	return response()->json(['Message' => 'report deleted', 200]);
    }
}
