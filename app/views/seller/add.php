<h3 class="mb-4">➕ Thêm sản phẩm mới</h3>
<form method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Tên sản phẩm</label>
        <input type="text" name="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Mô tả</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label>Giá</label>
        <input type="number" name="price" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Loại trái cây</label>
        <div class="mb-3">
    <label>Loại trái cây 1</label>
        <select name="mix_cat1" class="form-select">
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['cat_id'] ?>"><?= $c['cat_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Loại trái cây 2</label>
        <select name="mix_cat2" class="form-select">
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['cat_id'] ?>"><?= $c['cat_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    </div>
    <div class="mb-3">
        <label>Ảnh sản phẩm</label>
        <input type="file" name="image" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
    <a href="<?= BASE_URL ?>/productmanage" class="btn btn-secondary">Quay lại</a>
</form>
