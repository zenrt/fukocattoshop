<?php
include 'koneksi.php';
include 'header.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { 
    echo "<script>window.location='index.php';</script>"; exit; 
}

// ==========================================
// KUMPULAN QUERY UNTUK MENARIK DATA
// ==========================================
$list_produk = mysqli_query($conn, "SELECT * FROM produk ORDER BY id_produk DESC");
$list_adopsi = mysqli_query($conn, "SELECT a.*, u.nama_lengkap, p.nama_produk FROM adopsi_kucing a JOIN users u ON a.id_user = u.id_user JOIN produk p ON a.id_produk = p.id_produk ORDER BY id_adopsi DESC");
$list_grooming = mysqli_query($conn, "SELECT g.*, u.nama_lengkap FROM grooming g JOIN users u ON g.id_user = u.id_user ORDER BY id_grooming DESC");
$list_transaksi = mysqli_query($conn, "SELECT t.*, u.nama_lengkap, p.nama_produk FROM transaksi t JOIN users u ON t.id_user = u.id_user JOIN produk p ON t.id_produk = p.id_produk ORDER BY id_transaksi DESC");
$titipan_user = mysqli_query($conn, "SELECT p.*, u.nama_lengkap FROM produk p JOIN users u ON p.id_user_owner = u.id_user WHERE p.status_produk='pending' ORDER BY id_produk DESC");
?>

