<?php
include 'koneksi.php';
include 'header.php';

// Proteksi: Hanya Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { 
    echo "<script>window.location='index.php';</script>"; exit; 
}

// Tarik SEMUA data riwayat dari awal sampai akhir
$riwayat_transaksi = mysqli_query($conn, "SELECT t.*, u.nama_lengkap, p.nama_produk FROM transaksi t JOIN users u ON t.id_user = u.id_user JOIN produk p ON t.id_produk = p.id_produk ORDER BY t.id_transaksi DESC");
$riwayat_grooming = mysqli_query($conn, "SELECT g.*, u.nama_lengkap FROM grooming g JOIN users u ON g.id_user = u.id_user ORDER BY g.id_grooming DESC");
$riwayat_adopsi = mysqli_query($conn, "SELECT a.*, u.nama_lengkap, p.nama_produk FROM adopsi_kucing a JOIN users u ON a.id_user = u.id_user JOIN produk p ON a.id_produk = p.id_produk ORDER BY a.id_adopsi DESC");

// Fungsi kecil untuk mewarnai status
function getStatusColor($status) {
    if($status == 'pending') return 'bg-yellow-100 text-yellow-700';
    if($status == 'ditolak') return 'bg-red-100 text-red-700';
    return 'bg-green-100 text-green-700'; // Untuk disetujui / dikirim / aktif
}
?>

<div class="max-w-7xl mx-auto px-4 py-10">
    
    <div class="flex items-center gap-4 mb-10">
        <a href="admin.php" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-bold transition"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
        <h1 class="text-3xl font-extrabold text-gray-800"><i class="fa-solid fa-book-journal-whills text-purple-600"></i> Rekam Jejak Seluruh User</h1>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 mb-10 overflow-x-auto">
        <h2 class="text-2xl font-bold mb-6 border-b pb-2 text-green-600"><i class="fa-solid fa-cart-shopping"></i> Riwayat Transaksi Aksesoris & Pakan</h2>
        <table class="w-full text-left border-collapse min-w-max">
            <tr class="bg-gray-100">
                <th class="p-3 border">Tgl Pembelian</th>
                <th class="p-3 border">User Pembeli</th>
                <th class="p-3 border">Detail Barang</th>
                <th class="p-3 border">Total Belanja</th>
                <th class="p-3 border text-center">Status Akhir</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($riwayat_transaksi)): ?>
            <tr class="hover:bg-gray-50 border-b">
                <td class="p-3 text-sm text-gray-500"><?= date('d M Y, H:i', strtotime($row['tanggal'])) ?? '-' ?></td>
                <td class="p-3"><b><?= $row['nama_lengkap'] ?></b></td>
                <td class="p-3 text-sm">
                    <b><?= $row['nama_produk'] ?> (x<?= $row['jumlah'] ?>)</b><br>
                    <span class="text-gray-500">Ekspedisi: <?= $row['metode_pengiriman'] ?></span>
                </td>
                <td class="p-3 font-bold text-green-600">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                <td class="p-3 text-center">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase <?= getStatusColor($row['status']) ?>"><?= $row['status'] ?></span>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 mb-10 overflow-x-auto">
        <h2 class="text-2xl font-bold mb-6 border-b pb-2 text-blue-600"><i class="fa-solid fa-bath"></i> Riwayat Booking Grooming</h2>
        <table class="w-full text-left border-collapse min-w-max">
            <tr class="bg-gray-100">
                <th class="p-3 border">User Pemesan</th>
                <th class="p-3 border">Paket Layanan</th>
                <th class="p-3 border">Jadwal Eksekusi</th>
                <th class="p-3 border text-center">Status Akhir</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($riwayat_grooming)): ?>
            <tr class="hover:bg-gray-50 border-b">
                <td class="p-3"><b><?= $row['nama_lengkap'] ?></b></td>
                <td class="p-3 text-sm"><?= $row['paket_harga'] ?></td>
                <td class="p-3 text-sm font-bold text-gray-700"><?= $row['tanggal'] ?> (<?= $row['jam'] ?>)</td>
                <td class="p-3 text-center">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase <?= getStatusColor($row['status']) ?>"><?= $row['status'] ?></span>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 mb-10 overflow-x-auto">
        <h2 class="text-2xl font-bold mb-6 border-b pb-2 text-orange-600"><i class="fa-solid fa-file-signature"></i> Riwayat Pengajuan Adopsi</h2>
        <table class="w-full text-left border-collapse min-w-max">
            <tr class="bg-gray-100">
                <th class="p-3 border">User Pemohon</th>
                <th class="p-3 border">Kucing yang Diadopsi</th>
                <th class="p-3 border">Alasan User</th>
                <th class="p-3 border text-center">Status Akhir</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($riwayat_adopsi)): ?>
            <tr class="hover:bg-gray-50 border-b">
                <td class="p-3"><b><?= $row['nama_lengkap'] ?></b></td>
                <td class="p-3"><b><?= $row['nama_produk'] ?></b></td>
                <td class="p-3 text-sm italic text-gray-500">"<?= $row['alasan'] ?>"</td>
                <td class="p-3 text-center">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase <?= getStatusColor($row['status']) ?>"><?= $row['status'] ?></span>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>
</body>
</html>