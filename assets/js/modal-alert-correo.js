document.addEventListener("DOMContentLoaded", function () {
    const elementoModal = document.getElementById("addEmailModal");

    const modalCorreo = new bootstrap.Modal(elementoModal, {
        backdrop: "static",
        keyboard: false,
    });

    modalCorreo.show();
});
