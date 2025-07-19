<?php
class productmanagecontroller extends controller {
    public function index() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') {
            echo "<script>
                            alert('Bạn không có quyền truy cập! Vui lòng đăng nhập!');
                            window.location.href = '" . BASE_URL . "/auth/login';
                        </script>";
            exit;
        }

        $productModel = $this->model('productmodel');
        $products = $productModel->getproductsbyseller('seller1'); // chỉ 1 người bán
        $orderModel = $this->model('ordermodel');
        

        $from = $_GET['from'] ?? null;
        $to = $_GET['to'] ?? null;

        $pendingCount = $orderModel->countordersbystatus('pending', $from, $to);

        require_once APP_PATH . '/views/layout/render.php';
        render_layout('seller/manage', [
            'products' => $products,
            'pendingCount' => $pendingCount,

            // ✅ Truyền thêm biến vào view
            'from' => $from,
            'to' => $to]);
    }

    public function delete($id) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'seller') exit;

        $productModel = $this->model('productmodel');
        $product = $productModel->getproductbyid($id);

        if (!$product || $product['seller'] !== 'seller1') {
            echo "<script>alert('Sản phẩm không tồn tại hoặc không thuộc quyền của bạn!'); location.href='" . BASE_URL . "/productmanage';</script>";
            exit;
        }

        if ($product['status'] == 0) {
            echo "<script>alert('Sản phẩm đang ẩn, không thể xoá!'); location.href='" . BASE_URL . "/productmanage';</script>";
            exit;
        }

        $productModel->deleteproduct($id, 'seller1');

        echo "<script>alert('Xoá sản phẩm thành công!'); location.href='" . BASE_URL . "/productmanage';</script>";
        exit;
    }

    public function add() {
        if ($_SESSION['role'] !== 'seller') exit;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productModel = $this->model('productmodel');

            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $mix_cat1 = $_POST['mix_cat1'];
            $mix_cat2 = $_POST['mix_cat2'];
            $image = $_FILES['image']['name'];

            // upload ảnh
            if (!empty($image)) {
                move_uploaded_file($_FILES['image']['tmp_name'], PUBLIC_PATH . '/images/' . $image);
            }

            $productModel->addproduct($name, $description, $price, $image, $mix_cat1, $mix_cat2, 'seller1');
            echo "<script>
                    alert('Thêm sản phẩm mới thành công!');
                    window.location.href = '" . BASE_URL . "/productmanage';
                </script>";
                exit;
        }

        // Hiển thị form
        $productModel = $this->model('productmodel');
        $categories = $productModel->getallcategories();

        require_once APP_PATH . '/views/layout/render.php';
        render_layout('seller/add', [
            'categories' => $categories,]);
    }

    public function edit($id) {
        if ($_SESSION['role'] !== 'seller') exit;

        $productModel = $this->model('productmodel');
        $product = $productModel->getproductbyid($id);

        if (!$product || $product['seller'] !== 'seller1') {
            echo "Không tìm thấy sản phẩm hoặc không có quyền.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $mix_cat1 = $_POST['mix_cat1'];
            $mix_cat2 = $_POST['mix_cat2'];
            $image = $product['image'];

            if (!empty($_FILES['image']['name'])) {
                $image = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], PUBLIC_PATH . '/images/' . $image);
            }

            $productModel->updateproduct($id, $name, $description, $price, $image, $mix_cat1, $mix_cat2);
            echo "<script>
                            alert('Sửa sản phẩm thành công!');
                            window.location.href = '" . BASE_URL . "/productmanage';
                        </script>";
            exit;
        }

        $categories = $productModel->getallcategories();
        require_once APP_PATH . '/views/layout/render.php';
        render_layout('seller/edit', ['product' => $product, 'categories' => $categories]);
    }
        public function toggle($id) {
        if ($_SESSION['role'] !== 'seller') exit;

        $productModel = $this->model('productmodel');
        $productModel->toggleproductstatus($id, 'seller1');
        header("Location: " . BASE_URL . "/productmanage");
    }
}