<?php
// Memulai session PHP
session_start();

// Mengecek apakah user sudah login, jika belum maka redirect ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Pengaturan karakter dan tampilan responsive -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Tour Indonesia</title>

    <!-- Memuat file CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Memuat animasi AOS (Animate on Scroll) -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Style tambahan -->
    <style>
        /* Memberi jarak agar konten tidak tertutup navbar */
        body {
            padding-top: 70px;
        }

        /* Gambar latar pada bagian hero */
        .hero-home {
            background: url('https://images.unsplash.com/photo-1533900298318-6b8da08a523e?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
            height: 400px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
        }

        /* Gaya tulisan nama brand */
        .navbar-brand {
            font-size: 2.5rem;
            color: #000;
        }

        /* Mode gelap */
        body.dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }

        /* Navbar, background, footer pada dark mode */
        body.dark-mode .navbar,
        body.dark-mode .bg-light,
        body.dark-mode footer {
            background-color: #1f1f1f !important;
            color: #e0e0e0;
        }

        /* Link navbar dark mode */
        body.dark-mode .navbar-light .navbar-nav .nav-link {
            color: #e0e0e0;
        }

        /* Brand dark mode */
        body.dark-mode .navbar-brand {
            color: #e0e0e0;
        }

        /* Link aktif */
        body.dark-mode .nav-link.active {
            color: #0d6efd;
        }

        /* Border dan shadow untuk dark mode */
        body.dark-mode .border,
        body.dark-mode .shadow-sm {
            border-color: #333 !important;
            background-color: #1f1f1f;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top" data-aos="fade-down">
    <div class="container">
        <!-- Nama Website -->
        <a class="navbar-brand fw-bold" href="index.php">TourNesia</a>

        <!-- Tombol untuk tampilan mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu navigasi -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav me-3">
                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="destinations.php">Destinations</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="booking.php">Booking</a></li>
                <li class="nav-item"><a class="nav-link" href="data_wisata.php">Wisata</a></li>
                <li class="nav-item"><a class="nav-link" href="data_pengunjung.php">Pengunjung</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>
            </ul>

            <!-- Switch tombol dark mode -->
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="darkModeToggle">
                <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section (sambutan) -->
<div class="hero-home">
    <h1 data-aos="zoom-in">Selamat Datang di TourNesia</h1>
</div>

<!-- Konten Utama -->
<div class="container section-padding">
    <div class="row text-center" data-aos="fade-up">
        <!-- Judul & deskripsi -->
        <div class="col-md-12 mb-5">
            <h2>Jelajahi Keindahan Indonesia Bersama Kami</h2>
            <p class="lead">Nikmati pengalaman liburan tak terlupakan dengan destinasi terbaik dan layanan terbaik.</p>
        </div>

        <!-- 3 Fitur Utama -->
        <div class="col-md-4 mb-4">
            <div class="p-4 border rounded shadow-sm h-100">
                <div class="fs-1 text-primary mb-3">🗺️</div>
                <h5>Beragam Destinasi</h5>
                <p>Kunjungi tempat wisata populer maupun tersembunyi di pulau Jawa dan Bali.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="p-4 border rounded shadow-sm h-100">
                <div class="fs-1 text-primary mb-3">🚗</div>
                <h5>Paket Lengkap</h5>
                <p>Pilihan paket wisata mulai dari transportasi, akomodasi hingga tour guide profesional.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="p-4 border rounded shadow-sm h-100">
                <div class="fs-1 text-primary mb-3">📞</div>
                <h5>Dukungan 24/7</h5>
                <p>Tim kami siap membantu kebutuhan perjalanan Anda kapan saja.</p>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light text-center py-3">
    &copy; 2025 Tour Wisata.
</footer>

<!-- Script JS Bootstrap dan AOS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<script>
    // Inisialisasi animasi scroll
    AOS.init({
        duration: 800,       // durasi animasi
        easing: 'ease-in-out', // efek animasi
        once: true           // hanya sekali
    });

    // Dark Mode Toggle
    const toggle = document.getElementById('darkModeToggle');
    const body = document.body;

    // Cek localStorage, jika dark mode aktif maka aktifkan
    if (localStorage.getItem('dark-mode') === 'enabled') {
        body.classList.add('dark-mode');
        toggle.checked = true;
    }

    // Event ketika toggle diubah
    toggle.addEventListener('change', function () {
        if (this.checked) {
            body.classList.add('dark-mode');
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            body.classList.remove('dark-mode');
            localStorage.setItem('dark-mode', 'disabled');
        }
    });

    // Tambah bayangan navbar saat scroll ke bawah
    window.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('shadow');
        } else {
            navbar.classList.remove('shadow');
        }
    });
</script>

</body>
</html>
