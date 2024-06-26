// Set new default font family and font color to mimic Bootstrap's default styling
(Chart.defaults.global.defaultFontFamily = "Nunito"),
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

var filter_value = "all";
var myLineChartmhl;
var myLineChartmam;
var myLineChartmhlNonCD;
var myLineChartmamNonCD;

function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + "").replace(",", "").replace(" ", "");
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
        dec = typeof dec_point === "undefined" ? "." : dec_point,
        s = "",
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return "" + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
}
if (window.location.pathname == "/home") {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        method: "GET",
        async: false,
        url: "/getLabels",
        success: function (result) {
            label = result;
        },
    });

    $.ajax({
        method: "GET",
        async: false,
        url: "/getNonCDLabels",
        success: function (result) {
            NonCDlabel = result;
        },
    });
    showLoadingIndicator();
    const delay = new Promise((resolve) => setTimeout(resolve, 1));
    delay.then(() => {
        mhl();
        mam();
        mhlNonCD();
        mamNonCD();
        hideLoadingIndicator();
    });

}

function filter(value) {
    showLoadingIndicator();
    const delay = new Promise((resolve) => setTimeout(resolve, 1));
    removeData(myLineChartmam);
    removeData(myLineChartmhl);
    removeData(myLineChartmhlNonCD);
    removeData(myLineChartmamNonCD);
    filter_value = value;
    delay.then(() => {
        mhl();
        mam();
        mhlNonCD();
        mamNonCD();
        hideLoadingIndicator();
    });
}

