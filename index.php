<?php
include 'koneksi.php';
include 'header.php'; // MANGGIL HEADER DI SINI

$kucing = mysqli_query($conn, "SELECT * FROM produk WHERE kategori='kucing' AND status_produk='aktif'");
$aksesoris = mysqli_query($conn, "SELECT * FROM produk WHERE kategori='aksesoris'");
?>

<div class="relative bg-gradient-to-r from-orange-100 via-orange-50 to-yellow-100 py-24 text-center shadow-inner overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M54.627 0l.83.83-53.797 53.797-.83-.83L54.627 0zM29.172 0l.828.828-28.344 28.344-.828-.828L29.172 0zm25.455 25.455l.83.83-25.456 25.455-.83-.83 25.456-25.455z\' fill=\'%23f97316\' fill-opacity=\'1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>
    
    <div class="relative z-10">
        <h1 class="text-5xl md:text-6xl font-extrabold text-gray-800 mb-4 tracking-tight drop-shadow-sm">Temukan Anabul Kesayanganmu! <i class="fa-solid fa-cat text-orange-500"></i></h1>
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">Pusat adopsi kucing terpercaya, aksesoris lengkap, & layanan home grooming profesional langsung ke rumahmu.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-12">

    <section id="kucing" class="mb-24 mt-8">
        <div class="flex items-center mb-8 border-l-8 border-orange-500 pl-4">
            <h2 class="text-3xl font-extrabold text-gray-800">Adopsi Kucing</h2>
            <span class="ml-4 bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm font-bold">Siap Adopsi</span>
        </div>
        
        <?php if(mysqli_num_rows($kucing) > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php while($row = mysqli_fetch_assoc($kucing)): ?>
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden transform transition duration-300 hover:-translate-y-2 hover:shadow-2xl border border-gray-100">
                    
                    <div onclick="openModal('<?= addslashes($row['nama_produk']) ?>', '<?= $row['foto'] ?>', '<?= $row['foto_2'] ?? '' ?>', '<?= $row['foto_3'] ?? '' ?>', '<?= $row['jenis_kucing'] ?>', '<?= $row['umur'] ?>', '<?= $row['gender'] ?>', '<?= number_format($row['harga'], 0, ',', '.') ?>', '<?= addslashes($row['catatan']) ?>', <?= $row['id_produk'] ?>)" class="relative group cursor-pointer">
                        <img src="uploads/<?= $row['foto'] ?>" class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <span class="bg-white/20 backdrop-blur-md text-white px-6 py-2 rounded-full font-bold border border-white/50 shadow-lg"><i class="fa-solid fa-expand mr-2"></i>Lihat Detail Kucing</span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-extrabold text-2xl text-gray-800"><?= $row['nama_produk'] ?></h3>
                            <span class="bg-orange-100 text-orange-600 font-bold px-2 py-1 rounded-lg text-sm"><?= $row['gender'] ?></span>
                        </div>
                        <p class="text-green-500 font-extrabold text-xl mb-4"><i class="fa-solid fa-heart"></i> Gratis (Syarat Berlaku)</p>
                        
                        <div class="bg-orange-50 p-4 rounded-2xl text-sm mb-6 border border-orange-100/50">
                            <div class="grid grid-cols-2 gap-2 mb-2">
                                <p><i class="fa-solid fa-paw text-orange-400 w-5"></i> <b>Ras:</b> <br><span class="text-gray-600"><?= $row['jenis_kucing'] ?></span></p>
                                <p><i class="fa-solid fa-hourglass-half text-orange-400 w-5"></i> <b>Umur:</b> <br><span class="text-gray-600"><?= $row['umur'] ?></span></p>
                            </div>
                            <hr class="my-2 border-orange-200">
                            <p class="text-gray-600 italic line-clamp-2">"<?= $row['catatan'] ?>"</p>
                        </div>

                        <a href="form_kucing.php?id=<?= $row['id_produk'] ?>" class="block text-center bg-gray-900 text-white py-3.5 rounded-xl font-bold hover:bg-orange-500 shadow-md transition-colors duration-300">Bawa Pulang Sekarang</a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="bg-gray-50 p-12 rounded-3xl text-center border-dashed border-2 border-gray-300 flex flex-col items-center">
                <i class="fa-solid fa-cat text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-xl font-medium">Yah, saat ini belum ada kucing yang tersedia untuk diadopsi.</p>
            </div>
        <?php endif; ?>
    </section>

    <section id="aksesoris" class="mb-24 border-t-2 border-gray-100 pt-16 mt-8">
        <h2 class="text-3xl font-extrabold mb-8 border-l-8 border-green-500 pl-4">Aksesoris & Pakan</h2>
        
        <?php if(mysqli_num_rows($aksesoris) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while($aks = mysqli_fetch_assoc($aksesoris)): ?>
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl overflow-hidden transform transition duration-300 hover:-translate-y-1 border border-gray-100 flex flex-col group">
                    
                    <div class="h-56 bg-gray-50 flex items-center justify-center p-4 overflow-hidden border-b border-gray-100">
                        <img src="uploads/<?= $aks['foto'] ?>" class="w-full h-full object-contain transition duration-500 group-hover:scale-110 drop-shadow-sm">
                    </div>
                    
                    <div class="p-6 text-center flex flex-col flex-grow">
                        <h3 class="font-bold text-xl mb-2 text-gray-800 line-clamp-1" title="<?= $aks['nama_produk'] ?>"><?= $aks['nama_produk'] ?></h3>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2 h-10"><?= $aks['deskripsi'] ?? $aks['catatan'] ?? 'Deskripsi tidak tersedia.' ?></p>
                        <p class="text-green-600 font-extrabold text-2xl mb-6 mt-auto">Rp <?= number_format($aks['harga'], 0, ',', '.') ?></p>
                        
                        <a href="detail_aksesoris.php?id=<?= $aks['id_produk'] ?>" class="block w-full bg-green-500 text-white py-3 rounded-xl font-bold hover:bg-green-600 hover:shadow-lg transition-all duration-300">
                            <i class="fa-solid fa-cart-plus mr-1"></i> Beli Sekarang
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="bg-gray-50 p-10 rounded-2xl text-center border-dashed border-2 border-gray-300">
                <p class="text-gray-500 text-lg">Stok aksesoris dan pakan sedang kosong Coy!</p>
            </div>
        <?php endif; ?>
    </section>

    <section id="grooming" class="mb-10 border-t-2 border-gray-100 pt-16 mt-8">
        <div class="bg-white p-10 rounded-3xl shadow-xl border border-gray-100 max-w-4xl mx-auto relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-orange-100 rounded-full opacity-50"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-yellow-100 rounded-full opacity-50"></div>
            
            <div class="relative z-10">
                <h2 class="text-3xl font-extrabold mb-8 text-center text-orange-600"><i class="fa-solid fa-bath"></i> Booking Home Grooming</h2>
                <form action="proses_grooming.php" method="POST" class="space-y-6">
                    <div>
                        <label class="block font-bold mb-2 text-gray-700">Pilih Preset Paket</label>
                        <select name="paket" class="w-full p-4 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition outline-none" required>
                            <option value="Basic (Mandi & Potong Kuku) - Rp 80.000">🚿 Basic (Mandi & Potong Kuku) - Rp 80.000</option>
                            <option value="Premium (Mandi Kutu/Jamur) - Rp 150.000">🧴 Premium (Mandi Kutu/Jamur) - Rp 150.000</option>
                            <option value="Sultan (Full SPA) - Rp 250.000">👑 Sultan (Full SPA) - Rp 250.000</option>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block font-bold mb-2 text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" class="w-full p-4 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition outline-none" required>
                        </div>
                        <div>
                            <label class="block font-bold mb-2 text-gray-700">Jam Layanan</label>
                            <select name="jam" class="w-full p-4 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition outline-none" required>
                                <option value="08:00 - 10:00">08:00 - 10:00 WIB</option>
                                <option value="10:00 - 12:00">10:00 - 12:00 WIB</option>
                                <option value="13:00 - 15:00">13:00 - 15:00 WIB</option>
                                <option value="15:00 - 17:00">15:00 - 17:00 WIB</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold mb-2 text-gray-700">No. WhatsApp</label>
                            <input type="text" name="no_telp" placeholder="0812..." class="w-full p-4 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition outline-none" required>
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold mb-2 text-gray-700">Alamat Rumah Lengkap</label>
                        <textarea name="alamat" rows="3" placeholder="Sertakan patokan rumah biar groomer gak nyasar..." class="w-full p-4 border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition outline-none" required></textarea>
                    </div>
                    <button type="submit" name="booking" class="w-full bg-orange-600 text-white font-extrabold text-xl py-4 rounded-xl hover:bg-orange-700 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">Kirim Form Booking</button>
                </form>
            </div>
        </div>
    </section>

</div>

<div id="catModal" class="fixed inset-0 z-[100] hidden bg-black/80 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-3xl overflow-hidden max-w-5xl w-full flex flex-col md:flex-row relative shadow-2xl scale-95 transform transition-all" id="modalContent">
        
        <button onclick="closeModal()" class="absolute top-4 right-4 bg-white/80 hover:bg-red-500 hover:text-white backdrop-blur-sm shadow-md rounded-full w-12 h-12 flex items-center justify-center text-xl font-bold z-20 transition-colors">
            <i class="fa-solid fa-xmark"></i>
        </button>
        
        <div class="md:w-1/2 bg-gray-100 p-6 flex flex-col items-center justify-center relative">
            <img id="modalMainImg" src="" class="w-full h-[400px] object-cover rounded-2xl shadow-md mb-4 border border-gray-200">
            
            <div class="flex space-x-3 overflow-x-auto w-full justify-center pb-2">
                <img onclick="changePreview(this.src)" id="modalThumb1" src="" class="hidden w-20 h-20 object-cover rounded-xl cursor-pointer border-4 border-orange-500 opacity-100 transition hover:opacity-80 shadow-sm thumb-img">
                <img onclick="changePreview(this.src)" id="modalThumb2" src="" class="hidden w-20 h-20 object-cover rounded-xl cursor-pointer border-4 border-transparent hover:border-orange-300 opacity-70 hover:opacity-100 transition shadow-sm thumb-img">
                <img onclick="changePreview(this.src)" id="modalThumb3" src="" class="hidden w-20 h-20 object-cover rounded-xl cursor-pointer border-4 border-transparent hover:border-orange-300 opacity-70 hover:opacity-100 transition shadow-sm thumb-img">
            </div>
            <p class="text-xs text-gray-400 mt-2 italic">*Klik thumbnail untuk melihat dari angle lain</p>
        </div>

        <div class="md:w-1/2 p-8 md:p-10 flex flex-col bg-white">
            <div class="mb-auto">
                <div class="flex justify-between items-end mb-2">
                    <h3 id="modalName" class="text-4xl md:text-5xl font-extrabold text-gray-800 tracking-tight"></h3>
                </div>
                <p id="modalPrice" class="text-3xl font-bold text-orange-500 mb-8"></p>
                
                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div class="bg-blue-50 p-3 rounded-2xl text-center border border-blue-100">
                        <i class="fa-solid fa-paw text-blue-400 text-2xl mb-2"></i>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Ras</p>
                        <p id="modalBreed" class="font-bold text-gray-800 text-sm"></p>
                    </div>
                    <div class="bg-green-50 p-3 rounded-2xl text-center border border-green-100">
                        <i class="fa-solid fa-hourglass-half text-green-400 text-2xl mb-2"></i>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Umur</p>
                        <p id="modalAge" class="font-bold text-gray-800 text-sm"></p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-2xl text-center border border-purple-100">
                        <i class="fa-solid fa-venus-mars text-purple-400 text-2xl mb-2"></i>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Gender</p>
                        <p id="modalGender" class="font-bold text-gray-800 text-sm"></p>
                    </div>
                </div>
                
                <h4 class="font-bold text-gray-800 mb-2">Tentang Anabul:</h4>
                <p id="modalDesc" class="text-gray-600 leading-relaxed mb-8 bg-gray-50 p-4 rounded-xl border-l-4 border-orange-400"></p>
            </div>
            
            <a id="modalAdoptionLink" href="#" class="mt-4 w-full text-center bg-gray-900 text-white py-4 rounded-2xl font-bold text-lg hover:bg-orange-600 shadow-xl hover:shadow-2xl transition-all duration-300 flex items-center justify-center group">
                Ajukan Adopsi Sekarang <i class="fa-solid fa-arrow-right ml-2 transform group-hover:translate-x-2 transition-transform"></i>
            </a>
        </div>
    </div>
</div>

<script>
    function openModal(name, img1, img2, img3, breed, age, gender, price, desc, id) {
        document.getElementById('modalName').innerText = name;
        
        let pathImg1 = 'uploads/' + img1;
        document.getElementById('modalMainImg').src = pathImg1;
        
        let thumb1 = document.getElementById('modalThumb1');
        thumb1.src = pathImg1;
        thumb1.classList.remove('hidden');

        let thumb2 = document.getElementById('modalThumb2');
        if (img2 && img2.trim() !== "") {
            thumb2.src = 'uploads/' + img2;
            thumb2.classList.remove('hidden');
        } else {
            thumb2.classList.add('hidden');
        }

        let thumb3 = document.getElementById('modalThumb3');
        if (img3 && img3.trim() !== "") {
            thumb3.src = 'uploads/' + img3;
            thumb3.classList.remove('hidden');
        } else {
            thumb3.classList.add('hidden');
        }

        document.getElementById('modalBreed').innerText = breed;
        document.getElementById('modalAge').innerText = age;
        document.getElementById('modalGender').innerText = gender;
        document.getElementById('modalPrice').innerHTML = '<span class="text-green-500"><i class="fa-solid fa-hand-holding-heart"></i> Gratis Diadopsi</span>';
        document.getElementById('modalDesc').innerText = desc;
        document.getElementById('modalAdoptionLink').href = 'form_kucing.php?id=' + id;
        
        let thumbs = document.querySelectorAll('.thumb-img');
        thumbs.forEach(t => {
            t.classList.remove('border-orange-500', 'opacity-100');
            t.classList.add('border-transparent', 'opacity-70');
        });
        document.getElementById('modalThumb1').classList.add('border-orange-500', 'opacity-100');
        document.getElementById('modalThumb1').classList.remove('border-transparent', 'opacity-70');

        const modal = document.getElementById('catModal');
        const modalContent = document.getElementById('modalContent');
        modal.classList.remove('hidden');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('catModal');
        const modalContent = document.getElementById('modalContent');
        
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);

        document.body.style.overflow = 'auto';
    }

    function changePreview(src) {
        document.getElementById('modalMainImg').src = src;
        
        let thumbs = document.querySelectorAll('.thumb-img');
        thumbs.forEach(t => {
            if(t.src === src) {
                t.classList.add('border-orange-500', 'opacity-100');
                t.classList.remove('border-transparent', 'opacity-70');
            } else {
                t.classList.remove('border-orange-500', 'opacity-100');
                t.classList.add('border-transparent', 'opacity-70');
            }
        });
    }

    document.getElementById('catModal').addEventListener('click', function(e) {
        if(e.target === this) {
            closeModal();
        }
    });
</script>

</body>
</html>