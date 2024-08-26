<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{asset('js/jquery.js')}}"></script>
    <link href="{{asset('css/select2.css')}}" rel="stylesheet" />
    <script src="{{asset('js/select2.js')}}"></script>
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="{{asset('js/chart-report.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/better-scroll.css')}}">
    {{ view('components.charts.links') }}
    <title>Chart-Report</title>
</head>
<body class="" >
{{-- <body class="max-h-screen overflow-hidden" > --}}
    <div class="bg-gray-900 text-white">
        <div class="flex justify-between ">
            <div class="w-72 ">
                {{-- the control panel --}}
                <div class=" h-[90vh] overflow-y-scroll overflow-x-hidden better-scroll px-2">
                    {{-- what to generate --}}
                    <x-chartReport-control-panel-block title="Type">
                        <select id="resource-type" class="bg-gray-800 text-center text-white px-2 py-1 rounded-md w-full text-sm">
                            <option value="report">Report</option>
                            <option value="chart">Chart</option>
                        </select>
                    </x-chartReport-control-panel-block>
                    {{-- department selection --}}
                    <x-chartReport-control-panel-block title="Department">
                        <div class="w-full">
                            <select id="department" class="bg-gray-800 text-center text-white px-2 py-1 rounded-md w-full text-sm">
                                @foreach ($dept_list as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </x-chartReport-control-panel-block>
                    {{-- scheme selection --}}
                    <x-chartReport-control-panel-block title="Scheme">
                        <select id="scheme" class="bg-gray-800 text-center text-white px-2 py-1 rounded-md w-full text-sm">
                        </select>
                    </x-chartReport-control-panel-block>
                    {{-- time selection --}}
                    <x-chartReport-control-panel-block title="Time Duration">
                        <div class="flex flex-col justify-around relative space-x-4">
                            <label for="time-from" class=" flex flex-col text-white">
                                From Year:
                                <input type="number" name="time-from" id="time-from" class="text-white year-input bg-black">
                            </label>
                            <label for="time-to" class=" flex flex-col text-white">
                                To Year:
                                <input type="number" name="time-to" id="time-to" class="text-white year-input bg-black">
                            </label>
                        </div>
                    </x-chartReport-control-panel-block>
                    {{-- area selection --}}
                    <x-chartReport-control-panel-block title="Area Selection">
                        <div class="flex flex-wrap justify-around mb-2">
                            <x-chartReport-control-panel-radio-button text="State" id="state"/>
                            <x-chartReport-control-panel-radio-button text="District" id="district"/>
                            <x-chartReport-control-panel-radio-button text="Taluka" id="taluka"/>
                        </div>
                        
                        <select id="area-selection" class="bg-gray-800 text-center text-white w-full px-2 py-1 rounded-md text-sm mt-2 disabled:opacity-40">
                            <optgroup label="State" class="text-left" >
                                <option value="goa">Goa</option>
                            </optgroup>
                            <optgroup label="District" class="text-left" >
                                <option value="northGoa">North Goa</option>
                                <option value="southGoa">South Goa</option>
                            </optgroup>
                            <optgroup label="Taluka" class="text-left">
                                <option value="bardez">Bardez</option>
                                <option value="bicholim">Bicholim</option>
                                <option value="canacona">Canacona</option>
                                <option value="dharbandora">Dharbandora</option>
                                <option value="mormugao">Mormugao</option>
                                <option value="pernem">Pernem</option>
                                <option value="ponda">Ponda</option>
                                <option value="salcette">Salcette</option>
                                <option value="sanguem">Sanguem</option>
                                <option value="sattari">Sattari</option>
                                <option value="tiswadi">Tiswadi</option>
                                <option value="quepem">Quepem</option>
                            </optgroup>
                        </select>
                    </x-chartReport-control-panel-block>
                    {{-- aadhaar Seeded --}}
                    <x-chartReport-control-panel-block title="Aadhaar Seeded">
                        <select id="aadhaar" class="bg-gray-800 text-center text-white w-full px-2 py-1 rounded-md text-sm">
                            <option value="both">Both</option>
                            <option value="seeded">Aadhaar Seeded</option>
                            <option value="unseeded">Non Aadhaar Seeded</option>
                        </select>
                    </x-chartReport-control-panel-block>
                    {{-- Bank Linked --}}
                    <x-chartReport-control-panel-block title="Bank Linked">
                        <select id="bank" class="bg-gray-800 text-center text-white w-full px-2 py-1 rounded-md text-sm">
                            <option value="both">Both</option>
                            <option value="bankAcLinked">Bank Account linked</option>
                            <option value="bankAcNotLinked">Bank Account Not linked</option>
                        </select>
                    </x-chartReport-control-panel-block>
                    {{-- distribution type --}}
                    <x-chartReport-control-panel-block title="Distribution Type">
                        <select id="distribution-type" class="bg-gray-800 text-center text-white w-full px-2 py-1 rounded-md text-sm">
                            <option value="areaWise">Area Wise Distribution</option>
                            <option value="aadhaarSeed">Aadhaar Seeded Distribution</option>
                            <option value="bankLinked">Bank account linked Distribution</option>
                            <option value="maleFemale">Male-Female Distribution</option>
                            <option value="beneficiaryCount">Beneficiary Count</option>
                        </select>
                    </x-chartReport-control-panel-block>
                </div>
                {{-- generate button --}}
                <div class="h-[10vh] flex" >
                    <button class="bg-green-600 text-white w-5/6 py-2 m-auto rounded-md shadow-lg hover:bg-green-700 transition" id="gen_chart">
                        Generate Chart  
                    </button>
                </div>
            </div>
            <div class="flex-1 m-3 bg-gray-800 text-white flex flex-col p-4 rounded-lg shadow-lg ">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-4">
                    <div class="bg-slate-600 text-white text-center font-bold text-2xl py-3 " id="title">
                        Select options and Generate Chart
                    </div>
                    <div id="chart-holder" class="text-black relative ">
                        <span id="chart-text" class="absolute top-[50%] left-[40%] z-0">Generated Chart will be shown
                            here</span>
                        {{ view('components.charts.chart-renderer', ['id' => 'chart']) }}
                        <div class="w-5/6  text-wrap mx-auto bg-slate-400 p-2" id="output"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </html>
    <style>
        #years input[type="checkbox"] {
            display: none;
        }
    
        #years span {
            display: inline-block;
            text-transform: uppercase;
            border: 2px solid rgb(255, 0, 0);
            border-radius: 3px;
            color: rgb(255, 0, 0);
        }
    
        #years input[type="checkbox"]:checked+span {
            background-color: rgb(255, 0, 0);
            color: black;
        }
    
        .select2-container--default .select2-selection--single {
            background-color: #171717;
            border: 1px solid #646464;
            border-radius: 4px;
    
        }
    
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff;
            padding: 8px;
            text-align: center;
            line-height: 0.625rem;
        }
    
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            border-left: 1px solid #333;
        }
    
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #4d4d4da9;
        }
    
        .select2-dropdown {
            background-color: #f0f0f0;
            color: #000;
        }
    
        .select2-results__option {
            color: #333;
        }
    </style>
</body>
</html>