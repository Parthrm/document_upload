<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function generateReport(Request $request)
    {
        // Capture the form selections from the request
        $department = $request->query('Department');
        $scheme = $request->query('Scheme');
        $distributionType = $request->query('Distribution-Type');
        $areaType = $request->query('Area-Type');

        // Fetch the data based on the selections
        $data = $this->fetchReportData($department, $scheme, $distributionType, $areaType);
        $departmentName = DB::table('departments')
        ->where('id', $department)
        ->value('name');

        // Convert date fields to Carbon instances
        $data = $data->map(function ($item) {
            $item->created_at = Carbon::parse($item->created_at);
            $item->updated_at = Carbon::parse($item->updated_at);
            return $item;
        });

        // Generate the PDF
        $pdf = PDF::loadView('reports.report', compact('data','departmentName', 'department', 'scheme', 'distributionType', 'areaType'));

        // Return the PDF as a download
        return $pdf->download('report.pdf');
        
    }

    private function fetchReportData($department, $scheme, $distributionType, $areaType)
    {
        return DB::table('beneficiaries')
            ->where('department_id', $department)
            ->where('scheme_name', $scheme)
            ->get();
    }
}
