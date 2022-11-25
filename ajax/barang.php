<?php
require_once('../utils/functions.php');

$keyword = $_GET["keyword"];

$query = "SELECT * FROM `barang`
WHERE
NAMA LIKE '%$keyword%' OR
KODE LIKE '%$keyword%' OR
HARGA_BELI LIKE '%$keyword%' ORDER BY KODE DESC LIMIT 0, 10
";
$brg = query($query);
?>
<script>
    $(document).ready(function() {
        var table = $('#table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ]
        });

        $(document).on("keydown", function(e) {
            console.log(e.which);
            if (e.which === 65 && (e.ctrlKey || e.metaKey)) {
                $("#tambah")[0].click();
            }
            if (e.which === 69 && (e.ctrlKey || e.metaKey)) {
                $(".buttons-excel")[0].click();
            }
        });
    })
</script>

<?php if (!empty($brg)) : ?>
    <table class="table w-full">
        <!-- head -->
        <thead>
            <tr>
                <th>Nama</th>
                <th>Satuan/Stok</th>
                <th>Diskon</th>
                <th>Harga/Margin</th>
                <th>Garansi/Poin</th>
                <th>Golongan/Subgolongan</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($brg as $b) : ?>
                <tr>
                    <td>
                        <div class="flex items-center space-x-3">
                            <div class="avatar">
                                <div class="mask mask-squircle w-12 h-12">
                                    <img width="50px" height="50px" src="<?= $b["FOTO"]; ?>" alt="Gambar <?= $b["FOTO"]; ?>" />
                                </div>
                            </div>
                            <div>
                                <div class="font-bold"><?= $b["NAMA"]; ?></div>
                                <div class="text-sm opacity-50"><?= $b["KODE"]; ?></div>
                                <div class="text-sm opacity-50"><?= $b["TGL_TRANSAKSI"]; ?></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        Satuan: <?= $b["SATUAN_ID"]; ?>
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
                        <a href="editBarang.php?id=<?= $b["KODE"]; ?>"><i class="fa-solid fa-pen-to-square text-sky-500 scale-150"></i></a>
                        <a href="deleteBarang.php?id=<?= $b["KODE"]; ?>" onclick="return confirm('Apakah anda benar benar ingin menghapus barang ini?')"><i class="fa-solid fa-trash text-rose-500 scale-150"></i></a>
                        <a href="detailBarang.php?id=<?= $b["KODE"]; ?>"><i class="fa-solid fa-file-lines text-amber-500 scale-150"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif ?>
<?php if (empty($brg)) : ?>
    <h2 class="text-2xl text-rose-600 font-bold text-center">Sayangnya, Barang Tidak Ditemukan 😥</h2>
<?php endif; ?>