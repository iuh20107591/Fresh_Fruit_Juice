<?php
function render_layout($view, $data = []) {
    extract($data); // Giải nén tất cả biến từ mảng $data

    require_once APP_PATH . '/views/layout/header.php';

    echo '<div class="row">';

    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $basePath = rtrim(BASE_URL, '/');

    // Xác định có hiển thị sidebar khách hàng không
    $showUserSidebar = (
        ($currentPath === $basePath || $currentPath === $basePath . '/') ||
        (str_contains($view, 'product') && !str_contains($view, 'detail'))
    );

    // Xác định có hiển thị sidebar quản lý của người bán không (Thêm trang mới vào sidebar)
    $showSellerSidebar = str_contains($currentPath, '/productmanage') || 
                        str_contains($currentPath, '/categorymanage') || 
                        str_contains($currentPath, '/statisticsmanage') ||
                        str_contains($currentPath, '/ordermanage');

    if ($showUserSidebar) {
        // Tự động nạp danh mục nếu chưa có
        if (!isset($categories)) {
            require_once APP_PATH . '/models/productmodel.php';
            $productModel = new productmodel();
            $categories = $productModel->getallcategories();
        }

        echo '<div class="col-md-3">';
        require APP_PATH . '/views/layout/sidebar.php';
        echo '</div>';

        echo '<div class="col-md-9">';
    } elseif ($showSellerSidebar) {
        echo '<div class="col-md-2">';
        require APP_PATH . '/views/layout/sellersidebar.php';
        echo '</div>';

        echo '<div class="col-md-10">';
    } else {
        echo '<div class="col-12">';
    }

    require_once APP_PATH . "/views/$view.php";

    echo '</div>'; // col
    echo '</div>'; // row

    require_once APP_PATH . '/views/layout/footer.php';
}
?>