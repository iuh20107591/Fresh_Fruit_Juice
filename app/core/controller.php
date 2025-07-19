<?php
    class controller {
        public function model($model) {
            require_once APP_PATH . '/models/' . $model . '.php';
            return new $model();
        }

        public function view($view, $data = []) {
            require_once APP_PATH . '/views/' . $view . '.php';
        }
    }
?>