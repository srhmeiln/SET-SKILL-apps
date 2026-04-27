<?php
session_start();

// ==============================================================================
// KONFIGURASI DATABASE
// Ubah bagian ini sesuai dengan kredensial dari Web Hosting / cPanel Anda.
// ==============================================================================

$host = 'localhost';          // Biasanya tetap 'localhost' untuk kebanyakan hosting
$user = 'root';               // Ganti dengan Username Database di Hosting (misal: u1234567_admin)
$pass = '';                   // Ganti dengan Password Database di Hosting Anda
$db   = 'setskill_db';        // Ganti dengan Nama Database di Hosting (misal: u1234567_setskill)

// Membuat koneksi menggunakan MySQLi
$conn = new mysqli($host, $user, $pass, $db);

// Mengecek jika koneksi gagal (Sangat berguna untuk melacak error di hosting)
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error . ". <br><br><b>TIPS:</b> Pastikan username, password, dan nama database sudah benar sesuai yang dibuat di panel hosting Anda.");
}

// ==============================================================================
// HELPER FUNCTIONS (JANGAN DIUBAH)
// ==============================================================================

// Helper function untuk mengecek apakah user sudah login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Helper function untuk membatasi akses halaman berdasarkan role (User/Admin)
function checkRole($role) {
    if (!isLoggedIn()) {
        header("Location: ../login.php");
        exit();
    }
    
    global $conn;
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT role, subscription_status FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $u_data = $res->fetch_assoc();
    $stmt->close();

    // Pastikan session dan db sinkron
    if ($u_data['role'] !== $role) {
        if ($u_data['role'] === 'admin') {
            header("Location: ../Admin/index.php");
        } else {
            if ($u_data['subscription_status'] === 'paid') {
                header("Location: ../User/index.php");
            } else {
                header("Location: ../subscribe.php");
            }
        }
        exit();
    }

    // Jika role sesuai (yaitu 'user'), tapi status berlangganan belum 'paid', larang masuk ke dashboard user
    if ($role === 'user' && $u_data['subscription_status'] !== 'paid') {
        header("Location: ../subscribe.php");
        exit();
    }
}
?>
