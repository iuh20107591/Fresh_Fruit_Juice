<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config.php';

$url = isset($_GET['url']) ? explode('/', trim($_GET['url'], '/')) : [];

$controllerName = !empty($url[0]) ? $url[0] . 'controller' : 'homecontroller';
$actionName = $url[1] ?? 'index';
$params = array_slice($url, 2);

$controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName;

    if (method_exists($controller, $actionName)) {
        call_user_func_array([$controller, $actionName], $params);
    } else {
        echo "Không tìm thấy action <b>$actionName()</b>";
    }
} else {
    echo "Không tìm thấy controller <b>$controllerName</b>";
}
?>