<?php
    class authcontroller extends controller {
        public function login() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userModel = $this->model('usermodel');
                $user = $userModel->authenticate($_POST['username'], $_POST['password']);
                if ($user) {
                    $_SESSION['user'] = $user;
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    echo "<script>
                            alert('Đăng nhập thành công!');
                            window.location.href = '" . BASE_URL . "/';
                        </script>";
                    exit;
                } else {
                    require_once APP_PATH . '/views/layout/render.php';
                    render_layout('auth/login', ['error' => 'Sai thông tin đăng nhập']);
                }
            } else {
                require_once APP_PATH . '/views/layout/render.php';
                render_layout('auth/login');
            }
        }

        public function logout() {
            session_destroy();
            echo "<script>
                    alert('Đăng xuất thành công!');
                    window.location.href = '" . BASE_URL . "/';
                </script>";
        }
    }
?>