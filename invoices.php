<?php
require_once 'utils/functions.php';
require_once 'utils/loggedAdmin.php';

$nota = query("SELECT * FROM JUAL ORDER BY TANGGAL DESC LIMIT 0, 20");
$salesman = query("SELECT KODE, NAMA FROM salesman");

if (isset($_POST["cari"])) {
    $mahasiswa = cariNota($_POST["keyword"]);
}

$title = "Invoices - $username";
include('shared/navadmin.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">

    <h1 class="text-2xl font-semibold">Order & Invoices.</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>

    <a class="btn btn-primary mb-8" href="pilihBarang.php">Tambah Nota</a>
    <a class="btn btn-warning mb-8" href="admin.php">Kembali</a>
    <a class="btn btn-info text-sm mb-8" href="barangTerjual.php">Lihat Records Barang Terjual</a>
    <a class="btn btn-info text-sm mb-8" href="penjualanNota.php">Lihat Records Penjualan Nota</a>

    <div class="">
        <input type="text" name="keyword" size="40" class="input input-bordered max-w-xs mr-2" autofocus placeholder="Masukkan Keyword Harga, Salesman, Harga" autocomplete="off" id="keyword">
        <button type="submit" name="cari" class="opacity-50" id="tombol-cari">Cari</button>
    </div>

    <?php if (!empty($nota)) { ?>
        <div id="container" class="grid lg:grid-cols-3 md:grid-cols-2 gap-16 mt-8">
            <?php foreach ($nota as $n) : ?>
                <?php $namaPelanggan = query("SELECT NAMA FROM CUSTOMER WHERE KODE = '" . $n['CUSTOMER_ID'] . "'"); ?>
                <div class="card w-96 <?php if ($n['TOTAL_PELUNASAN_NOTA'] >= $n['TOTAL_NOTA']) {
                                            echo 'bg-emerald-50';
                                        } else {
                                            echo 'bg-base-100';
                                        } ?> bg-base-100 shadow-xl">
                    <a href=" detailInvoice.php?nota=<?= $n['NOTA']; ?>" class="card-body">
                        <h2 class="card-title">
                            <?= $n['NOTA']; ?>
                        </h2>
                        <div class="badge badge-secondary"><?php if (!empty($namaPelanggan)) {
                                                                echo $namaPelanggan[0]["NAMA"];
                                                            } else {
                                                                echo $n['CUSTOMER_ID'];
                                                            }; ?></div>
                        <div class="badge badge-secondary"><?= $n['TANGGAL']; ?></div>
                        <p>Salesman ID: <span class="badge badge-primary"><?php foreach ($salesman as $s) {
                                                                                if ($s['KODE'] == $n['SALESMAN_ID']) {
                                                                                    echo $s['NAMA'];
                                                                                }
                                                                            } ?></span></p>
                        <p>Operator: <span class="badge"><?= query("SELECT NAMA FROM user_admin WHERE ID = " . $n['OPERATOR'])[0]['NAMA']; ?></span></p>
                        <p>Total: <?= $n['TOTAL_NOTA']; ?></p>
                        <div class="card-actions justify-end">
                            <div class="badge badge-outline"><?= $n['STATUS_BAYAR']; ?></div>
                            <div class="badge badge-outline"><?= $n['STATUS_NOTA']; ?></div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php } else { ?>
        <p class="text-lg">Belum ada yang pesan... 😩</a>.</p>
    <?php } ?>
</main>

<script src="script/cariNota.js"></script>

<?php
include('shared/footer.php')
?>