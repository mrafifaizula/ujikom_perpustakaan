$(document).ready(function () {
    $("#tableProfil").DataTable({
        dom: "Bfrtip",
        buttons: [
            {
                extend: "copyHtml5",
                text: '<i class="fas fa-copy"></i> Copy',
                title: "Data_Export",
                className: "btn btn-primary",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
            {
                extend: "excelHtml5",
                text: '<i class="fas fa-file-excel"></i> Excel',
                title: "Data_Export",
                className: "btn btn-success",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
            {
                extend: "pdfHtml5",
                text: '<i class="fas fa-file-pdf"></i> PDF',
                title: "Data_Export",
                className: "btn btn-danger",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
            {
                extend: "print",
                text: '<i class="fas fa-print"></i> Print',
                title: "Data_Export",
                className: "btn btn-info",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                },
            },
        ],
    });
});

$(document).ready(function () {
    $("#tableDenda").DataTable({
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
