<?php
require_once 'config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Semua field harus diisi!";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role, status, subscription_status FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            if ($user['status'] == 'blocked') {
                $error = "Akun Anda telah diblokir. Hubungi administrator.";
            } else if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                if ($user['role'] == 'admin') {
                    header("Location: Admin/index.php");
                } else {
                    if ($user['subscription_status'] == 'paid') {
                        header("Location: User/index.php");
                    } else {
                        header("Location: subscribe.php");
                    }
                }
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SETskill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { background-color: var(--light-blue); display: flex; align-items: center; min-height: 100vh; }
    </style>
</head>
<body>
    <div class="container">
        <div class="auth-container">
            <div class="auth-header">
                <a href="index.php" class="text-decoration-none">
                    <h2>SETskill</h2>
                </a>
                <p class="text-muted">Silakan masuk ke akun Anda</p>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required autofocus>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-custom-primary w-100 mb-3">Masuk</button>
                <div class="text-center">
                    <p class="mb-0 text-muted">Belum punya akun? <a href="register.php" class="text-primary text-decoration-none fw-bold">Daftar sekarang</a></p>
                    <a href="index.php" class="text-muted small text-decoration-none mt-2 d-inline-block">&larr; Kembali ke Beranda</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
