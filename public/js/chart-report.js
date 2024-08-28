$(document).ready(function() {

    // function to handle change of type element
    $('#resource-type').on('change',function(){
        if($(this).val()=='chart')
        {
            $('#gen_chart').text('Generate Chart');
            $('#chart-block').show();
        }
        else
        {
            $('#gen_chart').text('Generate Report');
            $('#chart-block').hide();
        }
    })

    // function to load the schemes 
    $('#department').on('change', function() {
        const selectedValue = $(this).val();
        const $select2 = $('#scheme');

        // Clear existing options
        $select2.empty();

        // API call to get the schemes
        $.ajax({
            url: '/chart-report/schemes/' + selectedValue,
            type: 'GET',
            success: function(response) {
                response.schemes.forEach(function(scheme) {
                    const $option = $('<option>').text(scheme.name).val(scheme.id);
                    $select2.append($option);
                });
            },
            error: function(error) {
                console.log("error occurred ->", error);
            }
        });
    });

    // Initial setup: Hide all option groups and disable the select input
    $('#area-selection').prop('disabled', true);
    $('#area-selection optgroup').hide();

    // Handle the 'State' radio button change event
    $('#state').change(function() {
        if ($(this).is(':checked')) {
            // Disable the select input when 'State' is selected
            $('#area-selection').prop('disabled', true);
            $('#area-selection optgroup').hide();
            $('#area-selection optgroup[label="State"]').show();
            $('#area-selection').prop('multiple', false);
        }
    });

    // Handle the 'District' radio button change event
    $('#district').change(function() {
        if ($(this).is(':checked')) {
            // Enable the select input and show only the 'District' optgroup
            $('#area-selection').prop('disabled', false);
            $('#area-selection').prop('multiple', false); // Disable multiple selection
            $('#area-selection optgroup').hide();
            $('#area-selection optgroup[label="District"]').show();
        }
    });

    // Handle the 'Taluka' radio button change event
    $('#taluka').change(function() {
        if ($(this).is(':checked')) {
            // Enable the select input, allow multiple selection, and show only the 'Taluka' optgroup
            $('#area-selection').prop('disabled', false);
            $('#area-selection').prop('multiple', true); // Enable multiple selection
            $('#area-selection optgroup').hide();
            $('#area-selection optgroup[label="Taluka"]').show();
        }
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

    $('#gen_chart').click(function() {
        if(front_end_checking()){
            load_result(false);
        }
    });

    function front_end_checking() {
        var area = $('input[name="area"]:checked').val();
        var areaSelection = $('#area-selection').val();
        var district_names = [ 'northGoa' , 'southGoa' ];
        var taluka_names = [ "bardez","bicholim","canacona","dharbandora","mormugao","pernem","ponda","salcette","sanguem","sattari","tiswadi","quepem"];
        // TODO do the taluka checking ones dont return the boolean value
        switch (area) {
            case 'state':break;
            case 'district':
                if(!district_names.includes(areaSelection))
                {
                    alert('Select a district to continue');
                    return false;
                }
                break;
            case 'taluka':
                if(district_names.includes(areaSelection) || areaSelection === 'goa')
                {
                    alert('Select a taluka to continue');
                    return false;
                }
                break;
            default: 
                alert('Please select a valid area');
                return false;
        }

        return true;
    }

    function load_result() {
        var data = {
            type: $('#resource-type').val(),
            department: $('#department').val(),
            scheme: $('#scheme').val(),
            area: $('input[name="area"]:checked').val(),
            areaSelection: $('input[name="area"]:checked').val() == 'state' ? 'goa' : $('#area-selection').val(),
            aadhaar: $('#aadhaar').val(),
            bank: $('#bank').val(),
            distributionType: $('#distribution-type').val(),
            timeFrom: $('#time-from').val(),
            timeTo: $('#time-to').val(),
            chartType: $('#chart-type').val(),
            print: false,
        };
        $.ajax({
            url: '/chart-report/result', // Replace with your actual endpoint
            type: 'GET',
            data: data,
            success: function(response) {
                console.log(response);
                console.log("Generated URL:", response.generatedUrl);
                // Handle the response from the server, e.g., update the chart
                if(data.type === 'report'){
                    $('#report-output').html(response);
                    $('#title').text('Report Generation');
                    $('#chart').hide();
                    $('#report-output').show();
                    data.print=true;
                    var fullUrl = window.location.origin + '/chart-report/result' + '?' + $.param(data);
                    $('#print').attr('href',fullUrl);
                    $('#print').show();
                }
                else{
                    $('#chart').show();
                    $('#title').text(response.title);
                    $('#report-output').hide();
                    load_chart(chartEle, $('#chart-type').val(), response.data);
                    $('#print').hide();
                }
                $('#chart-text').hide();
                // $('#output').text(JSON.stringify(response,null,2));
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }

    // load_chart(chartEle, 'bar', data);
    let chartEle = document.getElementById('chart').getContext('2d');
    // Trigger change event on page load to populate select2 initially
    $('#department').trigger('change');
    $('#distribution-type').trigger('change');
    $('#resource-type').trigger('change');
    $('#scheme').select2();
    $('#distribution-type').select2();
    $('#department').select2();
    $('#print').hide();
    // $('#area-selection').select2();

    // delete this code these lines set default values
    $("#state").prop("checked", true);
    $("#time-from").val(2020);
    $("#time-to").val(2024);
});