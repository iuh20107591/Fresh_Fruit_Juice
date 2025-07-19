<?php
    class homecontroller extends controller {
        public function index() {
            $productModel = $this->model('productmodel');
            $products = $productModel->filterproducts();

            require_once APP_PATH . '/views/layout/render.php';
            render_layout('product/index', ['products' => $products]);
        }
    }
?>