<?php
class productmodel {
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

    public function getproductbyid($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ? AND status = 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function filterproducts($cat_id = null, $minPrice = 0, $maxPrice = 1000000) {
        $sql = "SELECT p.*, 
                    c1.cat_name AS cat1_name, 
                    c2.cat_name AS cat2_name
                FROM products p
                LEFT JOIN category c1 ON p.mix_cat1 = c1.cat_id
                LEFT JOIN category c2 ON p.mix_cat2 = c2.cat_id
                WHERE p.price BETWEEN ? AND ? 
                AND p.status = 1
                AND (IFNULL(c1.status, 1) = 1 AND IFNULL(c2.status, 1) = 1)";

        $params = [$minPrice, $maxPrice];
        $types = "dd";

        if (isset($cat_id) && is_numeric($cat_id)) {
            $sql .= " AND (p.mix_cat1 = ? OR p.mix_cat2 = ?)";
            $params[] = $cat_id;
            $params[] = $cat_id;
            $types .= "ii";
        }

        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            die("SQL error: " . $this->db->error);
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getallcategories() {
        $stmt = $this->db->prepare("SELECT cat_id, cat_name FROM category WHERE status = 1 ORDER BY cat_name ASC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getproductsbyseller($seller) {
        $sql = "SELECT p.*, 
                    c1.cat_name AS cat1_name, 
                    c2.cat_name AS cat2_name
                FROM products p
                LEFT JOIN category c1 ON p.mix_cat1 = c1.cat_id
                LEFT JOIN category c2 ON p.mix_cat2 = c2.cat_id
                WHERE p.seller = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $seller);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteproduct($id, $seller) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ? AND seller = ?");
        $stmt->bind_param("is", $id, $seller);
        $stmt->execute();
    }

    public function addproduct($name, $desc, $price, $image, $mix1, $mix2, $seller) {
        $stmt = $this->db->prepare("INSERT INTO products (name, description, price, image, mix_cat1, mix_cat2, seller) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsiis", $name, $desc, $price, $image, $mix1, $mix2, $seller);
        $stmt->execute();
    }

    public function updateproduct($id, $name, $desc, $price, $image, $mix1, $mix2) {
        $stmt = $this->db->prepare("UPDATE products 
                                    SET name = ?, description = ?, price = ?, image = ?, mix_cat1 = ?, mix_cat2 = ? 
                                    WHERE id = ?");
        $stmt->bind_param("ssdsiii", $name, $desc, $price, $image, $mix1, $mix2, $id);
        $stmt->execute();
    }

    public function toggleproductstatus($id, $seller) {
        $stmt = $this->db->prepare("UPDATE products SET status = NOT status WHERE id = ? AND seller = ?");
        $stmt->bind_param("is", $id, $seller);
        $stmt->execute();
    }
}
?>