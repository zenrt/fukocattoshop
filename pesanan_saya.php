<?php
include 'koneksi.php';
include 'header.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data milik user ini saja
$cek_adopsi = mysqli_query($conn, "SELECT a.*, p.nama_produk FROM adopsi_kucing a JOIN produk p ON a.id_produk = p.id_produk WHERE id_user='$id_user' ORDER BY id_adopsi DESC");
$cek_grooming = mysqli_query($conn, "SELECT * FROM grooming WHERE id_user='$id_user' ORDER BY id_grooming DESC");
?>

<div class="max-w-5xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-extrabold mb-8 text-gray-800">Status Pesanan & Pengajuan Saya</h1>

    <div class="bg-white p-8 rounded-2xl shadow-lg border-l-8 border-orange-500 mb-8">
        <h2 class="text-xl font-bold mb-4 border-b pb-2 text-orange-600"><i class="fa-solid fa-cat"></i> Adopsi Kucing</h2>
        <?php if(mysqli_num_rows($cek_adopsi) > 0): ?>
            <ul class="space-y-4">
                <?php while($ad = mysqli_fetch_assoc($cek_adopsi)): ?>
                    <li class="p-4 bg-gray-50 rounded-lg border">
                        <p class="text-lg">Pengajuan Adopsi: <b><?= $ad['nama_produk'] ?></b></p>
                        <p>Status: 
                            <span class="font-bold uppercase 
                                <?= $ad['status'] == 'ditolak' ? 'text-red-500' : ($ad['status'] == 'disetujui' ? 'text-green-500' : 'text-orange-500') ?>">
                                <?= $ad['status'] ?>
                            </span>
                        </p>
                        <?php if($ad['status'] == 'ditolak'): ?>
                            <p class="mt-2 text-sm text-red-600 bg-red-100 p-2 rounded border border-red-200">
                                <b>Alasan Ditolak:</b> "<?= $ad['alasan_penolakan'] ?>"
                            </p>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="text-gray-500 italic">Kamu belum pernah mengajukan adopsi kucing.</p>
        <?php endif; ?>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-lg border-l-8 border-blue-500">
        <h2 class="text-xl font-bold mb-4 border-b pb-2 text-blue-600"><i class="fa-solid fa-bath"></i> Jadwal Home Grooming</h2>
        <?php if(mysqli_num_rows($cek_grooming) > 0): ?>
            <ul class="space-y-4">
                <?php while($gr = mysqli_fetch_assoc($cek_grooming)): ?>
                    <li class="p-4 bg-gray-50 rounded-lg border">
                        <p class="text-lg">Paket: <b><?= $gr['paket_harga'] ?></b></p>
                        <p>Jadwal: <?= $gr['tanggal'] ?> (Jam <?= $gr['jam'] ?>)</p>
                        <p>Status: 
                            <span class="font-bold uppercase 
                                <?= $gr['status'] == 'ditolak' ? 'text-red-500' : ($gr['status'] == 'disetujui' ? 'text-green-500' : 'text-orange-500') ?>">
                                <?= $gr['status'] ?>
                            </span>
                        </p>
                        <?php if($gr['status'] == 'ditolak'): ?>
                            <p class="mt-2 text-sm text-red-600 bg-red-100 p-2 rounded border border-red-200">
                                <b>Alasan Ditolak:</b> "<?= $gr['alasan_penolakan'] ?>"
                            </p>
                        <?php endif; ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p class="text-gray-500 italic">Kamu belum memiliki jadwal booking grooming.</p>
        <?php endif; ?>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border p-6 mb-8">
    <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
        <i class="fa-solid fa-bag-shopping text-green-500"></i> Belanjaan Saya
    </h2>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <tr class="text-gray-400 text-sm border-b">
                <th class="pb-3 font-medium">Produk</th>
                <th class="pb-3 font-medium text-center">Jumlah</th>
                <th class="pb-3 font-medium">Total Harga</th>
                <th class="pb-3 font-medium text-center">Status</th>
            </tr>
            <?php 
            // Query buat narik data belanjaan + info produknya
            $id_user = $_SESSION['id_user'];
            $ambil = mysqli_query($conn, "SELECT t.*, p.nama_produk, p.foto FROM transaksi t JOIN produk p ON t.id_produk = p.id_produk WHERE t.id_user = '$id_user' ORDER BY t.id_transaksi DESC");
            while($pecah = mysqli_fetch_assoc($ambil)): 
            ?>
            <tr class="border-b last:border-0">
                <td class="py-4">
                    <div class="flex items-center gap-3">
                        <img src="uploads/<?= $pecah['foto'] ?>" class="w-12 h-12 object-cover rounded-lg">
                        <span class="font-bold text-gray-800"><?= $pecah['nama_produk'] ?></span>
                    </div>
                </td>
                <td class="py-4 text-center"><?= $pecah['jumlah'] ?></td>
                <td class="py-4 font-bold text-orange-500">Rp <?= number_format($pecah['total_harga'], 0, ',', '.') ?></td>
                <td class="py-4 text-center">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase 
                        <?= ($pecah['status'] == 'pending') ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600' ?>">
                        <?= $pecah['status'] ?>
                    </span>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>
</div>
</body>
</html>