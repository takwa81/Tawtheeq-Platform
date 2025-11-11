$(document).ready(function () {
    const orderForm = $("#orderForm");
    const submitBtn = orderForm.find('button[type="submit"]');

    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, "0");
    const dd = String(today.getDate()).padStart(2, "0");
    const hh = String(today.getHours()).padStart(2, "0");
    const min = String(today.getMinutes()).padStart(2, "0");

    $("#date").val(`${yyyy}-${mm}-${dd}`);
    $("#time").val(`${hh}:${min}`);

    // --- Translation messages from Blade window object ---
    const trans = window.translations || {
        saving: "جارٍ الحفظ...",
        save: "حفظ",
        success: "تم حفظ الطلب بنجاح ✅",
        validation_error: "الرجاء تصحيح الأخطاء في النموذج ⚠️",
        unexpected_error: "حدث خطأ غير متوقع ❌",
    };

    // --- Ctrl + S submits the form ---
    $(document).on("keydown", function (e) {
        if (e.ctrlKey && e.key === "s") {
            e.preventDefault();
            orderForm.submit();
        }
    });

    // --- Handle form submit ---
    orderForm.on("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const actionUrl = orderForm.attr("action");

        submitBtn.prop("disabled", true).text(trans.saving);

        $(".invalid-feedback").remove();
        $(".is-invalid").removeClass("is-invalid");

        $.ajax({
            url: actionUrl,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                toastr.success(trans.success);
                setTimeout(() => {
                    window.location.href =
                        response.redirect_url ?? "/dashboard/orders";
                }, 1000);
            },
            error: function (xhr) {
                submitBtn.prop("disabled", false).text(trans.save);

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, messages) {
                        const input = $(`[name='${key}']`);
                        input.addClass("is-invalid");

                        const errorMsg = `<div class="invalid-feedback d-block mt-1">${messages[0]}</div>`;
                        input
                            .closest(".form-group, .col-md-6, .mb-3, div")
                            .append(errorMsg);
                    });

                    toastr.error(trans.validation_error);
                } else {
                    toastr.error(trans.unexpected_error);
                    console.error(xhr.responseText);
                }
            },
            complete: function () {
                submitBtn.prop("disabled", false).text(trans.save);
            },
        });
    });

    // --- Remove validation class & error message on input/select change ---
    $(document).on("input change", "input, select, textarea", function () {
        $(this).removeClass("is-invalid");
        $(this).siblings(".invalid-feedback").remove();
    });

    // --- Handle order image preview ---
    document.querySelectorAll('input[type="file"]').forEach(function (input) {
        input.addEventListener("change", function () {
            const preview = document.getElementById("preview-" + this.id);
            if (this.files && this.files[0] && preview) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result; // set preview image
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
});
