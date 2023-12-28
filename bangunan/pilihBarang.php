<?php
require_once 'utils/functions.php';
require_once 'utils/loggedAdmin.php';

if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

$title = "Pilih Barang - $username";
include('shared/navadmin.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold mb-4">Pilih Barang</h1>
    <a class="btn btn-primary mb-8" href="tambahNota.php">Lanjut Checkout</a>
    <label for="my-modal-6" class="btn btn-success">Lihat Keranjang <div class="indicator">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="badge badge-sm indicator-item">...</span>
        </div></label>
    <button class="btn btn-error mb-8 btn-clear-cart">Reset Keranjang</button>
    <a class="btn btn-warning mb-8" href="jual.php">Kembali</a>

    <div class="">
        <input type="text" name="keyword" size="40" class="input input-bordered max-w-xs mr-2" autofocus placeholder="Masukkan Keyword Nama/Kode/Harga" autocomplete="off" id="keyword">
        <button type="submit" name="cari" class="opacity-50" id="tombol-cari">Cari</button>
    </div>

    <div id="container" class="grid lg:grid-cols-4 md:grid-cols-2 gap-16 mt-8">
    </div>
</main>

<input type="checkbox" id="my-modal-6" class="modal-toggle" />
<div class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Keranjang Kamu.</h3>
        <p class="py-4">Sebelum checkout pastikan barang kamu sudah sesuai, ya 😎.</p>
        <div class="isi-modal"></div>
        <p class="text-info-cart font-semibold mt-4">Total Harga:</p>
        <div class="modal-action">
            <a href="tambahNota.php" class="btn btn-success">Checkout</a>
            <label for="my-modal-6" class="btn">Kembali</label>
        </div>
    </div>
</div>

<script src="script/cariBarang.js"></script>
<script src="script/cart.js"></script>
<?php
include('shared/footer.php')
?>