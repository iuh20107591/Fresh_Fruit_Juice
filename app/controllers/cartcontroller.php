<?php
class cartcontroller extends controller {
    public function index() {
        $cart = $_SESSION['cart'] ?? [];
        require_once APP_PATH . '/views/layout/render.php';
        render_layout('cart/index', ['cart' => $cart]);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;
            $quantity = max(1, intval($_POST['quantity'] ?? 1));

            $productModel = $this->model('productmodel');
            $product = $productModel->getproductbyid($productId);

            if ($product) {
                $_SESSION['cart'][$productId] ??= [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'quantity' => 0
                ];
                $_SESSION['cart'][$productId]['quantity'] += $quantity;
            }

            header("Location: " . BASE_URL . "/cart");
            exit;
        }
    }

    public function remove($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header("Location: " . BASE_URL . "/cart");
        exit;
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
            foreach ($_POST['quantities'] as $id => $qty) {
                if (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['quantity'] = max(1, intval($qty));
                }
            }
        }
        header("Location: " . BASE_URL . "/cart");
        exit;
    }
    public function checkout() {
        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            echo "<div class='alert alert-warning'>Giỏ hàng của bạn đang trống.</div>";
            return;
        }

        require_once APP_PATH . '/views/layout/render.php';
        render_layout('cart/checkout', ['cart' => $cart]);
    }

    public function processcheckout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $cart = $_SESSION['cart'] ?? [];

            // ✅ Kiểm tra số điện thoại hợp lệ
            if (!$this->isvalidvietnamesephone($phone)) {
                echo "<script>alert('Số điện thoại không hợp lệ!'); history.back();</script>";
                exit;
            }

            if (empty($name) || empty($phone) || empty($address) || empty($cart)) {
                echo "<div class='alert alert-danger'>Vui lòng nhập đầy đủ thông tin và kiểm tra giỏ hàng.</div>";
                return;
            }

            // Kết nối database
            $config = require APP_PATH . '/config.php';
            $db = new mysqli(
                $config['db']['host'],
                $config['db']['user'],
                $config['db']['pass'],
                $config['db']['name']
            );

            // 1. Lưu đơn hàng
            $stmt = $db->prepare("INSERT INTO orders (customer_name, phone, address, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $name, $phone, $address);
            $stmt->execute();
            $orderId = $stmt->insert_id;

            // 2. Lưu từng sản phẩm
            $itemStmt = $db->prepare("INSERT INTO order_items (order_id, product_id, name, price, quantity) VALUES (?, ?, ?, ?, ?)");
            foreach ($cart as $item) {
                $itemStmt->bind_param("iisdi", $orderId, $item['id'], $item['name'], $item['price'], $item['quantity']);
                $itemStmt->execute();
            }

            unset($_SESSION['cart']);
            echo "<script>alert('Đặt hàng thành công!'); window.location.href = '" . BASE_URL . "/';</script>";
            exit;
        }
    }
    private function isvalidvietnamesephone($phone) {
        return preg_match('/^(03|05|07|08|09)\d{8}$/', $phone);
    }
}
