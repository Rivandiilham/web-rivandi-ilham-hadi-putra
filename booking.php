<?php 
// Menghubungkan ke database
include 'koneksi.php';

// Fungsi untuk membersihkan input dari karakter berbahaya
function cleanInput($data) {
    $data = trim($data); // Menghapus spasi di awal dan akhir
    $data = stripslashes($data); // Menghapus backslash
    $data = htmlspecialchars($data); // Mencegah XSS
    return $data;
}

// Fungsi untuk menghitung diskon berdasarkan usia
function calculateDiscount($age) {
    if ($age < 12) {
        return 0.5; // Diskon 50% untuk anak-anak
    } elseif ($age > 60) {
        return 0.3; // Diskon 30% untuk lansia
    } else {
        return 0; // Tidak ada diskon
    }
}

// Daftar harga masing-masing tour
$tourPrices = [
    'Bali' => 5000000,
    'Yogyakarta' => 3500000,
    'Bandung' => 2500000,
    'Surabaya' => 3000000
];

// Inisialisasi variabel error dan input
$nameErr = $emailErr = $ageErr = "";
$name = $email = $age = $tour = "";
$bookingSuccess = false; // Penanda apakah booking berhasil

// Jika form dikirim (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi nama
    if (empty($_POST["name"])) {
        $nameErr = "Nama harus diisi";
    } else {
        $name = cleanInput($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Hanya huruf dan spasi yang diperbolehkan";
        }
    }

    // Validasi email
    if (empty($_POST["email"])) {
        $emailErr = "Email harus diisi";
    } else {
        $email = cleanInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Format email tidak valid";
        }
    }

    // Validasi usia
    if (empty($_POST["age"])) {
        $ageErr = "Usia harus diisi";
    } else {
        $age = cleanInput($_POST["age"]);
        if (!is_numeric($age) || $age < 1 || $age > 120) {
            $ageErr = "Usia harus antara 1-120 tahun";
        }
    }

    // Ambil data tour
    $tour = cleanInput($_POST["tour"]);

    // Jika tidak ada error
    if (empty($nameErr) && empty($emailErr) && empty($ageErr)) {
        // Hitung total diskon
        $discount = calculateDiscount($age); // Diskon berdasarkan usia
        $extraDiscount = 0.1; // Diskon tambahan 10%
        $totalDiscount = $discount + $extraDiscount;
        if ($totalDiscount > 1) $totalDiscount = 1; // Maksimal 100%

        // Hitung harga akhir
        $price = $tourPrices[$tour]; // Harga asli
        $finalPrice = $price * (1 - $totalDiscount); // Setelah diskon

        // Simpan data booking ke database menggunakan prepared statement
        $stmt = $koneksi->prepare("INSERT INTO bookings (name, email, age, tour, original_price, discount_percent, final_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissdd", $name, $email, $age, $tour, $price, $totalDiscount, $finalPrice);
        if ($stmt->execute()) {
            $bookingSuccess = true;
        } else {
            // Tampilkan error jika gagal
            echo "<div class='alert alert-danger'>Gagal menyimpan data booking: " . $stmt->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Tour Wisata</title>

    <!-- Link ke Bootstrap 5 untuk styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link ke AOS (Animate on Scroll) untuk animasi scroll -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Style CSS internal -->
    <style>
        body {
            background-color: #f8f9fa; /* Warna latar */
            font-family: 'Arial', sans-serif; /* Jenis font */
            transition: background-color 0.3s, color 0.3s;
            padding-top: 70px; /* Memberi ruang di atas karena navbar fixed */
        }

        .navbar {
            background-color: white;
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 2.5rem; /* Ukuran besar brand */
        }

        body.dark-mode .navbar {
            background-color: #121212; /* Navbar dalam dark mode */
        }

        .navbar-nav .nav-link {
            font-weight: bold;
            color: #343a40 !important;
            margin-right: 10px;
        }

        .navbar-nav .nav-link:hover {
            color: #0056b3 !important; /* Hover efek untuk navlink */
        }

        .dark-toggle {
            background: none;
            border: none;
            color: #121212;
            font-size: 1.5rem;
            margin-left: 10px;
        }

        /* Styling untuk dark mode */
        body.dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }

        body.dark-mode .card {
            background-color: #1e1e1e;
            color: #e0e0e0;
        }

        body.dark-mode .form-control,
        body.dark-mode .form-label {
            background-color: #1e1e1e;
            color: #e0e0e0;
        }

        body.dark-mode .navbar-nav .nav-link {
            color: #e0e0e0 !important;
        }

        body.dark-mode .navbar-brand {
            color: #e0e0e0 !important;
        }

        body.dark-mode .dark-toggle {
            color: #ffd700; /* Warna kuning untuk dark mode toggle */
        }

        .error {
            color: red;
            font-size: 0.9em;
        }

        footer {
            background-color: rgb(48, 46, 46);
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

    <!-- Navbar atas -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top" data-aos="fade-down">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">TourNesia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <!-- Menu navigasi -->
                <ul class="navbar-nav me-3">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="destinations.php">Destinations</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="booking.php">Booking</a></li>
                    <li class="nav-item"><a class="nav-link" href="data_wisata.php">Wisata</a></li>
                    <li class="nav-item"><a class="nav-link" href="data_pengunjung.php">Pengunjung</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>
                </ul>

                <!-- Switch untuk dark mode -->
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="darkModeToggle">
                    <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten utama halaman -->
    <div class="container mt-5 pt-5">
        <h1 class="text-center mt-5">Pemesanan Tour Wisata</h1>
        
        <!-- Formulir pemesanan -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mb-4">
            <div class="mb-3">
                <label for="tour" class="form-label">Pilih Tour</label>
                <select class="form-control" id="tour" name="tour" required>
                    <option value="Bali" <?php if ($tour == "Bali") echo "selected"; ?>>Tour Bali - Rp 5.000.000</option>
                    <option value="Yogyakarta" <?php if ($tour == "Yogyakarta") echo "selected"; ?>>Tour Yogyakarta - Rp 3.500.000</option>
                    <option value="Bandung" <?php if ($tour == "Bandung") echo "selected"; ?>>Tour Bandung - Rp 2.500.000</option>
                    <option value="Surabaya" <?php if ($tour == "Surabaya") echo "selected"; ?>>Tour Surabaya - Rp 3.000.000</option>
                </select>
            </div>

            <!-- Input Nama -->
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control <?php if (!empty($nameErr)) echo "is-invalid"; ?>" id="name" name="name" value="<?php echo $name; ?>" required>
                <div class="error"><?php echo $nameErr; ?></div>
            </div>

            <!-- Input Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control <?php if (!empty($emailErr)) echo "is-invalid"; ?>" id="email" name="email" value="<?php echo $email; ?>" required>
                <div class="error"><?php echo $emailErr; ?></div>
            </div>

            <!-- Input Usia -->
            <div class="mb-3">
                <label for="age" class="form-label">Usia</label>
                <input type="number" class="form-control <?php if (!empty($ageErr)) echo "is-invalid"; ?>" id="age" name="age" value="<?php echo $age; ?>" min="1" max="120" required>
                <div class="error"><?php echo $ageErr; ?></div>
            </div>

            <!-- Tombol submit -->
            <button type="submit" class="btn btn-primary btn-custom">Pesan</button>
        </form>

        <!-- Notifikasi sukses jika booking berhasil -->
        <?php if ($bookingSuccess): ?>
            <div class="alert alert-success">
                <h4>Booking Berhasil!</h4>
                <p>Terima kasih, <?php echo $name; ?>! Berikut detail pemesanan Anda:</p>
                <ul>
                    <li>Tour: <?php echo $tour; ?></li>
                    <li>Harga Awal: Rp <?php echo number_format($price, 0, ',', '.'); ?></li>
                    <li>Diskon Usia: <?php echo ($discount * 100); ?>%</li>
                    <li>Diskon Tambahan: 10%</li>
                    <li>Total Diskon: <?php echo ($totalDiscount * 100); ?>%</li>
                    <li>Total Harga: Rp <?php echo number_format($finalPrice, 0, ',', '.'); ?></li>
                </ul>
                <p>Konfirmasi dikirim ke email: <?php echo $email; ?></p>
            </div>
        <?php endif; ?>

        <!-- Footer -->
        <footer class="mt-5">
            <p>&copy; 2025 Tour Wisata</p>
        </footer>
    </div>

    <!-- Script toggle dark mode -->
    <script>
        function toggleDarkMode() {
            const body = document.body;
            const darkSwitch = document.getElementById("darkModeToggle");
            body.classList.toggle("dark-mode");
            localStorage.setItem("darkMode", body.classList.contains("dark-mode"));
            darkSwitch.checked = body.classList.contains("dark-mode");
        }

        window.onload = function () {
            const darkSwitch = document.getElementById("darkModeToggle");
            if (localStorage.getItem("darkMode") === "true") {
                document.body.classList.add("dark-mode");
                if (darkSwitch) darkSwitch.checked = true;
            }
            darkSwitch.addEventListener("change", toggleDarkMode);
        };
    </script>

    <!-- Script AOS animasi scroll -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>AOS.init();</script>

</body>
</html>
