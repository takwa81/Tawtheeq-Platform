$(document).ready(function () {
    const form = $("#subscriptionForm");
    const modal = $("#subscriptionModal");
    const submitButton = form.find("#submitButton");
    const modalTitle = $("#subscriptionModalLabel");
    const cardsContainer = $("#cardsContainer"); 

    let isEdit = false;
    let editId = null;

    function renderCard(packageData) {
        const features = packageData.features ? packageData.features.join(", ") : "";
        return `
            <div class="col-md-4 mb-4" id="card-${packageData.id}">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">${packageData.name_ar} / ${packageData.name_en}</h5>
                        <p class="card-text">${packageData.description}</p>
                        <ul class="list-group list-group-flush mb-2">
                            <li class="list-group-item"><strong>Price:</strong> ${packageData.price}</li>
                            <li class="list-group-item"><strong>Branches Limit:</strong> ${packageData.branches_limit}</li>
                            <li class="list-group-item"><strong>Duration (days):</strong> ${packageData.duration_days}</li>
                            <li class="list-group-item"><strong>Features:</strong> ${features}</li>
                        </ul>
                        <div class="d-flex justify-content-between">
                            <a href="javascript:void(0)" class="btn btn-sm btn-primary edit-data"
                               data-id="${packageData.id}"
                               data-name_en="${packageData.name_en}"
                               data-name_ar="${packageData.name_ar}"
                               data-description="${packageData.description}"
                               data-price="${packageData.price}"
                               data-branches_limit="${packageData.branches_limit}"
                               data-duration_days="${packageData.duration_days}"
                               data-features='${JSON.stringify(packageData.features)}'>
                                <i class="material-icons md-edit"></i> Edit
                            </a>
                            <form class="d-inline delete-form" action="/dashboard/subscription_packages/${packageData.id}" method="POST" data-id="${packageData.id}">
                                <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="button" class="btn btn-sm btn-danger delete-button">
                                    <i class="material-icons md-delete"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // Handle edit button
    $(document).on("click", ".edit-data", function () {
        isEdit = true;
        editId = $(this).data("id");

        modalTitle.text("Edit Subscription Package");
        submitButton.text("Edit");

        form.find("#name_ar").val($(this).data("name_ar"));
        form.find("#name_en").val($(this).data("name_en"));
        form.find("#description").val($(this).data("description"));
        form.find("#price").val($(this).data("price"));
        form.find("#branches_limit").val($(this).data("branches_limit"));
        form.find("#duration_days").val($(this).data("duration_days"));
        form.find("#features").val($(this).data("features").join(", "));

        form.attr("action", `/dashboard/subscription_packages/${editId}`);
        if (!form.find('input[name="_method"]').length) {
            form.append('<input type="hidden" name="_method" value="PUT">');
        }

        modal.modal("show");
    });

    // Handle form submission
    form.on("submit", function (e) {
        e.preventDefault();

        submitButton.prop("disabled", true).html(`
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            ${isEdit ? "Updating..." : "Saving..."}
        `);

        const formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                const packageData = res.data;
                const newCard = renderCard(packageData);

                if (isEdit) {
                    $(`#card-${packageData.id}`).replaceWith(newCard);
                    toastr.success("Updated successfully");
                } else {
                    $("#noDataCard").remove(); // remove "no data" card if exists
                    cardsContainer.prepend(newCard);
                    toastr.success(res.message ?? "Created successfully");
                }

                submitButton.prop("disabled", false).text(isEdit ? "Edit" : "Save");
                form[0].reset();
                modal.modal("hide");
                isEdit = false;
                editId = null;
            },
            error: function (xhr) {
                submitButton.prop("disabled", false).text(isEdit ? "Edit" : "Save");
                toastr.error(xhr.responseJSON?.message ?? "Unexpected error");
            }
        });
    });

    // Reset modal on close
    modal.on("hidden.bs.modal", function () {
        form[0].reset();
        form.find('input[name="_method"]').remove();
        form.attr("action", "/dashboard/subscription_packages");
        modalTitle.text("Add New Subscription Package");
        submitButton.text("Save");
        isEdit = false;
        editId = null;
    });
});
