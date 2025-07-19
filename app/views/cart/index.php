<h2 class="mb-4">🛒 Giỏ hàng của bạn</h2>

<?php if (!empty($cart)): ?>
    <form method="post" action="<?= BASE_URL ?>/cart/update">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Hình</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th width="120">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; foreach ($cart as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td width="100"><img src="<?= BASE_URL ?>/public/images/<?= $item['image'] ?>" class="img-thumbnail" width="80"></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= number_format($item['price']) ?> VND</td>
                    <td width="120">
                        <input type="number" name="quantities[<?= $item['id'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control">
                    </td>
                    <td><?= number_format($subtotal) ?> VND</td>
                    <td style="text-align: center;">
                        <a href="<?= BASE_URL ?>/cart/remove/<?= $item['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xoá sản phẩm này?')">Xoá</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                    <td colspan="2"><strong><?= number_format($total) ?> VND</strong></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-success">Cập nhật số lượng</button>
        <a href="<?= BASE_URL ?>/cart/checkout" class="btn btn-primary float-end">🧾 Tiến hành đặt hàng</a>
    </form>
<?php else: ?>
    <div class="alert alert-info">Giỏ hàng của bạn đang trống.</div>
<?php endif; ?>
