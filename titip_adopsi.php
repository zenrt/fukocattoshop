<?php
include 'koneksi.php';
include 'header.php';

if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Harus login dulu buat titip adopsi!'); window.location='login.php';</script>"; exit;
}
?>

<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white p-10 rounded-3xl shadow-xl border border-gray-100">
        <h2 class="text-3xl font-extrabold mb-2 text-gray-800">Form Titip Adopsi</h2>
        <p class="text-gray-500 mb-8">Bantu anabulmu menemukan rumah baru yang penuh kasih sayang.</p>

        <form action="proses_titip.php" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block font-bold mb-2 text-gray-700">Nama Kucing</label>
                    <input type="text" name="nama" class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" required>
                </div>
                <div>
                    <label class="block font-bold mb-2 text-gray-700">Ras Kucing</label>
                    <input type="text" name="jenis" placeholder="Contoh: Persia / Domestik" class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" required>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">
                <div>
                    <label class="block font-bold mb-2 text-gray-700">Umur</label>
                    <input type="text" name="umur" placeholder="Cth: 5 Bulan" class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" required>
                </div>
                <div>
                    <label class="block font-bold mb-2 text-gray-700">Gender</label>
                    <select name="gender" class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" required>
                        <option value="Jantan">Jantan</option>
                        <option value="Betina">Betina</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold mb-2 text-gray-700">WhatsApp Kamu</label>
                    <input type="text" name="no_wa" placeholder="0812..." class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" required>
                </div>
            </div>

            <div>
                <label class="block font-bold mb-2 text-gray-700">Foto Kucing</label>
                <input type="file" name="foto" class="w-full p-3 border border-dashed border-gray-300 rounded-xl" required>
            </div>

            <div>
                <label class="block font-bold mb-2 text-gray-700">Mengapa Kucing Ini Ingin Dilepas? (Alasan)</label>
                <textarea name="alasan" rows="3" placeholder="Contoh: Saya harus pindah ke luar kota dan tidak bisa membawa anabul..." class="w-full p-4 border rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" required></textarea>
            </div>

            <button type="submit" name="titip" class="w-full bg-orange-600 text-white font-extrabold text-lg py-4 rounded-xl hover:bg-orange-700 shadow-lg transition transform hover:-translate-y-1">Kirim ke Admin untuk Review</button>
        </form>
    </div>
</div>