function mhl() {
    // Market Highs And Lows
    var ctx = document.getElementById("mhlChart");
    if (ctx != null) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            method: "GET",
            async: false,
            url: "/mhlChart/" + filter_value,
            success: function (result) {
                if(!result.message){
                    max = result.max;
                    min = result.min;
                    my = result.my;
                    dataset = [
                        {
                            label: "Market High",
                            lineTension: 0.3,
                            backgroundColor: "rgba(0, 0, 0, 0)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 1,
                            data: max,
                        },
                        {
                            label: "Market Low",
                            lineTension: 0.0,
                            backgroundColor: "rgba(0, 0, 0, 0)", // Example background color for the second line
                            borderColor: "rgba(255, 0, 0, 1)", // Example border color for the second line
                            pointRadius: 1,
                            pointBackgroundColor: "rgba(255, 99, 132, 1)", // Example point color for the second line
                            pointBorderColor: "rgba(255, 0, 0, 1)", // Example point border color for the second line
                            pointHoverRadius: 3,
                            // pointHoverBackgroundColor: "rgba(255, 99, 132, 1)", // Example point hover color for the second line
                            // pointHoverBorderColor: "rgba(255, 99, 132, 1)", // Example point hover border color for the second line
                            pointHitRadius: 10,
                            pointBorderWidth: 4,
                            data: min,
                        },
                    ];
                    if (my.length != 0) {
                        dataset.push({
                            label: "My Institute Data",
                            lineTension: 0.3,
                            backgroundColor: "rgba(0, 0, 0, 0)", // Example background color for the second line
                            borderColor: "rgba(0, 255, 0, 1)", // Example border color for the second line
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(0, 255, 0, 1)", // Example point color for the second line
                            pointBorderColor: "rgba(0, 255, 0, 1)", // Example point border color for the second line
                            pointHoverRadius: 3,
                            // pointHoverBackgroundColor: "rgba(255, 99, 132, 1)", // Example point hover color for the second line
                            // pointHoverBorderColor: "rgba(255, 99, 132, 1)", // Example point hover border color for the second line
                            pointHitRadius: 10,
                            pointBorderWidth: 4,
                            data: my,
                        });
                    }
                    myLineChartmhl = new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: label,
                            datasets: dataset,
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0,
                                },
                            },
                            scales: {
                                xAxes: [
                                    {
                                        time: {
                                            unit: "Rate",
                                        },
                                        gridLines: {
                                            display: true,
                                            drawBorder: true,
                                        },
                                        ticks: {
                                            beginAtZero: true,
                                            maxTicksLimit: 20,
                                            fontColor: "black",
                                            fontStyle: "bold",
                                        },
                                    },
                                ],
                                yAxes: [
                                    {
                                        scaleLabel: {
                                            display: true,
                                            labelString: "APY",
                                        },
                                        ticks: {
                                            maxTicksLimit: 13,
                                            beginAtZero: true,
                                            padding: 10,
                                            fontColor: "black",
                                            fontStyle: "bold",
                                            callback: function (value, index, values) {
                                                return number_format(value, 2);
                                            },
                                        },
                                        gridLines: {
                                            drawBorder: true,
                                            borderDash: [2],
                                            zeroLineBorderDash: [2],
                                        },
                                    },
                                ],
                            },
                            legend: {
                                display: true,
                            },
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: "#6e707e",
                                titleFontSize: 14,
                                borderColor: "#dddfeb",
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                intersect: false,
                                mode: "index",
                                caretPadding: 10,
                                callbacks: {
                                    label: function (tooltipItem, chart) {
                                        var datasetLabel =
                                            chart.datasets[tooltipItem.datasetIndex]
                                                .label || "";
                                        return (
                                            datasetLabel +
                                            ": " +
                                            number_format(tooltipItem.yLabel, 2)
                                        );
                                    },
                                },
                            },
                        },
                    });
                }else{
                    var parentDiv = document.getElementById("allGraphs");
                    if (parentDiv) {
                        parentDiv.parentNode.removeChild(parentDiv);
                    }
                }
            },
        });
    }
}
function mam() {
    // //Market Averages And Medians
    var ctx = document.getElementById("mamChart");
    if (ctx != null) {
        ctx.getContext("2d").clearRect(0, 0, ctx.width, ctx.height);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            method: "GET",
            async: false,
            url: "/mamChart/" + filter_value,
            success: function (result) {
                if(!result.message){
                    average = result.avg;
                    median = result.med;
                    my = result.my;
                    dataset = [
                        {
                            label: "Average",
                            lineTension: 0.3,
                            backgroundColor: "rgba(0, 0, 0, 0)",
                            borderColor: "rgba(255, 0, 0, 1)",
                            pointRadius: 3,
                            pointHoverBackgroundColor: "rgba(255, 99, 132, 1)", // Example point hover color for the second line
                            pointHoverBorderColor: "rgba(255, 99, 132, 1)", // Example point hover border color for the second line
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 1,
                            data: average,
                        },
                        {
                            label: "Median",
                            lineTension: 0.3,
                            backgroundColor: "rgba(0, 0, 0, 0)", // Example background color for the second line
                            borderColor: "rgba(78, 115, 223, 1)", // Example border color for the second line
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(255, 99, 132, 1)", // Example point color for the second line
                            pointBorderColor: "rgba(255, 99, 132, 1)", // Example point border color for the second line
                            pointHoverRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 1,
                            data: median,
                        },
                    ];
                    if (my.length != 0) {
                        dataset.push({
                            label: "My Institute Data",
                            lineTension: 0.3,
                            backgroundColor: "rgba(0, 0, 0, 0)", // Example background color for the second line
                            borderColor: "rgba(0, 255, 0, 1)", // Example border color for the second line
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(0, 255, 0, 1)", // Example point color for the second line
                            pointBorderColor: "rgba(0, 255, 0, 1)", // Example point border color for the second line
                            pointHoverRadius: 3,
                            // pointHoverBackgroundColor: "rgba(255, 99, 132, 1)", // Example point hover color for the second line
                            // pointHoverBorderColor: "rgba(255, 99, 132, 1)", // Example point hover border color for the second line
                            pointHitRadius: 10,
                            pointBorderWidth: 4,
                            data: my,
                        });
                    }
                    myLineChartmam = new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: label,
                            datasets: dataset,
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0,
                                },
                            },
                            scales: {
                                xAxes: [
                                    {
                                        time: {
                                            unit: "Rate",
                                        },
                                        gridLines: {
                                            display: true,
                                            drawBorder: true,
                                        },
                                        ticks: {
                                            beginAtZero: true,
                                            maxTicksLimit: 20,
                                            fontColor: "black",
                                            fontStyle: "bold",
                                        },
                                    },
                                ],
                                yAxes: [
                                    {
                                        scaleLabel: {
                                            display: true,
                                            labelString: "APY",
                                        },
                                        ticks: {
                                            maxTicksLimit: 13,
                                            padding: 10,
                                            // Include a dollar sign in the ticks
                                            callback: function (value, index, values) {
                                                return number_format(value, 2);
                                            },
                                            fontColor: "black",
                                            fontStyle: "bold",
                                        },
                                        gridLines: {
                                            drawBorder: true,
                                            borderDash: [2],
                                            zeroLineBorderDash: [2],
                                        },
                                    },
                                ],
                            },
                            legend: {
                                display: true,
                            },
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: "#6e707e",
                                titleFontSize: 14,
                                borderColor: "#dddfeb",
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                intersect: false,
                                mode: "index",
                                caretPadding: 10,
                                callbacks: {
                                    label: function (tooltipItem, chart) {
                                        var datasetLabel =
                                            chart.datasets[tooltipItem.datasetIndex]
                                                .label || "";
                                        return (
                                            datasetLabel +
                                            ": " +
                                            number_format(tooltipItem.yLabel, 2)
                                        );
                                    },
                                },
                            },
                        },
                    });
                }
            },
        });
    }
}

