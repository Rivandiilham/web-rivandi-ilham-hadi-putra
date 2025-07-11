<?php
include "koneksi.php";

function displayRating($rating) {
    echo '<div class="rating">';
    for ($i = 1; $i <= 5; $i++) {
        echo ($i <= $rating) ? '★' : '☆';
    }
    echo '</div>';
}

function getBestSeason($destination) {
    switch ($destination) {
        case 'Bali':
            return 'April-Oktober';
        case 'Yogyakarta':
            return 'Mei-September';
        case 'Bandung':
            return 'Sepanjang Tahun';
        case 'Surabaya':
            return 'April-November';
        default:
            return 'Tidak diketahui';
    }
}

$result = mysqli_query($koneksi, "SELECT * FROM wisata");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinasi Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body { padding-top: 70px; }
        .hero-home {
            background: url('https://images.unsplash.com/photo-1533900298318-6b8da08a523e?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
            height: 400px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
        }
        .navbar-brand { font-size: 2.5rem; }
        body.dark-mode { background-color: #121212; color: #e0e0e0; }
        body.dark-mode .navbar, body.dark-mode .bg-light, body.dark-mode footer {
            background-color: #1f1f1f !important; color: #e0e0e0;
        }
        body.dark-mode .navbar-light .navbar-nav .nav-link { color: #e0e0e0; }
        body.dark-mode .nav-link.active { color: #0d6efd; }
        body.dark-mode .card,
        body.dark-mode .card-body,
        body.dark-mode .card-text,
        body.dark-mode .card-title,
        body.dark-mode .fw-bold,
        body.dark-mode .rating,
        body.dark-mode .season-badge { color: black !important; }
        body.dark-mode .card { background-color: white !important; }
        .shadow-scroll { box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .season-badge {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: rgba(255,126,95,0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
        }
        .rating {
            color: #ff7e5f;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        body.dark-mode .navbar-brand { color: white !important; }
        body.dark-mode .card-title { color: black !important; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" data-aos="fade-down">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">TourNesia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav me-3">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link active" href="destinations.php">Destinations</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="booking.php">Booking</a></li>
                <li class="nav-item"><a class="nav-link" href="data_wisata.php">Wisata</a></li>
                <li class="nav-item"><a class="nav-link" href="data_pengunjung.php">Pengunjung</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>
            </ul>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="darkModeToggle">
                <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
            </div>
        </div>
    </div>
</nav>

<header class="hero-home" data-aos="fade-up">
    <h1>Destinasi Wisata Kami</h1>
</header>

<div class="container">
    <h2 data-aos="fade-right">Daftar Destinasi:</h2>
    <div class="row">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $bestSeason = getBestSeason($row['nama_wisata']);
            echo "
            <div class='col-md-3 mb-4' data-aos='fade-up'>
                <div class='card h-100'>
                    <div style='position: relative;'>
                        <img src='uploads/{$row['gambar']}' class='card-img-top' alt='{$row['nama_wisata']}'>
                        <div class='season-badge'>Musim Terbaik: $bestSeason</div>
                    </div>
                    <div class='card-body'>
                        <h5 class='card-title'>{$row['nama_wisata']}</h5>";
                        displayRating(4);
                        echo "
                        <p class='card-text'>{$row['deskripsi']}</p>
                        <p class='fw-bold'>Rp " . number_format($row['harga'], 0, ',', '.') . "</p>
                        <a href='booking.php' class='btn btn-primary'>Pesan Sekarang</a>
                    </div>
                </div>
            </div>
            ";
        }
        ?>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, easing: 'ease-in-out', once: true });
    const toggle = document.getElementById('darkModeToggle');
    const body = document.body;
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
    window.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('shadow-scroll');
        } else {
            navbar.classList.remove('shadow-scroll');
        }
    });
</script>

</body>
</html>
