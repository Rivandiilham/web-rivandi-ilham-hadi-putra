<?php
// Memulai session PHP agar bisa menggunakan $_SESSION
session_start();

// Mengecek apakah user sudah login, jika belum arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit; // Menghentikan eksekusi script setelah redirect
}

// Menyisipkan koneksi ke database
include "koneksi.php";

// Mengecek apakah parameter `id` dikirim lewat URL (GET)
if (isset($_GET['id'])) {
    // Mengamankan nilai `id` dari SQL Injection
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Membuat query SQL untuk menghapus data dari tabel `wisata` berdasarkan `id`
    $query = "DELETE FROM wisata WHERE id = '$id'";
    
    // Menjalankan query hapus
    $result = mysqli_query($koneksi, $query);
    
    // Jika query berhasil dijalankan
    if ($result) {
        // Redirect kembali ke halaman data_wisata.php setelah berhasil menghapus
        header("Location: data_wisata.php");
        exit;
    } else {
        // Jika gagal, tampilkan pesan kesalahan dari MySQL
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    // Jika tidak ada parameter id di URL, redirect ke halaman data_wisata.php
    header("Location: data_wisata.php");
    exit;
}
?>
