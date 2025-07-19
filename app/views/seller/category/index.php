<h3>📂 Quản lý loại sản phẩm</h3>
<a href="<?= BASE_URL ?>/categorymanage/add" class="btn btn-success mb-3">➕ Thêm loại</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tên</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $c): ?>
        <tr>
            <td><?= htmlspecialchars($c['cat_name']) ?></td>
            <td><?= $c['status'] ? '✅ Hiển thị' : '🚫 Ẩn' ?></td>
            <td>
                <a href="<?= BASE_URL ?>/categorymanage/toggle/<?= $c['cat_id'] ?>" class="btn btn-warning btn-sm">Chuyển trạng thái</a>
                <a href="<?= BASE_URL ?>/categorymanage/delete/<?= $c['cat_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xoá danh mục này?')">Xoá</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
