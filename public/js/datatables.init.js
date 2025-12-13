/*
 Template Name: Fonik - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesbrand
 File: Datatable js
 */

$(document).ready(function () {
    $(".datatable").DataTable({
        dom: "Bfrtip",
        responsive: true,
        buttons: [
            {
                extend: "print",
                exportOptions: {
                    columns: ":not(:last-child)",
                },
                footer: true,
            },
            {
                extend: "excel",
                exportOptions: {
                    columns: ":not(:last-child)",
                },
                footer: true,
            },
        ],
    });

    $(".custom-datatable").DataTable({
        dom: "Bfrtip",
        mColumns: "visible",
        searching: false,
        lengthChange: false,
        paging: false,
        ordering: false,
        info: false,
        buttons: [
            {
                extend: "print",
                exportOptions: {
                    columns: ":not(:last-child)",
                },
                footer: true,
            },
            {
                extend: "excel",
                exportOptions: {
                    columns: ":not(:last-child)",
                },
                footer: true,
            },
        ],
    });

    //Buttons examples
    $(".datatable-buttons").DataTable({
        dom: "Bfrtip",
        lengthChange: false,
        buttons: [
            {
                extend: "print",
                exportOptions: {
                    columns: ":not(:last-child)",
                },
                footer: true,
            },
            {
                extend: "excel",
                exportOptions: {
                    columns: ":not(:last-child)",
                },
                footer: true,
            },
        ],
    });
});
