<?php
include 'koneksi.php';

if (isset($_POST['login'])) {
    session_start();
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
    
    if (mysqli_num_rows($cek) > 0) {
        $data = mysqli_fetch_assoc($cek);
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];
        
        header("location: " . ($data['role'] == 'admin' ? "admin.php" : "index.php"));
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
include 'header.php'; 
?>
<div class="flex items-center justify-center min-h-[80vh]">
    <div class="bg-white p-10 rounded-2xl shadow-xl w-[400px]">
        <h2 class="text-3xl font-extrabold text-center text-orange-600 mb-8">Login User</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" class="w-full mb-5 p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" required>
            <input type="password" name="password" placeholder="Password" class="w-full mb-8 p-4 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 outline-none" required>
            <button type="submit" name="login" class="w-full bg-orange-500 text-white font-bold py-4 rounded-xl hover:bg-orange-600 transition shadow-lg">Masuk</button>
        </form>
        <p class="text-center mt-6 text-gray-600">Belum punya akun? <a href="register.php" class="text-blue-600 font-bold hover:underline">Daftar</a></p>
    </div>
</div>
</body>
</html>