<!DOCTYPE html>
<!-- Deklarasi tipe dokumen HTML -->
<html lang="id">
<!-- Tag HTML dengan atribut bahasa Indonesia -->

<head>
    <meta charset="UTF-8">
    <!-- Menentukan karakter encoding UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Responsive agar tampilan menyesuaikan perangkat -->
    <title>Kontak Kami</title>
    <!-- Judul halaman -->

    <!-- Link CDN Bootstrap 5 untuk styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link CDN AOS untuk animasi saat scroll -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- CSS internal untuk kustomisasi desain -->
    <style>
        /* Warna dasar, font dan transisi */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            transition: background-color 0.3s, color 0.3s;
            padding-top: 70px; /* Memberi ruang atas karena navbar fixed */
        }

        /* Styling navbar */
        .navbar {
            background-color: white;
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 2.5rem;
            font-weight: bold;
            color: #343a40 !important;
        }

        .navbar-nav .nav-link {
            font-weight: bold;
            color: #343a40 !important;
            margin-right: 10px;
        }

        .navbar-nav .nav-link:hover {
            color: #0056b3 !important;
        }

        .dark-toggle {
            background: none;
            border: none;
            color: #121212;
            font-size: 1.5rem;
            margin-left: 10px;
        }

        h1 {
            font-size: 4rem;
            margin-top: 20px;
            text-align: center;
        }

        /* Gambar dalam card */
        .card-img-top {
            height: 200px;
            object-fit: cover;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        /* Hover efek pada card */
        .card:hover {
            transform: translateY(-5px);
            transition: 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-custom {
            background-color: #ff7e5f;
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #feb47b;
            color: white;
        }

        footer {
            background-color: rgb(48, 46, 46);
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* DARK MODE */
        body.dark-mode {
            background-color: #121212;
            color: #e0e0e0;
        }

        body.dark-mode .card,
        body.dark-mode .form-control,
        body.dark-mode .form-label,
        body.dark-mode .card-text,
        body.dark-mode .card-title,
        body.dark-mode .card-subtitle {
            background-color: #1e1e1e;
            color: #e0e0e0;
        }

        body.dark-mode .navbar,
        body.dark-mode .navbar-brand,
        body.dark-mode .navbar-nav .nav-link {
            background-color: #121212;
            color: #e0e0e0 !important;
        }

        body.dark-mode .dark-toggle {
            color: #ffd700;
        }
    </style>
</head>

<body>
    <!-- Navbar responsif dengan link navigasi -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top" data-aos="fade-down">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">TourNesia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav me-3">
                    <!-- Navigasi halaman -->
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="destinations.php">Destinations</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="booking.php">Booking</a></li>
                    <li class="nav-item"><a class="nav-link" href="data_wisata.php">Wisata</a></li>
                    <li class="nav-item"><a class="nav-link" href="data_pengunjung.php">Pengunjung</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>
                </ul>

                <!-- Tombol toggle dark mode -->
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="darkModeToggle">
                    <label class="form-check-label" for="darkModeToggle">Dark Mode</label>
                </div>
            </div>
        </div>
    </nav>

    <!-- Container utama -->
    <div class="container mt-5 pt-5">
        <h1 data-aos="fade-down" class="text-center mt-5">Kontak Kami</h1>

        <?php
        // Konfigurasi koneksi ke database
        $host = "localhost";
        $user = "rivandii_tour_indonesia";
        $pass = "Rivandiilham";
        $db   = "rivandii_tour_indonesia";

        $mysqli = new mysqli($host, $user, $pass, $db);

        if ($mysqli->connect_errno) {
            die("Gagal koneksi ke database: " . $mysqli->connect_error);
        }

        // Fungsi membersihkan input dari karakter berbahaya
        function sanitizeInput($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Fungsi kirim pesan via email / log file
        function sendContactEmail($name, $email, $message) {
            $to = "admin@tourwisata.com";
            $subject = "Pesan Baru dari $name";
            $headers = "From: $email";

            // Simpan ke file log
            $logMessage = "Pesan dari: $name ($email)\nIsi pesan:\n$message\n=================================\n";
            file_put_contents('contact_log.txt', $logMessage, FILE_APPEND);

            return true;
        }

        // Variabel validasi dan input awal
        $nameErr = $emailErr = $messageErr = "";
        $name = $email = $message = "";
        $success = false;

        // Proses jika form disubmit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validasi nama
            if (empty($_POST["name"])) {
                $nameErr = "Nama harus diisi";
            } else {
                $name = sanitizeInput($_POST["name"]);
                if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                    $nameErr = "Hanya huruf dan spasi yang diperbolehkan";
                }
            }

            // Validasi email
            if (empty($_POST["email"])) {
                $emailErr = "Email harus diisi";
            } else {
                $email = sanitizeInput($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Format email tidak valid";
                }
            }

            // Validasi pesan
            if (empty($_POST["message"])) {
                $messageErr = "Pesan harus diisi";
            } else {
                $message = sanitizeInput($_POST["message"]);
            }

            // Jika semua input valid
            if (empty($nameErr) && empty($emailErr) && empty($messageErr)) {
                // Simpan ke database
                $stmt = $mysqli->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $name, $email, $message);

                if ($stmt->execute()) {
                    $success = true;
                    $name = $email = $message = ""; // Kosongkan form
                } else {
                    echo "<div class='alert alert-danger'>Gagal menyimpan ke database: " . $mysqli->error . "</div>";
                }

                $stmt->close();

                // Kirim ke log file
                sendContactEmail($name, $email, $message);
            }
        }

        $mysqli->close(); // Tutup koneksi
        ?>

        <!-- Jika berhasil, tampilkan pesan sukses -->
        <?php if ($success): ?>
            <div class="success-message" data-aos="slide-up" data-aos-duration="1000">
                <h4>Terima kasih, <?php echo $name; ?>!</h4>
                <p>Pesan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda melalui email.</p>
            </div>
        <?php endif; ?>

        <!-- Form kontak -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" data-aos="slide-up" data-aos-duration="1000">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control <?php if (!empty($nameErr)) echo 'is-invalid'; ?>" id="name" name="name" value="<?php echo $name; ?>" required>
                <div class="error"><?php echo $nameErr; ?></div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control <?php if (!empty($emailErr)) echo 'is-invalid'; ?>" id="email" name="email" value="<?php echo $email; ?>" required>
                <div class="error"><?php echo $emailErr; ?></div>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Pesan</label>
                <textarea class="form-control <?php if (!empty($messageErr)) echo 'is-invalid'; ?>" id="message" name="message" rows="5" required><?php echo $message; ?></textarea>
                <div class="error"><?php echo $messageErr; ?></div>
            </div>
            <button type="submit" class="btn btn-primary">Kirim</button>
        </form>

        <!-- Footer -->
        <footer class="mt-4" data-aos="fade-up" data-aos-duration="1000">
            <p>&copy; 2025 TourNesia.</p>
        </footer>
    </div>

    <!-- Script Bootstrap dan AOS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <!-- Inisialisasi AOS dan dark mode -->
    <script>
        AOS.init();

        const toggle = document.getElementById('darkModeToggle');
        const body = document.body;

        // Cek apakah dark mode aktif sebelumnya
        if (localStorage.getItem('dark-mode') === 'enabled') {
            body.classList.add('dark-mode');
            toggle.checked = true;
        }

        // Event toggle dark mode
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
