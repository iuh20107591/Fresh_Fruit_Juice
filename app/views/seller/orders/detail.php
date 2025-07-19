<h3>🧾 Chi tiết đơn hàng</h3>

<!-- Thông tin đơn -->
<p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
<p><strong>SĐT:</strong> <?= htmlspecialchars($order['phone']) ?></p>
<p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address']) ?></p>
<p><strong>Thời gian:</strong> <?= $order['created_at'] ?></p>
<p><strong>Trạng thái:</strong>
    <?php if ($order['status'] === 'done'): ?>
        <span class="badge bg-success">✔ Hoàn tất</span>
    <?php else: ?>
        <span class="badge bg-warning text-dark">⏳ Chờ xử lý</span>
    <?php endif; ?>
</p>

<!-- Danh sách sản phẩm -->
<h5 class="mt-4">Danh sách sản phẩm:</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Đơn giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        <?php $total = 0; foreach ($items as $i): ?>
            <tr>
                <td><?= htmlspecialchars($i['name']) ?></td>
                <td><?= number_format($i['price']) ?> VND</td>
                <td><?= $i['quantity'] ?></td>
                <td><?= number_format($i['price'] * $i['quantity']) ?> VND</td>
            </tr>
        <?php $total += $i['price'] * $i['quantity']; endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Tổng cộng</th>
            <th><?= number_format($total) ?> VND</th>
        </tr>
    </tfoot>
</table>

<!-- Nút thao tác -->
<div class="mt-4 d-flex flex-wrap gap-2">
    <!-- 🔙 Nút quay lại -->
    <a href="<?= BASE_URL ?>/ordermanage<?= $order['deleted'] ? '?deleted=1' : '' ?>" class="btn btn-secondary">
        ← Quay lại
    </a>

    <!-- 🧾 Nếu đơn đang chờ xử lý và chưa bị hủy: Cho phép hoàn thành -->
    <?php if ($order['status'] === 'pending' && !$order['deleted']): ?>
        <a href="<?= BASE_URL ?>/ordermanage/markdone/<?= $order['id'] ?>" class="btn btn-success"
           onclick="return confirm('Đánh dấu đơn hàng đã hoàn thành?')">
            ✔ Hoàn thành đơn
        </a>

        <!-- Cho phép hủy đơn -->
        <a href="<?= BASE_URL ?>/ordermanage/delete/<?= $order['id'] ?>" class="btn btn-danger btn-huydon"
           onclick="return confirm('Bạn có chắc chắn muốn hủy đơn này?')">
            🗑 Hủy đơn
        </a>
    <?php endif; ?>

    <!-- ✅ Nếu đơn đã bị hủy: Cho phép khôi phục -->
    <?php if ($order['deleted']): ?>
        <a href="<?= BASE_URL ?>/ordermanage/restore/<?= $order['id'] ?>" class="btn btn-warning"
           onclick="return confirm('Khôi phục đơn hàng này?')">
            🔁 Khôi phục
        </a>
    <?php endif; ?>

    <!-- 🔒 Nếu đơn đã hoàn tất: không hiển thị nút gì thêm -->
</div>

