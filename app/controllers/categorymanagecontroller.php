<?php
class categorymanagecontroller extends controller {
    public function index() {
        if ($_SESSION['role'] !== 'seller') exit;

        $model = $this->model('categorymodel');
        $categories = $model->getall();

        $orderModel = $this->model('ordermodel');

        $from = $_GET['from'] ?? null;
        $to = $_GET['to'] ?? null;

        $pendingCount = $orderModel->countordersbystatus('pending', $from, $to);

        require_once APP_PATH . '/views/layout/render.php';
        render_layout('seller/category/index', [
            'categories' => $categories,
            'pendingCount' => $pendingCount,

            // ✅ Truyền thêm biến vào view
            'from' => $from,
            'to' => $to]);
    }

    public function toggle($id) {
        if ($_SESSION['role'] !== 'seller') exit;

        $model = $this->model('categorymodel');
        $model->togglestatus($id);
        header("Location: " . BASE_URL . "/categorymanage");
    }

    public function add() {
        if ($_SESSION['role'] !== 'seller') exit;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['cat_name'];
            $model = $this->model('categorymodel');
            $model->add($name);
            header("Location: " . BASE_URL . "/categorymanage");
        }
        require_once APP_PATH . '/views/layout/render.php';
        render_layout('seller/category/add');
    }

    public function delete($id) {
        if ($_SESSION['role'] !== 'seller') exit;

        $model = $this->model('categorymodel');
        $model->delete($id);
        header("Location: " . BASE_URL . "/categorymanage");
    }
}
