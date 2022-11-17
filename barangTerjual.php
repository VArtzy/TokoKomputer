<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$item = query("SELECT * FROM item_jual ORDER BY ID DESC LIMIT 0, 20");

if (isset($_POST["cari"])) {
    $mahasiswa = cariItem($_POST["keyword"]);
}

$title = "Records Barang Terjual - $username";
include('shared/navadmin.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Halaman Track Records Barang Terjual</h1>
    <a class="btn btn-primary mb-8" href="pilihBarang.php">Tambah Nota</a>
    <a class="btn btn-warning mb-8" href="invoices.php">Kembali</a>

    <div class="">
        <input type="text" name="keyword" size="40" class="input input-bordered max-w-xs mr-2 mb-4" autofocus placeholder="Masukkan Keyword Kode Barang, Nota atau Jumlah/Harga Beli" autocomplete="off" id="keyword">
        <button type="submit" name="cari" class="opacity-50" id="tombol-cari">Cari</button>
    </div>

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
            <tbody id="container">
                <?php foreach ($item as $i) : ?>
                    <tr>
                        <th><?= $i['ID']; ?></th>
                        <td><?= $i['NOTA']; ?></td>
                        <td><?= $i['BARANG_ID']; ?></td>
                        <td><?= $i['JUMLAH']; ?></td>
                        <td><?= $i['HARGA_BELI']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script src="script/cariItem.js"></script>

<?php
include('shared/footer.php');
?>