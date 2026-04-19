<?php
include 'koneksi.php';
include 'header.php';

if (!isset($_SESSION['id_user'])) { echo "<script>window.location='login.php';</script>"; exit; }
$id_user = $_SESSION['id_user'];

// Proses Hapus Item Keranjang
if(isset($_GET['hapus'])){
    $id_k = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_keranjang='$id_k' AND id_user='$id_user'");
    header("location: keranjang.php");
}

// Tarik data keranjang
$keranjang = mysqli_query($conn, "SELECT k.*, p.nama_produk, p.harga, p.foto FROM keranjang k JOIN produk p ON k.id_produk = p.id_produk WHERE id_user='$id_user'");
$total_belanja = 0;
$ada_barang = mysqli_num_rows($keranjang) > 0;

// Proses Checkout Eksekusi
if(isset($_POST['checkout'])){
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $pengiriman = $_POST['pengiriman'];
    $pembayaran = $_POST['pembayaran'];

    // Pindahkan semua isi keranjang ke tabel transaksi
    $ambil_cart = mysqli_query($conn, "SELECT k.*, p.harga, p.stok FROM keranjang k JOIN produk p ON k.id_produk = p.id_produk WHERE id_user='$id_user'");
    
    while($c = mysqli_fetch_assoc($ambil_cart)){
        $subtotal = $c['jumlah'] * $c['harga'];
        $id_produk = $c['id_produk'];
        $qty = $c['jumlah'];
        $ukr = $c['ukuran'];

        // Potong Stok
        $stok_baru = $c['stok'] - $qty;
        mysqli_query($conn, "UPDATE produk SET stok='$stok_baru' WHERE id_produk='$id_produk'");

        // Insert ke transaksi
        mysqli_query($conn, "INSERT INTO transaksi (id_user, id_produk, ukuran, jumlah, total_harga, alamat_pengiriman, metode_pengiriman, metode_pembayaran) 
                             VALUES ('$id_user', '$id_produk', '$ukr', '$qty', '$subtotal', '$alamat', '$pengiriman', '$pembayaran')");
    }

    // Kosongkan keranjang
    mysqli_query($conn, "DELETE FROM keranjang WHERE id_user='$id_user'");
    echo "<script>alert('Checkout Sukses! Silakan tunggu konfirmasi Admin.'); window.location='pesanan_saya.php';</script>";
}
?>

<div class="max-w-6xl mx-auto px-4 py-12 flex gap-8 items-start">
    
    <div class="w-2/3 bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
        <h2 class="text-3xl font-extrabold mb-6 border-b pb-4 text-gray-800"><i class="fa-solid fa-cart-shopping text-orange-500"></i> Keranjang Saya</h2>
        
        <?php if(!$ada_barang): ?>
            <div class="text-center py-10 text-gray-500">
                <i class="fa-solid fa-box-open text-6xl mb-4 text-gray-300"></i>
                <p class="text-xl">Keranjang kamu masih kosong Coy!</p>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php while($row = mysqli_fetch_assoc($keranjang)): 
                    $sub = $row['jumlah'] * $row['harga'];
                    $total_belanja += $sub;
                ?>
                <div class="flex items-center gap-6 bg-gray-50 p-4 rounded-2xl border">
                    <img src="uploads/<?= $row['foto'] ?>" class="w-24 h-24 object-cover rounded-xl shadow-sm">
                    <div class="flex-1">
                        <h3 class="font-bold text-xl text-gray-800"><?= $row['nama_produk'] ?></h3>
                        <p class="text-sm text-gray-500">Ukuran: <span class="font-bold text-orange-600"><?= $row['ukuran'] ?></span> | Qty: <?= $row['jumlah'] ?></p>
                        <p class="font-black text-green-600 mt-2">Rp <?= number_format($sub, 0, ',', '.') ?></p>
                    </div>
                    <a href="keranjang.php?hapus=<?= $row['id_keranjang'] ?>" class="bg-red-100 text-red-500 p-3 rounded-xl hover:bg-red-500 hover:text-white transition" title="Hapus"><i class="fa-solid fa-trash"></i></a>
                </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if($ada_barang): ?>
    <div class="w-1/3 bg-orange-50 p-8 rounded-3xl shadow-xl border border-orange-200 sticky top-28">
        <h2 class="text-2xl font-bold mb-6 text-orange-700 border-b border-orange-200 pb-2">Ringkasan & Checkout</h2>
        
        <div class="flex justify-between items-center mb-8">
            <span class="text-gray-600 font-bold">Total Belanja:</span>
            <span class="text-3xl font-black text-green-600">Rp <?= number_format($total_belanja, 0, ',', '.') ?></span>
        </div>

        <form method="POST" class="space-y-5">
            <div>
                <label class="block font-bold text-sm mb-1 text-gray-700">Alamat Pengiriman Lengkap</label>
                <textarea name="alamat" rows="3" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-orange-500" required></textarea>
            </div>
            <div>
                <label class="block font-bold text-sm mb-1 text-gray-700">Metode Pengiriman</label>
                <select name="pengiriman" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-orange-500" required>
                    <option value="J&T Express">J&T Express</option>
                    <option value="JNE Reguler">JNE Reguler</option>
                    <option value="SiCepat">SiCepat Halu</option>
                    <option value="Gojek/Grab (Instan)">Gojek/Grab (Instan Lokal)</option>
                </select>
            </div>
            <div>
                <label class="block font-bold text-sm mb-1 text-gray-700">Metode Pembayaran</label>
                <select name="pembayaran" class="w-full p-3 border rounded-xl focus:ring-2 focus:ring-orange-500" required>
                    <option value="Transfer BCA">Transfer Bank BCA</option>
                    <option value="Transfer Mandiri">Transfer Bank Mandiri</option>
                    <option value="QRIS">QRIS / E-Wallet</option>
                    <option value="COD (Bayar di Tempat)">COD (Bayar di Tempat)</option>
                </select>
            </div>
            
            <button type="submit" name="checkout" class="w-full bg-orange-600 text-white font-black text-lg py-4 rounded-xl hover:bg-orange-700 shadow-lg mt-4 transition">
                Proses Checkout Sekarang
            </button>
        </form>
    </div>
    <?php endif; ?>

</div>
</body>
</html>