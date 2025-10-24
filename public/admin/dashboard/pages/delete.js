$(document).ready(function () {
    $(document).on("click", ".delete-button", function (e) {
        e.preventDefault();

        let button = $(this);
        let form = button.closest("form");
        let id = form.data("id");
        let action = form.attr("action");
        let token = form.find("input[name='_token']").val();

        Swal.fire({
            title: "هل أنت متأكد من هذه العملية؟",
            text: "لن تتمكن من استرجاع البيانات بعد الحذف!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ff5087",
            cancelButtonColor: "#d33",
            confirmButtonText: "نعم، احذف",
            cancelButtonText: "إلغاء",
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
                        $(`#row-${id}`).remove();
                        toastr.success("تم الحذف بنجاح");
                    },
                    error: function (xhr) {
                        toastr.error("حدث خطأ أثناء تنفيذ العملية");
                    },
                });
            }
        });
    });
});
