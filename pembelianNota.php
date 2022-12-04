<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$item = query("SELECT * FROM item_pelunasan_hutang");

$title = "Records Nota Pelunasan - $username";
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
            "pageLength": 50,
            dom: 'Blfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });

        $(document).on("keydown", function(e) {
            if (e.which === 69 && (e.ctrlKey || e.metaKey)) {
                $(".buttons-excel")[0].click();
            }
            if (e.which === 70 && (e.ctrlKey || e.metaKey)) {
                $(".buttons-pdf")[0].click();
            }
        });
    })
</script>
<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Halaman Track Records Pelunasan Nota</h1>
    <a class="btn btn-primary mb-8" href="pilihBarangBeli.php">Tambah Nota</a>
    <a class="btn btn-warning mb-8" href="beli.php">Kembali</a>

    <div class="overflow-x-auto">
        <p class="badge badge-sm">Convert To Excel (CTRL + E)</p>
        <p class="badge badge-sm">Convert To PDF (CTRL + F)</p>

        <table id="table" class="table table-compact w-full">
            <thead>
                <tr>
                    <th>No Pelunasan</th>
                    <th>Kode Nota</th>
                    <th>Supplier</th>
                    <th>Tanggal</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Operator</th>
                </tr>
            </thead>
            <tbody id="container">
                <?php foreach ($item as $i) {
                    $p = query("SELECT * FROM pelunasan_hutang WHERE NO_PELUNASAN = '" . $i['NO_PELUNASAN'] . "'")[0];
                ?>
                    <tr>
                        <th><?= $i['NO_PELUNASAN']; ?></th>
                        <td><?= $i['NOTA_BELI']; ?></td>
                        <td><?= query("SELECT NAMA FROM supplier WHERE KODE = '" . $p['SUPPLIER_ID'] . "'")[0]["NAMA"]; ?></td>
                        <td><?= $p['TANGGAL']; ?></td>
                        <td><?= $i['NOMINAL']; ?></td>
                        <td><?= $i['KETERANGAN']; ?></td>
                        <td><?= query("SELECT NAMA FROM user_admin WHERE ID =" . $p['OPERATOR'])[0]["NAMA"]; ?></td>
                    </tr>
                <?php } ?>
        </table>
    </div>
</main>

<script src="script/cariPelunasan.js"></script>

<?php
include('shared/footer.php');
?>