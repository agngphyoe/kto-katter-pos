$(document).on('click', '.deleteAction', function(event) {
    event.preventDefault();

    var button = $(this);
    var routeName = button.data('route');
    var redirectRoute = button.data('redirect-route');
    onDelete(routeName, `/${redirectRoute}`);
});

function onDelete(routeName, returnRoute) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this record!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {

        if (result.isConfirmed) {
            $.ajax({
                url: routeName,
                type: 'DELETE',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        window.location.href = returnRoute;
                    });

                },
                error: function (response) {
                    console.log(response);
                    Swal.fire({
                        title: 'Error!',
                        text: response.status == 500 ? response.responseJSON.message : 'An error occurred while deleting.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                }
            });
        }
    });
}