function mhlNonCD() {
    // NON CD Market Highs And Lows
    var ctx = document.getElementById("mhlChartNonCD");
    if (ctx != null) {
        ctx.getContext("2d").clearRect(0, 0, ctx.width, ctx.height);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            method: "GET",
            async: false,
            url: "/mhlChartNonCD/" + filter_value,
            success: function (result) {
                if(!result.message){
                    max = result.max;
                    min = result.min;
                    my = result.my;
                    dataset = [
                        {
                            label: "Market High",
                            lineTension: 0.3,
                            backgroundColor: "rgba(0, 0, 0, 0)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 1,
                            data: max,
                        },
                        {
                            label: "Market Low",
                            lineTension: 0.0,
                            backgroundColor: "rgba(0, 0, 0, 0)", // Example background color for the second line
                            borderColor: "rgba(255, 0, 0, 1)", // Example border color for the second line
                            pointRadius: 1,
                            pointBackgroundColor: "rgba(255, 99, 132, 1)", // Example point color for the second line
                            pointBorderColor: "rgba(255, 0, 0, 1)", // Example point border color for the second line
                            pointHoverRadius: 3,
                            // pointHoverBackgroundColor: "rgba(255, 99, 132, 1)", // Example point hover color for the second line
                            // pointHoverBorderColor: "rgba(255, 99, 132, 1)", // Example point hover border color for the second line
                            pointHitRadius: 10,
                            pointBorderWidth: 4,
                            data: min,
                        },
                    ];
                    if (my.length != 0) {
                        dataset.push({
                            label: "My Institute Data",
                            lineTension: 0.3,
                            backgroundColor: "rgba(0, 0, 0, 0)", // Example background color for the second line
                            borderColor: "rgba(0, 255, 0, 1)", // Example border color for the second line
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(0, 255, 0, 1)", // Example point color for the second line
                            pointBorderColor: "rgba(0, 255, 0, 1)", // Example point border color for the second line
                            pointHoverRadius: 3,
                            // pointHoverBackgroundColor: "rgba(255, 99, 132, 1)", // Example point hover color for the second line
                            // pointHoverBorderColor: "rgba(255, 99, 132, 1)", // Example point hover border color for the second line
                            pointHitRadius: 10,
                            pointBorderWidth: 4,
                            data: my,
                        });
                    }
                    myLineChartmhlNonCD = new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: NonCDlabel,
                            datasets: dataset,
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0,
                                },
                            },
                            scales: {
                                xAxes: [
                                    {
                                        time: {
                                            unit: "Rate",
                                        },
                                        gridLines: {
                                            display: true,
                                            drawBorder: true,
                                        },
                                        ticks: {
                                            beginAtZero: true,
                                            maxTicksLimit: 20,
                                            fontColor: "black",
                                            fontStyle: "bold",
                                        },
                                    },
                                ],
                                yAxes: [
                                    {
                                        scaleLabel: {
                                            display: true,
                                            labelString: "APY",
                                        },
                                        ticks: {
                                            maxTicksLimit: 13,
                                            beginAtZero: true,
                                            padding: 10,
                                            callback: function (value, index, values) {
                                                return number_format(value, 2);
                                            },
                                            fontColor: "black",
                                            fontStyle: "bold",
                                        },
                                        gridLines: {
                                            drawBorder: true,
                                            borderDash: [2],
                                            zeroLineBorderDash: [2],
                                        },
                                    },
                                ],
                            },
                            legend: {
                                display: true,
                            },
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: "#6e707e",
                                titleFontSize: 14,
                                borderColor: "#dddfeb",
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                intersect: false,
                                mode: "index",
                                caretPadding: 10,
                                callbacks: {
                                    label: function (tooltipItem, chart) {
                                        var datasetLabel =
                                            chart.datasets[tooltipItem.datasetIndex]
                                                .label || "";
                                        return (
                                            datasetLabel +
                                            ": " +
                                            number_format(tooltipItem.yLabel, 2)
                                        );
                                    },
                                },
                            },
                        },
                    });
                }
            },
        });
    }
}

