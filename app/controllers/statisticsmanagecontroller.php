<?php
class statisticsmanagecontroller extends controller {
    public function index() {
        if ($_SESSION['role'] !== 'seller') exit;

        $orderModel = $this->model('ordermodel');
        

        $from = $_GET['from'] ?? null;
        $to = $_GET['to'] ?? null;

        $pendingCount = $orderModel->countordersbystatus('pending', $from, $to);
        
        $data = [
            'totalOrders' => $orderModel->countordersinrange($from, $to),
            'doneOrders' => $orderModel->countordersbystatus('done', $from, $to),
            'pendingOrders' => $orderModel->countordersbystatus('pending', $from, $to),
            'totalRevenue' => $orderModel->calculaterevenueinrange($from, $to),
            'topProducts' => $orderModel->getbestsellingproducts($from, $to),
            'revenueOverTime' => $orderModel->getrevenueovertime($from, $to),
            'pendingCount' => $pendingCount,

            // ✅ Truyền thêm biến vào view
            'from' => $from,
            'to' => $to
        ];

        require_once APP_PATH . '/views/layout/render.php';
        render_layout('seller/statistics/index', $data);
    }
}
