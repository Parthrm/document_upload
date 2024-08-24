<x-main_page>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <div class="bg-gray-900 text-white">
        <div class="min-h-screen flex justify-between p-4">
            <div class="w-72">
                <div class="border border-gray-600 rounded-lg p-3 my-3 shadow-lg">
                    <div class="text-center mb-3 font-bold text-lg">Department</div>
                    <div class="w-full">
                        <select id="department" class="bg-gray-800 text-white px-2 py-1 rounded-md w-full text-sm">
                            <option value="1">Department of Agricultural Research and Education</option>
                            <option value="2">Department of Agriculture and Farmers Welfare</option>
                            <option value="3">Department of Animal Husbandry and Dairying</option>
                            <option value="4">Department of Atomic Energy</option>
                            <option value="5">Department of BioTechnology</option>
                            <option value="6">Department of Chemicals and Petrochemicals</option>
                            <option value="7">Department of Commerce</option>
                            <option value="8">Department of Drinking Water and Sanitation</option>
                            <option value="9">Department of Empowerment of Persons with Disabilities</option>
                            <option value="10">Department of Ex Servicemen Welfare</option>
                            <option value="11">Department of Fertilizers</option>
                            <option value="12">Department of Financial Services</option>
                            <option value="13">Department of Fisheries</option>
                            <option value="14">Department of Food and Public Distribution</option>
                            <option value="15">Department of Health and Family Welfare</option>
                            <option value="16">Department of Health Research</option>
                            <option value="17">Department of Higher Education</option>
                            <option value="18">Department of Home</option>
                            <option value="19">Department of Internal Security</option>
                            <option value="20">Department of Jammu and Kashmir and Ladakh Affairs</option>
                            <option value="21">Department of Pharmaceuticals</option>
                            <option value="22">Department of Public Enterprises</option>
                            <option value="23">Department of Rural Development</option>
                            <option value="24">Department of School Education and Literacy</option>
                            <option value="25">Department of Science and Technology</option>
                            <option value="26">Department of Scientific and Industrial Research</option>
                            <option value="27">Department of Social Justice and Empowerment</option>
                            <option value="28">Department of Space</option>
                            <option value="29">Department of Sports</option>
                            <option value="20">Department of Water Resources, River Development and Ganga Rejuvenation</option>
                            <option value="31">Department of Youth Affairs</option>
                            <option value="32">Ministry of AYUSH</option>
                            <option value="33">Ministry of Culture</option>
                            <option value="34">Ministry of Development of North Eastern Region</option>
                            <option value="35">Ministry of Earth Science</option>
                            <option value="36">Ministry of Electronics and Information Technology</option>
                            <option value="37">Ministry of Environment Forest and Climate Change</option>
                            <option value="38">Ministry of External Affairs</option>
                            <option value="39">Ministry of Heavy Industries</option>
                            <option value="40">Ministry of Housing and Urban Affairs</option>
                            <option value="41">Ministry of Information and Broadcasting</option>
                            <option value="42">Ministry of Labour and Employment</option>
                            <option value="43">Ministry of Micro Small and Medium Enterprises</option>
                            <option value="44">Ministry of Minority Affairs</option>
                            <option value="45">Ministry of New and Renewable Energy</option>
                            <option value="46">Ministry of Petroleum and Natural Gas</option>
                            <option value="47">Ministry of Railways</option>
                            <option value="48">Ministry of Skill Development and Entrepreneurship</option>
                            <option value="49">Ministry of Statistics and Programme Implementation</option>
                            <option value="50">Ministry of Textiles</option>
                            <option value="51">Ministry of Tourism</option>
                            <option value="52">Ministry of Tribal Affairs</option>
                            <option value="53">Ministry of Women and Child Development</option>
                        </select>
                    </div>
                </div>
                <div class="border border-gray-600 rounded-lg p-3 my-3 shadow-lg">
                    <div class="text-center mb-3 font-bold text-lg">Scheme</div>
                    <select id="scheme" class="bg-gray-800 text-white px-2 py-1 rounded-md w-full text-sm">
                    </select>
                </div>
                <div class="border border-gray-600 rounded-lg p-3 my-3 shadow-lg">
                    <div class="text-center mb-3 font-bold text-lg">Distribution Type</div>
                    <select id="distribution-type" class="bg-gray-800 text-white w-full px-2 py-1 rounded-md text-sm">
                        <option value="1">Area Wise Distribution</option>
                        <option value="2">Aadhar Seeded Distribution</option>
                        <option value="3">Bank account linked Distribution</option>
                        <option value="4">Male-Female Distribution</option>
                        <option value="5">Beneficiary Count</option>
                    </select>
                </div>
                <div id="sub-distributions" class="border border-gray-600 rounded-lg p-3 my-3 shadow-lg">
                    <div class="text-center mb-3 font-bold text-lg">Sub Distributions</div>
                    <div id="area-selection">
                        <div class="font-semibold mb-2">Area Wise:</div>
                        <select id="area-type" class="bg-gray-800 text-white w-full px-2 py-1 rounded-md text-sm">
                            <option value="District">District</option>
                            <option value="Taluka">Taluka</option>
                            <option value="Urban-Rural">Urban-Rural</option>
                        </select>
                    </div>
                    <div id="graph-selection">
                        <div class="font-semibold mb-2">Graph Type:</div>
                        <select id="graph-type" class="bg-gray-800 text-white w-full px-2 py-1 rounded-md text-sm">
                            <option value="bar">Bar</option>
                            <option value="pie">Pie</option>
                            <option value="line">Line</option>
                            <option value="polarArea">Polar Area</option>
                            <option value="doughnut">Doughnut</option>
                            <option value="radar">Radar</option>
                        </select>
                    </div>
                </div>
                <button class="bg-green-600 text-white w-full py-2 rounded-md shadow-lg hover:bg-green-700 transition"
                    id="gen_chart">
                    Generate Chart
                </button>
                <button class="bg-blue-600 text-white w-full py-2 rounded-md shadow-lg hover:bg-blue-700 transition mt-4"
                    id="gen_report">
                    Generate Report
                </button>
    
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
                    </div>
                </div>
            </div>
        </div>
        {{ view('components.charts.links') }}
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
    
    <script>
        $(document).ready(function() {
    
            $('#department').on('change', function() {
                const selectedValue = $(this).val();
                const $select2 = $('#scheme');
    
                // Clear existing options
                $select2.empty();
    
                // API call to get the schemes
                $.ajax({
                    url: '/schemes/' + selectedValue,
                    type: 'GET',
                    success: function(response) {
                        response.schemes.forEach(function(scheme) {
                            const $option = $('<option>').text(scheme).val(scheme);
                            $select2.append($option);
                        });
                    },
                    error: function(error) {
                        console.log("error occurred ->", error);
                    }
                });
            });
    
            let data = {
                labels: ["2019-20", "2020-21", "2021-22", "2022-23", "2023-24"],
                datasets: [{
                        label: "Males",
                        data: random_list(1000, 2000, 5),
                        borderWidth: 2,
                    },
                    {
                        label: "Females",
                        data: random_list(1000, 2000, 5),
                        borderWidth: 2,
                    },
                ],
            };
    
            $('#distribution-type').on('change', function() {
                const selectedValue = $(this).val();
                if (selectedValue == 1) {
                    $('#area-selection').fadeIn(); // Animate the element's appearance
                } else {
                    $('#area-selection').fadeOut(); // Animate the element's disappearance
                }
            });
    
    
            $('#gen_chart').on('click', function() {
                const dept = $('#department').val();
                const scheme = $('#scheme').val();
                const distribution_type = $('#distribution-type').val();
                const area_type = $('#area-type').val();
    
                $.ajax({
                    url: '/chart-data',
                    type: 'GET',
                    headers: {
                        'Department': dept,
                        'Scheme': scheme,
                        'Distribution-Type': distribution_type,
                        'Area-Type': area_type
                    },
                    success: function(response) {
    
                        switch (distribution_type) {
                            case '1':
                                $('#title').text('Area Wise Distribution');
                                break;
                            case '2':
                                $('#title').text('Aadhar Seeded Distribution');
                                break;
                            case '3':
                                $('#title').text('Bank account linked Distribution');
                                break;
                            case '4':
                                $('#title').text('Male-Female Distribution');
                                break;
                            case '5':
                                $('#title').text('Time Beneficiary Count');
                                break;
                            default:
                                $('#title').text('Error occurred');
                        }
    
                        $('#chart-text').hide();
    
                        load_chart(chartEle, $('#graph-type').val(), response);
                    },
                    error: function(error) {
                        console.log("error occurred ->", error);
                    }
                });
    
            });
    
    
            let chartEle = document.getElementById('chart').getContext('2d');
            // load_chart(chartEle, 'bar', data);
            // Trigger change event on page load to populate select2 initially
            $('#department').trigger('change');
            $('#distribution-type').trigger('change');
            $('#scheme').select2();
            $('#distribution-type').select2();
            $('#department').select2();
            $('#area-type').select2();
            $('#graph-type').select2();
    
        });
        $('#gen_report').on('click', function() {
        const dept = $('#department').val();
        const scheme = $('#scheme').val();
        const distributionType = $('#distribution-type').val();
        const areaType = $('#area-type').val();
    
        // Open the report in a new tab
        window.open(
            `/generate-report?Department=${dept}&Scheme=${scheme}&Distribution-Type=${distributionType}&Area-Type=${areaType}`,
            '_blank'
        );
    });
    
    </script>
</x-main_page>
