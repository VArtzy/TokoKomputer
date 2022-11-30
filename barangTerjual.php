<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$item = query("SELECT * FROM item_jual ORDER BY NOTA DESC LIMIT 0, 20");

if (isset($_POST["cari"])) {
    $mahasiswa = cariItem($_POST["keyword"]);
}

$title = "Records Barang Terjual - $username";
include('shared/navadmin.php');
?>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#table').DataTable({
            dom: 'Blfrtip',
            buttons: [
                'excel'
            ]
        });

        $(document).on("keydown", function(e) {
            if (e.which === 69 && (e.ctrlKey || e.metaKey)) {
                $(".buttons-excel")[0].click();
            }
        });
    })
</script>


<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Halaman Track Records Barang Terjual</h1>
    <a class="btn btn-primary mb-8" href="pilihBarang.php">Tambah Nota</a>
    <a class="btn btn-warning mb-8" href="invoices.php">Kembali</a>

    <div class="">
        <input type="text" name="keyword" size="40" class="input input-bordered max-w-xs mr-2 mb-4" autofocus placeholder="Masukkan Keyword Kode Barang, Nota atau Jumlah/Harga Beli" autocomplete="off" id="keyword">
        <button type="submit" name="cari" class="opacity-50" id="tombol-cari">Cari</button>
    </div>

    <div class="overflow-x-auto">
        <table id="table" class="table table-compact w-full">
            <thead>
                <tr>
                    <th>Kode Nota</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="container">
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
            </tbody>
        </table>
    </div>
</main>

<script src="script/cariItem.js"></script>

<?php
include('shared/footer.php');
?>