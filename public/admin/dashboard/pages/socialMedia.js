$(document).ready(function () {
    const form = $("#socialMediaForm");
    const modal = $("#socialMediaModal");
    const submitButton = form.find("#submitButton");
    const modalTitle = $("#socialMediaModalLabel");
    const tableBody = $("#tableData");

    let isEdit = false;
    let editId = null;

    // Edit click event
    $(document).on("click", ".edit-data", function () {
        isEdit = true;
        editId = $(this).data("id");

        modalTitle.text("تعديل وسيلة تواصل");
        submitButton.text("تحديث");

        // تعبئة البيانات
        form.find("#name_ar").val($(this).data("name_ar"));
        form.find("#name_en").val($(this).data("name_en"));

        const imagePath = $(this).data("image");
        $("#previewImage").attr("src", imagePath);

        form.attr("action", `/dashboard/social_media/${editId}`);
        form.append('<input type="hidden" name="_method" value="PUT">');

        modal.modal("show");
    });

    // Form submission handler
    form.on("submit", function (e) {
        e.preventDefault();

        submitButton.prop("disabled", true).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            ${isEdit ? "جاري التحديث..." : "جاري الحفظ..."}
        `);

        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                const data = res.data;

                const newRow = `
                    <tr id="row-${data.id}">
                        <td>${data.id}</td>
                        <td>
                            <img src="${res.image_url}" alt="${data.name_ar}" class="rounded-circle" width="40" height="40">
                        </td>
                        <td>${data.name_ar}</td>
                        <td>${data.name_en}</td>
                        <td>
                            <a href="javascript:void(0)" 
                               class="btn btn-md rounded font-sm edit-data"
                               data-id="${data.id}"
                               data-name_ar="${data.name_ar}"
                               data-name_en="${data.name_en}"
                               data-image="${res.image_url}">
                                <i class="material-icons md-edit"></i>
                            </a>
                            <form class="d-inline delete-form" action="/dashboard/social_media/${data.id}" method="POST">
                                <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr("content")}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="button" class="btn btn-md bg-danger rounded font-sm delete-button">
                                    <i class="material-icons md-delete"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                `;

                if (isEdit) {
                    $(`#row-${data.id}`).replaceWith(newRow);
                    toastr.success("تم التحديث بنجاح");
                } else {
                    $("#noDataRow").remove();
                    tableBody.prepend(newRow);
                    toastr.success("تمت الإضافة بنجاح");
                }

                submitButton.prop("disabled", false).text(isEdit ? "تحديث" : "حفظ");

                form[0].reset();
                $("#previewImage").attr("src", "/assets/images/upload.svg"); // reset preview
                modal.modal("hide");
            },
            error: function (xhr) {
                submitButton.prop("disabled", false).text(isEdit ? "تحديث" : "حفظ");

                if (xhr.status === 422) {
                    displayErrors(xhr.responseJSON.errors);
                } else {
                    toastr.error("حدث خطأ غير متوقع");
                }
            },
        });
    });

    // Reset modal when closed
    modal.on("hidden.bs.modal", function () {
        isEdit = false;
        editId = null;

        form[0].reset();
        form.find('input[name="_method"]').remove();
        form.attr("action", "/dashboard/social_media");

        $("#previewImage").attr("src", "/assets/images/upload.svg");

        modalTitle.text("إضافة وسيلة تواصل جديدة");
        submitButton.text("حفظ");
    });

    // إزالة الأخطاء عند الكتابة
    $("input, textarea").on("input", function () {
        const field = $(this).attr("name");
        $(`#${field}Error`).empty();
    });

    // عرض الأخطاء
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

    // معاينة الصورة
    $("#imageInput").on("change", function (event) {
        const input = event.target;
        const preview = $("#previewImage");

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    });
});
