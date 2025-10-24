document.addEventListener("DOMContentLoaded", function () {
    // Country/Governorate/Zone
    const countrySelect = document.getElementById("country_id");
    const governorateSelect = document.getElementById("governorate_id");
    const zoneSelect = document.getElementById("zone_id");

    const selectedCountry = countrySelect?.getAttribute("data-selected");
    const selectedGovernorate =
        governorateSelect?.getAttribute("data-selected");
    const selectedZone = zoneSelect?.getAttribute("data-selected");

    countrySelect?.addEventListener("change", function () {
        loadGovernorates(this.value); // User changed country
    });

    governorateSelect?.addEventListener("change", function () {
        loadZones(this.value); // User changed governorate
    });

    console.log(selectedCountry, "selectedCountry");
    console.log(selectedGovernorate, "selectedGovernorate");

    console.log("governorateSelect", governorateSelect);
    console.log("countrySelect", countrySelect);

    async function loadGovernorates(countryId, preselectGovernorate = null) {
        governorateSelect.innerHTML = '<option value="">اختر المحافظة</option>';
        zoneSelect.innerHTML = '<option value="">اختر المنطقة</option>';

        if (!countryId) return;

        try {
            const res = await fetch(`/api/countries/${countryId}/governorates`);
            const response = await res.json();

            response.data.forEach((g) => {
                const isSelected =
                    g.id == (preselectGovernorate ?? selectedGovernorate);
                governorateSelect.add(
                    new Option(g.name_ar, g.id, isSelected, isSelected)
                );
            });

            // If we have a governorate to preselect (edit page), load its zones
            const govToLoad = preselectGovernorate ?? selectedGovernorate;
            if (govToLoad) {
                await loadZones(govToLoad, selectedZone);
            }
        } catch (err) {
            console.error(err);
        }
    }

    async function loadZones(governorateId, preselectZone = null) {
        zoneSelect.innerHTML = '<option value="">اختر المنطقة</option>';
        if (!governorateId) return;

        try {
            const res = await fetch(`/api/governorates/${governorateId}/zones`);
            const response = await res.json();

            response.data.forEach((z) => {
                const isSelected = z.id == (preselectZone ?? selectedZone);
                zoneSelect.add(
                    new Option(z.name_ar, z.id, isSelected, isSelected)
                );
            });
        } catch (err) {
            console.error(err);
        }
    }

    // On page load, populate governorates/zones for edit page
    if (selectedCountry) {
        loadGovernorates(selectedCountry, selectedGovernorate);
    }

    // Location Type & Map
    const locationType = document.getElementById("location_type");
    const mapContainer = document.getElementById("mapContainer");
    const mapCoords = document.querySelector(".map-coords");
    const latInput = document.getElementById("location_on_map_lat");
    const longInput = document.getElementById("location_on_map_long");

    let map, marker;

    function toggleMapInputs() {
        const show =
            locationType.value === "map" || locationType.value === "hybrid";
        if (mapContainer) mapContainer.style.display = show ? "block" : "none";
        if (mapCoords) mapCoords.style.display = show ? "flex" : "none";
        if (show && !map) initMap();
    }

    function initMap() {
        const defaultLat = latInput.value || 33.5138;
        const defaultLng = longInput.value || 36.2765;

        map = L.map("serviceMap").setView([defaultLat, defaultLng], 13);
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "© OpenStreetMap contributors",
        }).addTo(map);

        if (latInput.value && longInput.value) {
            marker = L.marker([latInput.value, longInput.value]).addTo(map);
        }

        map.on("click", function (e) {
            const { lat, lng } = e.latlng;
            latInput.value = lat.toFixed(6);
            longInput.value = lng.toFixed(6);
            if (marker) marker.setLatLng([lat, lng]);
            else marker = L.marker([lat, lng]).addTo(map);
        });
    }

    locationType?.addEventListener("change", toggleMapInputs);
    toggleMapInputs();

    // handle form

    const form = $("#serviceForm");
    const submitButton = form.find('button[type="submit"]');
    const isEditPage = form.attr("method") !== "POST";

    $(document).on("keydown", function (event) {
        if (event.ctrlKey && event.key === "s") {
            event.preventDefault();
            form.submit();
        }
    });

    form.on("submit", function (e) {
        e.preventDefault();
        submitButton
            .prop("disabled", true)
            .html(
                `<span class="spinner-border spinner-border-sm"></span> ${
                    isEditPage ? "جارٍ التحديث..." : "جارٍ الحفظ..."
                }`
            );
        const formData = new FormData(this);

        $.ajax({
            type: form.attr("method"),
            url: form.attr("action"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                toastr.success(response.message ?? "تم الحفظ بنجاح");
                window.location.href = "/dashboard/services";
            },
            error: function (xhr) {
                submitButton
                    .prop("disabled", false)
                    .html(isEditPage ? "تحديث" : "حفظ");
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    for (const key in errors) {
                        $("#" + key + "Error").text(errors[key][0]);
                        toastr.error(errors[key][0]);
                    }
                } else {
                    toastr.error("حدث خطأ غير متوقع، الرجاء المحاولة لاحقاً");
                }
            },
        });
    });

    const tagSelect = document.getElementById("tags");
    new Choices(tagSelect, {
        removeItemButton: true,
        searchEnabled: true,
        placeholder: true,
        // placeholderValue: "اختر التاغات الملائمة",
        shouldSort: false,
    });
});
