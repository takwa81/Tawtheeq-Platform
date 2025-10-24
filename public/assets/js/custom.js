function responseError(jqXhr, textStatus, errorMessage) {
    var error = "";
    $.each(jqXhr.responseJSON.errors, function (key, value) {
        error = error + "<h6>- " + value + "</h6>";
    });
    if (error === "") {
        error = jqXhr.responseJSON.message;
    }

    Toast.fire({
        icon: "error",
        title: error,
    });
}
function responseTrue(data) {
    Toast.fire({
        icon: "success",
        title: data["message"],
    });
}
const Toast = Swal.mixin({
    toast: true,
    position: "bottom-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});
