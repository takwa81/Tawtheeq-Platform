$(document).ready(function () {

    const form = $("#governorateForm");
    const modal = $("#governorateModal");
    const submitButton = form.find("#submitButton");
    const modalTitle = $("#governorateModalLabel");
    const tableBody = $("#tableData");

    let isEdit = false;
    let editId = null;

    // Render a governorate row
    function renderRow(governorate) {
        return `
            <tr id="row-${governorate.id}">
                <td>${governorate.id}</td>
                <td>${governorate.country.name_ar}</td>

                <td>${governorate.name_ar}</td>
                <td>${governorate.name_en}</td>
                <td>${governorate.zones_count}</td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-md rounded font-sm edit-data"
                        data-id="${governorate.id}" 
                        data-country_id="${governorate.country_id}"
                        data-name_ar="${governorate.name_ar}"
                        data-name_en="${governorate.name_en}">
                        <i class="material-icons md-edit"></i>
                    </a>
                    <form class="d-inline delete-form" action="/dashboard/governorates/${governorate.id}" method="POST" data-id="${governorate.id}">
                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-md bg-danger rounded font-sm delete-button">
                            <i class="material-icons md-delete"></i>
                        </button>
                    </form>
                    <a href="/dashboard/governorates/${governorate.id}" class="btn btn-md bg-secondary rounded font-sm">
                        <i class="material-icons md-remove_red_eye"></i>
                    </a>
                </td>
            </tr>
        `;
    }

    // Edit button handler
    $(document).on("click", ".edit-data", function () {
        isEdit = true;
        editId = $(this).data("id");

        modalTitle.text('تعديل محافظة');
        submitButton.text('تحديث');
        form.find("#country_id").val($(this).data("country_id"));
        form.find("#name_ar").val($(this).data("name_ar"));
        form.find("#name_en").val($(this).data("name_en"));

        form.attr("action", `/dashboard/governorates/${editId}`);
        form.append('<input type="hidden" name="_method" value="PUT">');

        modal.modal("show");
    });

    // Form submission
    form.on("submit", function (e) {
        e.preventDefault();

        submitButton.prop("disabled", true).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            ${isEdit ? 'جار التعديل' : 'جار الحفظ'}
        `);

        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                const governorate = res.data;
                console.log(governorate)
                const newRow = renderRow(governorate);

                if (isEdit) {
                    $(`#row-${governorate.id}`).replaceWith(newRow);
                    toastr.success('تم التحديث بنجاح');
                } else {
                    $("#noDataRow").remove();
                    tableBody.prepend(newRow);
                    toastr.success(res.message ?? 'تم الإنشاء بنجاح');
                }

                submitButton.prop("disabled", false).text(isEdit ? 'تعديل' :'حفظ');
                form[0].reset();
                modal.modal("hide");
            },
            error: function (xhr) {
                submitButton.prop("disabled", false).text(isEdit ? 'تعديل' :'حفظ');

                if (xhr.status === 422) {
                    displayErrors(xhr.responseJSON.errors);
                } else {
                    toastr.error(xhr.responseJSON.message ?? "خطأ غير متوقع");
                }
            }
        });
    });

    // Reset modal on close
    modal.on("hidden.bs.modal", function () {
        isEdit = false;
        editId = null;

        form[0].reset();
        form.find('input[name="_method"]').remove();
        form.attr("action", "/dashboard/governorates");

        modalTitle.text('إضافة محافظة جديدة');
        submitButton.text('حفظ');
    });

    // Clear validation errors on input
    $("input, select, textarea").on("input", function () {
        const field = $(this).attr("name");
        $(`#${field}Error`).empty();
    });

    // Display validation errors
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
