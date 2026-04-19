<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Login dulu sebelum belanja aksesoris!'); window.location='login.php';</script>";
    exit;
}
// Di sistem nyata, ini bakal masuk ke tabel keranjang (cart) atau pesanan.
echo "<script>alert('Fitur keranjang belanja (cart) akan segera hadir! Untuk saat ini stok tercatat.'); window.location='index.php#aksesoris';</script>";
?>