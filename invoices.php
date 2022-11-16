<?php
require_once 'utils/functions.php';
require_once 'utils/loggedAdmin.php';

$nota = query("SELECT * FROM JUAL ORDER BY TANGGAL LIMIT 0, 20");

if (isset($_POST["cari"])) {
    $mahasiswa = cariNota($_POST["keyword"]);
}

$title = "Invoices - $username";
include('shared/navadmin.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">

    <h1 class="text-2xl font-semibold">Order & Invoices.</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>

    <a class="btn btn-warning mb-8" href="admin.php">Kembali</a>

    <div class="">
        <input type="text" name="keyword" size="40" class="input input-bordered max-w-xs mr-2" autofocus placeholder="Masukkan Keyword Harga, Salesman, Harga" autocomplete="off" id="keyword">
        <button type="submit" name="cari" class="opacity-50" id="tombol-cari">Cari</button>
    </div>

    <?php if (!empty($nota)) { ?>
        <div id="container" class="grid lg:grid-cols-3 md:grid-cols-2 gap-16 mt-8">
            <?php foreach ($nota as $n) : ?>
                <?php $namaPelanggan = query("SELECT NAMA FROM CUSTOMER WHERE KODE = '" . $n['CUSTOMER_ID'] . "'")[0]["NAMA"]; ?>
                <div class="card w-96 <?php if ($n['TOTAL_PELUNASAN_NOTA'] >= $n['TOTAL_NOTA']) {
                                            echo 'bg-emerald-50';
                                        } else {
                                            echo 'bg-base-100';
                                        } ?> bg-base-100 shadow-xl">
                    <a href=" detailInvoice.php?nota=<?= $n['NOTA']; ?>" class="card-body">
                        <h2 class="card-title">
                            <?= $n['NOTA']; ?>
                        </h2>
                        <div class="badge badge-secondary"><?= $namaPelanggan; ?></div>
                        <div class="badge badge-secondary"><?= $n['TANGGAL']; ?></div>
                        <p>Salesman ID: <span class="badge badge-primary"><?= $n['SALESMAN_ID']; ?></span></p>
                        <p>Operator: <span class="badge"><?= $n['OPERATOR']; ?></span></p>
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