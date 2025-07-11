<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

// Ambil ID dari parameter
$id = $_GET['id'];

// Ambil data lama
$query = mysqli_query($koneksi, "SELECT * FROM wisata WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan.'); window.location='data_wisata.php';</script>";
    exit;
}

// Proses update
if (isset($_POST['update'])) {
    $nama_wisata = mysqli_real_escape_string($koneksi, $_POST['nama_wisata']);
    $lokasi = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Cek apakah user upload file baru
    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "uploads/";
        $file_name = time() . '_' . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $file_name;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                // Hapus gambar lama jika ada
                if (!empty($data['gambar']) && file_exists("uploads/" . $data['gambar'])) {
                    unlink("uploads/" . $data['gambar']);
                }
                $gambar = $file_name;
            } else {
                echo "<script>alert('Upload gambar gagal.');</script>";
                $gambar = $data['gambar'];
            }
        } else {
            echo "<script>alert('File harus berupa gambar (jpg, jpeg, png, gif).');</script>";
            $gambar = $data['gambar'];
        }
    } else {
        $gambar = $data['gambar'];
    }

    $update = mysqli_query($koneksi, "UPDATE wisata SET 
        nama_wisata = '$nama_wisata',
        lokasi = '$lokasi',
        harga = '$harga',
        deskripsi = '$deskripsi',
        gambar = '$gambar'
        WHERE id = $id
    ");

    if ($update) {
        echo "<script>alert('Data berhasil diupdate'); window.location='data_wisata.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupdate data');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Wisata - TourNesia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat fixed;
            color: #333;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="text-center mb-4">Edit Data Wisata</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Nama Wisata</label>
                            <input type="text" name="nama_wisata" class="form-control" required value="<?= htmlspecialchars($data['nama_wisata']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" required value="<?= htmlspecialchars($data['lokasi']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control" required value="<?= htmlspecialchars($data['harga']) ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Wisata</label>
                            <input type="file" name="gambar" class="form-control">
                            <?php if (!empty($data['gambar'])): ?>
                                <small>Gambar saat ini:</small><br>
                                <img src="uploads/<?= htmlspecialchars($data['gambar']) ?>" alt="" style="max-width: 200px;">
                            <?php endif; ?>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                        <a href="data_wisata.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
