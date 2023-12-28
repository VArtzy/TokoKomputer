<?php
require '../utils/functions.php';
$no_nota = $_GET['no_nota'];
$pin = $_GET['pin'];
$nota = query("SELECT * FROM tanda_terima_barang WHERE NOTA = '$no_nota'")[0];
?>

<?php if ($nota && $pin && $nota["PIN"] == $pin) : ?>
    <div class="card bg-base-100 shadow-lg">
        <div class="card-body">
            <h2 class="card-title">
                <?= $nota['NOTA']; ?>
            </h2>
            <div class="badge badge-secondary"><?= $nota['TANGGAL']; ?></div>
            <p>Nama: <span class="badge"><?= $nota['CUSTOMER']; ?></span></p>
            <p>Telepon: <span class="badge"><?= $nota['TELEPON']; ?></span></p>
            <p class="flex justify-around">Keluhan: <textarea class="textarea textarea-bordered" readonly cols="30" rows="3"><?= $nota['KELUHAN']; ?></textarea></p>
            <p class="flex justify-around mb-2">Kelengkapan: <textarea class="textarea textarea-bordered" readonly cols="30" rows="3"><?= $nota['KELENGKAPAN']; ?></textarea></p>
            <div class="card-actions justify-end">
                <div class="badge badge-outline"><?= $nota['ADDED_BY']; ?></div>
            </div>
        </div>
    </div>
<?php elseif (!$pin && !$no_nota) : ?>
    <h2 class="text-2xl text-rose-600 font-bold text-center">Masukkan PIN dan Nomor Nota 😥</h2>
<?php elseif ($nota["NOTA"] != $no_nota) : ?>
    <h2 class="text-2xl text-rose-600 font-bold text-center">Nota Tidak Ditemukan 😥</h2>
<?php elseif ($nota["PIN"] != $pin || !$pin) : ?>
    <h2 class="text-2xl text-rose-600 font-bold text-center">PIN Salah Atau Kosong 😥</h2>
<?php else : ?>
    <h2 class="text-2xl text-rose-600 font-bold text-center">Sayangnya, Nota Servis Tidak Ditemukan 😥</h2>
<?php endif; ?>