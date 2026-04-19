<?php
include 'koneksi.php';
include 'header.php'; // Header biar gak hilang

if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Harus login dulu bro buat isi form!'); window.location='login.php';</script>";
    exit;
}

$id_produk = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id_produk'");
$kucing = mysqli_fetch_assoc($query);
?>

<div class="max-w-3xl mx-auto px-4 py-12">
    <div class="bg-white p-8 rounded-2xl shadow-xl">
        <h2 class="text-3xl font-extrabold mb-6 border-b pb-4">Form Pengajuan Adopsi: <span class="text-orange-600"><?= $kucing['nama_produk'] ?></span></h2>
        
        <form action="proses_adopsi.php" method="POST" class="space-y-6">
            <input type="hidden" name="id_produk" value="<?= $kucing['id_produk'] ?>">
            
            <div>
                <label class="block font-bold mb-2">Pekerjaan Saat Ini</label>
                <input type="text" name="pekerjaan" placeholder="Cth: Mahasiswa / Karyawan" class="w-full border p-4 rounded-xl focus:ring-2 focus:ring-orange-500" required>
            </div>
            <div>
                <label class="block font-bold mb-2">Pengalaman Memelihara Kucing</label>
                <select name="pengalaman" class="w-full border p-4 rounded-xl bg-gray-50 focus:ring-2 focus:ring-orange-500" required>
                    <option value="Belum Pernah (Pemula)">Belum Pernah (Pemula)</option>
                    <option value="Pernah Pelihara">Pernah Pelihara Sebelumnya</option>
                    <option value="Sekarang Punya Kucing">Sekarang Sedang Pelihara Kucing</option>
                </select>
            </div>
            <div>
                <label class="block font-bold mb-2">Alasan Adopsi & Komitmen</label>
                <textarea name="alasan" rows="3" placeholder="Ceritakan kenapa kamu mau rawat kucing ini..." class="w-full border p-4 rounded-xl focus:ring-2 focus:ring-orange-500" required></textarea>
            </div>
            <div>
                <label class="block font-bold mb-2">Alamat Lengkap (Tempat Tinggal Kucing)</label>
                <textarea name="alamat" rows="2" class="w-full border p-4 rounded-xl focus:ring-2 focus:ring-orange-500" required></textarea>
            </div>
            <div>
    <label class="block font-bold mb-2 text-gray-700">Nomor WhatsApp Aktif</label>
    <input type="text" name="no_wa" placeholder="Contoh: 08123456789 (Wajib yang bisa dihubungi)" class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-orange-500 outline-none bg-gray-50" required>
</div>
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-xl mb-6">
    <h3 class="font-extrabold text-red-700 mb-3 text-lg"><i class="fa-solid fa-triangle-exclamation"></i> Syarat & Ketentuan Adopsi (Wajib Dibaca)</h3>
    <ul class="list-disc list-inside text-sm text-red-600 space-y-2 mb-4">
        <li>Berkomitmen merawat kucing seumur hidupnya, bukan hanya saat lucu/kecil.</li>
        <li>Kucing <b>TIDAK UNTUK DIPERJUALBELIKAN</b> atau dipindahtangankan tanpa sepengetahuan Fukocatto Shop.</li>
        <li>Bersedia memberikan pakan yang layak, akses air bersih, dan membawanya ke dokter hewan jika sakit.</li>
        <li>Kucing tidak boleh dikurung di dalam kandang 24 jam penuh (harus ada waktu bermain).</li>
        <li>Bersedia di-<i>follow up</i> (dimintai foto/video perkembangan kucing) oleh Admin secara berkala via WhatsApp.</li>
    </ul>
    
    <div class="flex items-start gap-3 mt-4 bg-white p-4 rounded-lg border border-red-200 shadow-sm">
        <input type="checkbox" id="setuju" name="setuju" class="w-5 h-5 accent-red-600 mt-0.5 cursor-pointer" required>
        <label for="setuju" class="text-sm font-bold text-gray-700 cursor-pointer">
            Saya telah membaca, memahami, dan bersedia mematuhi seluruh syarat adopsi di atas. Jika melanggar, saya siap mengembalikan kucing tersebut.
        </label>
    </div>
</div>

            <button type="submit" name="kirim_form" class="w-full bg-blue-600 text-white font-bold text-lg py-4 rounded-xl hover:bg-blue-700 shadow-lg">Kirim Pengajuan ke Admin</button>
        </form>
    </div>
</div>
</body>
</html>