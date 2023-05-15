<?php
require_once('../utils/functions.php');

$keyword = $_GET["keyword"];

$query = "SELECT * FROM `barang`
WHERE
NAMA LIKE '%$keyword%' OR
KODE LIKE '%$keyword%' OR
KODE_BARCODE LIKE '%$keyword%' OR
HARGA_BELI LIKE '%$keyword%' ORDER BY KODE DESC LIMIT 0, 10
";
$brg = query($query);
?>

<?php if (!empty($brg)) : ?>
    <?php foreach ($brg as $b) : ?>
        <a class="border-slate-600 border rounded-md px-8 py-6" href="kartuBarang.php?id=<?= $b["KODE"]; ?>">
            <div class="flex items-center space-x-3">
                <div class="avatar">
                    <div class="mask mask-squircle w-12 h-12">
                        <img width="50px" height="50px" src="<?= $b["FOTO"]; ?>" alt="<?= $b["FOTO"]; ?>" />
                    </div>
                </div>
                <div>
                    <div class="font-bold"><?= $b["NAMA"]; ?></div>
                    <div class="text-sm opacity-50"><?= $b["KODE"]; ?></div>
                    <div class="text-sm opacity-50"><?= $b["TGL_TRANSAKSI"]; ?></div>
                </div>
            </div>
            <span class="text-sm font-semibold opacity-70"><?= rupiah($b["HARGA_BELI"]); ?></span>
            <br>
            <span class="text-xl font-semibold opacity-70"><?= $b["MARGIN"]; ?></span>
        </a>
    <?php endforeach; ?>
<?php endif ?>
<?php if (empty($brg)) : ?>
    <h2 class="text-2xl text-rose-600 font-bold text-center">Sayangnya, Kartu Stok Barang Tidak Ditemukan 😥</h2>
<?php endif; ?>