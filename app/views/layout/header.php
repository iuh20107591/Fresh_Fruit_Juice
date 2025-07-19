<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cửa hàng nước ép</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS + JS -->
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <!-- Scripts tùy chọn -->
    <script src="public/js/chartrevenue.js" defer></script>
    <script src="public/js/welcomemodal.js" defer></script>
    <script src="public/js/rowclick.js" defer></script>
    <script src="public/js/autorefreshbadge.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="public/js/chart.js" defer></script>
</head>
<body>

    <!-- Wrapper layout -->
    <div id="wrapper">

        <!-- Toast đơn hàng mới -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
            <div id="orderToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        🛒 Có đơn hàng mới đang chờ xử lý!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <!-- Sticky Header + Navbar -->
        <div class="sticky-top bg-white shadow-sm z-3">

            <header class="bg-success text-white py-3">
                <div class="container position-relative d-flex justify-content-between align-items-center">
                    <h1 class="mb-0 text-md-start">🍹 Cửa hàng nước ép trái cây</h1>

                    <!-- Nút i -->
                    <a href="javascript:void(0);" id="infobtn"
                    class="info-trigger text-decoration-none d-flex align-items-center">
                        <span class="circle-i flash-ping">i</span>
                        <span class="info-label ms-1">Thông tin</span>
                    </a>
                </div>
            </header>

            <nav class="navbar navbar-expand-lg navbar-light bg-light border-top border-bottom">
                <div class="container">
                    <a class="navbar-brand" href="<?= BASE_URL ?>">Trang chủ</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="mainNavbar">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a href="<?= BASE_URL ?>/cart" class="btn btn-outline-dark btn-sm">
                                    🛒 Giỏ hàng (<?= count($_SESSION['cart'] ?? []) ?>)
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            <?php if (!empty($_SESSION['username'])): ?>
                                <li class="nav-item d-flex align-items-center">
                                    <span class="me-2">👋 Xin chào, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
                                    <?php if ($_SESSION['role'] === 'seller'): ?>
                                        <a href="<?= BASE_URL ?>/statisticsmanage" class="btn btn-outline-secondary btn-sm me-2">🛠 Quản lý</a>
                                    <?php endif; ?>
                                    <a href="<?= BASE_URL ?>/auth/logout" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn đăng xuất không?')">
                                    Đăng xuất
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a href="<?= BASE_URL ?>/auth/login" class="btn btn-sm btn-outline-primary">Đăng nhập</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Modal giới thiệu cửa hàng -->
        <div class="modal fade" id="welcomemodal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="welcomeModalLabel">🍹 Chào mừng đến với Cửa hàng Nước Ép Trái Cây Tươi!</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <p>✅ Chúng tôi chuyên cung cấp các loại nước ép nguyên chất, tươi ngon, tốt cho sức khỏe.</p>
                        <!-- <p>🎁 <strong>Ưu đãi đặc biệt:</strong> Giảm giá 10% cho đơn hàng đầu tiên!</p> -->
                        <p>📦 Giao hàng tận nơi trong khu vực Bình Trị. Cam kết giao nhanh – ép mới – không chất bảo quản.</p>
                        <p><strong>⚠️Quan trọng: Cửa hàng chỉ hoạt động từ 07h00 đến 16h30 hàng ngày, sau thời gian này sẽ không nhận đơn!</strong></p>
                        <p class="text-muted"><small>— Cảm ơn bạn đã ghé thăm chúng tôi! 🥰🥰🥰</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Tôi đã hiểu</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nội dung chính -->
        <main class="container my-4 flex-fill">
