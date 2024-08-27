<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Barryvdh\DomPDF\Facade\Pdf;

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

        
        $departmentName = $this->getDepartmentName($department);
        $schemeName = $this->getSchemeName($scheme);
        $distributionName = $this->getDistributionName($distributionType);

        $columnsList = ['name', 'district', 'taluka', 'gender', 'aadhaar_seeded','bank_seeded'];

        $result = DB::table('beneficiaries');
        $result = $this->filterDepartment($department, $result);
        $result = $this->filterScheme($scheme, $result);
        $result = $this->filterAadhaar($aadhaar, $result);
        $result = $this->filterBank($bank, $result);
        $result = $this->filterTime($timeFrom,$timeTo,$result);
        switch ($distributionType) {
            case 'areaWise':
                switch ($area) {
                    case 'state':{
                        $result = $result->selectRaw('YEAR(created_at) as year, COUNT(*) as total_records')
                                ->groupBy('year')->get();
                        $year = [];
                        $count = [];
                        foreach ($result as $row) {
                            $year[] = $row->year;
                            $count[] = $row->total_records;
                        }
                        return response()->json(
                            [
                                'data' =>[
                                    'labels' => $year,
                                    'datasets' => [
                                        [
                                            'label' => $areaSelection,
                                            'data' => $count,
                                        ]
                                    ]
                                ],
                                'title' => $distributionName
                            ]);
                    }
                    case 'district':{
                        $result = $result->selectRaw('YEAR(created_at) as year, COUNT(*) num,district ')->groupBy('district')->groupBy('year')->orderBy('year')->get();
                        $reorientedData = [
                            'labels' => [],
                            'datasets' => [],
                        ];
                        $districts = [];
                        $years = [];
                        foreach ($result as $item) {
                            $year = $item->year;
                            $district = $item->district;
                            $num = $item->num;
                            if (!in_array($year, $years)) {
                                $years[] = $year;
                            }
                            if (!isset($districts[$district])) {
                                $districts[$district] = array_fill(0, count($years), 0);
                            }
                            $yearIndex = array_search($year, $years);
                            $districts[$district][$yearIndex] = $num;
                        }
                        $reorientedData['labels'] = $years;
                        foreach ($districts as $district => $dataPoints) {
                            $reorientedData['datasets'][] = [
                                'label' => $district,
                                'data' => $dataPoints,
                            ];
                        }
                        
                        // print_r($reorientedData);
                        return response()->json(
                            [
                                'data' => $reorientedData,
                                'title' => $distributionName
                            ]);
                    }
                    case 'taluka':
                        $result = $result->selectRaw('YEAR(created_at) as year, COUNT(*) num,taluka ')->groupBy('taluka')->groupBy('year')->orderBy('year')->get();
                        $reorientedData = [
                            'labels' => [],
                            'datasets' => [],
                        ];
                        $talukas = [];
                        $years = [];
                        foreach ($result as $item) {
                            $year = $item->year;
                            $taluka = $item->taluka;
                            $num = $item->num;
                            if (!in_array($year, $years)) {
                                $years[] = $year;
                            }
                            if (!isset($talukas[$taluka])) {
                                $talukas[$taluka] = array_fill(0, count($years), 0);
                            }
                            $yearIndex = array_search($year, $years);
                            $talukas[$taluka][$yearIndex] = $num;
                        }
                        $reorientedData['labels'] = $years;
                        foreach($talukas as $taluka => $dataPoints) {
                            $reorientedData['datasets'][] = [
                                'label' => $taluka,
                                'data' => $dataPoints,
                            ];
                        }
                        return response()->json(
                            [
                                'data' =>$reorientedData,
                                'title' => $distributionName
                            ]);
                }
                break;
            case 'aadhaarSeed':$result = $result->orderBy('aadhaar_seeded');break;
            case 'bankLinked':$result = $result->orderBy('bank_seeded');break;
            case 'maleFemale':$result = $result->orderBy('gender');break;
            case 'beneficiaryCount':break;
        }
        
        // $result = $this->filterArea($area,$areaSelection,$result);
        // $result = $result->select('year','total_records',...$columnsList,)->get();
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
        $print = $request->input('print');

        $departmentName = $this->getDepartmentName($department);
        $schemeName = $this->getSchemeName($scheme);
        $distributionName = $this->getDistributionName($distributionType);

        $columnsList = ['name', 'district', 'taluka', 'gender', 'aadhaar_seeded','bank_seeded'];

        $result = DB::table('beneficiaries');
        $result = $this->filterDepartment($department, $result);
        $result = $this->filterScheme($scheme, $result);
        $result = $this->filterAadhaar($aadhaar, $result);
        $result = $this->filterBank($bank, $result);
        $result = $this->filterTime($timeFrom,$timeTo,$result);
        switch ($distributionType) {
            case 'areaWise':break;
            case 'aadhaarSeed':$result = $result->orderBy('aadhaar_seeded');break;
            case 'bankLinked':$result = $result->orderBy('bank_seeded');break;
            case 'maleFemale':$result = $result->orderBy('gender');break;
            case 'beneficiaryCount':break;
        }
        $result = $this->filterArea($area,$areaSelection,$result);
        $result = $result->select(...$columnsList)->get();
        $result = $this->substituteAadhaarBank($result);
        
        if ($print=='true') {
            $pdf = Pdf::loadView('ChartReport.chartReport-report-view',compact('result','departmentName','schemeName','area','areaSelection','aadhaar','bank','distributionType','timeFrom','timeTo','distributionName'));
            return $pdf->download('document.pdf');
        }
        else        
        return view('ChartReport.chartReport-report-view',compact('result','departmentName','schemeName','area','areaSelection','aadhaar','bank','distributionType','timeFrom','timeTo','distributionName'));
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
    private function filterArea($area,$areaSelection,$result){
        switch ($area) {
            case 'state':
                $result = $result->orderBy('district')->orderBy('taluka');
                break;
            case 'district':
                $result = $this->filterDistrict($areaSelection, $result);
                $result = $result->orderBy('district')->orderBy('taluka');
                break;
            case 'taluka':
                $result = $this->filterTaluka($areaSelection, $result);
                $result = $result->orderBy('district')->orderBy('taluka');
                break;
        }
        return $result;
    }
}