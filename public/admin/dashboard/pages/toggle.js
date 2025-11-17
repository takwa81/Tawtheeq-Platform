$(document).on("click", ".toggle-status", function (e) {
    e.preventDefault();

    let button = $(this);
    let url = button.data("url"); // always get URL from data-url
    let currentStatus = button.data("status"); // always get current status from data-status

    if (!url) {
        console.error("Toggle URL not found on element!");
        return;
    }

    Swal.fire({
        title: currentStatus === "active" ? "إلغاء التفعيل" : "تفعيل",
        text: "هل أنت متأكد من هذه العملية؟",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00c1ca",
        cancelButtonColor: "#d33",
        confirmButtonText: "نعم",
        cancelButtonText: "إلغاء",
    }).then((result) => {
        if (!result.isConfirmed) return;

        $.get(url, { _token: $("meta[name='csrf-token']").attr("content") })
            .done(function (response) {
                if (!response.status) {
                    toastr.error(response.message ?? "حدث خطأ أثناء تنفيذ العملية");
                    return;
                }

                toastr.success(response.message ?? "تمت العملية بنجاح");

                // Update table row if exists
                let row = button.closest("tr");
                let badgeCell = row.find("td").eq(3);

                if (badgeCell.length) {
                    badgeCell.html(
                        currentStatus === "active"
                            ? '<span class="badge bg-danger">غير فعال</span>'
                            : '<span class="badge bg-success">فعال</span>'
                    );

                    // Update button inside table row
                    button.replaceWith(
                        `<a href="#" class="btn btn-md ${currentStatus === "active" ? "bg-success" : "bg-warning"} rounded font-sm my-1 toggle-status"
                           data-url="${response.data.toggle_url}"
                           data-status="${currentStatus === "active" ? "inactive" : "active"}"
                           title="${currentStatus === "active" ? "تفعيل" : "إلغاء التفعيل"}">
                            <i class="material-icons ${currentStatus === "active" ? "md-toggle_on" : "md-toggle_off"}"></i>
                        </a>`
                    );
                }

                // Update show page badge & dropdown if exists
                const badgePage = $("#statusBadge");
                const actionPage = $("#actionState"); // the container for dropdown link

                if (badgePage.length) {
                    badgePage.html(
                        currentStatus === "active"
                            ? '<span class="badge bg-danger">غير فعال</span>'
                            : '<span class="badge bg-success">فعال</span>'
                    );
                }
                console.log(actionPage,'actionPage');

                if (actionPage.length) {
                    actionPage.find(".toggle-status").replaceWith(
                        `<a class="dropdown-item toggle-status" href="#"
                           data-url="${response.data.toggle_url}"
                           data-status="${currentStatus === "active" ? "inactive" : "active"}"
                           title="${currentStatus === "active" ? "تفعيل" : "إلغاء التفعيل"}">
                            <i class="material-icons ${currentStatus === "active" ? "md-toggle_on" : "md-toggle_off"} me-1"></i>
                            ${currentStatus === "active" ? "تفعيل" : "إلغاء التفعيل"}
                        </a>`
                    );
                }
            })
            .fail(function () {
                toastr.error("حدث خطأ أثناء تنفيذ العملية");
            });
    });
});
