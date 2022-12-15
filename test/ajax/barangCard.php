<?php
require_once('../utils/functions.php');

$keyword = $_GET["keyword"];

$query = "SELECT *, a.KODE as BARANG_KODE FROM BARANG a LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID
WHERE
a.NAMA LIKE '%$keyword%' OR
a.KODE LIKE '%$keyword%' OR
a.KODE_BARCODE LIKE '%$keyword%' OR
b.HARGA_JUAL LIKE '%$keyword%' ORDER BY a.KODE DESC LIMIT 0, 10
";
$brg = query($query);
?>

<?php if (!empty($brg)) : ?>
  <?php foreach ($brg as $b) : ?> <div class="card max-w-lg bg-base-100 shadow-xl">
      <figure><img class="aspect-video object-cover" src="<?= $b["FOTO"]; ?>" alt="<?= $b["NAMA"]; ?>" /></figure>
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
        <div class="card-actions flex justify-end">
          <input id="input-angka" type="number" value="1">
          <button class="btn <?php if (round($b["STOK"]) > 0) {
                                echo 'btn-success';
                              } else {
                              } ?> btn-sm text-white add-to-cart" onclick="tambahBarang(event)" <?php if (round($b["STOK"]) > 0) {
                                                                                                } else {
                                                                                                  echo 'disabled';
                                                                                                } ?> data-id="<?= $b["BARANG_KODE"]; ?>" data-name="<?= $b["NAMA"]; ?>" data-price="<?= $b["HARGA_JUAL"]; ?>" data-stok="<?= $b["STOK"]; ?>">TAMBAH</button>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif ?>
<?php if (empty($brg)) : ?>
  <h2 class="text-2xl text-rose-600 font-bold text-center">Sayangnya, Barang Tidak Ditemukan 😥</h2>
<?php endif; ?>