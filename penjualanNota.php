<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$item = query("SELECT * FROM item_pelunasan_piutang LIMIT 20");

if (isset($_POST["cari"])) {
    $mahasiswa = cariPelunasan($_POST["keyword"]);
}

$title = "Records Nota Pelunasan - $username";
include('shared/navadmin.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Halaman Track Records Pelunasan Nota</h1>
    <a class="btn btn-primary mb-8" href="pilihBarang.php">Tambah Nota</a>
    <a class="btn btn-warning mb-8" href="invoices.php">Kembali</a>

    <div class="">
        <input type="text" name="keyword" size="40" class="input input-bordered max-w-xs mr-2 mb-4" autofocus placeholder="Masukkan Keyword Tanggal, Keterangan, Operator, No Pelunasan" autocomplete="off" id="keyword">
        <button type="submit" name="cari" class="opacity-50" id="tombol-cari">Cari</button>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-compact w-full">
            <thead>
                <tr>
                    <th>No Pelunasan</th>
                    <th>Kode Nota</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Operator</th>
                </tr>
            </thead>
            <tbody id="container">
                <?php foreach ($item as $i) {
                    $p = query("SELECT * FROM pelunasan_piutang WHERE NO_PELUNASAN = '" . $i['NO_PELUNASAN'] . "'")[0];
                ?>
                    <tr>
                        <th><?= $i['NO_PELUNASAN']; ?></th>
                        <td><?= $i['NOTA_JUAL']; ?></td>
                        <td><?= $p['CUSTOMER_ID']; ?></td>
                        <td><?= $p['TANGGAL']; ?></td>
                        <td><?= $i['NOMINAL']; ?></td>
                        <td><?= $i['KETERANGAN']; ?></td>
                        <td><?= $p['OPERATOR']; ?></td>
                    </tr>
                <?php } ?>
        </table>
    </div>
</main>

<script src="script/cariPelunasan.js"></script>

<?php
include('shared/footer.php');
?>