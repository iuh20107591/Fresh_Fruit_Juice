<div class="sticky-sidebar mb-4">
    <form method="get" action="<?= BASE_URL ?>/product/index">
        <div class="mb-2">
            <select name="cat_id" class="form-select">
                <option value="">-- Tất cả loại trái cây --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['cat_id'] ?>" <?= ($filters['cat_id'] ?? '') == $cat['cat_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['cat_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-2">
            <input type="number" name="min_price" class="form-control" placeholder="Giá tối thiểu"
                   value="<?= htmlspecialchars($filters['minPrice'] ?? '') ?>">
        </div>
        <div class="mb-2">
            <input type="number" name="max_price" class="form-control" placeholder="Giá tối đa"
                   value="<?= htmlspecialchars($filters['maxPrice'] ?? '') ?>">
        </div>
        <button type="submit" class="btn btn-primary w-100">Lọc</button>
    </form>
</div>
