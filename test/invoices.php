<?php
require_once 'utils/functions.php';
require_once 'utils/loggedAdmin.php';

$nota = query("select a.TANGGAL, a.TEMPO, a.SALESMAN_ID, a.CUSTOMER_ID, a.OPERATOR, a.NOTA, a.KETERANGAN, a.STATUS_NOTA, a.STATUS_BAYAR, (select SUM(jumlah*harga_jual) from item_jual where nota = a.nota) AS PIUTANG, (select sum(nominal-diskon-retur-diskon_rp) from item_pelunasan_piutang where nota_jual = a.nota) as SISA_PIUTANG from jual a ORDER BY TANGGAL DESC LIMIT 0, 20;");
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

    <a class="btn btn-info text-sm mb-8" href="jual.php">Lihat Records Nota</a>

    <div class="">
        <input type="text" name="keyword" size="40" class="input input-bordered max-w-xs mr-2" autofocus placeholder="Masukkan Keyword Harga, Salesman, Harga" autocomplete="off" id="keyword">
        <button type="submit" name="cari" class="opacity-50" id="tombol-cari">Cari</button>
    </div>

    <?php if (!empty($nota)) { ?>
        <div id="container" class="grid lg:grid-cols-3 md:grid-cols-2 gap-16 mt-8">
            <?php foreach ($nota as $n) : ?>
                <div class="card w-96 <?php if (rupiah($n['PIUTANG']) === rupiah($n['SISA_PIUTANG'])) {
                                            echo 'bg-emerald-50';
                                        } else {
                                            echo 'bg-base-100';
                                        } ?> bg-base-100 shadow-xl">
                    <a href=" detailInvoice.php?nota=<?= $n['NOTA']; ?>" class="card-body">
                        <h2 class="card-title">
                            <?= $n['NOTA']; ?>
                        </h2>
                        <div class="badge badge-lg badge-secondary"><?php if (isset(query("SELECT NAMA FROM customer WHERE KODE = '" . $n['CUSTOMER_ID'] . "'")[0]['NAMA'])) {
                                                                        echo query("SELECT NAMA FROM customer WHERE KODE = '" . $n['CUSTOMER_ID'] . "'")[0]['NAMA'];
                                                                    } else {
                                                                        echo $n['CUSTOMER_ID'];
                                                                    } ?></div>
                        <div class="flex gap-2 mb-2">
                            <div class="badge badge-secondary"><?= $n['TANGGAL']; ?></div>=>
                            <div class="badge badge-primary"><?= $n['TEMPO']; ?></div>
                        </div>
                        <p>Salesman ID: <span class="badge badge-primary"><?php foreach ($salesman as $s) {
                                                                                if ($s['KODE'] == $n['SALESMAN_ID']) {
                                                                                    echo $s['NAMA'];
                                                                                }
                                                                            } ?></span></p>
                        <p>Operator: <span class="badge"><?= query("SELECT NAMA FROM user_admin WHERE ID = " . $n['OPERATOR'])[0]['NAMA']; ?></span></p>
                        <p>Piutang: <?= rupiah($n['PIUTANG']); ?></p>
                        <p>Sisa Piutang: <?= rupiah($n['SISA_PIUTANG']); ?></p>
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

    <a class="btn btn-primary mt-8" href="pilihBarang.php">Tambah Nota</a>
    <a class="btn btn-warning mt-8" href="admin.php">Kembali</a>
</main>

<script src="script/cariNota.js"></script>

<?php
include('shared/footer.php')
?>