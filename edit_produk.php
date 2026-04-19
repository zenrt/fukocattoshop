<?php
include 'koneksi.php';
include 'header.php';

// Pastikan hanya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { 
    echo "<script>window.location='index.php';</script>"; exit; 
}

$id_produk = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id_produk'");
$data = mysqli_fetch_assoc($query);

// Proses Update Data
if (isset($_POST['update_produk'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = $_POST['harga'];
    $jenis = mysqli_real_escape_string($conn, $_POST['jenis_kucing'] ?? '');
    $umur = mysqli_real_escape_string($conn, $_POST['umur'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan'] ?? '');

    // Cek apakah admin upload foto baru
    if ($_FILES['foto_baru']['name'] != '') {
        $foto_baru = $_FILES['foto_baru']['name'];
        $tmp = $_FILES['foto_baru']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $foto_baru);
        
        $sql = "UPDATE produk SET nama_produk='$nama', harga='$harga', jenis_kucing='$jenis', umur='$umur', gender='$gender', catatan='$catatan', foto='$foto_baru' WHERE id_produk='$id_produk'";
    } else {
        // Kalau gak upload foto baru, foto lama tetap aman
        $sql = "UPDATE produk SET nama_produk='$nama', harga='$harga', jenis_kucing='$jenis', umur='$umur', gender='$gender', catatan='$catatan' WHERE id_produk='$id_produk'";
    }

    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Data berhasil diperbarui!'); window.location='admin.php';</script>";
    }
}
?>

<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-2xl font-bold text-gray-800"><i class="fa-solid fa-pen-to-square text-blue-500"></i> Edit Produk: <span class="text-orange-600"><?= $data['nama_produk'] ?></span></h2>
            <a href="admin.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-bold hover:bg-gray-300">Kembali</a>
        </div>

        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold mb-2">Nama Barang / Kucing</label>
                    <input type="text" name="nama" value="<?= $data['nama_produk'] ?>" class="border p-3 rounded-lg w-full focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>
                <div>
                    <label class="block font-bold mb-2">Harga (Rp)</label>
                    <input type="number" name="harga" value="<?= $data['harga'] ?>" class="border p-3 rounded-lg w-full focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>
            </div>

            <?php if($data['kategori'] == 'kucing'): ?>
            <div class="bg-orange-50 p-6 rounded-xl border border-orange-200">
                <h3 class="font-bold text-orange-600 mb-4">Detail Kucing</h3>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">Ras Kucing</label>
                        <select name="jenis_kucing" class="border p-3 rounded-lg w-full">
                            <option value="Persia" <?= $data['jenis_kucing']=='Persia'?'selected':'' ?>>Persia</option>
                            <option value="Anggora" <?= $data['jenis_kucing']=='Anggora'?'selected':'' ?>>Anggora</option>
                            <option value="Bengal" <?= $data['jenis_kucing']=='Bengal'?'selected':'' ?>>Bengal</option>
                            <option value="Domestik" <?= $data['jenis_kucing']=='Domestik'?'selected':'' ?>>Domestik</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Umur</label>
                        <input type="text" name="umur" value="<?= $data['umur'] ?>" class="border p-3 rounded-lg w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Gender</label>
                        <select name="gender" class="border p-3 rounded-lg w-full">
                            <option value="Jantan" <?= $data['gender']=='Jantan'?'selected':'' ?>>Jantan</option>
                            <option value="Betina" <?= $data['gender']=='Betina'?'selected':'' ?>>Betina</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Catatan Khusus</label>
                    <textarea name="catatan" rows="2" class="border p-3 rounded-lg w-full"><?= $data['catatan'] ?></textarea>
                </div>
            </div>
            <?php endif; ?>

            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 flex gap-6 items-center">
                <img src="uploads/<?= $data['foto'] ?>" class="w-24 h-24 object-cover rounded-lg shadow-md border">
                <div class="w-full">
                    <label class="block font-bold mb-2">Ganti Foto Baru? (Opsional)</label>
                    <input type="file" name="foto_baru" accept="image/*" class="border p-2 rounded-lg w-full bg-white">
                    <p class="text-xs text-gray-500 mt-1">*Biarkan kosong jika tidak ingin mengubah foto lama.</p>
                </div>
            </div>

            <button type="submit" name="update_produk" class="w-full bg-blue-600 text-white font-bold text-lg py-4 rounded-xl hover:bg-blue-700 shadow-lg">Simpan Perubahan</button>
        </form>
    </div>
</div>
</body>
</html>