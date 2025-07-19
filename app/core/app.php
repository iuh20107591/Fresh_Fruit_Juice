<?php
    class app {
        protected $controller = 'homecontroller';
        protected $method = 'index';
        protected $params = [];

        public function __construct() {
            $url = $this->parseUrl();
            if (!empty($url[0]) && file_exists(APP_PATH . '/controllers/' . ucfirst($url[0]) . 'controller.php')) {
                $this->controller = ucfirst($url[0]) . 'controller';
                unset($url[0]);
            }
            require_once APP_PATH . '/controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller;

            if (isset($url[1]) && method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
            $this->params = $url ? array_values($url) : [];
            call_user_func_array([$this->controller, $this->method], $this->params);
        }

        public function parseurl() {
            if (isset($_GET['url'])) {
                return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
            }
            return [];
        }
    }
?>