<div class="max-w-7xl mx-auto px-4 py-10">
    
    <div class="bg-gray-900 text-white p-6 rounded-2xl shadow-xl mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold">Control Panel Admin</h1>
            <p class="text-gray-300 mt-2">Kelola Kucing, Aksesoris, & Approval Form.</p>
        </div>
        <a href="laporan_admin.php" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg transition transform hover:-translate-y-1 flex items-center gap-2">
            <i class="fa-solid fa-file-invoice"></i> Lihat Semua Riwayat & Laporan
        </a>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 mb-10">
        <h2 class="text-2xl font-bold mb-6 border-b pb-2"><i class="fa-solid fa-plus-circle text-green-500"></i> Tambah Kucing / Aksesoris</h2>
        <form action="proses_admin.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            
            <div class="grid grid-cols-2 gap-6">
                <input type="text" name="nama" placeholder="Nama Barang/Kucing" class="border p-3 rounded-lg w-full" required>
                <select name="kategori" class="border p-3 rounded-lg w-full" required>
                    <option value="kucing">Kucing</option>
                    <option value="aksesoris">Aksesoris</option>
                </select>
            </div>
            
            <div class="grid grid-cols-1 gap-6">
                <input type="number" name="harga" placeholder="Harga Jual (Rp)" class="border p-3 rounded-lg w-full" required>
            </div>

            <div class="bg-blue-50 p-5 rounded-xl border border-blue-100 mt-4">
                <h3 class="font-bold text-blue-800 mb-3"><i class="fa-solid fa-images"></i> Upload Foto Produk / Kucing</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1 text-gray-700">Foto Utama (Wajib) <span class="text-red-500">*</span></label>
                        <input type="file" name="foto" accept="image/*" class="border p-2 bg-white rounded-lg w-full" required>
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1 text-gray-700">Foto Angle 2 (Opsional)</label>
                        <input type="file" name="foto_2" accept="image/*" class="border p-2 bg-white rounded-lg w-full">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1 text-gray-700">Foto Angle 3 (Opsional)</label>
                        <input type="file" name="foto_3" accept="image/*" class="border p-2 bg-white rounded-lg w-full">
                    </div>
                </div>
            </div>

            <div>
                <label class="block font-bold mb-2 text-gray-700 mt-2">Deskripsi Produk</label>
                <textarea name="deskripsi" rows="3" placeholder="Jelaskan detail bahan, ukuran, fungsi, dll..." class="border p-3 rounded-lg w-full"></textarea>
            </div>

            <div class="bg-green-50 p-5 rounded-xl border border-green-200 mt-2 flex items-center gap-4">
                <input type="checkbox" name="butuh_ukuran" value="ya" class="w-6 h-6 accent-green-600 rounded cursor-pointer" id="cb_ukuran">
                <label for="cb_ukuran" class="font-bold text-green-800 cursor-pointer text-lg">
                    Centang ini jika barang butuh pilihan ukuran (S, M, L, XL)
                </label>
            </div>
            
            <div class="bg-orange-50 p-6 rounded-xl mt-4 border border-orange-200">
                <h3 class="font-bold text-orange-600 mb-4">Detail Khusus Kucing (Kosongi jika Aksesoris)</h3>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <select name="jenis_kucing" class="border p-3 rounded-lg w-full">
                        <option value="">-- Ras Kucing --</option>
                        <option value="Persia">Persia</option>
                        <option value="Anggora">Anggora</option>
                        <option value="Bengal">Bengal</option>
                        <option value="Domestik">Domestik</option>
                    </select>
                    <input type="text" name="umur" placeholder="Umur (Cth: 3 Bulan)" class="border p-3 rounded-lg w-full">
                    <select name="gender" class="border p-3 rounded-lg w-full">
                        <option value="">-- Gender --</option>
                        <option value="Jantan">Jantan</option>
                        <option value="Betina">Betina</option>
                    </select>
                </div>
                <textarea name="catatan" rows="2" placeholder="Catatan/Sifat Kucing..." class="border p-3 rounded-lg w-full"></textarea>
            </div>
            <button type="submit" name="tambah_produk" class="bg-green-600 text-white font-bold px-6 py-4 rounded-xl hover:bg-green-700 w-full mt-4 text-lg shadow-md transition">Simpan ke Database</button>
        </form>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 mb-10 overflow-x-auto">
        <h2 class="text-2xl font-bold mb-6 border-b pb-2 text-indigo-600"><i class="fa-solid fa-boxes-stacked"></i> Kelola Katalog Produk</h2>
        <table class="w-full text-left border-collapse min-w-max">
            <tr class="bg-indigo-50">
                <th class="p-3 border">Foto Utama</th>
                <th class="p-3 border">Nama & Kategori</th>
                <th class="p-3 border">Harga & Detail</th>
                <th class="p-3 border text-center">Aksi</th>
            </tr>
            <?php while($p = mysqli_fetch_assoc($list_produk)): ?>
            <tr class="hover:bg-gray-50">
                <td class="p-3 border w-24"><img src="uploads/<?= $p['foto'] ?>" class="w-full h-16 object-cover rounded shadow-sm"></td>
                <td class="p-3 border">
                    <b class="text-lg"><?= $p['nama_produk'] ?></b><br>
                    <span class="text-xs font-bold uppercase bg-gray-200 px-2 py-1 rounded"><?= $p['kategori'] ?></span>
                    <span class="text-xs font-bold uppercase ml-1 <?= $p['status_produk'] == 'teradopsi' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' ?> px-2 py-1 rounded"><?= $p['status_produk'] ?></span>
                </td>
                <td class="p-3 border text-sm">
                    <span class="font-bold text-orange-600 text-lg">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span><br>
                    <?php if($p['kategori'] == 'kucing'): ?>
                        Ras: <?= $p['jenis_kucing'] ?> | Gender: <?= $p['gender'] ?>
                    <?php else: ?>
                        Butuh Ukuran: <span class="font-bold uppercase <?= $p['butuh_ukuran']=='ya' ? 'text-green-600' : 'text-gray-500' ?>"><?= $p['butuh_ukuran'] ?? 'tidak' ?></span>
                    <?php endif; ?>
                </td>
                <td class="p-3 border text-center space-x-2">
                    <a href="edit_produk.php?id=<?= $p['id_produk'] ?>" class="bg-blue-500 text-white px-4 py-2 rounded font-bold hover:bg-blue-600 shadow-sm inline-block"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <a href="proses_admin.php?hapus_produk=<?= $p['id_produk'] ?>" onclick="return confirm('Yakin mau hapus <?= $p['nama_produk'] ?>?')" class="bg-red-500 text-white px-4 py-2 rounded font-bold hover:bg-red-600 shadow-sm inline-block"><i class="fa-solid fa-trash"></i> Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 mb-10 overflow-x-auto">
        <h2 class="text-2xl font-bold mb-6 border-b pb-2 text-orange-600"><i class="fa-solid fa-file-signature"></i> Review Pengajuan Adopsi</h2>
        <table class="w-full text-left border-collapse min-w-max">
            <tr class="bg-orange-50">
                <th class="p-3 border">Data Pemohon</th>
                <th class="p-3 border w-1/4">Pengalaman & Alamat</th>
                <th class="p-3 border w-1/3">Alasan Adopsi</th>
                <th class="p-3 border text-center">Kucing</th>
                <th class="p-3 border text-center">Aksi</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($list_adopsi)): ?>
            <tr class="hover:bg-gray-50 align-top">
                <td class="p-3 border text-sm">
                    <p class="font-bold text-gray-800 text-base"><?= $row['nama_lengkap'] ?></p>
                    <p class="text-green-600 font-bold mt-1"><i class="fa-brands fa-whatsapp"></i> <?= $row['no_wa'] ?></p>
                    <p class="text-gray-500 mt-1"><i class="fa-solid fa-briefcase"></i> Pekerjaan: <b><?= $row['pekerjaan'] ?></b></p>
                </td>
                <td class="p-3 border text-sm">
                    <p class="text-gray-700"><b>Pengalaman:</b> <br><?= $row['pengalaman'] ?? '-' ?></p>
                    <hr class="my-2 border-gray-200">
                    <p class="text-gray-700"><b>Alamat:</b> <br><?= $row['alamat_lengkap'] ?? '-' ?></p>
                </td>
                <td class="p-3 border">
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 text-sm text-gray-700 h-24 overflow-y-auto italic">
                        "<?= $row['alasan'] ?>"
                    </div>
                </td>
                <td class="p-3 border text-center font-bold text-orange-600">
                    <?= $row['nama_produk'] ?><br>
                    <span class="text-xs text-gray-500 uppercase"><?= $row['status'] ?></span>
                </td>
                <td class="p-3 border text-center">
                    <?php if($row['status'] == 'pending'): ?>
                    <form action="proses_admin.php" method="POST" class="flex flex-col gap-2">
                        <input type="hidden" name="id_adopsi" value="<?= $row['id_adopsi'] ?>">
                        <input type="hidden" name="id_produk" value="<?= $row['id_produk'] ?>">
                        <button type="submit" name="aksi_adopsi" value="disetujui" class="bg-green-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-green-600 transition"><i class="fa-solid fa-check mr-1"></i> ACC</button>
                        <div class="flex flex-col gap-1 mt-2">
                            <input type="text" name="alasan_tolak" placeholder="Ketik alasan tolak..." class="text-xs p-2 border rounded focus:ring-1 focus:ring-red-500 outline-none">
                            <button type="submit" name="aksi_adopsi" value="ditolak" class="bg-red-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-red-600 transition"><i class="fa-solid fa-xmark mr-1"></i> Tolak</button>
                        </div>
                    </form>
                    <?php else: ?>
                        <span class="text-sm text-gray-500 font-bold">SELESAI</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 mb-10 overflow-x-auto">
        <h2 class="text-2xl font-bold mb-6 border-b pb-2 text-rose-600"><i class="fa-solid fa-hourglass-start"></i> Review Kucing Titipan User</h2>
        <table class="w-full text-left border-collapse min-w-max">
            <tr class="bg-rose-50">
                <th class="p-3 border">Foto</th>
                <th class="p-3 border">Data Kucing & Pemilik</th>
                <th class="p-3 border">Alasan Dilepas</th>
                <th class="p-3 border text-center">Aksi</th>
            </tr>
            <?php while($t = mysqli_fetch_assoc($titipan_user)): ?>
            <tr class="hover:bg-gray-50">
                <td class="p-3 border w-24"><img src="uploads/<?= $t['foto'] ?>" class="w-20 h-20 object-cover rounded-lg shadow-sm"></td>
                <td class="p-3 border text-sm">
                    <b class="text-lg"><?= $t['nama_produk'] ?></b> (<?= $t['jenis_kucing'] ?>)<br>
                    Oleh: <?= $t['nama_lengkap'] ?><br>
                    WA: <span class="text-green-600 font-bold"><?= $t['no_wa'] ?></span>
                </td>
                <td class="p-3 border text-sm italic">"<?= $t['alasan_rehome'] ?>"</td>
                <td class="p-3 border text-center space-x-2">
                    <form action="proses_admin.php" method="POST" class="inline">
                        <input type="hidden" name="id_produk" value="<?= $t['id_produk'] ?>">
                        <button type="submit" name="approve_titipan" value="aktif" class="bg-green-500 text-white px-4 py-2 rounded font-bold hover:bg-green-600 mb-2 w-full"><i class="fa-solid fa-check"></i> ACC & Publish</button>
                        <button type="submit" name="approve_titipan" value="ditolak" class="bg-red-500 text-white px-4 py-2 rounded font-bold hover:bg-red-600 w-full"><i class="fa-solid fa-xmark"></i> Tolak</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 mb-10 overflow-x-auto">
        <h2 class="text-2xl font-bold mb-6 border-b pb-2 text-blue-600"><i class="fa-solid fa-bath"></i> Review Booking Grooming</h2>
        <table class="w-full text-left border-collapse min-w-max">
            <tr class="bg-blue-50">
                <th class="p-3 border">Pemesan & No. WA</th>
                <th class="p-3 border">Paket & Jadwal</th>
                <th class="p-3 border">Status</th>
                <th class="p-3 border">Aksi / Alasan Tolak</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($list_grooming)): ?>
            <tr class="hover:bg-gray-50">
                <td class="p-3 border text-sm">
                    <b><?= $row['nama_lengkap'] ?></b><br>
                    <a href="https://wa.me/<?= $row['no_wa'] ?? '' ?>" target="_blank" class="text-green-600 font-bold hover:underline"><i class="fa-brands fa-whatsapp"></i> <?= $row['no_wa'] ?? '-' ?></a>
                </td>
                <td class="p-3 border text-sm"><?= $row['paket_harga'] ?><br><b>Jadwal:</b> <?= $row['tanggal'] ?> (<?= $row['jam'] ?>)</td>
                <td class="p-3 border font-bold text-gray-600 uppercase"><?= $row['status'] ?></td>
                <td class="p-3 border">
                    <?php if($row['status'] == 'pending'): ?>
                    <form action="proses_admin.php" method="POST" class="flex items-center gap-2">
                        <input type="hidden" name="id_grooming" value="<?= $row['id_grooming'] ?>">
                        <input type="text" name="alasan_tolak" placeholder="Isi alasan ditolak..." class="border p-2 rounded text-sm w-48">
                        <button type="submit" name="aksi_grooming" value="disetujui" class="bg-green-500 text-white px-4 py-2 rounded font-bold hover:bg-green-600">ACC</button>
                        <button type="submit" name="aksi_grooming" value="ditolak" class="bg-red-500 text-white px-4 py-2 rounded font-bold hover:bg-red-600">Tolak</button>
                    </form>
                    <?php else: ?>
                        <span class="text-sm text-gray-500">Selesai. <?= $row['status'] == 'ditolak' ? 'Alasan: '.$row['alasan_penolakan'] : '' ?></span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 overflow-x-auto">
        <h2 class="text-2xl font-bold mb-6 border-b pb-2 text-green-600"><i class="fa-solid fa-box"></i> Review Pembelian Aksesoris & Pakan</h2>
        <table class="w-full text-left border-collapse min-w-max">
            <tr class="bg-green-50">
                <th class="p-3 border">Pembeli & Alamat</th>
                <th class="p-3 border">Pesanan & Total Harga</th>
                <th class="p-3 border">Status</th>
                <th class="p-3 border">Aksi / Alasan Tolak</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($list_transaksi)): ?>
            <tr class="hover:bg-gray-50">
                <td class="p-3 border text-sm">
                    <b><?= $row['nama_lengkap'] ?></b><br>
                    <span class="text-gray-500">Alamat: <?= $row['alamat_pengiriman'] ?></span><br>
                    <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-1 rounded mt-1 inline-block"><?= $row['metode_pengiriman'] ?> | <?= $row['metode_pembayaran'] ?></span>
                </td>
                <td class="p-3 border text-sm">
                    <b><?= $row['nama_produk'] ?> (x<?= $row['jumlah'] ?>)</b><br>
                    Ukuran: <span class="font-bold text-orange-600"><?= $row['ukuran'] ?></span><br>
                    <span class="text-lg font-bold text-green-600">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></span>
                </td>
                <td class="p-3 border font-bold text-gray-600 uppercase"><?= $row['status'] ?></td>
                <td class="p-3 border">
                    <?php if($row['status'] == 'pending'): ?>
                    <form action="proses_admin.php" method="POST" class="flex items-center gap-2">
                        <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi'] ?>">
                        <input type="text" name="alasan_tolak" placeholder="Isi alasan ditolak..." class="border p-2 rounded text-sm w-48">
                        <button type="submit" name="aksi_transaksi" value="dikirim" class="bg-green-500 text-white px-4 py-2 rounded font-bold hover:bg-green-600 shadow-sm">Kirim Barang</button>
                        <button type="submit" name="aksi_transaksi" value="ditolak" class="bg-red-500 text-white px-4 py-2 rounded font-bold hover:bg-red-600 shadow-sm">Tolak</button>
                    </form>
                    <?php else: ?>
                        <span class="text-sm text-gray-500">Selesai. <?= $row['status'] == 'ditolak' ? 'Alasan: '.$row['alasan_penolakan'] : '' ?></span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

</div>
</body>
</html>