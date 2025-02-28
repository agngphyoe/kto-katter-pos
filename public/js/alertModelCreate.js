function saveData(route, redirectRoute, formData) {
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        url: route,
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken, // Include the CSRF token in the headers
        },
        data: formData,
        success: function (response) {
            var swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    title: "my-title",
                    content: "text-primary",
                    confirmButton: "confirm-Button",
                },
                buttonsStyling: false,
            });

            swalWithBootstrapButtons
                .fire({
                    imageUrl: "/images/Done-rafiki.png",
                    imageAlt: "Custom Image",
                    imageWidth: 400,
                    imageHeight: 400,
                    title: "Success!",
                    text: "Your new key data has been successfully created",
                    icon: "info",
                    confirmButtonText: "Back to Main Page ->",
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        console.log(redirectRoute);
                        window.location.href = redirectRoute;
                    }
                });
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseJSON)
            var errors = xhr.responseJSON.errors;
            displayValidationErrors(errors);
        },
    });
}


function displayValidationErrors(errors) {
    console.log(errors)
    $(".text-red-500").empty(); // Clear previous error messages

    $.each(errors, function (field, messages) {
        var errorField = $('[name="' + field + '"]');
        var errorContainer = errorField.closest(".mb-4");

        errorContainer.find(".text-red-500").remove();

        $.each(messages, function (index, message) {
            errorContainer.append(
                '<p class="text-red-500 text-xs mt-1">* ' + message + "</p>"
            );
        });
    });
}
