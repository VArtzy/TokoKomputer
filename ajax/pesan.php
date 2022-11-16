<?php
require_once('../utils/functions.php');

$keyword = $_GET["keyword"];

$query = "SELECT * FROM `jual`
WHERE
SALESMAN_ID LIKE '%$keyword%' OR
STATUS_NOTA LIKE '%$keyword%' OR
OPERATOR LIKE '%$keyword%' OR
TEMPO LIKE '%$keyword%' OR
TANGGAL LIKE '%$keyword%' OR
TOTAL_PELUNASAN_NOTA LIKE '%$keyword%' OR
STATUS_BAYAR LIKE '%$keyword%' LIMIT 0, 10
";
$nota = query($query);
?>

<?php if (!empty($nota)) : ?>
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
<?php endif ?>
<?php if (empty($brg)) : ?>
    <h2 class="text-2xl text-rose-600 font-bold text-center">Sayangnya, Nota Tidak Ditemukan 😥</h2>
<?php endif; ?>