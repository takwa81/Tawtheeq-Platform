$(document).ready(function () {
    const form = $("#serviceForm");
    const modal = $("#serviceModal");
    const submitButton = form.find("#submitButton");
    const modalTitle = $("#serviceModalLabel");

    form.on("submit", function (e) {
        e.preventDefault();

        submitButton.prop("disabled", true).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            جاري الحفظ
        `);

        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                toastr.success(res.message ?? "تمت الإضافة بنجاح");

                form[0].reset();
                modal.modal("hide");

                if (res.edit_url) {
                    window.location.href = res.edit_url;
                }
            },
            error: function (xhr) {
                submitButton.prop("disabled", false).text("حفظ");

                if (xhr.status === 422) {
                    displayErrors(xhr.responseJSON.errors);
                } else {
                    toastr.error(xhr.responseJSON.message ?? "خطأ غير متوقع");
                }
            },
        });
    });

    modal.on("hidden.bs.modal", function () {
        form[0].reset();
        form.find('input[name="_method"]').remove();
        form.attr("action", "/dashboard/services");

        modalTitle.text("إضافة خدمة جديدة");
        submitButton.text("حفظ");
    });

    function displayErrors(errors) {
        for (const key in errors) {
            $(`#${key}Error`).html(`
                <div class="mt-1">
                    <small class="text-danger py-1 opacity-75" style="font-size: 12px;">
                        <i class="icon material-icons md-error_outline"></i>
                        ${errors[key][0]}
                    </small>
                </div>
            `);
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
 
    const saveBtn = document.getElementById("saveSocials");
    if (saveBtn) {
        saveBtn.addEventListener("click", function () {
            const socials = [];
            document
                .querySelectorAll("#socialMediaContainer .input-group")
                .forEach((group) => {
                    socials.push({
                        id: group.dataset.id,
                        link: group.querySelector(".social-link").value.trim(),
                    });
                });

            const serviceId = this.dataset.serviceId;
            const token = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content");

            fetch(`/dashboard/services/${serviceId}/socials`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                },
                body: JSON.stringify({ socials }),
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.status) {
                        toastr.success(data.message);
                    } else {
                        toastr.error("فشل في التحديث");
                    }
                })
                .catch((err) => {
                    console.error(err);
                    toastr.error("حدث خطأ غير متوقع");
                });
        });
    }

    
});
