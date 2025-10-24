$(document).ready(function () {
    $(document).on("click", ".restore-button", function (e) {
        e.preventDefault();

        let button = $(this);
        let form = button.closest("form");
        let id = form.data("id");
        let action = form.attr("action");
        let token = form.find("input[name='_token']").val();

        Swal.fire({
            title: "هل أنت متأكد من استرجاع هذا المستخدم؟",
            text: "سيتم استرجاع هذا المستخدم بالكامل!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#572972",
            cancelButtonColor: "#d33",
            confirmButtonText: "نعم، استرجاع",
            cancelButtonText: "إلغاء",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: action,
                    type: "POST",
                    data: {
                        _token: token
                    },
                    success: function (response) {
                        toastr.success("تم الاسترجاع بنجاح");

                        let url = window.location.href.split('?')[0];
                        window.location.href = url;
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON?.message ?? "حدث خطأ أثناء تنفيذ العملية");
                    },
                });
            }
        });
    });
});
