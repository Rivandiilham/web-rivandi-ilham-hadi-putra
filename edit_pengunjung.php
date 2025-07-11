<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

// Ambil ID
$id = $_GET['id'];

// Ambil data lama
$query = mysqli_query($koneksi, "SELECT * FROM pengunjung WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='data_pengunjung.php';</script>";
    exit;
}

// Proses update
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $usia = mysqli_real_escape_string($koneksi, $_POST['usia']);
    $tujuan_wisata = mysqli_real_escape_string($koneksi, $_POST['tujuan_wisata']);

    $update = mysqli_query($koneksi, "UPDATE pengunjung SET 
        nama = '$nama',
        email = '$email',
        usia = '$usia',
        tujuan_wisata = '$tujuan_wisata'
        WHERE id = $id
    ");

    if ($update) {
        echo "<script>alert('Data berhasil diupdate!'); window.location='data_pengunjung.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengunjung</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('https://cdn.pixabay.com/photo/2015/12/01/20/28/road-1072823_1280.jpg') center/cover no-repeat fixed;
            color: #333;
        }
        .card {
            background: rgba(255, 255, 255, 0.9);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-center mb-4">Edit Data Pengunjung</h3>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required value="<?= htmlspecialchars($data['nama']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($data['email']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Usia</label>
                            <input type="number" name="usia" class="form-control" required value="<?= htmlspecialchars($data['usia']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tujuan Wisata</label>
                            <input type="text" name="tujuan_wisata" class="form-control" required value="<?= htmlspecialchars($data['tujuan_wisata']) ?>">
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                        <a href="data_pengunjung.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
