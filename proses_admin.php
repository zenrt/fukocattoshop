<?php
session_start();
include 'koneksi.php';

// Proteksi Ganda: Pastikan cuma Admin yang bisa ngejalanin mesin ini
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}

// ====================================================
// 1. MESIN UNTUK TAMBAH KUCING / AKSESORIS BARU
// ====================================================
if (isset($_POST['tambah_produk'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    
    // TANGKAP DESKRIPSI & UKURAN BARU
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $butuh_ukuran = isset($_POST['butuh_ukuran']) ? 'ya' : 'tidak'; 
    
    // Variabel khusus kucing
    $jenis = mysqli_real_escape_string($conn, $_POST['jenis_kucing'] ?? '');
    $umur = mysqli_real_escape_string($conn, $_POST['umur'] ?? '');
    $gender = $_POST['gender'] ?? '';
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan'] ?? '');

    if (!is_dir('uploads')) { mkdir('uploads', 0777, true); }

    // Proses Foto Utama (Wajib)
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $path = "uploads/" . $foto;
    $upload_sukses = move_uploaded_file($tmp, $path);

    // Proses Foto 2 (Opsional)
    $foto_2 = NULL;
    if (!empty($_FILES['foto_2']['name'])) {
        $foto_2 = $_FILES['foto_2']['name'];
        $tmp_2 = $_FILES['foto_2']['tmp_name'];
        move_uploaded_file($tmp_2, "uploads/" . $foto_2);
    }

    // Proses Foto 3 (Opsional)
    $foto_3 = NULL;
    if (!empty($_FILES['foto_3']['name'])) {
        $foto_3 = $_FILES['foto_3']['name'];
        $tmp_3 = $_FILES['foto_3']['tmp_name'];
        move_uploaded_file($tmp_3, "uploads/" . $foto_3);
    }

    if ($upload_sukses) {
        $query = "INSERT INTO produk (nama_produk, kategori, harga, foto, foto_2, foto_3, umur, jenis_kucing, gender, catatan, deskripsi, butuh_ukuran, status_produk) 
                  VALUES ('$nama', '$kategori', '$harga', '$foto', '$foto_2', '$foto_3', '$umur', '$jenis', '$gender', '$catatan', '$deskripsi', '$butuh_ukuran', 'aktif')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Produk berhasil ditambahkan ke katalog!'); window.location='admin.php';</script>";
        } else {
            echo "<script>alert('Gagal simpan ke database: " . mysqli_error($conn) . "'); window.location='admin.php';</script>";
        }
    } else {
        echo "<script>alert('GAGAL UPLOAD FOTO UTAMA!'); window.location='admin.php';</script>";
    }
}


// ====================================================
// 2. MESIN UNTUK ACC / TOLAK ADOPSI KUCING (UPDATE LOGIC)
// ====================================================
if (isset($_POST['aksi_adopsi'])) {
    $id = $_POST['id_adopsi'];
    $aksi = $_POST['aksi_adopsi']; // Isinya 'disetujui' atau 'ditolak'
    $alasan = mysqli_real_escape_string($conn, $_POST['alasan_tolak']); 
    
    if ($aksi == 'ditolak' && empty($alasan)) {
        echo "<script>alert('Bro, kalau nolak form adopsi, alasannya wajib diisi dong biar usernya tau!'); window.location='admin.php';</script>";
        exit;
    }

    // UPDATE: Ambil ID Kucing dari tabel adopsi dulu biar kita tau kucing mana yang diadopsi
    $cek_kucing = mysqli_query($conn, "SELECT id_produk FROM adopsi_kucing WHERE id_adopsi='$id'");
    $data_kucing = mysqli_fetch_assoc($cek_kucing);
    $id_produk_teradopsi = $data_kucing['id_produk'];

    // Eksekusi Update Status Form Adopsi
    $query = "UPDATE adopsi_kucing SET status='$aksi', alasan_penolakan='$alasan' WHERE id_adopsi='$id'";
    if (mysqli_query($conn, $query)) {
        
        // JIKA DISETUJUI, UBAH STATUS KUCING JADI TERADOPSI BIAR HILANG DARI HALAMAN DEPAN
        if ($aksi == 'disetujui') {
            mysqli_query($conn, "UPDATE produk SET status_produk='teradopsi' WHERE id_produk='$id_produk_teradopsi'");
        }

        echo "<script>alert('Status Adopsi berhasil diupdate!'); window.location='admin.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location='admin.php';</script>";
    }
}


// ====================================================
// 3. MESIN UNTUK ACC / TOLAK BOOKING GROOMING
// ====================================================
if (isset($_POST['aksi_grooming'])) {
    $id = $_POST['id_grooming'];
    $aksi = $_POST['aksi_grooming']; 
    $alasan = mysqli_real_escape_string($conn, $_POST['alasan_tolak']); 
    
    if ($aksi == 'ditolak' && empty($alasan)) {
        echo "<script>alert('Kasih tau usernya alasannya kenapa jadwal grooming ditolak!'); window.location='admin.php';</script>";
        exit;
    }

    $query = "UPDATE grooming SET status='$aksi', alasan_penolakan='$alasan' WHERE id_grooming='$id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Status Grooming berhasil diupdate!'); window.location='admin.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location='admin.php';</script>";
    }
}


