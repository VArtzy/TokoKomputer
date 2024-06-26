<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$nom = '15';
if (!in_array($nom, $aksesMenu)) return header('Location: admin.php');
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';

$item = query("select a.TANGGAL, a.TEMPO, a.SALESMAN_ID, a.CUSTOMER_ID, a.OPERATOR, a.NOTA, a.KETERANGAN, a.STATUS_NOTA, a.STATUS_BAYAR, (select SUM(jumlah*harga_jual) from item_jual where nota = a.nota) AS PIUTANG, (select SUM(jumlah*harga_jual) from item_jual where nota = a.nota) - COALESCE((select sum(nominal-diskon-retur-diskon_rp) from item_pelunasan_piutang where nota_jual = a.nota), 0) as SISA_PIUTANG from jual a ORDER BY TANGGAL DESC");

if (isset($_GET['hapus'])) {
    // cek apakah daata berhasil diubah
    if (hapusJual($_GET['nota']) > 0) {
        echo "
        <script>
        alert('Berhasil Menghapus Jual');
        document.location.href = 'Jual.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
        echo "<script>
        alert('Berhasil Menghapus Jual');
        document.location.href = 'Jual.php';
        </script>
        ";
    }
}

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.3.0/js/dataTables.dateTime.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.3.0/css/dataTables.dateTime.min.css">

<script>
    var minDate, maxDate;

    // Custom filtering function which will search data in column four between two values
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var min = minDate.val();
            var max = maxDate.val();
            var date = new Date(data[1]);

            if (
                (min === null && max === null) ||
                (min === null && date <= max) ||
                (min <= date && max === null) ||
                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        }
    );

    $(document).ready(function() {
        minDate = new DateTime($('#min'), {
            format: 'MMMM Do YYYY'
        });
        maxDate = new DateTime($('#max'), {
            format: 'MMMM Do YYYY'
        });
        var table = $('#table').DataTable({
            "pageLength": 50,
            <?php if (isset($aksi[3]) && $aksi[3] === '1') : ?>
                dom: 'Blfrtip',
            <?php endif; ?>
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
        $('#min, #max').on('change', function() {
            table.draw();
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
    <?php if (isset($aksi[0]) && $aksi[0] === '1') : ?>
        <a class="btn btn-primary mb-8" href="pilihBarang.php">Tambah Nota</a>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <p class="badge badge-sm">Convert To Excel (CTRL + E)</p>
        <p class="badge badge-sm">Convert To PDF (CTRL + F)</p>

        <table border="0" cellspacing="5" cellpadding="5">
            <tbody class="flex">
                <tr>
                    <td>Tanggal</td>
                    <td><input class="input rounded-none input-bordered input-xs" type=" text" id="min" name="min"></td>
                </tr>
                <tr>
                    <td>sampai</td>
                </tr>
                <tr>
                    <td><input class="input rounded-none input-bordered input-xs" type=" text" id="max" name="max"></td>
                </tr>
            </tbody>
        </table>

        <table id="table" class="table table-compact w-full">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nota</th>
                    <th class="text-xs">Langganan</th>
                    <th class="text-xs">Keterangan</th>
                    <th>Piutang</th>
                    <th>Sisa Piutang</th>
                    <th class="text-xs">Tempo (Nota)</th>
                    <th>Salesman</th>
                    <th>Operator</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="container">
                <?php foreach ($item as $key => $i) {
                ?>
                    <tr>
                        <th><?= $key + 1; ?></th>
                        <td><?= $i['TANGGAL']; ?></td>
                        <td><?= $i['NOTA']; ?></td>
                        <td class="max-w-[8ch] truncate overflow-hidden"><?php if (isset(query("SELECT NAMA FROM customer WHERE KODE = '" . $i['CUSTOMER_ID'] . "'")[0]['NAMA'])) {
                                                                                echo query("SELECT NAMA FROM customer WHERE KODE = '" . $i['CUSTOMER_ID'] . "'")[0]['NAMA'];
                                                                            } else {
                                                                                echo $i['CUSTOMER_ID'];
                                                                            } ?></td>
                        <td class="max-w-[15ch] truncate overflow-hidden"><?= $i['KETERANGAN']; ?></td>
                        <td><?= rupiah($i['PIUTANG']); ?></td>
                        <td><?= rupiah($i['SISA_PIUTANG']); ?></td>
                        <td><?= $i['TEMPO']; ?></td>
                        <td><?= query("SELECT NAMA FROM salesman WHERE KODE = '" . $i['SALESMAN_ID'] . "'")[0]["NAMA"]; ?></td>
                        <td><?= query("SELECT NAMA FROM user_admin WHERE id = '" . $i['OPERATOR'] . "'")[0]["NAMA"]; ?></td>
                        <td>
                            <div class="tooltip tooltip-info tooltip-right" data-tip="Enter">
                                <a tabindex="1" href="detailinvoice.php?nota=<?= $i['NOTA']; ?>&open"><i class="fa-solid fa-pen-to-square text-sky-500 scale-150"></i></a>
                            </div>
                            <?php if (isset($aksi[2]) && $aksi[2] === '1') : ?>
                                <div class="tooltip tooltip-error" data-tip="Enter">
                                    <a tabindex="1" onclick="return confirm('Yakin ingin menghapus nota?')" href="Jual.php?nota=<?= $i['NOTA']; ?>&hapus" id="hapus" name="hapus" class="text-rose-500" type="submit"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
        </table>
    </div>
</main>

<script src="script/cariPelunasan.js"></script>

<?php
include('shared/footer.php');
?>