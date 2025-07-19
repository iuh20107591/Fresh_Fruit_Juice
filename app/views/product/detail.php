<div class="row">
    <div class="col-md-6">
        <img src="<?= BASE_URL ?>/public/images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid rounded">
    </div>
    <div class="col-md-6">
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
        <h4 class="text-success fw-bold">Giá: <?= number_format($product['price']) ?> VND</h4>

        <form method="post" action="<?= BASE_URL ?>/cart/add">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng</label>
                <input type="number" name="quantity" id="quantity" value="1" class="form-control" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm vào giỏ hàng</button>
        </form>
    </div>
</div>