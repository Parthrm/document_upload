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
        $reorientedData = ['labels' => [],'datasets' => [],];
        $years = [];
        switch ($distributionType) {
            case 'areaWise':{
                switch ($area) {
                    case 'state':{
                        $result = $result->selectRaw('YEAR(created_at) as year, COUNT(*) as total_records')
                                        ->groupBy('year')
                                        ->get();
                        $count = [];
                        foreach ($result as $row) {
                            $years[] = $row->year;
                            $count[] = $row->total_records;
                        }
                        $reorientedData['labels'] = $years;
                        $reorientedData['datasets'][] = [
                            'label' => $areaSelection,
                            'data' => $count,
                        ];
                        break;
                    }
                    case 'district':{
                        $result = $result->selectRaw('YEAR(created_at) as year, COUNT(*) num,district ')
                                        ->groupBy('district')
                                        ->groupBy('year')
                                        ->orderBy('year')
                                        ->get();

                        $districtList = ["North Goa","South Goa"];
                        foreach ($result as $item) {
                            $year = $item->year;
                            if (!in_array($year, $years)) {
                                $years[] = $year;
                            }
                        }
                        $reorientedData['labels'] = $years;
                        foreach ($districtList as $district) {
                            $reorientedData['datasets'][] = [
                                'label'=> $district,
                                'data' => array_fill(0, count($years), 0)
                            ];
                        }
                        foreach ($result as $item) {
                            $year = $item->year;
                            $district = $item->district;
                            $num = $item->num;
                            $year_index = array_search($year,$years);
                            $district_index = array_search($district,$districtList);
                            $reorientedData['datasets'][$district_index]['data'][$year_index]=$num;
                        }
                        break;
                    }
                    case 'taluka':{
                        $result =   $result ->selectRaw('YEAR(created_at) as year, COUNT(*) num,taluka ')
                                            ->groupBy('taluka')
                                            ->groupBy('year')
                                            ->orderBy('year')
                                            ->get();
                        $talukaList = ["Bardez","Bicholim","Canacona","Dharbandora","Mormugao","Pernem","Ponda","Quepem","Salcette","Sanguem","Sattari","Tiswadi",];
                        foreach ($result as $item) {
                            $year = $item->year;
                            if (!in_array($year, $years)) {
                                $years[] = $year;
                            }
                        }
                        $reorientedData['labels'] = $years;
                        foreach ($talukaList as $taluka) {
                            $reorientedData['datasets'][] = [
                                'label'=> $taluka,
                                'data' => array_fill(0, count($years), 0)
                            ];
                        }
                        foreach ($result as $item) {
                            $year = $item->year;
                            $taluka = $item->taluka;
                            $num = $item->num;
                            $year_index = array_search($year,$years);
                            $taluka_index = array_search($taluka,$talukaList);
                            $reorientedData['datasets'][$taluka_index]['data'][$year_index]=$num;
                        }
                        break;
                    }
                }
                break;
            }
            case 'aadhaarSeed':{
                $result = $result->selectRaw('YEAR(created_at) as year, COUNT(*) num,aadhaar_seeded')
                                ->groupBy('aadhaar_seeded')
                                ->groupBy('year')
                                ->orderBy('year')
                                ->get();
                $reorientedData['labels'] = ['Aadhaar Seeded','Not Aadhaar Seeded'];
                foreach ($result as $item) {
                    $year = $item->year;
                    if (!in_array($year, $years)) {
                        $years[] = $year;
                        $reorientedData['datasets'][] = [
                            'label' => "$year",
                            'data' => [0,0]
                        ];
                    }
                }
                foreach ($result as $item) {
                    $year = $item->year;
                    $aadhaar_seeded = $item->aadhaar_seeded;
                    $num = $item->num;
                    $aadhaar_seeded_index = array_search($year,$years);
                    $reorientedData['datasets'][$aadhaar_seeded_index]['data'][$aadhaar_seeded]=$num;
                }
                break;
            }
            case 'bankLinked':{
                $result = $result->selectRaw('YEAR(created_at) as year, COUNT(*) num,bank_seeded')
                                ->groupBy('bank_seeded')
                                ->groupBy('year')
                                ->orderBy('year')
                                ->get();
                $reorientedData['labels'] = ['Bank Seeded','Not Bank Seeded'];
                foreach ($result as $item) {
                    $year = $item->year;
                    if (!in_array($year, $years)) {
                        $years[] = $year;
                        $reorientedData['datasets'][] = [
                            'label' => "$year",
                            'data' => [0,0]
                        ];
                    }
                }
                foreach ($result as $item) {
                    $year = $item->year;
                    $bank_seeded = $item->bank_seeded;
                    $num = $item->num;
                    $bank_seeded_index = array_search($year,$years);
                    $reorientedData['datasets'][$bank_seeded_index]['data'][$bank_seeded]=$num;
                }
                break;
            }
            case 'gender':{
                $result = $result->selectRaw('YEAR(created_at) as year, COUNT(*) num,gender')
                                ->groupBy('gender')
                                ->groupBy('year')
                                ->orderBy('year')
                                ->get();
                $reorientedData['labels'] = ['Male','Female','Transgender'];
                $gender_index = ['Male'=>0,'Female'=>1,'Transgender'=>2];
                foreach ($result as $item) {
                    $year = $item->year;
                    if (!in_array($year, $years)) {
                        $years[] = $year;
                        $reorientedData['datasets'][] = [
                            'label' => "$year",
                            'data' => [0,0,0]
                        ];
                    }
                }
                foreach ($result as $item) {
                    $year = $item->year;
                    $gender = $item->gender;
                    $num = $item->num;
                    $year_index = array_search($year,$years);
                    $reorientedData['datasets'][$year_index]['data'][$gender_index[$gender]]=$num;
                }
                break;
            }
            case 'beneficiaryCount':{
                $result = $result->selectRaw('YEAR(created_at) as year, COUNT(*) num')
                                ->groupBy('year')
                                ->orderBy('year')
                                ->get();
                foreach ($result as $item) {
                    $year = $item->year;
                    $num = $item->num;
                    if (!in_array($year, $years)) {
                        $years[] = $year;
                        $reorientedData['datasets'][] = [
                            'label' => "$year",
                            'data' => [$num]
                        ];
                    }
                }
                $reorientedData['labels'] = ["Years"];
                break;
            }
        }
        return response()->json(
        [
            'data' =>$reorientedData,
            'title' => $distributionName
        ]);
    }
    private function report_request(Request $request){
        // fetch the url data
        $url = $request->fullUrl();
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

        // fetch the data from other tables
        $departmentName = $this->getDepartmentName($department);
        $schemeName = $this->getSchemeName($scheme);
        $distributionName = $this->getDistributionName($distributionType);
        
        // list of columns to be displayed in the report with their order 
        $columnsList = ['name', 'district', 'taluka', 'gender', 'aadhaar_seeded','bank_seeded'];
        $fetch_only_date = false;

        $result = DB::table('beneficiaries');
        $result = $this->filterDepartment($department, $result);
        $result = $this->filterScheme($scheme, $result);
        $result = $this->filterAadhaar($aadhaar, $result);
        $result = $this->filterBank($bank, $result);
        $result = $this->filterTime($timeFrom,$timeTo,$result);
        switch ($distributionType) {
            case 'areaWise':break;
            case 'aadhaarSeed':$result = $result->orderBy('aadhaar_seeded','DESC');break;
            case 'bankLinked':$result = $result->orderBy('bank_seeded','DESC');break;
            case 'gender':$result = $result->orderBy('gender');break;
            case 'beneficiaryCount':break;
        }
        $result = $this->filterArea($area,$areaSelection,$result);
        if($fetch_only_date){
            $result = $result->select(...$columnsList);
            $result = $result->selectRaw('DATE(created_at) as date');
        }
        else{
            $columnsList += ['create_at']; 
            $result = $result->select(...$columnsList);
            // $result = $result->select('create_at');
        }
        $result = $result->get();
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
            case 'gender' : return "Male-Female Distribution";
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