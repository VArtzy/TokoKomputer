<?php
require_once 'utils/functions.php';
require_once 'utils/logged.php';

$brg = query("SELECT * FROM BARANG a LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID ORDER BY RAND() LIMIT 0, 20");

if (isset($_POST["cari"])) {
  $mahasiswa = cari($_POST["keyword"]);
}

$title = "Belanja";
include('shared/nav.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">

  <h1 class="text-2xl mb-8 font-semibold">Belanja</h1>

  <h2 class="text-xl mb-4 loading-dom-content">Loading...</h2>

  <div class="">
    <input type="text" name="keyword" size="30" class="input input-bordered max-w-xs mr-2" autofocus placeholder="Masukkan Keyword Nama/Kode/Harga" autocomplete="off" id="keyword">
    <button type="submit" name="cari" class="opacity-50" id="tombol-cari">Cari</button>
  </div>


  <div id="container" class="grid lg:grid-cols-4 md:grid-cols-2 gap-16 mt-8">
    <?php foreach ($brg as $b) : ?>
      <div class="card max-w-lg bg-base-100 shadow-xl">
        <figure class="aspect-video object-cover"><img class="aspect-video object-cover" src="<?= $b["FOTO"]; ?>" alt="<?= $b["NAMA"]; ?>" /></figure>
        <div class="card-body">
          <h2 class="card-title text-sm"><?= $b["NAMA"]; ?></h2>
          <div class="flex gap-2">
            <span class="badge <?php if (round($b["STOK"]) > 0) {
                                  echo 'badge-accent';
                                } else {
                                  echo 'badge-error';
                                } ?> badge-sm text-white"><?= round($b["STOK"]); ?></span>
            <span class="badge badge-sm"><?= rupiah($b["HARGA_JUAL"]); ?></span>
          </div>
          <p class="text-xs"></p>
          <div class="card-actions justify-end">
            <button class="btn <?php if (round($b["STOK"]) > 0) {
                                  echo 'btn-success';
                                } else {
                                } ?> btn-sm text-white add-to-cart" <?php if (round($b["STOK"]) > 0) {
                                                                    } else {
                                                                      echo 'disabled';
                                                                    } ?> data-id="<?= $b["KODE"]; ?>" data-name="<?= $b["NAMA"]; ?>" data-price="<?= $b["HARGA_JUAL"]; ?>" data-stok="<?= $b["STOK"]; ?>">TAMBAH</button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="btn-group mt-4">
    <button class="btn">«</button>
    <button class="btn">Page 1</button>
    <button class="btn">»</button>
  </div>

</main>

<script src="script/cariBarang.js"></script>

<?php
include('shared/footer.php')
?>