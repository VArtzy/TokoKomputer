<?php
require_once('../utils/functions.php');
require_once('../utils/loggedAdmin.php');

$nom = '11';
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';

$offset = $_GET['offset'];

$brg = query("SELECT * FROM BARANG ORDER BY NAMA ASC LIMIT " . $offset . ", 10");
?>

<?php foreach ($brg as $b) : ?>
    <tr id="card">
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
                    <div class="text-sm opacity-50"><?= $b["KODE_BARCODE"]; ?></div>
                    <div class="text-sm opacity-50"><?= $b["TGL_TRANSAKSI"]; ?></div>
                </div>
            </div>
        </td>
        <td>
            Satuan: <?= query("SELECT NAMA FROM satuan WHERE KODE = '" . $b['SATUAN_ID'] . "'")[0]['NAMA']; ?> - <?= query("SELECT KONVERSI FROM satuan WHERE KODE = '" . $b['SATUAN_ID'] . "'")[0]['KONVERSI']; ?>
            <br />
            Stok: <?= round($b["STOK"]); ?>
            <br />
            <span class="badge badge-ghost badge-sm">Min: <?= $b["MIN_STOK"]; ?></span>
            <span class="badge badge-ghost badge-sm">Max: <?= $b["MAX_STOK"]; ?></span>
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
            <span class="text-xl font-semibold opacity-70"><?= $b["MARGIN"]; ?></span>
        </th>
        <th>
            <span class="badge mb-2"><?= $b["GARANSI"]; ?></span>
            <br>
            <span class="badge badge-warning"><?= $b["POIN"]; ?></span>
        </th>
        <th>
            <span class="badge badge-sm mb-2"><?= query("SELECT KETERANGAN FROM golongan WHERE KODE = '" . $b['GOLONGAN_ID'] . "'")[0]['KETERANGAN']; ?></span>
            <br>
            <span class="badge badge-sm badge-warning"><?= query("SELECT KETERANGAN FROM sub_golongan WHERE KODE = '" . $b['SUB_GOLONGAN_ID'] . "'")[0]['KETERANGAN']; ?></span>
        </th>
        <td class="grid items-center gap-2">
            <?php if (isset($aksi[1]) && $aksi[1] === '1') : ?>
                <a href="editBarang.php?id=<?= $b["KODE"]; ?>"><i class="fa-solid fa-pen-to-square text-sky-500 scale-150"></i></a>
            <?php endif; ?>
            <?php if (isset($aksi[2]) && $aksi[2] === '1') : ?>
                <a href="deleteBarang.php?id=<?= $b["KODE"]; ?>" onclick="return confirm('Apakah anda benar benar ingin menghapus barang ini?')"><i class="fa-solid fa-trash text-rose-500 scale-150"></i></a>
            <?php endif; ?>
            <a href="kartuBarang.php?id=<?= $b["KODE"]; ?>"><i class="fa-solid fa-file-lines text-amber-500 scale-150"></i></a>
        </td>
    </tr>
<?php endforeach; ?>