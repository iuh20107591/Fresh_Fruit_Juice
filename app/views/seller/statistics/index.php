<h3 class="mb-4">📊 Báo cáo thống kê</h3>

<?php
// Các khoảng thời gian mặc định
$today = date('Y-m-d');
$monday = date('Y-m-d', strtotime('monday this week'));
$firstOfMonth = date('Y-m-01');
$firstOfQuarter = date('Y-m-01', strtotime(date('Y-m-01') . ' -' . ((date('n') - 1) % 3) . ' months'));
$firstOfYear = date('Y-01-01');
?>
<div class="mb-3">
    <a href="<?= BASE_URL ?>/statisticsmanage" class="btn btn-sm btn-outline-dark">🔁 Toàn bộ</a>
    <a href="?from=<?= $monday ?>&to=<?= $today ?>" class="btn btn-sm btn-outline-primary">📆 Tuần này</a>
    <a href="?from=<?= $firstOfMonth ?>&to=<?= $today ?>" class="btn btn-sm btn-outline-success">📅 Tháng này</a>
    <a href="?from=<?= $firstOfQuarter ?>&to=<?= $today ?>" class="btn btn-sm btn-outline-warning">📊 Quý này</a>
    <a href="?from=<?= $firstOfYear ?>&to=<?= $today ?>" class="btn btn-sm btn-outline-info">🗓 Năm nay</a>
</div>

<form method="get" class="row g-2 mb-4">
    <div class="col-md-3">
        <label>Từ ngày</label>
        <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($_GET['from'] ?? '') ?>">
    </div>
    <div class="col-md-3">
        <label>Đến ngày</label>
        <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($_GET['to'] ?? '') ?>">
    </div>
    <div class="col-md-3 align-self-end">
        <button type="submit" class="btn btn-primary">📊 Thống kê</button>
    </div>
</form>

<?php if ($from || $to): ?>
    <div class="alert alert-info">
        Đang lọc theo khoảng: 
        <strong><?= $from ?: '---' ?></strong> → 
        <strong><?= $to ?: '---' ?></strong>
    </div>
<?php endif; ?>

<div class="row text-center mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Tổng đơn hàng</h5>
                <h3><?= $totalOrders ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h5>Chờ xử lý</h5>
                <h3><?= $pendingOrders ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Đã hoàn thành</h5>
                <h3><?= $doneOrders ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5>Tổng doanh thu</h5>
                <h3><?= number_format($totalRevenue) ?> VND</h3>
            </div>
        </div>
    </div>
</div>

<h5 class="mt-4">🥤 Top sản phẩm bán chạy</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Số lượng đã bán</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($topProducts as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= $product['total_sold'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h5 class="mt-5">📈 Biểu đồ sản phẩm bán chạy</h5>
<canvas id="bestSellingChart" height="100"></canvas>

<script>
    const chartData = <?= json_encode($topProducts) ?>;
</script>

<h5 class="mt-5">📉 Biểu đồ doanh thu theo thời gian</h5>
<canvas id="revenueChart" height="100"></canvas>

<script>
    const revenueData = <?= json_encode($revenueOverTime) ?>;
</script>
