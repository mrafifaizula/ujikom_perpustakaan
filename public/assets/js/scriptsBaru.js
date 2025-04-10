document.addEventListener("DOMContentLoaded", function () {
    var peminjamanData = window.chartData.peminjamanData || [];
    var bulanArray = window.chartData.bulanArray || [];

    var options = {
        series: [
            {
                name: "Peminjaman Selesai",
                data: peminjamanData,
            },
        ],
        chart: {
            height: 220,
            type: "line",
            zoom: {
                enabled: false,
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            curve: "straight",
        },
        title: {
            text: "Grafik Peminjaman",
            align: "left",
        },
        grid: {
            row: {
                colors: ["#f3f3f3", "transparent"],
                opacity: 0.5,
            },
        },
        xaxis: {
            categories: bulanArray,
        },
    };

    var chart = new ApexCharts(document.querySelector("#chartLine"), options);
    chart.render();
});

// chart bar
document.addEventListener("DOMContentLoaded", function () {
    var chartData = window.chartData; // Access the data passed from Blade

    var colors = ["#FF5733", "#33FF57", "#3357FF", "#F1C40F"];

    var options = {
        series: [
            {
                data: [
                    chartData.bukuCount,
                    chartData.penulisCount,
                    chartData.penerbitCount,
                    chartData.kategoriCount,
                ],
            },
        ],
        chart: {
            height: 220,
            type: "bar",
            events: {
                click: function (chart, w, e) {},
            },
        },
        colors: colors,
        plotOptions: {
            bar: {
                columnWidth: "45%",
                distributed: true,
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        title: {
            text: "Data Table",
            align: "left",
        },
        xaxis: {
            categories: ["Buku", "Penulis", "Penerbit", "Kategori"],
            labels: {
                style: {
                    colors: colors,
                    fontSize: "12px",
                },
            },
        },
    };

    // Create and render the chart
    var chart = new ApexCharts(document.querySelector("#chartBar"), options);
    chart.render();
});

$(document).ready(function () {
    $("#myTable1").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copyHtml5",
                text: '<i class="fas fa-copy"></i> Copy',
                title: "Data_Export",
                className: "btn btn-primary",
                exportOptions: {
                    columns: [0, 1],
                },
            },
            {
                extend: "excelHtml5",
                text: '<i class="fas fa-file-excel"></i> Excel',
                title: "Data_Export",
                className: "btn btn-success",
                exportOptions: {
                    columns: [0, 1], 
                },
            },
            {
                extend: "pdfHtml5",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                title: "Data_Export",
                className: "btn btn-danger",
                exportOptions: {
                    columns: [0, 1],
                },
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                title: "Data_Export",
                className: "btn btn-info",
                exportOptions: {
                    columns: [0, 1],
                },
            },
        ],
    });
});

$(document).ready(function () {
    $("#tableBuku").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copyHtml5",
                text: '<i class="fas fa-copy"></i> Copy',
                title: "Data_Export",
                className: "btn btn-primary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
            {
                extend: "excelHtml5",
                text: '<i class="fas fa-file-excel"></i> Excel',
                title: "Data_Export",
                className: "btn btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7], 
                },
            },
            {
                extend: "pdfHtml5",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                title: "Data_Export",
                className: "btn btn-danger",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                title: "Data_Export",
                className: "btn btn-info",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7],
                },
            },
        ],
    });
});

$(document).ready(function () {
    $("#tablePeminjaman").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copyHtml5",
                text: '<i class="fas fa-copy"></i> Copy',
                title: "Data_Export",
                className: "btn btn-primary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
            {
                extend: "excelHtml5",
                text: '<i class="fas fa-file-excel"></i> Excel',
                title: "Data_Export",
                className: "btn btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4], 
                },
            },
            {
                extend: "pdfHtml5",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                title: "Data_Export",
                className: "btn btn-danger",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                title: "Data_Export",
                className: "btn btn-info",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4],
                },
            },
        ],
    });
});
