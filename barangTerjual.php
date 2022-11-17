<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$item = query("SELECT * FROM item_jual ORDER BY ID DESC LIMIT 0, 20");

$title = "Records Barang Terjual - $username";
include('shared/navadmin.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Halaman Track Records Barang Terjual</h1>
    <a class="btn btn-primary mb-8" href="pilihBarang.php">Tambah Nota</a>
    <a class="btn btn-warning mb-8" href="admin.php">Kembali</a>

    <div class="overflow-x-auto">
        <table class="table table-compact w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Nota</th>
                    <th>Barang ID</th>
                    <th>Jumlah</th>
                    <th>Harga Beli</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($item as $i) : ?>
                    <tr>
                        <th><?= $i['ID']; ?></th>
                        <td><?= $i['NOTA']; ?></td>
                        <td><?= $i['BARANG_ID']; ?></td>
                        <td><?= $i['JUMLAH']; ?></td>
                        <td><?= $i['HARGA_BELI']; ?></td>
                    </tr>
                <?php endforeach; ?>
        </table>
    </div>
</main>

<?php
include('shared/footer.php');
?>