// ====================================================
// 4. MESIN UNTUK ACC / TOLAK PEMBELIAN AKSESORIS
// ====================================================
if (isset($_POST['aksi_transaksi'])) {
    $id = $_POST['id_transaksi'];
    $aksi = $_POST['aksi_transaksi']; 
    $alasan = mysqli_real_escape_string($conn, $_POST['alasan_tolak']); 
    
    if ($aksi == 'ditolak' && empty($alasan)) {
        echo "<script>alert('Alasan tolak pesanan aksesoris wajib diisi ya!'); window.location='admin.php';</script>";
        exit;
    }

    $query = "UPDATE transaksi SET status='$aksi', alasan_penolakan='$alasan' WHERE id_transaksi='$id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Status Pembelian Aksesoris berhasil diupdate!'); window.location='admin.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location='admin.php';</script>";
    }
}


// ====================================================
// 5. MESIN UNTUK MENGHAPUS PRODUK / KUCING
// ====================================================
if (isset($_GET['hapus_produk'])) {
    $id_hapus = $_GET['hapus_produk'];
    
    // UPDATE: Hapus file foto utama dan foto opsional dari folder uploads
    $cek_foto = mysqli_query($conn, "SELECT foto, foto_2, foto_3 FROM produk WHERE id_produk='$id_hapus'");
    $data_foto = mysqli_fetch_assoc($cek_foto);
    
    if($data_foto['foto'] != '' && file_exists("uploads/".$data_foto['foto'])) {
        unlink("uploads/".$data_foto['foto']);
    }
    if($data_foto['foto_2'] != '' && file_exists("uploads/".$data_foto['foto_2'])) {
        unlink("uploads/".$data_foto['foto_2']);
    }
    if($data_foto['foto_3'] != '' && file_exists("uploads/".$data_foto['foto_3'])) {
        unlink("uploads/".$data_foto['foto_3']);
    }

    // Eksekusi hapus di database
    $query_hapus = "DELETE FROM produk WHERE id_produk='$id_hapus'";
    if (mysqli_query($conn, $query_hapus)) {
        echo "<script>alert('Produk berhasil dihapus dari katalog!'); window.location='admin.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus produk!'); window.location='admin.php';</script>";
    }
}


// ====================================================
// 6. MESIN UNTUK ACC / TOLAK TITIPAN KUCING DARI USER (FITUR BARU)
// ====================================================
if (isset($_POST['approve_titipan'])) {
    $id_produk = $_POST['id_produk'];
    $status_baru = $_POST['approve_titipan']; // 'aktif' atau 'ditolak'

    $query = "UPDATE produk SET status_produk='$status_baru' WHERE id_produk='$id_produk'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Status Kucing Titipan berhasil dikurasi!'); window.location='admin.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.location='admin.php';</script>";
    }
}
?>