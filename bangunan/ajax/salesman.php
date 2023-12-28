<?php
require_once('../utils/functions.php');

$keyword = $_GET["keyword"];

$query = "SELECT * FROM `salesman`
WHERE
NAMA LIKE '%$keyword%' OR
ALAMAT LIKE '%$keyword%' OR
TELEPON LIKE '%$keyword%' LIMIT 0, 10
";
$salesman = query($query);
?>

<?php if (!empty($salesman)) : ?>
    <?php foreach ($salesman as $s) : ?>
        <tr>
            <td>
                <div class="flex items-center space-x-3">
                    <div>
                        <div class="font-bold"><?= $s['NAMA']; ?></div>
                        <div class="text-sm opacity-50"><?= $s['ALAMAT']; ?></div>
                    </div>
                </div>
            </td>
            <td>
                <span class="badge badge-ghost badge-sm"><?= $s['TELEPON']; ?></span>
            </td>
            <td><?= $s['NO_REKENING']; ?></td>
            </td>
            <td>
                <span class="badge text-white badge-success badge-sm"><?= $s['TOTAL_NOTA_PENJUALAN']; ?> Nota</span>
                <br>
                <span class="badge badge-sm"><?= $s['TOTAL_ITEM_PENJUALAN']; ?> Item</span>
            </td>
            <td>
                <a href="editSales.php?kode=<?= $s["KODE"]; ?>" class="btn btn-info btn-xs">Edit Sales</a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif ?>
<?php if (empty($salesman)) : ?>
    <h2 class="text-2xl text-rose-600 font-bold text-center">Sayangnya, Salesman Tidak Ditemukan 😥</h2>
<?php endif; ?>