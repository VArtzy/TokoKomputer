<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$id = $_GET["id"];

$brg = query("SELECT * FROM BARANG WHERE KODE = '$id'")[0];

$title = $brg["NAMA"];
include('shared/navadmin.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <img class="max-w-xl rounded-lg aspect-video object-cover" src="<?= $brg["FOTO"]; ?>" alt="<?= $brg["NAMA"]; ?>">
    <h1 class="text-2xl"><?= $brg["NAMA"]; ?></h1>
    <div class="grid grid-cols-5">
        <p>Satuan: <?= $brg["SATUAN_ID"]; ?></p>
        <p>Stok: <?= round($brg["STOK"]); ?></p>
        <p>Min Stok: <?= $brg["MIN_STOK"]; ?></p>
        <p>Max Stok: <?= $brg["MAX_STOK"]; ?></p>
        <p>Harga Beli: <?= rupiah($brg["HARGA_BELI"]); ?></p>
        <p>Margin: <?= $brg["MARGIN"]; ?></p>
        <p>Update Harga Jual: <?= $brg["IS_UPDATE_HARGA_JUAL"]; ?></p>
        <p>Golongan: <?= $brg["GOLONGAN_ID"]; ?></p>
        <p>Lokasi: <?= $brg["LOKASI_ID"]; ?></p>
        <p>Supplier: <?= $brg["SUPPLIER_ID"]; ?></p>
        <p>Kode Barcode: <?= $brg["KODE_BARCODE"]; ?></p>
        <p>Kode: <?= $brg["KODE"]; ?></p>
        <p>Urut: <?= $brg["URUT"]; ?></p>
        <p>Stok AWAL: <?= $brg["STOK_AWAL"]; ?></p>
        <p>Diskon (Rp.): <?= rupiah($brg["DISKON_RP"]); ?></p>
        <p>Garansi (Thn.): <?= $brg["GARANSI"]; ?> Tahun</p>
        <p>Sub Golongan: <?= $brg["SUB_GOLONGAN_ID"]; ?></p>
        <p>Tanggal Transaksi: <?= $brg["TGL_TRANSAKSI"]; ?></p>
        <p>Diskon General: <?= $brg["DISKON_GENERAL"]; ?></p>
        <p>Diskon SILVER: <?= $brg["DISKON_SILVER"]; ?></p>
        <p>Diskon GOLD: <?= $brg["DISKON_GOLD"]; ?></p>
        <p>POIN: <?= $brg["POIN"]; ?></p>
        <p>Wajib isi IMEI: <?= $brg["IS_WAJIB_ISI_IMEI"]; ?></p>
        <p>Guna: <?= $brg["GUNA"]; ?></p>
        <p>Temp Harga Beli: <?= $brg["temp_harga_beli"]; ?></p>
    </div>
    <a href="barang.php" class="btn btn-primary">Kembali</a>
</main>

<?php include('shared/footer.php') ?>