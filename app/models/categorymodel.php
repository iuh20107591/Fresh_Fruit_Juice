<?php
class categorymodel {
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

    public function getall() {
        return $this->db->query("SELECT * FROM category")->fetch_all(MYSQLI_ASSOC);
    }

    public function togglestatus($id) {
        $this->db->query("UPDATE category SET status = NOT status WHERE cat_id = " . intval($id));
    }

    public function add($name) {
        $stmt = $this->db->prepare("INSERT INTO category (cat_name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
    }

    public function delete($id) {
        $this->db->query("DELETE FROM category WHERE cat_id = " . intval($id));
    }
}
