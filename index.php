<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: Admin/index.php");
    } else {
        header("Location: User/index.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SETskill - Tempat Bertukar Skill</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fa-solid fa-people-arrows me-2"></i>SETskill
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimoni</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <a href="login.php" class="btn btn-outline-primary rounded-pill px-4">Masuk</a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a href="register.php" class="btn btn-primary rounded-pill px-4">Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold">Tukar Skill Anda, Tingkatkan Potensi!</h1>
                    <p class="lead mb-4">SETskill adalah platform komunitas di mana Anda dapat mengajarkan apa yang Anda kuasai dan mempelajari apa yang Anda butuhkan secara gratis melalui pertukaran kemampuan.</p>
                    <a href="register.php" class="btn btn-custom-light btn-lg me-2">Mulai Sekarang</a>
                    <a href="#about" class="btn btn-outline-light btn-lg rounded-pill">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0 text-center">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Team Work" class="img-fluid rounded shadow-lg" style="max-height: 400px; object-fit: cover;">
                </div>
                <div class="col-lg-6">
                    <h6 class="text-primary fw-bold text-uppercase">Visi & Misi</h6>
                    <h2 class="fw-bold mb-4">Membangun Ekosistem Belajar Bersama</h2>
                    <p class="text-muted mb-3">Di SETskill, kami percaya bahwa setiap orang memiliki sesuatu untuk diajarkan dan dipelajari. Kami hadir untuk mendobrak batasan finansial dalam pendidikan dengan sistem barter ilmu.</p>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> <strong>Visi:</strong> Menjadi platform pertukaran keterampilan terbesar di Indonesia yang inklusif dan saling memberdayakan.</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> <strong>Misi:</strong> Menghubungkan individu berdasarkan kebutuhan skill.</li>
                        <li class="mb-2"><i class="fa-solid fa-check text-primary me-2"></i> <strong>Misi:</strong> Menyediakan ruang interaksi yang aman dan suportif.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-light">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase">Fitur Utama</h6>
                <h2 class="fw-bold">Mengapa Memilih SETskill?</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-box text-center">
                        <div class="feature-icon">
                            <i class="fa-solid fa-magnifying-glass-location"></i>
                        </div>
                        <h4 class="fw-bold">Temukan Partner Terdekat</h4>
                        <p class="text-muted">Cari partner belajar yang berada di sekitar Anda menggunakan integrasi peta kami untuk memudahkan pertemuan tatap muka jika diperlukan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box text-center">
                        <div class="feature-icon">
                            <i class="fa-solid fa-comments"></i>
                        </div>
                        <h4 class="fw-bold">Komunikasi Mudah</h4>
                        <p class="text-muted">Gunakan fitur chat internal kami untuk berdiskusi, mengatur jadwal, dan berinteraksi dengan aman tanpa harus membagikan kontak pribadi di awal.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box text-center">
                        <div class="feature-icon">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <h4 class="fw-bold">Sistem Rating Terpercaya</h4>
                        <p class="text-muted">Bangun reputasi Anda dengan mendapatkan ulasan dan rating dari partner belajar Anda setelah sesi pertukaran ilmu selesai.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-5">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase">Testimoni</h6>
                <h2 class="fw-bold">Apa Kata Mereka?</h2>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm h-100 p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="rounded-circle me-3" width="60" height="60">
                            <div>
                                <h5 class="mb-0 fw-bold">Budi Santoso</h5>
                                <small class="text-muted">Mengajar PHP, Belajar Desain</small>
                            </div>
                        </div>
                        <p class="text-muted fst-italic">"Berkat SETskill, saya bisa belajar UI/UX Design secara gratis hanya dengan mengajarkan dasar-dasar PHP. Sangat membantu!"</p>
                        <div class="text-warning">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm h-100 p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User" class="rounded-circle me-3" width="60" height="60">
                            <div>
                                <h5 class="mb-0 fw-bold">Siti Aminah</h5>
                                <small class="text-muted">Mengajar B. Inggris, Belajar Public Speaking</small>
                            </div>
                        </div>
                        <p class="text-muted fst-italic">"Platform yang sangat inovatif. Saya menemukan partner belajar yang suportif dan kami rutin berlatih setiap akhir pekan."</p>
                        <div class="text-warning">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <h4 class="fw-bold mb-3">SETskill</h4>
            <p class="text-white-50">Tempat terbaik untuk bertukar kemampuan dan berkembang bersama.</p>
            <div class="mt-3">
                <a href="#" class="text-white-50 me-3"><i class="fa-brands fa-facebook fa-lg"></i></a>
                <a href="#" class="text-white-50 me-3"><i class="fa-brands fa-twitter fa-lg"></i></a>
                <a href="#" class="text-white-50"><i class="fa-brands fa-instagram fa-lg"></i></a>
            </div>
            <hr class="my-4 border-secondary">
            <p class="mb-0 text-white-50">&copy; <?php echo date('Y'); ?> SETskill. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
