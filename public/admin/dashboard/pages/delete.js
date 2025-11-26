$(document).ready(function () {
    $(document).on("click", ".delete-button", function (e) {
        e.preventDefault();

        let button = $(this);
        let form = button.closest("form");
        let id = form.data("id");
        let action = form.attr("action");
        let token = form.find("input[name='_token']").val();

        Swal.fire({
            title: window.translations.delete_confirm_title,
            text: window.translations.delete_confirm_text,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ff5087",
            cancelButtonColor: "#d33",
            confirmButtonText: window.translations.delete_confirm_yes,
            cancelButtonText: window.translations.delete_confirm_cancel,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: action,
                    type: "POST",
                    data: {
                        _token: token,
                        _method: "DELETE",
                    },
                    success: function (response) {
                        if (response.status === true) {
                            $(`#row-${id}`).remove();
                            toastr.success(window.translations.delete_success);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        let errorMessage =
                            xhr.responseJSON?.message ??
                            window.translations.delete_error;
                        toastr.error(errorMessage);
                    },
                });
            }
        });
    });
});
