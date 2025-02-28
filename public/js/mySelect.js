// $(document).ready(function() {
//     $('#myselect').select2();
//     $('#myselect1').select2();
//     $('#myselect2').select2();
//     $('#myselect3').select2();
//     $('#myselect4').select2();
//     $('#myselect5').select2();
//     $('#myselect6').select2();
//     $('#myselect7').select2();
//     $('#myselect8').select2();
//     $('#myselect10').select2();
//     $('#create1').select2();
//     $('#create2').select2();
//     $('#create3').select2();
//     $('#create4').select2();
//     $('#create5').select2();
//     $('.select2').select2();

// });

$('select[name="division_id"]').change(function () {
    var division_id = $(this).val();

    getTownshipData(division_id);
});

function getTownshipData(division_id) {
    $.ajax({
        url: "/customer/get-township-data",
        type: "GET",
        dataType: "json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            division_id: division_id,
        },
        success: function (response) {
            $("#townshipSelect").html(response.html);

            $(".select2").select2();
        },
        error: function (xhr, status, error) {
            console.log(error);
        },
    });
}