function mamNonCD() {
    // NON CD Market Averages And Medians
    var ctx = document.getElementById("NonCDmamChart");
    if (ctx != null) {
        ctx.getContext("2d").clearRect(0, 0, ctx.width, ctx.height);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            method: "GET",
            async: false,
            url: "/mamChartNonCD/" + filter_value,
            success: function (result) {
                if(!result.message){
                    average = result.avg;
                    median = result.med;
                    my = result.my;
                    dataset = [
                        {
                            label: "Average",
                            lineTension: 0.3,
                            backgroundColor: "rgba(0, 0, 0, 0)",
                            borderColor: "rgba(255, 0, 0, 1)",
                            pointRadius: 3,
                            pointHoverBackgroundColor: "rgba(255, 99, 132, 1)", // Example point hover color for the second line
                            pointHoverBorderColor: "rgba(255, 99, 132, 1)", // Example point hover border color for the second line
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 1,
                            data: average,
                        },
                        {
                            label: "Median",
                            lineTension: 0.3,
                            backgroundColor: "rgba(0, 0, 0, 0)", // Example background color for the second line
                            borderColor: "rgba(78, 115, 223, 1)", // Example border color for the second line
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(255, 99, 132, 1)", // Example point color for the second line
                            pointBorderColor: "rgba(255, 99, 132, 1)", // Example point border color for the second line
                            pointHoverRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 1,
                            data: median,
                        },
                    ];
                    if (my.length != 0) {
                        dataset.push({
                            label: "My Institute Data",
                            lineTension: 0.3,
                            backgroundColor: "rgba(0, 0, 0, 0)", // Example background color for the second line
                            borderColor: "rgba(0, 255, 0, 1)", // Example border color for the second line
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(0, 255, 0, 1)", // Example point color for the second line
                            pointBorderColor: "rgba(0, 255, 0, 1)", // Example point border color for the second line
                            pointHoverRadius: 3,
                            // pointHoverBackgroundColor: "rgba(255, 99, 132, 1)", // Example point hover color for the second line
                            // pointHoverBorderColor: "rgba(255, 99, 132, 1)", // Example point hover border color for the second line
                            pointHitRadius: 10,
                            pointBorderWidth: 4,
                            data: my,
                        });
                    }
                    myLineChartmamNonCD = new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: NonCDlabel,
                            datasets: dataset,
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0,
                                },
                            },
                            scales: {
                                xAxes: [
                                    {
                                        time: {
                                            unit: "Rate",
                                        },
                                        gridLines: {
                                            display: true,
                                            drawBorder: true,
                                        },
                                        ticks: {
                                            beginAtZero: true,
                                            maxTicksLimit: 20,
                                            fontColor: "black",
                                            fontStyle: "bold",
                                        },
                                    },
                                ],
                                yAxes: [
                                    {
                                        scaleLabel: {
                                            display: true,
                                            labelString: "APY",
                                        },
                                        ticks: {
                                            maxTicksLimit: 13,
                                            padding: 10,
                                            // Include a dollar sign in the ticks
                                            callback: function (value, index, values) {
                                                return number_format(value, 2);
                                            },
                                            fontColor: "black",
                                            fontStyle: "bold",
                                        },
                                        gridLines: {
                                            drawBorder: true,
                                            borderDash: [2],
                                            zeroLineBorderDash: [2],
                                        },
                                    },
                                ],
                            },
                            legend: {
                                display: true,
                            },
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: "#6e707e",
                                titleFontSize: 14,
                                borderColor: "#dddfeb",
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                intersect: false,
                                mode: "index",
                                caretPadding: 10,
                                callbacks: {
                                    label: function (tooltipItem, chart) {
                                        var datasetLabel =
                                            chart.datasets[tooltipItem.datasetIndex]
                                                .label || "";
                                        return (
                                            datasetLabel +
                                            ": " +
                                            number_format(tooltipItem.yLabel, 2)
                                        );
                                    },
                                },
                            },
                        },
                    });
                }
            },
        });
    }
}

function showLoadingIndicator() {
    document.getElementById("loadingIndicator").style.display = "block";
    document.getElementById("allGraphs").style.display = "none";
}

function hideLoadingIndicator() {
    document.getElementById("loadingIndicator").style.display = "none";
    document.getElementById("allGraphs").style.display = "flex";
}

function removeData(chart) {
    chart.data.datasets.forEach((dataset) => {
        while (dataset.data.length > 0) {
            dataset.data.pop();
        }
    });
    chart.update();
}
