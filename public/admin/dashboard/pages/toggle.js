$(document).on("click", ".toggle-status", function (e) {
    e.preventDefault();
    let button = $(this);
    let url = button.data("url");
    let currentStatus = button.data("status");

    Swal.fire({
        title: currentStatus === "active" ? "إلغاء التفعيل" : "تفعيل",
        text: "هل أنت متأكد من هذه العملية؟",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#572972",
        cancelButtonColor: "#d33",
        confirmButtonText: "نعم",
        cancelButtonText: "إلغاء",
    }).then((result) => {
        if (result.isConfirmed) {
            $.get(url, {_token: $("meta[name='csrf-token']").attr("content")}, function(response) {
                if(response.status) {
                    toastr.success(response.message ?? "تمت العملية بنجاح");

                    let row = button.closest("tr");
                    let badgeCell = row.find("td").eq(3); 
                    let actionCell = row.find("td").eq(4); 

                    if(currentStatus === "active") {
                        badgeCell.html('<span class="badge bg-danger">غير فعال</span>');

                        actionCell.find(".toggle-status").replaceWith(`
                            <a href="#" class="btn btn-md bg-success rounded font-sm my-1 toggle-status"
                               data-url="/dashboard/data_entries/activate/${response.data.id}"
                               data-status="inactive"
                               title="تفعيل">
                                <i class="material-icons md-toggle_on"></i>
                            </a>
                        `);
                    } else {
                        badgeCell.html('<span class="badge bg-success">فعال</span>');

                        actionCell.find(".toggle-status").replaceWith(`
                            <a href="#" class="btn btn-md bg-warning rounded font-sm my-1 toggle-status"
                               data-url="/dashboard/data_entries/deactivate/${response.data.id}"
                               data-status="active"
                               title="إلغاء التفعيل">
                                <i class="material-icons md-toggle_off"></i>
                            </a>
                        `);
                    }
                } else {
                    toastr.error(response.message ?? "حدث خطأ أثناء تنفيذ العملية");
                }
            }).fail(function() {
                toastr.error("حدث خطأ أثناء تنفيذ العملية");
            });
        }
    });
});
