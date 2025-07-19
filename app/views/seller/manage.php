<h3 class="mb-4">📦 Quản lý sản phẩm</h3>

<a href="<?= BASE_URL ?>/productmanage/add" class="btn btn-success mb-3">➕ Thêm sản phẩm</a>

 <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Giá</th>
                <th>Mô tả</th>
                <th>Loại</th>
                <th>Hình ảnh</th>
                <th>Thao tác</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= number_format($p['price']) ?> VND</td>
                <td><?= $p['description']?></td>
                <td>
                    <p class="text-muted">
                                Loại: 
                                <?= htmlspecialchars($p['cat1_name'] ?? '') ?>
                                <?= $p['cat2_name'] ? ' + ' . htmlspecialchars($p['cat2_name']) : '' ?>
                            </p>
                </td>
                <td><img src="<?= BASE_URL ?>/public/images/<?= $p['image'] ?>" width="80" height="60"></td>
                <td style="text-align: center;">
                    <a href="<?= BASE_URL ?>/productmanage/edit/<?= $p['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="<?= BASE_URL ?>/productmanage/delete/<?= $p['id'] ?>" class="btn btn-sm btn-danger"
                    onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                </td>
                <td>
                    <a href="<?= BASE_URL ?>/productmanage/toggle/<?= $p['id'] ?>" class="btn btn-sm <?= $p['status'] ? 'btn-secondary' : 'btn-success' ?>">
                        <?= $p['status'] ? 'Ẩn' : 'Hiển thị' ?>
                    </a>
                </td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>