document.addEventListener("DOMContentLoaded", function () {
    const rows = document.querySelectorAll(".clickable-row");
    rows.forEach(row => {
        row.style.cursor = "pointer";
        row.addEventListener("click", function (e) {
            // Ngăn việc bấm vào nút bên trong td (nếu có nút)
            if (e.target.tagName !== "A" && e.target.tagName !== "BUTTON") {
                const url = this.getAttribute("data-href");
                if (url) window.location.href = url;
            }
        });
    });
});
