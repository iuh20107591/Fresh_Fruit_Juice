<?php
    class usermodel {
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

        public function authenticate($username, $password) {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
    }
?>