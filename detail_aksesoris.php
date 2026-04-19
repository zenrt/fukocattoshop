<?php
include 'koneksi.php';
include 'header.php';

if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Login dulu boss!'); window.location='login.php';</script>"; exit;
}

$id_produk = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id_produk'");
$barang = mysqli_fetch_assoc($query);

// Proses Masukkan ke Keranjang
if(isset($_POST['masuk_keranjang'])){
    $id_user = $_SESSION['id_user'];
    $jumlah = $_POST['jumlah'];
    $ukuran = isset($_POST['ukuran']) ? $_POST['ukuran'] : '-';

    // Cek stok
    if($jumlah > $barang['stok']){
        echo "<script>alert('Stok gak cukup Coy! Sisa: ".$barang['stok']."');</script>";
    } else {
        mysqli_query($conn, "INSERT INTO keranjang (id_user, id_produk, jumlah, ukuran) VALUES ('$id_user', '$id_produk', '$jumlah', '$ukuran')");
        echo "<script>alert('Berhasil masuk keranjang!'); window.location='keranjang.php';</script>";
    }
}
?>

<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white p-8 rounded-3xl shadow-xl flex gap-10 border border-gray-100">
        <div class="w-1/2">
            <img src="uploads/<?= $barang['foto'] ?>" class="w-full rounded-2xl shadow-md border">
        </div>
        <div class="w-1/2 flex flex-col justify-center">
            <span class="bg-green-100 text-green-700 text-sm font-bold px-3 py-1 rounded-full w-max mb-4">Stok: <?= $barang['stok'] ?> Pcs</span>
            <h2 class="text-3xl font-extrabold text-gray-800 mb-2"><?= $barang['nama_produk'] ?></h2>
            <p class="text-4xl font-black text-orange-500 mb-6">Rp <?= number_format($barang['harga'], 0, ',', '.') ?></p>

            <form method="POST" class="space-y-6">
                <?php if($barang['butuh_ukuran'] == 'ya'): ?>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                    <label class="block font-bold mb-2 text-gray-700"><i class="fa-solid fa-ruler"></i> Pilih Ukuran (Lingkar Dada/Leher)</label>
                    <select name="ukuran" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500" required>
                        <option value="">-- Pilih Ukuran --</option>
                        <option value="S">Ukuran S (Kitten - Lingkar 20-25 cm)</option>
                        <option value="M">Ukuran M (Kucing Remaja - Lingkar 26-30 cm)</option>
                        <option value="L">Ukuran L (Kucing Dewasa - Lingkar 31-35 cm)</option>
                        <option value="XL">Ukuran XL (Kucing Gemuk/Besar - Lingkar 36-40 cm)</option>
                    </select>
                </div>
                <?php endif; ?>

                <div>
                    <label class="block font-bold mb-2 text-gray-700">Jumlah Beli</label>
                    <input type="number" name="jumlah" min="1" max="<?= $barang['stok'] ?>" value="1" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-orange-500" required>
                </div>

                <button type="submit" name="masuk_keranjang" class="w-full bg-orange-500 text-white font-bold text-xl py-4 rounded-xl hover:bg-orange-600 shadow-lg transition">
                    <i class="fa-solid fa-cart-plus"></i> Masukkan Keranjang
                </button>
            </form>
        </div>
    </div>
</div>