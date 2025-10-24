$(document).ready(function () {
    const form = $("#serviceTypeForm");
    const modal = $("#serviceTypeModal");
    const submitButton = form.find("#submitButton");
    const modalTitle = $("#serviceTypeModalLabel");
    const tableBody = $("#tableData");

    let isEdit = false;
    let editId = null;

    const tagSelect = document.getElementById("tags");
    const tagsChoices = new Choices(tagSelect, {
        removeItemButton: true,
        searchEnabled: true,
        placeholder: true,
        shouldSort: false,
    });

    // Create or update row
    function renderRow(type) {
        let tagsHtml = "";
        if (type.tags && type.tags.length > 0) {
            type.tags.forEach((tag) => {
                tagsHtml += `<span class="badge bg-main-bold mx-1 my-1">${tag.name_ar} - ${tag.name_en}</span>`;
            });
        }
        return `
            <tr id="row-${type.id}">
                <td>${type.id}</td>
                <td>${type.name_ar}</td>
                <td>${type.name_en}</td>
                <td>${tagsHtml}</td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-md rounded font-sm edit-data"
                        data-id="${type.id}" data-name_ar="${type.name_ar}"
                        data-name_en="${
                            type.name_en
                        }" data-tags='${JSON.stringify(type.tags.map((t) => t.id))}'>
                        <i class="material-icons md-edit"></i>
                    </a>
                <form class="d-inline delete-form" action="/dashboard/service_types/${
                    type.id
                }" method="POST" data-id="${type.id}">
                    <input type="hidden" name="_token" value="${$(
                        'meta[name="csrf-token"]'
                    ).attr("content")}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-md bg-danger rounded font-sm delete-button">
                        <i class="material-icons md-delete"></i>
                    </button>
                </form>

                </td>
            </tr>
        `;
    }

    // Edit button handler
    $(document).on("click", ".edit-data", function () {
        isEdit = true;
        editId = $(this).data("id");

        modalTitle.text("تعديل نوع الخدمة");
        submitButton.text("تحديث");

        form.find("#name_ar").val($(this).data("name_ar"));
        form.find("#name_en").val($(this).data("name_en"));
        let selectedTags = $(this).data("tags") || [];
        if (typeof selectedTags === "string")
            selectedTags = JSON.parse(selectedTags);

        selectedTags = selectedTags.map((tag) => tag.toString());

        tagsChoices.setChoiceByValue(selectedTags);

        console.log("tags", selectedTags);

        form.attr("action", `/dashboard/service_types/${editId}`);
        form.append('<input type="hidden" name="_method" value="PUT">');

        modal.modal("show");
    });

    // Form submission handler
    form.on("submit", function (e) {
        e.preventDefault();

        submitButton.prop("disabled", true).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            ${isEdit ? "جار التعديل" : "جار الحفظ"}
        `);

        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                const type = res.data;
                const newRow = renderRow(type);

                if (isEdit) {
                    $(`#row-${type.id}`).replaceWith(newRow);
                    toastr.success("تم التحديث بنجاح");
                } else {
                    $("#noDataRow").remove();
                    tableBody.prepend(newRow);
                    toastr.success(res.message ?? "تم الإنشاء بنجاح");
                }

                submitButton
                    .prop("disabled", false)
                    .text(isEdit ? "تعديل" : "حفظ");

                form[0].reset();
                modal.modal("hide");
            },
            error: function (xhr) {
                submitButton
                    .prop("disabled", false)
                    .text(isEdit ? "تعديل" : "حفظ");

                if (xhr.status === 422) {
                    displayErrors(xhr.responseJSON.errors);
                } else {
                    toastr.error(xhr.responseJSON.message ?? "خطأ غير متوقع");
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
        form.attr("action", "/dashboard/service_types");

        modalTitle.text("إضافة نوع خدمة جديد");
        submitButton.text("حفظ");
    });

    // Clear error messages on input
    $("input, select, textarea").on("input", function () {
        const field = $(this).attr("name");
        $(`#${field}Error`).empty();
    });

    // Show validation errors
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
