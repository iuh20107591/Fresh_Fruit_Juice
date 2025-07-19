document.addEventListener("DOMContentLoaded", function () {
    const modalel = document.getElementById("welcomemodal");
    const infobtn = document.getElementById("infobtn");

    if (!sessionStorage.getItem("hasseenwelcome")) {
        const modal = new bootstrap.Modal(modalel);
        modal.show();
        sessionStorage.setItem("hasseenwelcome", "1");
    }

    // Hiển thị lại modal khi bấm nút i
    if (infobtn) {
        infobtn.addEventListener("click", function () {
            const modal = new bootstrap.Modal(modalel);
            modal.show();
        });
    }
});
