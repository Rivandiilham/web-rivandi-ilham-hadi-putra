<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$search = "";
$whereClause = "";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
    $whereClause = "WHERE nama_wisata LIKE '%$search%' 
                    OR lokasi LIKE '%$search%' 
                    OR deskripsi LIKE '%$search%'";
}

$query = "SELECT * FROM wisata $whereClause";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        body {
            padding-top: 70px;
            background: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat fixed;
            color: #333;
        }

        .table-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }

        body.dark-mode .navbar,
        body.dark-mode footer {
            background-color: #1f1f1f !important;
            color: #e0e0e0;
        }

        body.dark-mode .navbar-brand {
            color: #e0e0e0 !important;
        }

        body.dark-mode .table-container {
            background: rgba(33, 33, 33, 0.9);
        }

        body.dark-mode table,
        body.dark-mode table td,
        body.dark-mode table th {
            color: #ffffff !important;
        }

        body.dark-mode table thead {
            background-color: #333333 !important;
        }

        body.dark-mode table tbody tr {
            background-color: #1f1f1f !important;
        }

        body.dark-mode table tbody tr:nth-child(even) {
            background-color: #2a2a2a !important;
        }

        body.dark-mode table td,
        body.dark-mode table th {
            border-color: #444 !important;
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

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top" data-aos="fade-down">
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
                <li class="nav-item"><a class="nav-link active" href="data_wisata.php">Wisata</a></li>
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

<div class="container mt-5 pt-4 table-container" data-aos="fade-up">
    <h1 class="text-center mb-4" data-aos="zoom-in">Data Wisata</h1>
    
    <div class="d-flex flex-column flex-md-row justify-content-between mb-3 gap-2">
        <div class="d-flex gap-2">
            <a href="add_wisata.php" class="btn btn-success" data-aos="fade-right">Tambah Data</a>
            <a href="index.php" class="btn btn-primary" data-aos="fade-left">Kembali ke Home</a>
        </div>
        <form class="d-flex" method="get" action="data_wisata.php" data-aos="fade-left">
            <input class="form-control me-2" type="search" placeholder="Cari wisata..." name="search" value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Wisata</th>
                <th>Lokasi</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $nama = $row['nama_wisata'];
                $lokasi = $row['lokasi'];
                $deskripsi = $row['deskripsi'];
                $harga = $row['harga'];

                if ($search != "") {
                    $pattern = "/" . preg_quote($search, "/") . "/i";
                    $nama = preg_replace($pattern, "<mark>$0</mark>", $nama);
                    $lokasi = preg_replace($pattern, "<mark>$0</mark>", $lokasi);
                    $deskripsi = preg_replace($pattern, "<mark>$0</mark>", $deskripsi);
                }

                echo "<tr>";
                echo "<td>".$no++."</td>";
                echo "<td>".$nama."</td>";
                echo "<td>".$lokasi."</td>";
                echo "<td>Rp ".number_format($harga, 0, ',', '.')."</td>";
                echo "<td>".$deskripsi."</td>";
                echo "<td>
                    <a href='edit_wisata.php?id=".$row['id']."' 
                       class='btn btn-warning btn-sm me-1'>
                       Edit
                    </a>
                    <a href='hapus_wisata.php?id=".$row['id']."' 
                       class='btn btn-danger btn-sm'
                       onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>
                       Hapus
                    </a>
                  </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- GALERI GAMBAR -->
    <div class="mt-5">
        <h2 class="text-center mb-4" data-aos="fade-up">Galeri Gambar Wisata</h2>
        <div class="row">
            <?php
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_assoc($result)) {
                if (!empty($row['gambar'])) {
                    $nama = $row['nama_wisata'];
                    $lokasi = $row['lokasi'];
                    $deskripsi = $row['deskripsi'];
                    $harga = $row['harga'];

                    if ($search != "") {
                        $pattern = "/" . preg_quote($search, "/") . "/i";
                        $nama = preg_replace($pattern, "<mark>$0</mark>", $nama);
                        $lokasi = preg_replace($pattern, "<mark>$0</mark>", $lokasi);
                        $deskripsi = preg_replace($pattern, "<mark>$0</mark>", $deskripsi);
                    }
                    ?>
                    <div class="col-md-3 mb-4" data-aos="zoom-in">
                        <div class="card h-100 shadow-sm">
                            <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>"
                                 class="card-img-top"
                                 alt="<?= htmlspecialchars($row['nama_wisata']) ?>"
                                 style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title"><?= $nama ?></h5>
                                <p class="card-text"><strong>Lokasi:</strong> <?= $lokasi ?></p>
                                <p class="card-text"><strong>Harga:</strong> Rp <?= number_format($harga, 0, ',', '.') ?></p>
                                <p class="card-text"><?= $deskripsi ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

</div>

<footer class="bg-light text-center py-3 mt-5">
    &copy; 2025 TourNesia.
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

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
</script>
</body>
</html>
