<?php
require_once 'config.php';

// Cek apakah user sudah login
if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

// Ambil status user dari database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, subscription_status FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();

$status = $user_data['subscription_status'];

// Jika sudah paid, langsung lempar ke dashboard
if ($status == 'paid') {
    if ($_SESSION['role'] == 'admin') {
        header("Location: Admin/index.php");
    } else {
        header("Location: User/index.php");
    }
    exit();
}

$error = '';
$success = '';

// Proses upload bukti pembayaran
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['payment_proof'])) {
    if ($_FILES['payment_proof']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        $filename = $_FILES['payment_proof']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_filename = uniqid('pay_') . '.' . $ext;
            $upload_path = 'assets/uploads/payments/' . $new_filename;
            
            if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $upload_path)) {
                // Update database
                $update_stmt = $conn->prepare("UPDATE users SET subscription_status = 'waiting_verification', payment_proof = ? WHERE id = ?");
                $update_stmt->bind_param("si", $new_filename, $user_id);
                if ($update_stmt->execute()) {
                    $status = 'waiting_verification';
                    $success = "Bukti pembayaran berhasil diunggah. Silakan tunggu verifikasi dari Admin (maks 1x24 jam).";
                } else {
                    $error = "Terjadi kesalahan saat menyimpan ke database.";
                }
                $update_stmt->close();
            } else {
                $error = "Gagal menyimpan file yang diunggah.";
            }
        } else {
            $error = "Format file tidak diizinkan. Gunakan JPG, PNG, atau PDF.";
        }
    } else {
        $error = "Silakan pilih file bukti pembayaran terlebih dahulu.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Langganan - SETskill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body { background-color: var(--light-blue); display: flex; align-items: center; min-height: 100vh; padding: 40px 0; }
        .subscribe-container { max-width: 600px; margin: auto; background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    </style>
</head>
<body>
    <div class="container">
        <div class="subscribe-container">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary mb-2">Selesaikan Pendaftaran Anda</h2>
                <p class="text-muted">Halo, <?php echo htmlspecialchars($user_data['name']); ?>! Untuk mulai bertukar skill, silakan selesaikan proses langganan.</p>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if ($status == 'waiting_verification'): ?>
                <div class="text-center py-4">
                    <img src="https://cdn-icons-png.flaticon.com/512/942/942748.png" alt="Waiting" width="100" class="mb-3 opacity-75">
                    <h5 class="fw-bold text-warning">Menunggu Verifikasi Pembayaran</h5>
                    <p class="text-muted mb-4">Tim kami sedang memverifikasi bukti pembayaran Anda. Proses ini biasanya memakan waktu maksimal 1x24 jam.</p>
                    <a href="subscribe.php" class="btn btn-outline-primary rounded-pill px-4">Muat Ulang Status</a>
                    <a href="logout.php" class="btn btn-link text-muted mt-2 d-block">Keluar</a>
                </div>
            <?php else: ?>
                <div class="card border-primary mb-4 bg-primary bg-opacity-10 border-2 border-opacity-50">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold mb-0">Biaya Langganan (Seumur Hidup)</h6>
                            <h4 class="fw-bold text-primary mb-0">Rp 50.000</h4>
                        </div>
                        <p class="small text-muted mb-0">Satu kali bayar, nikmati akses penuh selamanya.</p>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold mb-3">Metode Pembayaran</h6>
                    <div class="p-3 border rounded-3 bg-light mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">Virtual Account (Semua Bank)</div>
                            <div class="text-primary fw-bold fs-5" style="letter-spacing: 2px;" id="va-number">88000 1234 5678 901</div>
                        </div>
                        <button class="btn btn-sm btn-outline-secondary" onclick="navigator.clipboard.writeText('8800012345678901'); alert('Nomor VA disalin!');">Salin</button>
                    </div>
                    <small class="text-muted">Anda bisa mentransfer dari aplikasi M-Banking atau e-Wallet apapun ke nomor Virtual Account di atas.</small>
                </div>

                <hr class="my-4">

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Konfirmasi Pembayaran</h6>
                        <label class="form-label text-muted small">Unggah Foto Bukti Transfer</label>
                        <input class="form-control" type="file" name="payment_proof" accept=".jpg,.jpeg,.png,.pdf" required>
                        <div class="form-text">Format: JPG, PNG, atau PDF. Maksimal 2MB.</div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill">Kirim Bukti Pembayaran</button>
                        <a href="logout.php" class="btn btn-light rounded-pill">Keluar</a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
