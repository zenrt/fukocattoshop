<?php
include 'koneksi.php';

$pesan = "";
if (isset($_POST['daftar'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "<p class='text-red-500 mb-4 text-center font-bold'>Username sudah dipakai, cari yang lain bos!</p>";
    } else {
        mysqli_query($conn, "INSERT INTO users (nama_lengkap, username, password) VALUES ('$nama', '$user', '$pass')");
        echo "<script>alert('Sukses bikin akun! Silakan login.'); window.location='login.php';</script>";
        exit;
    }
}

include 'header.php'; 
?>
<div class="flex items-center justify-center min-h-[80vh]">
    <div class="bg-white p-10 rounded-2xl shadow-xl w-[400px]">
        <h2 class="text-3xl font-extrabold text-center text-orange-600 mb-8">Daftar Akun</h2>
        <?= $pesan ?>
        <form method="POST" class="space-y-5">
            <input type="text" name="nama" placeholder="Nama Lengkap" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" required>
            <input type="text" name="username" placeholder="Username" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" required>
            <button type="submit" name="daftar" class="w-full bg-orange-500 text-white font-bold text-lg py-4 rounded-xl hover:bg-orange-600 transition shadow-lg">Daftar Sekarang</button>
        </form>
        <p class="text-center mt-6 text-gray-600">Sudah punya akun? <a href="login.php" class="text-blue-600 font-bold hover:underline">Login di sini</a></p>
    </div>
</div>
</body>
</html>