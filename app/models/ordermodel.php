<?php
class ordermodel {
    private $db;

    public function __construct() {
        $config = require APP_PATH . '/config.php';
        $this->db = new mysqli(
            $config['db']['host'],
            $config['db']['user'],
            $config['db']['pass'],
            $config['db']['name']
        );
        $this->db->set_charset("utf8");
    }

    public function getallorders($status = null, $includeDeleted = false) {
        $sql = "SELECT * FROM orders WHERE 1";

        if (!$includeDeleted) {
            $sql .= " AND deleted = 0";
        }

        if ($status) {
            $sql .= " AND status = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("s", $status);
        } else {
            $stmt = $this->db->prepare($sql);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getorderbyid($id) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getorderitems($order_id) {
        $stmt = $this->db->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteorder($id) {
        $stmt1 = $this->db->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();

        $stmt2 = $this->db->prepare("DELETE FROM orders WHERE id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
    }
    public function markasdone($id) {
        $stmt = $this->db->prepare("UPDATE orders SET status = 'done' WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
    public function countallorders() {
        return $this->db->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];
    }

    public function calculatetotalrevenue() {
        return $this->db->query("SELECT SUM(price * quantity) AS total FROM order_items")->fetch_assoc()['total'] ?? 0;
    }

    public function countordersinRange($from, $to) {
        $sql = "SELECT COUNT(*) AS total FROM orders WHERE 1";
        $params = [];
        if ($from) {
            $sql .= " AND created_at >= ?";
            $params[] = $from;
        }
        if ($to) {
            $sql .= " AND created_at <= ?";
            $params[] = $to . ' 23:59:59';
        }

        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function getordersbystatusanddeleted($status = '', $deleted = '0') {
        $sql = "SELECT * FROM orders WHERE deleted = ?";
        $params = [$deleted];
        $types = "i";

        if (!empty($status)) {
            $sql .= " AND status = ?";
            $params[] = $status;
            $types .= "s";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function calculaterevenueinRange($from = null, $to = null) {
        $sql = "
            SELECT SUM(oi.price * oi.quantity) AS total
            FROM order_items oi
            JOIN orders o ON o.id = oi.order_id
            WHERE 1
        ";
        $params = [];

        if ($from) {
            $sql .= " AND o.created_at >= ?";
            $params[] = $from;
        }
        if ($to) {
            $sql .= " AND o.created_at <= ?";
            $params[] = $to . ' 23:59:59';
        }

        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'] ?? 0;
    }

    public function getbestsellingproducts($from = null, $to = null, $limit = 5) {
        $sql = "
            SELECT oi.name, SUM(oi.quantity) AS total_sold
            FROM order_items oi
            JOIN orders o ON o.id = oi.order_id
            WHERE 1
        ";
        $params = [];

        if ($from) {
            $sql .= " AND o.created_at >= ?";
            $params[] = $from;
        }
        if ($to) {
            $sql .= " AND o.created_at <= ?";
            $params[] = $to . ' 23:59:59';
        }

        $sql .= " GROUP BY oi.product_id ORDER BY total_sold DESC LIMIT ?";
        $params[] = $limit;

        $types = str_repeat('s', count($params) - 1) . 'i';

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getrevenueovertime($from = null, $to = null) {
        $sql = "
            SELECT DATE(created_at) AS date, SUM(oi.price * oi.quantity) AS revenue
            FROM order_items oi
            JOIN orders o ON o.id = oi.order_id
            WHERE 1
        ";
        $params = [];

        if ($from) {
            $sql .= " AND o.created_at >= ?";
            $params[] = $from;
        }
        if ($to) {
            $sql .= " AND o.created_at <= ?";
            $params[] = $to . ' 23:59:59';
        }

        $sql .= " GROUP BY DATE(o.created_at) ORDER BY DATE(o.created_at) ASC";

        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function softdelete($id) {
        $stmt = $this->db->prepare("UPDATE orders SET deleted = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function restore($id) {
        $stmt = $this->db->prepare("UPDATE orders SET deleted = 0 WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function getdeletedorders() {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE deleted = 1 ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function countordersbystatus($status, $from = null, $to = null) {
        $sql = "SELECT COUNT(*) AS total FROM orders WHERE status = ? AND deleted = 0";
        $params = [$status];
        $types = "s";

        if ($from) {
            $sql .= " AND created_at >= ?";
            $params[] = $from;
            $types .= "s";
        }

        if ($to) {
            $sql .= " AND created_at <= ?";
            $params[] = $to . ' 23:59:59';
            $types .= "s";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc()['total'] ?? 0;
    }
}