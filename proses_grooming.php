<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Harus login dulu buat booking grooming!'); window.location='login.php';</script>";
    exit;
}

if (isset($_POST['booking'])) {
    $id_user = $_SESSION['id_user'];
    $paket = $_POST['paket'];
    $tanggal = $_POST['tanggal'];
    $jam = $_POST['jam'];
    $no_telp = mysqli_real_escape_string($conn, $_POST['no_telp']); // Tangkap nomor telepon
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    // Simpan ke database beserta no_telp
    $query = "INSERT INTO grooming (id_user, paket_harga, tanggal, jam, no_telp, alamat_home_service) 
              VALUES ('$id_user', '$paket', '$tanggal', '$jam', '$no_telp', '$alamat')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Booking berhasil dikirim! Silakan tunggu konfirmasi Admin.'); window.location='pesanan_saya.php';</script>";
    } else {
        echo "Wah gagal Coy, ini errornya: " . mysqli_error($conn);
    }
} else {
    echo "<script>alert('Akses ilegal!'); window.location='index.php';</script>";
}
?>