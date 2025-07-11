<?php
// Konfigurasi koneksi ke database
$host = "localhost";     // Nama host database (biasanya localhost untuk server lokal)
$user = "rivandii_tour_indonesia";          // Username database (root untuk XAMPP/Laragon default)
$pass = "Rivandiilham";              // Password database (kosong jika default XAMPP)
$db   = "rivandii_tour_indonesia"; // Nama database yang akan digunakan

// Membuat koneksi ke database menggunakan fungsi mysqli_connect
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Mengecek apakah koneksi berhasil atau tidak
if (!$koneksi) {
    // Jika koneksi gagal, tampilkan pesan error dan hentikan eksekusi script
    die("Koneksi Database gagal : " . mysqli_connect_error());
}
?>
