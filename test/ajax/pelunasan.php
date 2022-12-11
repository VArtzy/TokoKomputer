<?php
require_once('../utils/functions.php');

$keyword = $_GET["keyword"];

$query = "SELECT * FROM `pelunasan_piutang`
WHERE
NO_PELUNASAN LIKE '%$keyword%' OR
CUSTOMER_ID LIKE '%$keyword%' OR
TANGGAL LIKE '%$keyword%' OR
KETERANGAN LIKE '%$keyword%' OR
OPERATOR LIKE '%$keyword%' LIMIT 0, 20
";
$item = query($query);
?>

<?php if (!empty($item)) : ?>
    <?php foreach ($item as $i) {
        $p = query("SELECT * FROM item_pelunasan_piutang WHERE NO_PELUNASAN = '" . $i['NO_PELUNASAN'] . "'")[0];
    ?>
        <tr>
            <th><?= $i['NO_PELUNASAN']; ?></th>
            <td><?= $p['NOTA_JUAL']; ?></td>
            <td><?= $i['CUSTOMER_ID']; ?></td>
            <td><?= $i['TANGGAL']; ?></td>
            <td><?= $p['NOMINAL']; ?></td>
            <td><?= $p['KETERANGAN']; ?></td>
            <td><?= $i['OPERATOR']; ?></td>
        </tr>
    <?php } ?>
<?php endif ?>
<?php if (empty($item)) : ?>
    <h2 class="text-2xl text-rose-600 font-bold text-center">Sayangnya, Pelunasan Tidak Ditemukan 😥</h2>
<?php endif; ?>