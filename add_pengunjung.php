<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Jika belum login, redirect ke login
    exit;
}

include "koneksi.php"; // Koneksi ke database

// Inisialisasi variabel
$nama = $email = $usia = $tujuan = "";
$namaErr = $emailErr = $usiaErr = $tujuanErr = "";
$sukses = false;

// Jika form disubmit (dengan metode POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validasi nama
    if (empty($_POST["nama"])) {
        $namaErr = "Nama wajib diisi";
    } else {
        $nama = htmlspecialchars(trim($_POST["nama"])); // Bersihkan input
    }

    // Validasi email
    if (empty($_POST["email"])) {
        $emailErr = "Email wajib diisi";
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Format email tidak valid";
        }
    }

    // Validasi usia
    if (empty($_POST["usia"])) {
        $usiaErr = "Usia wajib diisi";
    } else {
        $usia = (int)$_POST["usia"];
        if ($usia <= 0 || $usia > 120) {
            $usiaErr = "Usia tidak valid";
        }
    }

    // Validasi tujuan wisata
    if (empty($_POST["tujuan"])) {
        $tujuanErr = "Tujuan wisata wajib diisi";
    } else {
        $tujuan = htmlspecialchars(trim($_POST["tujuan"]));
    }

    // Jika semua input valid, simpan ke database
    if (empty($namaErr) && empty($emailErr) && empty($usiaErr) && empty($tujuanErr)) {
        $sql = "INSERT INTO pengunjung (nama, email, usia, tujuan_wisata) 
                VALUES ('$nama', '$email', $usia, '$tujuan')";
        
        if (mysqli_query($koneksi, $sql)) {
            $sukses = true;
            // Kosongkan input setelah berhasil simpan
            $nama = $email = $usia = $tujuan = "";
        } else {
            echo "Gagal menyimpan data: " . mysqli_error($koneksi);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengunjung</title>
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Tambah Data Pengunjung</h1>
    
    <!-- Tampilkan alert sukses jika data berhasil disimpan -->
    <?php if ($sukses): ?>
        <div class="alert alert-success">Data berhasil ditambahkan!</div>
    <?php endif; ?>

    <!-- Form input data pengunjung -->
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="<?= $nama ?>">
            <div class="text-danger"><?= $namaErr ?></div> <!-- Tampilkan error jika ada -->
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?= $email ?>">
            <div class="text-danger"><?= $emailErr ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Usia</label>
            <input type="number" name="usia" class="form-control" value="<?= $usia ?>">
            <div class="text-danger"><?= $usiaErr ?></div>
        </div>
        <div class="mb-3">
            <label class="form-label">Tujuan Wisata</label>
            <input type="text" name="tujuan" class="form-control" value="<?= $tujuan ?>">
            <div class="text-danger"><?= $tujuanErr ?></div>
        </div>
        <!-- Tombol simpan dan kembali -->
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="data_pengunjung.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
