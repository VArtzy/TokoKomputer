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
    <a class="btn btn-primary mb-8" href="tambahNotaBeli.php">Lanjut Checkout</a>
    <button class="btn btn-error mb-8 btn-clear-cart">Reset Keranjang</button>
    <a class="btn btn-warning mb-8" href="invoices.php">Kembali</a>

    <div class="">
        <input type="text" name="keyword" size="40" class="input input-bordered max-w-xs mr-2" autofocus placeholder="Masukkan Keyword Nama/Kode/Harga" autocomplete="off" id="keyword">
        <button type="submit" name="cari" class="opacity-50" id="tombol-cari">Cari</button>
    </div>

    <div id="container" class="grid lg:grid-cols-4 md:grid-cols-2 gap-16 mt-8">
    </div>
</main>

<script src="script/cariBarang.js"></script>
<script src="script/cart.js"></script>
<?php
include('shared/footer.php')
?>