<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Tour Indonesia</title>
    
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link AOS CSS untuk animasi on scroll -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        /* Tambahkan margin atas agar konten tidak tertutup navbar fixed-top */
        body {
            padding-top: 70px;
        }

        /* Hero section background image */
        .hero-about {
            background: url('https://images.unsplash.com/photo-1556740749-887f6717d7e4?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
            height: 300px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
        }

        .navbar-brand {
            font-size: 2.5rem;
        }

        .about-icon {
            font-size: 3rem;
            color: #0d6efd;
        }

        .section-padding {
            padding: 60px 0;
        }

        /* Timeline styles */
        .timeline {
            position: relative;
            padding-left: 50px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #0d6efd;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -38px;
            top: 5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #0d6efd;
            border: 3px solid white;
        }

        /* Dark mode styles */
        body.dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }

        body.dark-mode .navbar,
        body.dark-mode .bg-light,
        body.dark-mode footer {
            background-color: #1f1f1f !important;
            color: #e0e0e0;
        }

        body.dark-mode .navbar-light .navbar-nav .nav-link {
            color: #e0e0e0;
        }

        body.dark-mode .nav-link.active {
            color: #0d6efd;
        }

        body.dark-mode .timeline::before,
        body.dark-mode .timeline-item::before {
            background-color: #0d6efd;
        }

        body.dark-mode .border,
        body.dark-mode .shadow-sm {
            border-color: #333 !important;
            background-color: #1f1f1f;
        }

        /* Teks brand navbar putih saat dark mode */
        body.dark-mode .navbar-brand {
            color: white !important;
        }
    </style>
</head>
<body>

<!-- Navbar dengan animasi AOS -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top" data-aos="fade-down">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">TourNesia</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav me-3">
        <!-- Menu navigasi -->
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="destinations.php">Destinations</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="booking.php">Booking</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="data_wisata.php">Wisata</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="data_pengunjung.php">Pengunjung</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Log Out</a>
        </li>
      </ul>

      <!-- Tombol toggle dark mode -->
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="darkModeToggle">
        <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
      </div>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<div class="hero-about">
    <h1 data-aos="fade-down">Tentang Kami</h1>
</div>

<!-- Konten utama -->
<div class="container section-padding">
    <!-- Bagian Siapa Kami -->
    <div class="row align-items-center mb-5" data-aos="fade-up">
        <div class="col-md-6">
            <h2>Siapa Kami?</h2>
            <p><strong>Tour Wisata</strong> adalah penyedia layanan tour yang berfokus pada pengalaman terbaik saat menjelajahi Indonesia. Kami berdiri sejak 2022 dan telah melayani ratusan wisatawan dengan berbagai destinasi menarik.</p>
            <p>Kami percaya bahwa setiap perjalanan adalah cerita. Maka dari itu, kami ingin membuat cerita Anda tak terlupakan.</p>
        </div>
        <div class="col-md-6">
            <!-- Carousel gambar -->
            <div id="aboutCarousel" class="carousel slide shadow rounded" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/Tour Yogyakarta.jpg" class="d-block w-100" alt="Gambar 1">
                    </div>
                    <div class="carousel-item">
                        <img src="img/Tour Bandung.jpg" class="d-block w-100" alt="Gambar 2">
                    </div>
                    <div class="carousel-item">
                        <img src="img/Tour Bali.jpg" class="d-block w-100" alt="Gambar 3">
                    </div>
                </div>
                <!-- Navigasi carousel -->
                <button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Section 3 Benefit -->
    <div class="row text-center" data-aos="fade-up" data-aos-delay="100">
        <?php
        // Fungsi untuk menampilkan kotak benefit
        function displayBenefit($icon, $title, $description) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="p-4 border rounded shadow-sm h-100">';
            echo '<div class="about-icon mb-3">' . $icon . '</div>';
            echo '<h5>' . $title . '</h5>';
            echo '<p>' . $description . '</p>';
            echo '</div></div>';
        }

        $benefits = [
            ['icon' => '🌍', 'title' => 'Destinasi Luas', 'description' => 'Kami menyediakan tour ke berbagai tempat populer dan tersembunyi yaitu Bali, Yogyakarta, Bandung dan Surabaya.'],
            ['icon' => '🛡️', 'title' => 'Aman & Terpercaya', 'description' => 'Tim profesional dan prosedur keamanan terbaik untuk kenyamanan Anda.'],
            ['icon' => '💬', 'title' => 'Layanan Ramah', 'description' => 'Kami siap membantu Anda sebelum, saat, dan sesudah perjalanan.']
        ];

        foreach ($benefits as $benefit) {
            displayBenefit($benefit['icon'], $benefit['title'], $benefit['description']);
        }
        ?>
    </div>

    <!-- Timeline Section -->
    <div class="row mt-5" data-aos="fade-up">
        <div class="col-12">
            <h2 class="text-center mb-4">Sejarah Kami</h2>
            <div class="timeline">
                <?php
                $history = [
                    ['year' => '2022', 'event' => 'Tour Wisata didirikan dengan 3 karyawan'],
                    ['year' => '2022', 'event' => 'Melayani lebih dari 100 wisatawan pertama'],
                    ['year' => '2023', 'event' => 'Membuka cabang pertama di Bali'],
                    ['year' => '2024', 'event' => 'Menerima penghargaan "Tour Operator Terbaik"'],
                    ['year' => '2025', 'event' => 'Melayani lebih dari 10.000 wisatawan']
                ];

                foreach ($history as $item) {
                    echo '<div class="timeline-item">';
                    echo '<h5>' . $item['year'] . '</h5>';
                    echo '<p>' . $item['event'] . '</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Statistik Section -->
    <div class="row mt-5 text-center" data-aos="fade-up">
        <div class="col-12">
            <h2 class="mb-4">Dalam Angka</h2>
        </div>
        <?php
        // Fungsi untuk menampilkan kotak statistik
        function displayStat($number, $label) {
            echo '<div class="col-md-3 mb-4">';
            echo '<div class="p-3 border rounded shadow-sm">';
            echo '<h3 class="text-primary">' . $number . '</h3>';
            echo '<p class="mb-0">' . $label . '</p>';
            echo '</div></div>';
        }

        $stats = [
            ['number' => '10.000+', 'label' => 'Wisatawan'],
            ['number' => '4+', 'label' => 'Destinasi'],
            ['number' => '100+', 'label' => 'Tour Guide'],
            ['number' => '4.9/5', 'label' => 'Rating']
        ];

        foreach ($stats as $stat) {
            displayStat($stat['number'], $stat['label']);
        }
        ?>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light text-center py-3">
    &copy; 2025 Tour Wisata.
</footer>

<!-- Script JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    // Dark mode toggle
    const toggle = document.getElementById('darkModeToggle');
    const body = document.body;

    // Cek localStorage apakah dark mode sebelumnya aktif
    if (localStorage.getItem('dark-mode') === 'enabled') {
        body.classList.add('dark-mode');
        toggle.checked = true;
    }

    toggle.addEventListener('change', function () {
        if (this.checked) {
            body.classList.add('dark-mode');
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            body.classList.remove('dark-mode');
            localStorage.setItem('dark-mode', 'disabled');
        }
    });

    // Navbar shadow on scroll
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
