$(document).ready(function () {
    const form = $("#dataEntryForm");
    const modal = $("#dataEntryModal");
    const submitButton = form.find("#submitButton");
    const modalTitle = $("#dataEntryModalLabel");
    const tableBody = $("#tableData");

    let isEdit = false;
    let editId = null;

    // Render table row
    function renderRow(user, branches_count) {
        return `
            <tr id="row-${user.id}">
                <td>${user.id}</td>
                <td>${user.full_name}</td>
                <td>${user.phone}</td>
                <td>${user.account_status_badge}</td>
                <td>${branches_count}</td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-md rounded font-sm edit-data"
                        data-id="${user.id}"
                        data-email="${user.email}"
                        data-full_name="${user.full_name}"
                        data-phone="${user.phone}">
                        <i class="material-icons md-edit"></i>
                    </a>
                    <form class="d-inline delete-form"
                          action="/dashboard/branch_managers/${user.id}"
                          method="POST" data-id="${user.id}">
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

    // 🧩 Edit button handler
    $(document).on("click", ".edit-data", function () {
        isEdit = true;
        editId = $(this).data("id");

        modalTitle.text(window.trans.edit_branch_manager);
        submitButton.text(window.trans.update);

        form.find("#email").val($(this).data("email"));
        form.find("#full_name").val($(this).data("full_name"));
        form.find("#phone").val($(this).data("phone"));

        // Hide password fields
        $("#password").closest(".col-md-6").hide();
        $("#password_confirmation").closest(".col-md-6").hide();

        form.attr("action", `/dashboard/branch_managers/${editId}`);
        form.append('<input type="hidden" name="_method" value="PUT">');

        modal.modal("show");
    });

    // 🧩 Form submission
    form.on("submit", function (e) {
        e.preventDefault();

        submitButton.prop("disabled", true).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            ${isEdit ? window.trans.updating : window.trans.saving}
        `);

        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                const user = res.data;
                const newRow = renderRow(user, res.branches_count);

                if (isEdit) {
                    $(`#row-${user.id}`).replaceWith(newRow);
                    toastr.success(window.trans.success_update);
                } else {
                    $("#noDataRow").remove();
                    tableBody.prepend(newRow);
                    toastr.success(res.message ?? window.trans.success_create);
                }

                submitButton
                    .prop("disabled", false)
                    .text(isEdit ? window.trans.update : window.trans.save);

                form[0].reset();
                $("#passwordField").show();
                modal.modal("hide");
            },
            error: function (xhr) {
                submitButton
                    .prop("disabled", false)
                    .text(isEdit ? window.trans.update : window.trans.save);

                if (xhr.status === 422) {
                    displayErrors(xhr.responseJSON.errors);
                } else {
                    toastr.error(
                        xhr.responseJSON?.message ??
                            window.trans.error_unexpected
                    );
                }
            },
        });
    });

    // 🧩 Restore modal state on close
    modal.on("hidden.bs.modal", function () {
        isEdit = false;
        editId = null;

        form[0].reset();
        form.find('input[name="_method"]').remove();
        form.attr("action", "/dashboard/branch_managers");

        modalTitle.text(window.trans.add_branch_manager);
        submitButton.text(window.trans.save);

        $("#passwordField").show();
    });

    // 🧩 Clear error messages
    $("input, select, textarea").on("input", function () {
        const field = $(this).attr("name");
        $(`#${field}Error`).empty();
    });

    // 🧩 Display validation errors
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

    $(document).on("click", ".open-subscription-modal", function () {
        let managerId = $(this).data("id");
        let managerName = $(this).data("name");

        $("#managerId").val(managerId);
        $("#managerName").text(managerName);

        let modal = new bootstrap.Modal(
            document.getElementById("subscriptionModal")
        );
        modal.show();
    });

    // subscription submit
    const subscriptionForm = $("#subscriptionForm");
    const subscriptionModal = $("#subscriptionModal");

    subscriptionForm.on("submit", function (e) {
        e.preventDefault();
        const selectedPackage = $("#selectedPackage").val();

        if (!selectedPackage) {
            toastr.error(window.trans.select_package);
            return; // Stop submission
        }

        const submitBtn = $(this).find("button[type='submit']");
        submitBtn.prop("disabled", true).text(window.trans.saving);

        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: $(this).serialize(),
            success: function (res) {
                toastr.success(
                    res.message ??
                        window.trans.subscription_created_successfully
                );

                submitBtn.prop("disabled", false).text(window.trans.save);
                subscriptionForm[0].reset();
                subscriptionModal.modal("hide");

                // Update subscription cell in the table
                const managerId = $("#managerId").val();
                const row = $(`#row-${managerId}`);

                if (row.length) {
                    const startDate = res.data.start_date; // from backend
                    const endDate = res.data.end_date; // optional
                    const badgeHtml = `<span class="badge bg-success">${startDate}</span>`;

                    row.find("td").eq(6).html(badgeHtml); // 7th td = subscribed_at
                }
            },
            error: function (xhr) {
                submitBtn.prop("disabled", false).text(window.trans.save);
                if (xhr.status === 422) {
                    console.log(xhr.responseJSON.errors);
                } else {
                    toastr.error(
                        xhr.responseJSON?.message ?? window.trans.error_occurred
                    );
                }
            },
        });
    });

});

document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".selectable-package");

    cards.forEach((card) => {
        card.addEventListener("click", function () {
            // Remove active styles
            cards.forEach((c) =>
                c.classList.remove("border-primary", "shadow")
            );
            this.classList.add("border-primary", "shadow");

            // Show Date + Info sections
            document.getElementById("dateSection").classList.remove("d-none");
            document.getElementById("packageInfo").classList.remove("d-none");

            // Assign hidden package ID
            document.getElementById("selectedPackage").value = this.dataset.id;

            // Package Info
            const price = this.dataset.price;
            const duration = this.dataset.duration;
            const limit = this.dataset.limit;
            const name = this.dataset.name;

            document.getElementById("pName").innerText = name;
            document.getElementById("pPrice").innerText = price;
            document.getElementById("pDuration").innerText = duration;
            document.getElementById("pLimit").innerText = limit;

            // Auto Dates
            const start = new Date();
            const end = new Date();
            end.setDate(end.getDate() + parseInt(duration));

            const format = (d) => d.toISOString().split("T")[0];

            document.getElementById("start_date_display").value = format(start);
            document.getElementById("end_date_display").value = format(end);
            document.getElementById("start_date").value = format(start);
            document.getElementById("end_date").value = format(end);
        });
    });
});
