$(document).ready(function () {
    $(document).on("click", ".change-password-btn", function () {
        const userId = $(this).data("id");

        $("#changePasswordForm #cp_user_id").val(userId);

        $("#changePasswordForm")[0].reset();
        $("#passwordError, #password_confirmationError").empty();

        $("#changePasswordModal").modal("show");
    });

    $("#changePasswordForm").on("submit", function (e) {
        e.preventDefault();

        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');

        submitBtn.prop("disabled", true).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> جاري الحفظ...
        `);

        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            success: function (res) {
                if (res.status) {
                    toastr.success(res.message);
                    $("#changePasswordModal").modal("hide");
                    form[0].reset();
                } else {
                    toastr.error(res.message);
                }

                submitBtn.prop("disabled", false).text("حفظ");
            },
            error: function (xhr) {
                submitBtn.prop("disabled", false).text("حفظ");

                if (xhr.status === 422) {
                    displayErrorsChangePassword(xhr.responseJSON.errors);
                } else {
                    toastr.error(
                        xhr.responseJSON.message ?? "حدث خطأ أثناء العملية"
                    );
                }
            },
        });
    });

    function displayErrorsChangePassword(errors) {
        for (const key in errors) {
            const errorId = `${key}Error`;
            const $errorEl = $("#changePasswordForm").find(`#${errorId}`);
            if ($errorEl.length) {
                $errorEl.html(`
                    <div class="mt-1">
                        <small class="text-danger py-1 opacity-75" style="font-size: 12px;">
                            <i class="icon material-icons md-error_outline"></i>
                            ${errors[key][0]}
                        </small>
                    </div>
                `);
            } else {
                console.warn("Error element not found:", errorId);
            }
        }
    }
});
