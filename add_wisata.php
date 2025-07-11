<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$nama_wisata = $lokasi = $harga = $deskripsi = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_wisata = mysqli_real_escape_string($koneksi, $_POST["nama_wisata"]);
    $lokasi = mysqli_real_escape_string($koneksi, $_POST["lokasi"]);
    $harga = mysqli_real_escape_string($koneksi, $_POST["harga"]);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST["deskripsi"]);

    $file_name = $_FILES['gambar']['name'];
    $file_tmp = $_FILES['gambar']['tmp_name'];
    $upload_dir = "uploads/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (!empty($file_name)) {
        $target_path = $upload_dir . basename($file_name);

        if (move_uploaded_file($file_tmp, $target_path)) {
            $sql = "INSERT INTO wisata (nama_wisata, lokasi, harga, deskripsi, gambar)
                    VALUES ('$nama_wisata', '$lokasi', '$harga', '$deskripsi', '$file_name')";
            $query = mysqli_query($koneksi, $sql);

            if ($query) {
                header("Location: data_wisata.php");
                exit;
            } else {
                $errors[] = "Gagal menyimpan data: " . mysqli_error($koneksi);
            }
        } else {
            $errors[] = "Gagal mengupload gambar.";
        }
    } else {
        $errors[] = "Pilih file gambar.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Tambah Data Wisata</h1>

    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama_wisata" class="form-label">Nama Wisata</label>
            <input type="text" class="form-control" name="nama_wisata" value="<?= htmlspecialchars($nama_wisata) ?>" required>
        </div>
        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" class="form-control" name="lokasi" value="<?= htmlspecialchars($lokasi) ?>" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga" value="<?= htmlspecialchars($harga) ?>" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi"><?= htmlspecialchars($deskripsi) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Upload Gambar</label>
            <input type="file" class="form-control" name="gambar">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="data_wisata.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
