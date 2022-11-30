<?php
require_once 'utils/functions.php';
require_once 'utils/logged.php';

$nota = query("SELECT * FROM JUAL WHERE CUSTOMER_ID = '$id' ORDER BY RAND() LIMIT 0, 20");

$title = "Riwayat Pemesanan";
include('shared/nav.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">

    <h1 class="text-2xl mb-8 font-semibold">Riwayat Order Kamu.</h1>
    <h2 class="text-xl mb-4">Kamu bisa cek riwayat pesanan-pesanan kamu disini ya!</h2>

    <a class="btn btn-warning mb-8" href="pesan.php">Kembali</a>


    <?php if (!empty($nota)) { ?>
        <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-16 mt-8">
            <?php foreach ($nota as $n) : ?>
                <div class="card w-96 bg-base-100 shadow-xl">
                    <a href=" detailNota.php?nota=<?= $n['NOTA']; ?>" class="card-body">
                        <h2 class="card-title">
                            <?= $n['NOTA']; ?>
                        </h2>
                        <div class="badge badge-secondary"><?= $n['TANGGAL']; ?></div>
                        <p>Salesman ID: <?= $n['SALESMAN_ID']; ?></p>
                        <p>Total: <?= rupiah($n['TOTAL_NOTA']); ?></p>
                        <div class="card-actions justify-end">
                            <div class="badge badge-outline"><?= $n['STATUS_BAYAR']; ?></div>
                            <div class="badge badge-outline"><?= $n['STATUS_NOTA']; ?></div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php } else { ?>
        <p class="text-lg">Kamu belum pesan apa-apa lho! Yuk <a href="pesan.php" class="text-sky-600">Coba pesan</a>.</p>
    <?php } ?>
</main>

<?php
include('shared/footer.php')
?>