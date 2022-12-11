<?php
require_once('../utils/functions.php');

$keyword = $_GET["keyword"];

$query = "SELECT * FROM `item_jual`
WHERE
NOTA LIKE '%$keyword%' OR
BARANG_ID LIKE '%$keyword%' OR
JUMLAH LIKE '%$keyword%' OR
HARGA_BELI LIKE '%$keyword%' LIMIT 0, 20
";
$item = query($query);
?>

<?php if (!empty($item)) : ?>
    <?php foreach ($item as $i) : ?>
        <tr>
            <td><?= $i['NOTA']; ?></td>
            <td><?= query("SELECT NAMA FROM barang WHERE KODE =" . $i['BARANG_ID'])[0]["NAMA"]; ?></td>
            <td><?= $i['JUMLAH']; ?></td>
            <td><?= $i['HARGA_BELI']; ?></td>
            <td><?= $i['HARGA_JUAL']; ?></td>
            <td><?= $i['HARGA_JUAL'] * $i['JUMLAH']; ?></td>
        </tr>
    <?php endforeach; ?>
<?php endif ?>
<?php if (empty($item)) : ?>
    <h2 class="text-2xl text-rose-600 font-bold text-center">Sayangnya, Nota Item Tidak Ditemukan 😥</h2>
<?php endif; ?>