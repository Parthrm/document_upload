let data_set_colors = [
    ["#e63462", "#9826d1", "#FE5F55", "#2532e8", "#ff9f1c"],
    ["#e63462aa", "#9826d1aa", "#FE5F55aa", "#2532e8aa", "#ff9f1caa"],
];

function random_list(min, max, size) {
    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    let randomNumbers = [];
    for (let i = 0; i < size; i++) {
        randomNumbers.push(getRandomInt(min, max)); // Change the range as needed
    }
    return randomNumbers;
}

let customCanvasBackgroundColor = {
    id: 'customCanvasBackgroundColor',
    beforeDraw: (chart, args, options) => {
      const {ctx} = chart;
      ctx.save();
      ctx.globalCompositeOperation = 'destination-over';
      ctx.fillStyle = options.color || '#99ffff';
      ctx.fillRect(0, 0, chart.width, chart.height);
      ctx.restore();
    }
  };


let options_pie = {
    plugins: {
        customCanvasBackgroundColor: {
            color: 'white',
          },
        datalabels: {
            color: '#000',
            font:{
                weight:"bold",
                size:18
            }
        },
        // title:{
        //     text:"Male-Female Distribution",
        //     display:true,
        //     color:"black",
        //     font:{
        //         weight:"bold",
        //         size:24
        //     }
        // },
        legend: {
            position: "right",
            labels: {
                color: "#333333",
            },
        },
    },
};

let options_line = {
    scales: {
        y: {
            title:{
                text:"Frequency",
                display:true,
                align:'center',
                color:'black',
                font:{
                    weight:"bold",
                }
            },

            beginAtZero: true,
            grid: {
                color: "#F0F0F0",
            },
            ticks: {
                color: "#333333",
            },
        },
        x: {
            grid: {
                color: "#F0F0F0",
            },
            ticks: {
                color: "#333333",
            },
        },
    },
    plugins: {
        customCanvasBackgroundColor: {
            color: 'white',
          },
        datalabels: {
            color: '#000',
            font:{
                weight:"bold",
                size:18
            }
          },
    
        // title:{
        //     text:"Male-Female Distribution",
        //     display:true,
        //     color:"black",
        //     font:{
        //         weight:"bold",
        //         size:24
        //     }
        // },

        legend: {
            position: "right",
            labels: {
                color: "#333333",
            },
        },
    },
};

let options_bar = {
    scales: {
        y: {
            title:{
                text:"Frequency",
                display:true,
                align:'center',
                color:'black',
                font:{
                    weight:"bold",
                }
            },
            beginAtZero: true,
            grid: {
                color: "#F0F0F0",
            },
            ticks: {
                color: "#333333",
            },
        },
        x: {
            grid: {
                color: "#F0F0F0",
            },
            ticks: {
                color: "#333333",
            },
        },
    },
    plugins: {
        datalabels: {
            color: '#000',
            font: {
                weight: "bold",
                size: 18
            }
        },
        // title: {
        //     text: "Male-Female Distribution",
        //     display: true,
        //     color: "black",
        //     font: {
        //         weight: "bold",
        //         size: 24
        //     }
        // },
        legend: {
            position: "right",
            labels: {
                color: "#333333",
            },
        },
        tooltip: {
            enabled: true,
        },
        customCanvasBackgroundColor: {
            color: '#fff', // Custom color for the background
        }
    },
};

let chart_obj;

function load_chart(chart_ele,type,data) {

    let data_copy = JSON.parse(JSON.stringify(data));

    try {
        chart_obj.destroy();
    } catch (error) {}

    color_loader(data_copy);
    switch (type) {
        case "bar":{
            for (let i = 0; i < data_copy.datasets.length; i++) {
                data_copy.datasets[i].borderWidth = 2;
            }
            // console.log(data_copy);
            chart_obj = new Chart(chart_ele, {
                type: "bar",
                data: data_copy,
                options: options_bar,
            });
            break;}
        case "line":{
            for (let i = 0; i < data_copy.datasets.length; i++) {
                data_copy.datasets[i].tension = 0.4;
                data_copy.datasets[i].borderColor =
                    data_set_colors[0][i % data_set_colors[0].length];
            }
            chart_obj = new Chart(chart_ele, {
                type: "line",
                data: data_copy,
                options: options_line,
            });
            break;}
        case "pie":{
            for (let i = 0; i < data_copy.datasets.length; i++) {
                data_copy.datasets[i].borderWidth = 3;
                data_copy.datasets[i].borderColor = "white";
            }
            chart_obj = new Chart(chart_ele, {
                type: "pie",
                data: data_copy,
                options: options_pie,
            });
            break;}
        case "doughnut":{
            for (let i = 0; i < data_copy.datasets.length; i++) {
                data_copy.datasets[i].borderWidth = 3;
                data_copy.datasets[i].borderColor = "white";
            }
            chart_obj = new Chart(chart_ele, {
                type: "doughnut",
                data: data_copy,
                options: options_pie,
            });
            break;}
        case "radar":{
            for (let i = 0; i < data_copy.datasets.length; i++) {
                data_copy.datasets[i].borderWidth = 3;
                data_copy.datasets[i].borderColor = "white";
            }
            chart_obj = new Chart(chart_ele, {
                type: "radar",
                data: data_copy,
                options: options_pie,
            });
            break;}
        case "polarArea":{
            for (let i = 0; i < data_copy.datasets.length; i++) {
                data_copy.datasets[i].borderWidth = 3;
                data_copy.datasets[i].borderColor = "white";
                data.datasets[i].backgroundColor = data_set_colors[0][i % data_set_colors[0].length]+"33";
                data.datasets[i].borderColor = data_set_colors[0][i % data_set_colors[0].length];
            }
            chart_obj = new Chart(chart_ele, {
                type: "polarArea",
                data: data_copy,
                options: options_pie,
            });
            break;}
        default:
            break;
    }
}

function color_loader(data) {
    for (let i = 0; i < data.datasets.length; i++) {
        data.datasets[i].backgroundColor =
            data_set_colors[1][i % data_set_colors[1].length];
        data.datasets[i].borderColor =
            data_set_colors[0][i % data_set_colors[0].length];
    }
}

function downloadPDF(){
    const canvas = document.getElementById('chart');
    const canvasImage = canvas.toDataURL('image/jpeg',1.0);
    let pdf = new jsPDF('landscape');
    pdf.setFontSize(20);
    pdf.addImage(canvasImage,'JPEG',15,15,280,150);
    pdf.save('chart.pdf');
}
Chart.register(ChartDataLabels);
Chart.register(customCanvasBackgroundColor);