<?php
// Memulai session untuk mengecek login
session_start();

// Jika user belum login, redirect ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Menghubungkan ke file koneksi database
include "koneksi.php";

// Inisialisasi variabel pencarian
$search = "";
$whereClause = "";

// Jika ada pencarian yang dikirim via GET
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
    $whereClause = "WHERE nama LIKE '%$search%' OR tujuan_wisata LIKE '%$search%'";
}

// Query data pengunjung
$query = "SELECT * FROM pengunjung $whereClause";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pengunjung</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        body {
            padding-top: 70px;
        }

        .hero-section {
            background: url('https://cdn.pixabay.com/photo/2015/12/01/20/28/road-1072823_1280.jpg') center/cover no-repeat;
            height: 350px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
        }

        body.dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }

        body.dark-mode .hero-section {
            background-blend-mode: overlay;
            background-color: rgba(0,0,0,0.5);
        }

        body.dark-mode .table,
        body.dark-mode .table-bordered th,
        body.dark-mode .table-bordered td {
            background-color: #1f1f1f;
            color: #e0e0e0;
        }

        body.dark-mode .btn {
            color: #fff;
        }

        footer {
            margin-top: 50px;
        }

        mark {
            background-color: yellow;
            color: black;
            padding: 0 3px;
            border-radius: 2px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav id="mainNavbar" class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top" data-aos="fade-down">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">TourNesia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav me-3">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="destinations.php">Destinations</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="booking.php">Booking</a></li>
                <li class="nav-item"><a class="nav-link" href="data_wisata.php">Wisata</a></li>
                <li class="nav-item"><a class="nav-link active" href="data_pengunjung.php">Pengunjung</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>
            </ul>

            <!-- Tombol switch dark mode -->
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="darkModeToggle">
                <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero-section" data-aos="zoom-in">
    <h1 class="display-4 fw-bold">Data Pengunjung</h1>
</div>

<!-- Konten utama -->
<div class="container my-5" data-aos="fade-up">

    <!-- Tombol + Form Search (baru, mirip data_wisata.php) -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
        <div class="d-flex gap-2">
            <a href="add_pengunjung.php" class="btn btn-success">+ Tambah Pengunjung</a>
            <a href="index.php" class="btn btn-primary">← Kembali ke Home</a>
        </div>
        <form class="d-flex" method="get" action="">
            <input class="form-control me-2" type="search" name="search" placeholder="Cari nama atau tujuan..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
    </div>

    <!-- Tabel data pengunjung -->
    <div class="table-responsive shadow-sm rounded" data-aos="zoom-in">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Usia</th>
                    <th>Tujuan Wisata</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $nama = $row['nama'];
                    $tujuan = $row['tujuan_wisata'];

                    // Highlight keyword jika ada pencarian
                    if ($search != "") {
                        $pattern = "/" . preg_quote($search, "/") . "/i";
                        $nama = preg_replace($pattern, "<mark>$0</mark>", $nama);
                        $tujuan = preg_replace($pattern, "<mark>$0</mark>", $tujuan);
                    }

                    echo "<tr>";
                    echo "<td class='text-center'>".$no++."</td>";
                    echo "<td>".$nama."</td>";
                    echo "<td>".$row['email']."</td>";
                    echo "<td class='text-center'>".$row['usia']."</td>";
                    echo "<td>".$tujuan."</td>";
                    echo "<td class='text-center'>
                        <a href='edit_pengunjung.php?id=".$row['id']."' class='btn btn-sm btn-warning me-1'>Edit</a>
                        <a href='hapus_pengunjung.php?id=".$row['id']."' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin hapus data?\")'>Hapus</a>
                    </td>";
                    echo "</tr>";
                }

                if (mysqli_num_rows($result) === 0) {
                    echo "<tr><td colspan='6' class='text-center'>Data tidak ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light text-center py-3">
    &copy; 2025 TourNesia.
</footer>

<!-- Script Bootstrap & AOS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

<script>
    // Inisialisasi AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    // Dark mode toggle
    const toggle = document.getElementById('darkModeToggle');
    const body = document.body;
    const navbar = document.getElementById('mainNavbar');

    if (localStorage.getItem('dark-mode') === 'enabled') {
        body.classList.add('dark-mode');
        toggle.checked = true;
        navbar.classList.remove('navbar-light', 'bg-light');
        navbar.classList.add('navbar-dark', 'bg-dark');
    }

    toggle.addEventListener('change', function () {
        if (this.checked) {
            body.classList.add('dark-mode');
            navbar.classList.remove('navbar-light', 'bg-light');
            navbar.classList.add('navbar-dark', 'bg-dark');
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            body.classList.remove('dark-mode');
            navbar.classList.remove('navbar-dark', 'bg-dark');
            navbar.classList.add('navbar-light', 'bg-light');
            localStorage.setItem('dark-mode', 'disabled');
        }
    });

    // Efek shadow navbar saat scroll
    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            navbar.classList.add('shadow');
        } else {
            navbar.classList.remove('shadow');
        }
    });
</script>

</body>
</html>
