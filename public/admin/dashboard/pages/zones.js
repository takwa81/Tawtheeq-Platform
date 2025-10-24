$(document).ready(function () {

    const form = $("#zoneForm");
    const modal = $("#zoneModal");
    const submitButton = form.find("#submitButton");
    const modalTitle = $("#zoneModalLabel");
    const tableBody = $("#tableData");

    let isEdit = false;
    let editId = null;

    // Render a zone row
    function renderRow(zone) {
        return `
            <tr id="row-${zone.id}">
                <td>${zone.id}</td>
                <td>${zone.name_ar}</td>
                <td>${zone.name_en}</td>
                <td>
                    
                    <a href="javascript:void(0)" class="btn btn-md rounded font-sm edit-data"
                        data-id="${zone.id}" 
                        data-name_ar="${zone.name_ar}"
                        data-name_en="${zone.name_en}">
                        <i class="material-icons md-edit"></i>
                    </a>
                    <form class="d-inline delete-form" action="/dashboard/zones/${zone.id}" method="POST" data-id="${zone.id}">
                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-md bg-danger rounded font-sm delete-button">
                            <i class="material-icons md-delete"></i>
                        </button>
                    </form>
                
                </td>
            </tr>
        `;
    }

    // Edit button click
    $(document).on("click", ".edit-data", function () {
        isEdit = true;
        editId = $(this).data("id");

        modalTitle.text('تعديل المنطقة');
        submitButton.text('تحديث');

        form.find("#name_ar").val($(this).data("name_ar"));
        form.find("#name_en").val($(this).data("name_en"));
        form.find("#record_id").val(editId);

        form.attr("action", `/dashboard/zones/${editId}`);
        form.append('<input type="hidden" name="_method" value="PUT">');

        modal.modal("show");
    });

    // Form submission (create or update)
    form.on("submit", function (e) {
        e.preventDefault();

        submitButton.prop("disabled", true).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            ${isEdit ? 'جار التحديث' : 'جار الحفظ'}
        `);

        const formData = new FormData(this);

        // Make sure governorate_id is included
        formData.set('governorate_id', $("#governorate_id").val());

        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                const zone = res.data;

                const newRow = renderRow(zone);

                if (isEdit) {
                    $(`#row-${zone.id}`).replaceWith(newRow);
                    toastr.success('تم التحديث بنجاح');
                } else {
                    $("#noDataRow").remove();
                    tableBody.prepend(newRow);
                    toastr.success(res.message ?? 'تم الإنشاء بنجاح');
                }

                submitButton.prop("disabled", false).text(isEdit ? 'تحديث' : 'حفظ');

                form[0].reset();
                modal.modal("hide");
                isEdit = false;
                editId = null;
            },
            error: function (xhr) {
                submitButton.prop("disabled", false).text(isEdit ? 'تحديث' : 'حفظ');

                if (xhr.status === 422) {
                    displayErrors(xhr.responseJSON.errors);
                } else {
                    toastr.error(xhr.responseJSON.message ?? "خطأ غير متوقع");
                }
            }
        });
    });

    // Reset modal when closed
    modal.on("hidden.bs.modal", function () {
        isEdit = false;
        editId = null;

        form[0].reset();
        form.find('input[name="_method"]').remove();
        form.find("#record_id").val('');
        form.attr("action", "/dashboard/zones");

        modalTitle.text('إضافة منطقة جديدة');
        submitButton.text('حفظ');
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
