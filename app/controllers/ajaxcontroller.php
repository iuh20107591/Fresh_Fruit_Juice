<?php
class ajaxcontroller extends controller {
    public function pendingcount() {
        if ($_SESSION['role'] !== 'seller') exit;

        $orderModel = $this->model('ordermodel');
        $pending = $orderModel->countordersbystatus('pending');

        echo json_encode(['pending' => $pending]);
    }
}
