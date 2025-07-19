<?php
class ordermanagecontroller extends controller {
    public function index() {
        if ($_SESSION['role'] !== 'seller') exit;

        $status = $_GET['status'] ?? '';
        $deleted = isset($_GET['deleted']) ? $_GET['deleted'] : '0'; // giữ dạng chuỗi

        $orderModel = $this->model('ordermodel');

        // ✅ Lấy danh sách đơn hàng theo bộ lọc trạng thái và xóa
        $orders = $orderModel->getordersbystatusanddeleted($status, $deleted);

        // ✅ Đếm số lượng đơn (chỉ lấy số, không lấy mảng!)
        $pendingCount = count($orderModel->getordersbystatusanddeleted('pending', 0));
        $doneCount = count($orderModel->getordersbystatusanddeleted('done', 0));
        $deletedCount = count($orderModel->getordersbystatusanddeleted('', 1));

        require_once APP_PATH . '/views/layout/render.php';
        render_layout('seller/orders/index', [
            'orders' => $orders,
            'status' => $status,
            'pendingCount' => $pendingCount,
            'doneCount' => $doneCount,
            'deleted' => $deleted,
            'deletedCount' => $deletedCount
        ]);
    }

    public function detail($id) {
        if ($_SESSION['role'] !== 'seller') exit;
        $status = $_GET['status'] ?? '';
        $orderModel = $this->model('ordermodel');
        $order = $orderModel->getorderbyid($id);
        $items = $orderModel->getorderitems($id);

        $pendingCount = count($orderModel->getordersbystatusanddeleted('pending', 0));

        require_once APP_PATH . '/views/layout/render.php';
        render_layout('seller/orders/detail', [
            'order' => $order,
            'status' => $status,
            'items' => $items,
            'pendingCount' => $pendingCount
        ]);
    }

    public function delete($id) {
        $orderModel = $this->model('ordermodel');
        $orderModel->softdelete($id);

        echo "<script>alert('Đã chuyển đơn vào thùng rác'); location.href='" . BASE_URL . "/ordermanage';</script>";
    }

    public function restore($id) {
        $orderModel = $this->model('ordermodel');
        $orderModel->restore($id);

        echo "<script>alert('Đã khôi phục đơn hàng'); location.href='" . BASE_URL . "/ordermanage?deleted=1';</script>";
    }
    
    public function markdone($id) {
        if ($_SESSION['role'] !== 'seller') exit;

        $orderModel = $this->model('ordermodel');
        $orderModel->markasdone($id);
        header("Location: " . BASE_URL . "/ordermanage");
    }
}
