<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class ChartReportController extends Controller
{
    public function view(){
        $dept_list = DB::table('departments')->get();
        return view('ChartReport.ChartReport-editor',compact('dept_list'));
    }
    public function getSchemes($id)
    {
        // TODO add a system to return a error message when the data cannot be loaded
        $schemes = DB::table('schemes')->where('department_id',$id)->get();
            return response()->json(['schemes' => $schemes ]);
    }
    public function generateResponse(Request $request){

        // return response($request);
        // Process the request data
        $type = $request->input('type');
        if($type=='chart')
        return $this->chart_request($request);
        else
        return $this->report_request($request);
    }

    private function chart_request(Request $request){
        
        $department = $request->input('department');
        $scheme = $request->input('scheme');
        $area = $request->input('area');
        $areaSelection = $request->input('areaSelection');
        $aadhaar = $request->input('aadhaar');
        $bank = $request->input('bank');
        $distributionType = $request->input('distributionType');
        $timeFrom = $request->input('timeFrom');
        $timeTo = $request->input('timeTo');
    }
    private function report_request(Request $request){
        $department = $request->input('department');
        $scheme = $request->input('scheme');
        $area = $request->input('area');
        $areaSelection = $request->input('areaSelection');
        $aadhaar = $request->input('aadhaar');
        $bank = $request->input('bank');
        $distributionType = $request->input('distributionType');
        $timeFrom = $request->input('timeFrom');
        $timeTo = $request->input('timeTo');

        $departmentName = $this->getDepartmentName($department);
        $schemeName = $this->getSchemeName($scheme);
        $distributionName = $this->getDistributionName($distributionType);
        /*
        $distributionType
        */
        $result = DB::table('beneficiaries');
        switch ($distributionType) {
            case 'areaWise':
                $result = $this->filterDepartment($department, $result);
                $result = $this->filterScheme($scheme, $result);
                $result = $this->filterAadhaar($aadhaar, $result);
                $result = $this->filterBank($bank, $result);  
                $result = $this->filterTime($timeFrom,$timeTo,$result);  
                switch ($area) {
                    case 'goa':break;
                    case 'district':
                        $result = $this->filterDistrict($areaSelection, $result);
                        break;
                    case 'taluka':
                        $result = $this->filterTaluka($areaSelection, $result);
                        // $result = $result->orderBy('taluka');
                        break;
                }
                $result = $result->select('name', 'district', 'taluka','aadhaar_seeded','bank_seeded')->get();
                $result = $this->substituteAadhaarBank($result);
                break;
            default:
                # code...
                break;
        }
        return view('ChartReport.chartReport-report-view',
        compact('result','departmentName','schemeName','area','areaSelection','aadhaar','bank','distributionType','timeFrom','timeTo','distributionName'));
    }
    private function filterAadhaar($aadhaar,$result) {
        switch($aadhaar){
            case 'both': 
                return $result;
            case 'seeded': 
                return $result->where('aadhaar_seeded', 1);
            case 'unseeded': 
                return $result->where('aadhaar_seeded', 0);
            default:
                return $result; // in case the value is unexpected
        }
    }
    private function filterBank($bank,$result) {
        switch($bank){
            case 'both': 
                return $result;
            case 'bankAcLinked': 
                return $result->where('bank_seeded', 1);
            case 'bankAcNotLinked': 
                return $result->where('bank_seeded', 0);
            default:
                return $result; // in case the value is unexpected
        }
    }
    private function filterDepartment($department,$result) {
        return $result->where('department_id', $department);
    }
    private function filterScheme($scheme,$result) {
        return $result->where('scheme_id', $scheme);
    }
    private function filterDistrict($district,$result) {
        $district = $district == 'northGoa' ? 'North Goa': 'South Goa';
        return $result->where('district', $district);
    }
    private function filterTime($timeFrom,$timeTo,$result) {
        // modify the given years to dates that can used
        $startDate = Carbon::createFromDate($timeFrom, 1, 1)->startOfYear();
        $endDate = Carbon::createFromDate($timeTo, 12, 31)->endOfYear();
        return $result->whereBetween('created_at', [$startDate, $endDate]);
    }
    private function filterTaluka($talukaList,$result) {
        return $result->whereIn('taluka', $talukaList);
    }
    private function getDepartmentName($id){
        return DB::table('departments')->where('id',$id)->select('name')->get()[0]->name;
    }
    private function getSchemeName($id){
        return DB::table('schemes')->where('id',$id)->select('name')->get()[0]->name;
    }
    private function getDistributionName($distributionType){
        switch ($distributionType)
        {
            case 'areaWise':return "Area Wise Distribution";
            case 'aadhaarSeed' : return "Aadhaar Seeded Distribution";
            case 'bankLinked' : return "Bank account linked Distribution";
            case 'maleFemale' : return "Male-Female Distribution";
            case 'beneficiaryCount' : return "Beneficiary Count";
            default:return "N/A";
        }
    }
    private function substituteAadhaarBank($result){
        foreach ($result as $row) {
            // Perform some operations on each item
            $row->aadhaar_seeded = $row->aadhaar_seeded == true ? 'Seeded' : ' Not Seeded';
            $row->bank_seeded = $row->bank_seeded == true ? 'Linked' : ' Not Linked';
        }
        return $result;
    }
}

