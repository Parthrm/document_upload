{{-- to import the chart use this view method --}}
{{view('components.charts.chart-renderer',['id'=>'chart1'])}}
{{view('components.charts.chart-renderer',['id'=>'chart2'])}}
{{view('components.charts.chart-renderer',['id'=>'chart3'])}}
{{view('components.charts.chart-renderer',['id'=>'chart4'])}}
{{view('components.charts.chart-renderer',['id'=>'chart5'])}}
{{view('components.charts.chart-renderer',['id'=>'chart6'])}}

{{-- to bring in the links for chart generation --}}
{{view('components.charts.links')}}


<script>
    // this actually needs to be a API call
    let data = {
        labels: ["2019-20", "2020-21", "2021-22", "2022-23", "2023-24"],
        datasets: [
            {
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

    // mandatory function
    window.addEventListener("DOMContentLoaded", function () {
        // get the chart ele
        let chart_ele1 = document.getElementById('chart1').getContext('2d');
        let chart_ele2 = document.getElementById('chart2').getContext('2d');
        let chart_ele3 = document.getElementById('chart3').getContext('2d');
        let chart_ele4 = document.getElementById('chart4').getContext('2d');
        let chart_ele5 = document.getElementById('chart5').getContext('2d');
        let chart_ele6 = document.getElementById('chart6').getContext('2d');

        // pass the chart element, the type and the data 
        load_chart(chart_ele1,'bar',data);
        load_chart(chart_ele2,'line',data);
        load_chart(chart_ele3,'pie',data);
        load_chart(chart_ele4,'doughnut',data);
        load_chart(chart_ele5,'polararea',data);
        load_chart(chart_ele6,'radar',data);
    });
</script>