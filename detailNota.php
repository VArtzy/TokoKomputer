<?php
require_once 'utils/functions.php';
require_once 'utils/logged.php';

$nota = $_GET['nota'];

$customerID = query("SELECT CUSTOMER_ID FROM JUAL WHERE NOTA = '$nota'")[0]["CUSTOMER_ID"];

if ($id == $customerID) {
    $item = query("SELECT * FROM ITEM_JUAL WHERE nota = '$nota'");
} else {
    header('location: riwayat.php');
}

$title = "Nota " . $nota;
include('shared/nav.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">

    <h1 class="text-2xl mb-8 font-semibold">Details Nota <?= $nota; ?></h1>

    <?php
    foreach ($item as $i) {
        $brg = query("SELECT `KODE`, `NAMA`, `SATUAN_ID`, `STOK`, `MIN_STOK`, `MAX_STOK`, `HARGA_BELI`,`STOK_AWAL`, `DISKON_RP`, `GARANSI`, `DISKON_GENERAL`, `DISKON_SILVER`, `DISKON_GOLD`, `POIN`, `FOTO` FROM BARANG where id = " . $i['BARANG_ID']);
        foreach ($brg as $b) : ?>
            <tr>
                <td>
                    <div class="flex items-center space-x-3">
                        <div class="avatar">
                            <div class="mask mask-squircle w-12 h-12">
                                <img width="50px" height="50px" src="<?= $b["FOTO"]; ?>" alt="<?= $b["FOTO"]; ?>" />
                            </div>
                        </div>
                        <div>
                            <div class="font-bold"><?= $b["NAMA"]; ?></div>
                            <div class="text-sm opacity-50"><?= $b["KODE"]; ?></div>
                        </div>
                    </div>
                </td>
                <td>
                    Jumlah: <?= round($i['JUMLAH']); ?>
                    <br />
                    Stok: <?= round($b["STOK"]); ?>
                    <br />
                    Satuan: <?= $b["SATUAN_ID"]; ?>
                    <br />
                </td>
                <td>
                    Diskon: <?= $b["DISKON_RP"]; ?>
                    <br />
                    <span class="badge badge-ghost badge-sm">Diskon General: <?= $b["DISKON_GENERAL"]; ?></span>
                    <br />
                    <span class="badge badge-sm">Diskon Silver: <?= $b["DISKON_SILVER"]; ?></span>
                    <br />
                    <span class="badge badge-warning badge-sm">Diskon Gold: <?= $b["DISKON_GOLD"]; ?></span>
                </td>
                <th>
                    <span class="text-sm font-semibold opacity-70"><?= rupiah($b["HARGA_BELI"]); ?></span>
                    <br>
                    <span class="text-sm font-semibold opacity-70"><?= rupiah($b["HARGA_BELI"] * $i["HARGA_BELI"]); ?></span>
                    <br>
                </th>
                <th>
                    <span class="badge mb-2"><?= $b["GARANSI"]; ?></span>
                    <br>
                    <span class="badge badge-warning"><?= $b["POIN"]; ?></span>
                </th>
            </tr>
        <?php endforeach; ?>
    <?php } ?>

</main>

<?php
include('shared/footer.php')
?>