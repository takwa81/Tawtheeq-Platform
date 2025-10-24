$(document).ready(function () {
    const form = $("#attachmentForm");
    const modal = $("#uploadAttachmentModal");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    form.on("submit", function (e) {
        e.preventDefault();
        const serviceId = form.data("service-id");
        const submitButton = form.find("button[type='submit']");
        submitButton.prop("disabled", true).text("جارٍ الرفع...");
        form.find(".text-danger").html("");

        const formData = new FormData(this);

        $.ajax({
            url: `/dashboard/services/${serviceId}/attachments`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                toastr.success(res.message ?? "تم رفع المرفق بنجاح");

                const ext = res.attachment_file_name
                    .split(".")
                    .pop()
                    .toLowerCase();
                const isImage = ["jpg", "jpeg", "png", "gif", "webp"].includes(
                    ext
                );
                const isVideo = ["mp4", "mov", "avi", "mkv"].includes(ext);

                let previewHTML = "";
                if (isImage) {
                    previewHTML = `
                        <a href="${res.attachment_url}" target="_blank">
                            <img src="${res.attachment_url}" class="card-img-top rounded"
                                 alt="Attachment" style="height: 150px; object-fit: cover;">
                        </a>`;
                } else if (isVideo) {
                    previewHTML = `
                        <div class="d-flex justify-content-center align-items-center"
                             style="height:150px;background:#000;">
                            <i class="fa fa-play-circle text-white" style="font-size:40px;"></i>
                        </div>`;
                } else {
                    previewHTML = `
                        <div class="d-flex justify-content-center align-items-center"
                             style="height:150px;background:#f8f9fa;">
                            <i class="fa fa-file text-secondary" style="font-size:40px;"></i>
                        </div>`;
                }

                $("#attachmentsGallery").append(`
                    <div class="col-md-3 col-sm-4 col-6">
                        <div class="card shadow-sm position-relative">
                            ${previewHTML}
                            <div class="card-body text-center p-2">
                                <small class="text-muted d-block">${res.attachment_type}</small>
                                <button class="btn btn-sm btn-danger deleteAttachment mt-1"
                                        data-id="${res.attachment_id}">حذف</button>
                            </div>
                        </div>
                    </div>
                `);

                form[0].reset();
                modal.modal("hide");
                submitButton.prop("disabled", false).text("رفع");
            },
            error: function (xhr) {
                submitButton.prop("disabled", false).text("رفع");
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    for (const key in errors) {
                        $(`#${key}Error`).html(errors[key][0]);
                    }
                } else {
                    toastr.error(
                        xhr.responseJSON?.message ?? "حدث خطأ غير متوقع"
                    );
                }
            },
        });
    });

    $(document).on("click", ".deleteAttachment", function () {
        const attachmentId = $(this).data("id");
        const card = $(this).closest(".col-md-3");

        Swal.fire({
            title: "هل أنت متأكد من حذف هذا المرفق؟",
            text: "لن تتمكن من استرجاع البيانات بعد الحذف!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#572972",
            cancelButtonColor: "#d33",
            confirmButtonText: "نعم، احذف",
            cancelButtonText: "إلغاء",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/dashboard/services/attachments/${attachmentId}`,
                    type: "DELETE",
                    success: function (res) {
                        toastr.success(res.message ?? "تم الحذف بنجاح");
                        card.fadeOut(300, function () {
                            $(this).remove();
                        });
                    },
                    error: function (xhr) {
                        toastr.error(
                            xhr.responseJSON?.message ?? "حدث خطأ أثناء الحذف"
                        );
                    },
                });
            }
        });
    });

    modal.on("hidden.bs.modal", function () {
        form[0].reset();
        form.find(".text-danger").html("");
        form.find("button[type='submit']").prop("disabled", false).text("رفع");
    });
});
