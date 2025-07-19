<?php
class productcontroller extends controller {
    public function index() {
        $productModel = $this->model('productmodel');
        $cat_id = $_GET['cat_id'] ?? null;
        $minPrice = isset($_GET['min_price']) && is_numeric($_GET['min_price']) ? $_GET['min_price'] : 0;
        $maxPrice = isset($_GET['max_price']) && is_numeric($_GET['max_price']) ? $_GET['max_price'] : 1000000;

        $products = $productModel->filterproducts($cat_id, $minPrice, $maxPrice);
        $categories = $productModel->getallcategories();

        require_once APP_PATH . '/views/layout/render.php';
        render_layout('product/index', [
            'products' => $products,
            'filters' => compact('cat_id', 'minPrice', 'maxPrice'),
            'categories' => $categories
        ]);
    }

    public function detail($id) {
        $productModel = $this->model('productmodel');
        $product = $productModel->getproductbyid($id);
        if ($product) {
            require_once APP_PATH . '/views/layout/render.php';
            render_layout('product/detail', ['product' => $product]);
        } else {
            echo "<div class='alert alert-danger'>Sản phẩm không tồn tại.</div>";
        }
    }
}
