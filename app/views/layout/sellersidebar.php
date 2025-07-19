<div class="list-group mb-4 sticky-sidebar">
    <a href="<?= BASE_URL ?>/statisticsmanage"
    class="list-group-item list-group-item-action<?= str_contains($_SERVER['REQUEST_URI'], 'statisticsmanage') ? ' active' : '' ?>">
        📊 Báo cáo thống kê
    </a>
    <a href="<?= BASE_URL ?>/productmanage" class="list-group-item list-group-item-action<?= str_contains($_SERVER['REQUEST_URI'], 'productmanage') ? ' active' : '' ?>">
        📦 Quản lý sản phẩm
    </a>
    <a href="<?= BASE_URL ?>/categorymanage" class="list-group-item list-group-item-action<?= str_contains($_SERVER['REQUEST_URI'], 'categorymanage') ? ' active' : '' ?>">
        📂 Quản lý loại sản phẩm
    </a>
    <a href="<?= BASE_URL ?>/ordermanage"
        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center<?= str_contains($_SERVER['REQUEST_URI'], 'ordermanage') ? ' active' : '' ?>">
        🧾 Quản lý đơn hàng
        <?php if (!empty($pendingCount)): ?>
            <span class="badge bg-danger rounded-pill" id="pendingBadge">
                <?= $pendingCount ?>
            </span>
        <?php endif; ?>
    </a>
</div>
