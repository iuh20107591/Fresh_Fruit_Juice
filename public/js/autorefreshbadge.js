document.addEventListener("DOMContentLoaded", function () {
    const badge = document.getElementById("pendingBadge");
    const toastEl = document.getElementById("orderToast");
    const toast = toastEl ? new bootstrap.Toast(toastEl) : null;

    let previousPending = null;

    function updatePendingCount() {
        fetch("/fresh_fruit_juice/ajax/pendingcount")
            .then(res => res.json())
            .then(data => {
                const currentPending = parseInt(data.pending);

                if (badge) {
                    badge.textContent = currentPending;
                    badge.style.display = currentPending > 0 ? "inline-block" : "none";

                    // Nếu có đơn hàng mới
                    if (previousPending !== null && currentPending > previousPending) {
                        badge.classList.add("flash");
                        setTimeout(() => badge.classList.remove("flash"), 1000);

                        // ✅ Hiển thị toast
                        if (toast) toast.show();

                        // Hiển thị thông báo
                        if (Notification.permission === "granted") {
                            new Notification("🔔 Có đơn hàng mới đang chờ xử lý!");
                        }
                    }

                    previousPending = currentPending;
                }
            })
            .catch(err => console.error("Lỗi fetch pending:", err));
    }

    updatePendingCount(); // chạy lần đầu
    setInterval(updatePendingCount, 5000); // mỗi 5 giây
});