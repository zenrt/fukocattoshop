<?php
session_start();
include 'koneksi.php';

// Auth Guard
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Login dulu ya!'); window.location='login.php';</script>";
    exit;
}

if (isset($_POST['kirim_form'])) {
    $id_user = $_SESSION['id_user'];
    $id_produk = $_POST['id_produk'];
    
    // TANGKAP SEMUA DATA DI SINI (Termasuk WA)
    $no_wa = mysqli_real_escape_string($conn, $_POST['no_wa']);
    $pekerjaan = mysqli_real_escape_string($conn, $_POST['pekerjaan']);
    $pengalaman = $_POST['pengalaman'];
    $alasan = mysqli_real_escape_string($conn, $_POST['alasan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    // QUERY NYA JADI SATU AJA KAYA GINI
    $query = "INSERT INTO adopsi_kucing (id_user, id_produk, no_wa, pekerjaan, alamat_lengkap, pengalaman, alasan, status) 
              VALUES ('$id_user', '$id_produk', '$no_wa', '$pekerjaan', '$alamat', '$pengalaman', '$alasan', 'pending')";
              
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Berhasil diajukan! Menunggu admin mengecek form kamu.'); window.location='index.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>