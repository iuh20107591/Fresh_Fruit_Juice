<h3 class="mb-4">✏️ Cập nhật sản phẩm</h3>
<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Tên sản phẩm</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
    </div>
    <div class="mb-3">
        <label>Giá</label>
        <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Loại trái cây 1</label>
        <select name="mix_cat1" class="form-select">
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['cat_id'] ?>" <?= (isset($product['mix_cat1']) && $product['mix_cat1'] == $c['cat_id']) ? 'selected' : '' ?>>
                    <?= $c['cat_name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Loại trái cây 2</label>
        <select name="mix_cat2" class="form-select">
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['cat_id'] ?>" <?= (isset($product['mix_cat2']) && $product['mix_cat2'] == $c['cat_id']) ? 'selected' : '' ?>>
                    <?= $c['cat_name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Ảnh hiện tại</label><br>
        <img src="<?= BASE_URL ?>/public/images/<?= $product['image'] ?>" width="120"><br><br>
        <label>Thay ảnh mới (nếu có):</label>
        <input type="file" name="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
    <a href="<?= BASE_URL ?>/productmanage" class="btn btn-secondary">Quay lại</a>
</form>
