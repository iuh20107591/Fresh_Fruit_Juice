<h2 class="mb-4">Sản phẩm nước ép</h2>

<?php if (!empty($products)): ?>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?= BASE_URL ?>/public/images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>"
                         class="card-img-top" style="height: 210px;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="text-muted">
                            Loại: 
                            <?= htmlspecialchars($product['cat1_name'] ?? '') ?>
                            <?= $product['cat2_name'] ? ' + ' . htmlspecialchars($product['cat2_name']) : '' ?>
                        </p>
                        <p class="card-text text-truncate"><?= htmlspecialchars($product['description']) ?></p>
                        <p class="text-success fw-bold"><?= number_format($product['price']) ?> VND</p>
                        <a href="<?= BASE_URL ?>/product/detail/<?= $product['id'] ?>" class="btn btn-outline-info">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="alert alert-warning">Không có sản phẩm nào phù hợp.</div>
<?php endif; ?>
