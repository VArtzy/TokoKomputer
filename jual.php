<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$item = query("select a.TANGGAL, a.TEMPO, a.SALESMAN_ID, a.CUSTOMER_ID, a.OPERATOR, a.NOTA, a.KETERANGAN, a.STATUS_NOTA, a.STATUS_BAYAR, (select SUM(jumlah*harga_jual) from item_jual where nota = a.nota) AS PIUTANG, (select sum(nominal-diskon-retur-diskon_rp) from item_pelunasan_piutang where nota_jual = a.nota) as SISA_PIUTANG from jual a ORDER BY TANGGAL DESC LIMIT 0, 20;");

$title = "Records Nota Jual - $username";
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
    <a class="btn btn-primary mb-8" href="pilihBarang.php">Tambah Nota</a>
    <a class="btn btn-warning mb-8" href="invoices.php">Kembali</a>

    <div class="overflow-x-auto">
        <p class="badge badge-sm">Convert To Excel (CTRL + E)</p>
        <p class="badge badge-sm">Convert To PDF (CTRL + F)</p>

        <table id="table" class="table table-compact w-full">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nota</th>
                    <th>Langganan</th>
                    <th>Keterangan</th>
                    <th>Piutang</th>
                    <th>Sisa Piutang</th>
                    <th>Tempo (Nota)</th>
                    <th>Salesman</th>
                    <th>Operator</th>
                </tr>
            </thead>
            <tbody id="container">
                <?php foreach ($item as $key => $i) {
                ?>
                    <tr>
                        <th><?= $key + 1; ?></th>
                        <td><?= $i['TANGGAL']; ?></td>
                        <td><?= $i['NOTA']; ?></td>
                        <td><?php if (isset(query("SELECT NAMA FROM customer WHERE KODE = '" . $i['CUSTOMER_ID'] . "'")[0]['NAMA'])) {
                                echo query("SELECT NAMA FROM customer WHERE KODE = '" . $i['CUSTOMER_ID'] . "'")[0]['NAMA'];
                            } else {
                                echo $i['CUSTOMER_ID'];
                            } ?></td>
                        <td><?= $i['KETERANGAN']; ?></td>
                        <td><?= rupiah($i['PIUTANG']); ?></td>
                        <td><?= rupiah($i['SISA_PIUTANG']); ?></td>
                        <td><?= $i['TEMPO']; ?></td>
                        <td><?= query("SELECT NAMA FROM salesman WHERE KODE = '" . $i['SALESMAN_ID'] . "'")[0]["NAMA"]; ?></td>
                        <td><?= query("SELECT NAMA FROM user_admin WHERE id = '" . $i['OPERATOR'] . "'")[0]["NAMA"]; ?></td>
                    </tr>
                <?php } ?>
        </table>
    </div>
</main>

<script src="script/cariPelunasan.js"></script>

<?php
include('shared/footer.php');
?>