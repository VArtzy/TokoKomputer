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

    <?php if (!empty($nota)) { ?>
        <div class="grid grid-cols-4>
        <?php foreach ($nota as $n) : ?>
            <a href=" detailNota.php?nota=<?= $n['NOTA']; ?>"><?= $n['NOTA']; ?></a>
            <p><?= $n['SALESMAN_ID']; ?></p>
            <p><?= $n['STATUS_NOTA']; ?></p>
            <p><?= $n['STATUS_BAYAR']; ?></p>
            <p><?= $n['TANGGAL']; ?></p>
            <p><?= $n['TOTAL_NOTA']; ?></p>
        <?php endforeach; ?>
        </div>
    <?php } else { ?>
        <p class="text-lg">Kamu belum pesan apa-apa lho! Yuk <a href="pesan.php" class="text-sky-600">Coba pesan</a>.</p>
    <?php } ?>
</main>

<?php
include('shared/footer.php')
?>