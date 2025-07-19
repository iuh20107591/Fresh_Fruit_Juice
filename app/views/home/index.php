<!DOCTYPE html>
<html>
<head>
    <title>Trang chủ</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center text-success"><?= $data['message'] ?></h1>
    <div class="text-center mt-3">
        <a href="/auth/login" class="btn btn-outline-primary">Đăng nhập</a>
    </div>
</div>
</body>
</html>