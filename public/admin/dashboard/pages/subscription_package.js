$(document).ready(function () {
    const form = $("#subscriptionForm");
    const modal = $("#subscriptionModal");
    const submitButton = form.find("#submitButton");
    const modalTitle = $("#subscriptionModalLabel");
    const cardsContainer = $("#cardsContainer");

    let isEdit = false;
    let editId = null;

    // 🧩 Add new feature field
    $(document).on("click", "#addFeature", function () {
        $("#featuresContainer").append(`
        <div class="input-group mb-2 feature-item">
            <input type="text" name="features[]" class="form-control" placeholder="${window.translations.enterFeature}">
            <button type="button" class="btn btn-md bg-danger rounded font-sm remove-feature">
                <i class="material-icons md-delete"></i>
            </button>
        </div>
    `);
    });

    // 🧩 Remove feature input
    $(document).on("click", ".remove-feature", function () {
        $(this).closest(".feature-item").remove();
    });

    // 🧱 Render card exactly like Blade view
    function renderCard(pkg) {
        let featuresList = "";
        if (pkg.features && pkg.features.length > 0) {
            featuresList = `
                <h6 class="text-secondary">${
                    window.translations.featuresLabel
                }:</h6>
                <ul class="small ps-3">
                    ${pkg.features.map((f) => `<li>${f}</li>`).join("")}
                </ul>
            `;
        }

        return `
<div class="col-lg-4 col-md-6" id="card-${pkg.id}">
    <div class="card shadow-sm border-0 rounded-3 h-100">
        <div class="card-body d-flex flex-column justify-content-between">
            <div>
                <h5 class="fw-bold text-primary mb-2">
                    ${pkg.name_ar} / ${pkg.name_en}
                </h5>

                ${
                    pkg.description
                        ? `<p class="text-muted small mb-3">${pkg.description}</p>`
                        : ""
                }

                <ul class="list-unstyled mb-3">
                    <li><strong>${
                        translations.branches_count
                    }:</strong> ${pkg.branches_limit}</li>
                    <li><strong>${
                        translations.duration
                    }:</strong> ${pkg.duration_days ?? 0} ${translations.day}</li>
                    <li><strong>${
                        translations.price
                    }:</strong> ${Number(pkg.price).toFixed(2)} ر.س</li>
                </ul>

                ${featuresList}
            </div>

            <div class="mt-3 text-end">
                <a href="javascript:void(0)" class="btn btn-md rounded font-sm edit-data"
                   data-id="${pkg.id}"
                   data-name_ar="${pkg.name_ar}"
                   data-name_en="${pkg.name_en}"
                   data-description="${pkg.description ?? ""}"
                   data-price="${pkg.price}"
                   data-branches_limit="${pkg.branches_limit}"
                   data-duration_days="${pkg.duration_days ?? ""}"
                   data-features='${JSON.stringify(pkg.features ?? [])}'
                   title="${translations.edit_package}">
                    <i class="material-icons md-edit"></i>
                </a>

                <form class="d-inline delete-form" action="/dashboard/subscription_packages/${
                    pkg.id
                }" method="POST" data-id="${pkg.id}">
                    <input type="hidden" name="_token" value="${$(
                        'meta[name="csrf-token"]'
                    ).attr("content")}">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="button" class="btn btn-md bg-danger rounded font-sm delete-button" title="${
                        translations.delete_package
                    }">
                        <i class="material-icons md-delete"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
`;
    }

    // 🧩 Handle edit button
    $(document).on("click", ".edit-data", function () {
        isEdit = true;
        editId = $(this).data("id");
        modalTitle.text(window.translations.editPackage);
        submitButton.text(window.translations.update);

        form.find("#name_ar").val($(this).data("name_ar"));
        form.find("#name_en").val($(this).data("name_en"));
        form.find("#price").val($(this).data("price"));
        form.find("#branches_limit").val($(this).data("branches_limit"));
        form.find("#description").val($(this).data("description"));
        form.find("#duration_days").val($(this).data("duration_days"));

        // 🧹 Clear and re-add features
        $("#featuresContainer").empty();
        const features = $(this).data("features") || [];
        if (features.length > 0) {
            features.forEach((feature) => {
                $("#featuresContainer").append(`
                    <div class="input-group mb-2 feature-item">
                        <input type="text" name="features[]" class="form-control" value="${feature}">
                        <button type="button" class="btn btn-md bg-danger rounded font-sm remove-feature">
                            <i class="material-icons md-delete"></i>
                        </button>
                    </div>
                `);
            });
        } else {
            $("#featuresContainer").append(`
                <div class="input-group mb-2 feature-item">
                    <input type="text" name="features[]" class="form-control" placeholder="أدخل ميزة">
                    <button type="button" class="btn btn-md bg-danger rounded font-sm remove-feature">
                        <i class="material-icons md-delete"></i>
                    </button>
                </div>
            `);
        }

        form.attr("action", `/dashboard/subscription_packages/${editId}`);
        if (!form.find('input[name="_method"]').length) {
            form.append('<input type="hidden" name="_method" value="PUT">');
        }

        modal.modal("show");
    });

    // 🧩 Handle form submission
    form.on("submit", function (e) {
        e.preventDefault();

        submitButton.prop("disabled", true).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            ${
                isEdit
                    ? window.translations.updating
                    : window.translations.saving
            }        `);

        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                const pkg = res.data;
                const newCard = renderCard(pkg);

                if (isEdit) {
                    $(`#card-${pkg.id}`).replaceWith(newCard);
                    toastr.success(window.translations.successUpdate);
                } else {
                    $("#noDataCard").remove();
                    cardsContainer.prepend(newCard);
                    toastr.success(
                        isEdit
                            ? window.translations.successUpdate
                            : window.translations.successCreate
                    );
                }

                submitButton
                    .prop("disabled", false)
                    .text(
                        isEdit
                            ? window.translations.update
                            : window.translations.save
                    );
                form[0].reset();
                form.find('input[name="_method"]').remove();
                modal.modal("hide");
                isEdit = false;
                editId = null;
            },
            error: function (xhr) {
                submitButton
                    .prop("disabled", false)
                    .text(
                        isEdit
                            ? window.translations.update
                            : window.translations.save
                    );

                if (xhr.status === 422) {
                    displayErrors(xhr.responseJSON.errors);
                } else {
                    toastr.error(
                        xhr.responseJSON?.message ??
                            window.translations.unexpectedError
                    );
                }
            },
        });
    });

    // 🧩 Reset modal on close
    modal.on("hidden.bs.modal", function () {
        form[0].reset();
        form.find('input[name="_method"]').remove();
        form.attr("action", "/dashboard/subscription_packages");
        modalTitle.text(window.translations.createPackage);
        submitButton.text("حفظ");
        $(".text-danger").remove();
        isEdit = false;
        editId = null;
    });

    // 🧩 Clear validation errors on input/select/textarea
    $(document).on("input change", "input, select, textarea", function () {
        const field = $(this).attr("name");
        $(`#${field}Error`).empty();
    });

    // 🧩 Display validation errors (like companyForm)
    function displayErrors(errors) {
        for (const key in errors) {
            const field = $(`[name='${key}']`);
            if (field.length) {
                field.after(`
                    <div id="${key}Error" class="mt-1">
                        <small class="text-danger py-1 opacity-75" style="font-size: 12px;">
                            <i class="icon material-icons md-error_outline"></i>
                            ${errors[key][0]}
                        </small>
                    </div>
                `);
            } else {
                toastr.error(errors[key][0]);
            }
        }
    }
});
