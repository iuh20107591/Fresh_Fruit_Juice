<h2 class="mb-4">🧾 Thanh toán đơn hàng</h2>

<form method="post" id="checkoutForm" action="<?= BASE_URL ?>/cart/processcheckout">
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Họ và tên</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="col-12 mt-2">
            <label class="form-label">Địa chỉ giao hàng</label>
            <textarea name="address" class="form-control" rows="2" required></textarea>
        </div>
    </div>

    <h5 class="mb-3">🛒 Sản phẩm đặt mua:</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; foreach ($cart as $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td><?= number_format($item['price']) ?> VND</td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($subtotal) ?> VND</td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                <td class="fw-bold"><?= number_format($total) ?> VND</td>
            </tr>
        </tbody>
    </table>

    <button type="submit" class="btn btn-success">✅ Xác nhận đặt hàng</button>
    <a href="<?= BASE_URL ?>/cart" class="btn btn-secondary">← Quay lại giỏ hàng</a>
</form>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('#checkoutForm');
    form?.addEventListener('submit', function (e) {
        const phone = document.querySelector('input[name="phone"]').value;
        const phoneRegex = /^(03|05|07|08|09)\d{8}$/;

        if (!phoneRegex.test(phone)) {
            alert("📱 Số điện thoại không hợp lệ. Vui lòng nhập số di động Việt Nam (10 số bắt đầu bằng 03,05,07,08,09).");
            e.preventDefault();
        }
    });
});
</script>
