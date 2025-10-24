document.addEventListener("DOMContentLoaded", function () {
    const form = $("#serviceOwnerForm");
    const submitButton = $("#submitButton");
    const isEditPage = form.attr("method") === "POST" ? false : true;
 
    // Handle CTRL + S for form submission
    $(document).on("keydown", function (event) {
        if (event.ctrlKey && event.key === "s") {
            event.preventDefault();
            form.submit();
        }
    });

    // Handle form submission
    form.on("submit", function (e) {
        e.preventDefault();

        submitButton
            .prop("disabled", true)
            .html(
                `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ${
                    isEditPage ? "جارٍ التحديث..." : "جارٍ الحفظ..."
                }`
            );

        const formData = new FormData(this);

        $.ajax({
            type: form.attr("method"),
            url: form.attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                toastr.options.positionClass = "toast-bottom-right";
                toastr.success(response.message ?? "تم الحفظ بنجاح");
                // Redirect after saving/updating
                window.location.href = "/dashboard/service_owners";
            },
            error: function (xhr) {
                submitButton
                    .prop("disabled", false)
                    .html(isEditPage ? "تحديث" : "حفظ");

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    if (errors && Object.keys(errors).length > 0) {
                        const firstErrorKey = Object.keys(errors)[0];
                        const firstErrorMessage = errors[firstErrorKey][0];
                        toastr.options.positionClass = "toast-bottom-right";
                        toastr.error(firstErrorMessage);
                    }
                    displayErrors(xhr.responseJSON.errors);
                } else {
                    toastr.error("حدث خطأ غير متوقع، الرجاء المحاولة لاحقاً");
                }
            },
        });
    });

    function displayErrors(errors) {
        for (const key in errors) {
            $("#" + key + "Error").text(errors[key][0]);
        }
    }

    // Clear error when typing/selecting
    $("input, select, textarea").on("input change", function () {
        clearError($(this).attr("name"));
    });

    function clearError(name) {
        $("#" + name + "Error").empty();
    }

    // Preview image
    document.querySelectorAll('input[type="file"]').forEach(function (input) {
        input.addEventListener("change", function () {
            const preview = document.getElementById("preview-" + this.id);
            if (this.files && this.files[0] && preview) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
});
