<h3 class="mb-3">📋 Danh sách đơn hàng</h3>

<!-- 🔢 Thống kê -->
<div class="mb-3">
    <strong>Thống kê:</strong>
    <span class="badge bg-warning text-dark">⏳ Chờ xử lý: <?= $pendingCount ?></span>
    <span class="badge bg-success">✔ Đã hoàn tất: <?= $doneCount ?></span>
    <span class="badge bg-danger">🗑 Đã hủy: <?= $deletedCount ?></span>
</div>

<!-- 🔍 Bộ lọc -->
<form method="get" class="row gx-2 gy-1 align-items-center mb-3">
    <div class="col-auto">
        <select name="status" class="form-select">
            <option value="">-- Tiến độ đơn hàng --</option>
            <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>⏳ Chờ xử lý</option>
            <option value="done" <?= $status === 'done' ? 'selected' : '' ?>>✔ Đã hoàn tất</option>
        </select>
    </div>
    <div class="col-auto">
        <select name="deleted" class="form-select">
            <option value="0" <?= $deleted === '0' ? 'selected' : '' ?>>📦 Đang hoạt động</option>
            <option value="1" <?= $deleted === '1' ? 'selected' : '' ?>>🗑 Đã hủy</option>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
    </div>
</form>

<!-- 🧾 Bảng đơn hàng -->
 <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="16%">Khách hàng</th>
                <th width="10%">SĐT</th>
                <th width="38%">Địa chỉ</th>
                <th width="16%">Thời gian</th>
                <th width="10%">Trạng thái</th>
                <th width="10%">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $o): ?>
                <tr class="clickable-row" data-href="<?= BASE_URL ?>/ordermanage/detail/<?= $o['id'] ?>">
                    <td><?= htmlspecialchars($o['customer_name']) ?></td>
                    <td><?= htmlspecialchars($o['phone']) ?></td>
                    <td><?= htmlspecialchars($o['address']) ?></td>
                    <td><?= $o['created_at'] ?></td>
                    <td style="text-align: center;">
                        <?php if ($o['status'] === 'pending'): ?>
                            <span class="badge bg-warning text-dark">Chờ xử lý</span>
                        <?php else: ?>
                            <span class="badge bg-success">Hoàn tất</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;" class="action-cell">
                        <?php if ($o['status'] === 'done'): ?>
                            <button class="btn btn-secondary btn-sm" disabled>Đã hoàn tất</button>
                        <?php elseif ($o['deleted']): ?>
                            <a href="<?= BASE_URL ?>/ordermanage/restore/<?= $o['id'] ?>" class="btn btn-success btn-sm">Khôi phục</a>
                        <?php else: ?>
                            <a href="<?= BASE_URL ?>/ordermanage/delete/<?= $o['id'] ?>" class="btn btn-danger btn-sm btn-huydon" onclick="return confirm('Hủy đơn này?')">Hủy</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>