$(document).on("click", ".toggle-status", function (e) {
    e.preventDefault();

    let button = $(this);
    let url = button.data("url");
    let currentStatus = button.data("status");

    if (!url) {
        console.error("Toggle URL not found on element!");
        return;
    }

    Swal.fire({
        title: currentStatus === "active"
            ? window.translations.toggle_deactivate_title
            : window.translations.toggle_activate_title,
        text: window.translations.toggle_confirm_text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00c1ca",
        cancelButtonColor: "#d33",
        confirmButtonText: window.translations.toggle_yes,
        cancelButtonText: window.translations.toggle_cancel,
    }).then((result) => {
        if (!result.isConfirmed) return;

        $.get(url, { _token: $("meta[name='csrf-token']").attr("content") })
            .done(function (response) {
                if (!response.status) {
                    toastr.error(response.message ?? window.translations.toggle_error);
                    return;
                }

                toastr.success(response.message ?? window.translations.toggle_success);

                let newStatus = currentStatus === "active" ? "inactive" : "active";

                // Update table row badge
                let row = button.closest("tr");
                let badgeCell = row.find("td").eq(3);

                if (badgeCell.length) {
                    badgeCell.html(
                        newStatus === "active"
                            ? `<span class="badge bg-success">${window.translations.status_active}</span>`
                            : `<span class="badge bg-danger">${window.translations.status_inactive}</span>`
                    );

                    // Replace toggle button in list
                    button.replaceWith(
                        `<a href="#" class="btn btn-md ${newStatus === "active" ? "bg-warning" : "bg-success"} rounded font-sm my-1 toggle-status"
                           data-url="${response.data.toggle_url}"
                           data-status="${newStatus}"
                           title="${newStatus === "active" ? window.translations.toggle_deactivate_title : window.translations.toggle_activate_title}">
                            <i class="material-icons ${newStatus === "active" ? "md-toggle_off" : "md-toggle_on"}"></i>
                        </a>`
                    );
                }

                // Update show page badge
                const badgePage = $("#statusBadge");
                if (badgePage.length) {
                    badgePage.html(
                        newStatus === "active"
                            ? `<span class="badge bg-success">${window.translations.status_active}</span>`
                            : `<span class="badge bg-danger">${window.translations.status_inactive}</span>`
                    );
                }

                // Update dropdown action in show page
                const actionPage = $("#actionState");
                if (actionPage.length) {
                    actionPage.find(".toggle-status").replaceWith(
                        `<a class="dropdown-item toggle-status" href="#"
                           data-url="${response.data.toggle_url}"
                           data-status="${newStatus}">
                            <i class="material-icons ${newStatus === "active" ? "md-toggle_off" : "md-toggle_on"} me-1"></i>
                            ${newStatus === "active" ? window.translations.toggle_deactivate_title : window.translations.toggle_activate_title}
                        </a>`
                    );
                }
            })
            .fail(function () {
                toastr.error(window.translations.toggle_error);
            });
    });
});
