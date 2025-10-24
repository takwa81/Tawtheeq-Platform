document.addEventListener("DOMContentLoaded", function () {
    const updateBtn = document.getElementById("updateSchedule");
    if (updateBtn) {
        updateBtn.addEventListener("click", function () {
            const tableRows = document.querySelectorAll("#schedule tbody tr");
            const schedules = [];

            tableRows.forEach((row) => {
                const holiday = row.querySelector(".schedule-holiday");
                const day = holiday?.dataset.day;
                const is_holiday = holiday?.checked ?? false;
                const from_hour = is_holiday
                    ? null
                    : row.querySelector(".schedule-from")?.value || null;
                const to_hour = is_holiday
                    ? null
                    : row.querySelector(".schedule-to")?.value || null;

                if (day)
                    schedules.push({ day, is_holiday, from_hour, to_hour });
            });

            const serviceId = this.dataset.serviceId;
            const token = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content");

            $.ajax({
                url: `/dashboard/services/${serviceId}/schedules`,
                method: "POST",
                data: JSON.stringify({ schedules }),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": token,
                },
                success: function (response) {
                    toastr.success(response.message || "تم الحفظ بنجاح");
                },
                error: function (xhr, status, error) {
                    console.error(error);
                    toastr.error("حدث خطأ، الرجاء المحاولة لاحقاً");
                },
            });
        });
    }
});

$(document).ready(function () {
    $("#bulkFromHour, #bulkToHour").clockpicker({
        autoclose: true,
        placement: "bottom",
        align: "left",
        donetext: "تأكيد",
    });
    function toggleBulkSection() {
        const anyChecked = $(".bulk-checkbox:checked").length > 0;
        $("#bulkApplySection").toggle(anyChecked);
    }

    $(document).on("change", ".bulk-checkbox", function () {
        toggleBulkSection();
    });

    $(document).on("click", "#applyToAllBtn", function () {
        const fromHour = $("#bulkFromHour").val();
        const toHour = $("#bulkToHour").val();

        if (!fromHour || !toHour) {
            // alert("يرجى إدخال الوقت من وإلى قبل التطبيق");
            toastr.warning("يرجى إدخال الوقت من وإلى قبل التطبيق");

            return;
        }

        $(".bulk-checkbox:checked").each(function () {
            const day = $(this).data("day");
            const holidayCheckbox = $(
                '.schedule-holiday[data-day="' + day + '"]'
            );

            if (holidayCheckbox.length && !holidayCheckbox.is(":checked")) {
                $('.schedule-from[data-day="' + day + '"]').val(fromHour);
                $('.schedule-to[data-day="' + day + '"]').val(toHour);
            }
        });
    });

    $(document).on("change", ".schedule-holiday", function () {
        const day = $(this).data("day");
        const isHoliday = $(this).is(":checked");

        $('.schedule-from[data-day="' + day + '"]').prop("disabled", isHoliday);
        $('.schedule-to[data-day="' + day + '"]').prop("disabled", isHoliday);

        if (isHoliday) {
            $('.schedule-from[data-day="' + day + '"]').val("");
            $('.schedule-to[data-day="' + day + '"]').val("");
        }
    });

    $(document).on("change", "#selectAll", function () {
        const checked = $(this).is(":checked");
        $(".bulk-checkbox").prop("checked", checked).trigger("change");
    });

    toggleBulkSection();
});
