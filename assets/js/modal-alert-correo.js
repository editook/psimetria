document.addEventListener("DOMContentLoaded", function () {
    const elementoModal = document.getElementById("addEmailModal");
    if (elementoModal !== null) {
        const modalCorreo = new bootstrap.Modal(elementoModal, {
            backdrop: "static",
            keyboard: false,
        });

        modalCorreo.show();
    }
});
