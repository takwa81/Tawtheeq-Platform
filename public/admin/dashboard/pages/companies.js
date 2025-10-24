$(document).ready(function () {
    const form = $("#companyForm");
    const modal = $("#companyModal");
    const submitButton = form.find("#submitButton");
    const modalTitle = $("#companyModalLabel");
    const tableBody = $("#tableData");

    let isEdit = false;
    let editId = null;

    function renderRow(company, logo) {
        return `
            <tr id="row-${company.id}">
                <td>${company.id}</td>
                   <td>
                     <img src="${logo}" alt="${company.name_ar}" class="rounded-circle" width="40" height="40">
                </td>
                <td>${company.name_ar}</td>
                <td>${company.name_en}</td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-md rounded font-sm edit-data"
                        data-id="${company.id}"
                        data-name_ar="${company.name_ar}"
                        data-name_en="${company.name_en}"
                        data-logo = "${logo}">
                        <i class="material-icons md-edit"></i>
                    </a>

                    <form class="d-inline delete-form" action="/dashboard/companies/${
                        company.id
                    }" method="POST" data-id="${company.id}">
                        <input type="hidden" name="_token" value="${$(
                            'meta[name="csrf-token"]'
                        ).attr("content")}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-md bg-danger rounded font-sm delete-button">
                            <i class="material-icons md-delete"></i>
                        </button>
                    </form>

                    <a href="/dashboard/companies/${
                        company.id
                    }" class="btn btn-md bg-secondary rounded font-sm">
                        <i class="material-icons md-remove_red_eye"></i>
                    </a>
                </td>
            </tr>
        `;
    }

    // Handle edit
    $(document).on("click", ".edit-data", function () {
        isEdit = true;
        editId = $(this).data("id");

        modalTitle.text(dashboardLang.edit_company);
        submitButton.text(dashboardLang.edit);

        form.find("#name_ar").val($(this).data("name_ar"));
        form.find("#name_en").val($(this).data("name_en"));

        const imagePath = $(this).data("logo");
        $("#preview-imageInput").attr("src", imagePath);

        form.attr("action", `/dashboard/companies/${editId}`);
        form.append('<input type="hidden" name="_method" value="PUT">');

        modal.modal("show");
    });

    // Handle form submission
    form.on("submit", function (e) {
        e.preventDefault();

        submitButton.prop("disabled", true).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            ${isEdit ? dashboardLang.updating : dashboardLang.saving}
        `);

        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                const company = res.data;
                const logo = res.logo_url;
                const newRow = renderRow(company, logo);

                if (isEdit) {
                    $(`#row-${company.id}`).replaceWith(newRow);
                    toastr.success(dashboardLang.updated_successfully);
                } else {
                    $("#noDataRow").remove(); // remove "no data" row if exists
                    tableBody.prepend(newRow);
                    toastr.success(
                        res.message ?? dashboardLang.created_successfully
                    );
                }

                submitButton
                    .prop("disabled", false)
                    .text(isEdit ? dashboardLang.edit : dashboardLang.save);
                form[0].reset();
                modal.modal("hide");
            },
            error: function (xhr) {
                submitButton
                    .prop("disabled", false)
                    .text(isEdit ? dashboardLang.edit : dashboardLang.save);

                if (xhr.status === 422) {
                    displayErrors(xhr.responseJSON.errors);
                } else {
                    toastr.error(
                        xhr.responseJSON.message ??
                            dashboardLang.unexpected_error
                    );
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
        form.attr("action", "/dashboard/companies");

        modalTitle.text(dashboardLang.add_new_company);
        submitButton.text(dashboardLang.save);
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
