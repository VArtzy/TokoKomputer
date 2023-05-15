<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$nom = '11';
if (!in_array($nom, $aksesMenu)) return header('Location: admin.php');
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';

$id = $_GET["id"];

$brg = query("SELECT barang.NAMA, barang.STOK, item_jual.NOTA, (-item_jual.JUMLAH) as JUMLAH, item_jual.JUMLAH2, jual.TANGGAL, jual.CUSTOMER_ID, jual.KETERANGAN FROM barang LEFT JOIN item_jual ON barang.KODE = item_jual.BARANG_ID LEFT JOIN jual ON item_jual.NOTA = jual.NOTA WHERE barang.KODE = '$id' AND item_jual.NOTA IS NOT NULL UNION ALL SELECT barang.NAMA, barang.STOK, item_beli.NOTA, item_beli.JUMLAH, item_beli.JUMLAH2, beli.TANGGAL, beli.SUPPLIER_ID, beli.KETERANGAN FROM barang LEFT JOIN item_beli ON barang.KODE = item_beli.BARANG_ID LEFT JOIN beli ON item_beli.NOTA = beli.NOTA WHERE barang.KODE = '$id' AND item_beli.NOTA IS NOT NULL ORDER BY TANGGAL;");
$titlebrg = $brg[0]['NAMA'] ?? '';
$title = 'Kartu Stok - ' . $titlebrg;

$stok = $brg[0]['STOK'] ?? '';
$masuk = 0;
$keluar = 0;

include('shared/navadmin.php');
?>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.3.0/js/dataTables.dateTime.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.3.0/css/dataTables.dateTime.min.css">

<script>
    $(document).ready(function() {
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

        minDate = new DateTime($('#min'), {
            format: 'MMMM Do YYYY'
        });
        maxDate = new DateTime($('#max'), {
            format: 'MMMM Do YYYY'
        });
        var table = $('#table').DataTable({
            "pageLength": 50,
            // Disable initial sorting
            "aaSorting": [],
            "order": [
                [0, 'asc']
            ], // Sort by the first column in ascending order

            // Custom sorting function to move the last row to the end
            "fnDrawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    order: 'index'
                }).nodes();
                var lastRow = rows[rows.length - 1];
                $(lastRow).insertAfter($(lastRow).siblings(':last'));
            },
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
            console.log(e.which);
            if (e.which === 65 && (e.ctrlKey || e.metaKey)) {
                $("#tambah")[0].click();
            }
            if (e.which === 69 && (e.ctrlKey || e.metaKey)) {
                $(".buttons-excel")[0].click();
            }
            if (e.which === 70 && (e.ctrlKey || e.metaKey)) {
                $(".buttons-pdf")[0].click();
            }
            if (e.which === 81 && (e.ctrlKey || e.metaKey)) {
                $("#hapus")[0].click();
            }
            if (e.key === "Escape") {
                $("#pilihbarang")[0].click();
            }
        });
    })
</script>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Kartu Stok</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>
    <h3 class="text-2xl mb-4"><?= $brg[0]["NAMA"] ?? ''; ?></h3>
    <?php if (empty($brg)) : ?>
        <h2 class="text-2xl text-rose-600 font-bold text-center">Sayangnya, Barang Tidak Memiliki Transaksi 😥</h2>
    <?php endif; ?>
    <?php if (!empty($brg)) : ?>
        <table border="0" cellspacing="5" cellpadding="5">
            <tbody class="flex">
                <tr>
                    <td>Tanggal</td>
                    <td><input class="input input-bordered input-xs" type=" text" id="min" name="min"></td>
                </tr>
                <tr>
                    <td>sampai</td>
                </tr>
                <tr>
                    <td><input class="input input-bordered input-xs" type=" text" id="max" name="max"></td>
                </tr>
            </tbody>
        </table>
        <table id="table" class="table w-full text-sm">
            <p class="badge badge-sm">Next Row (Tab)</p>
            <p class="badge badge-sm">Previous Row (Shift + Tab)</p>
            <p class="badge badge-sm">Convert To Excel (CTRL + E)</p>
            <p class="badge badge-sm">Convert To PDF (CTRL + F)</p>
            <!-- head -->
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nota</th>
                    <th>Supplier/Langganan</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Saldo</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($brg as $i => $b) : ?>
                    <?php $stok += floatval($b["JUMLAH"]);
                    if ($b["JUMLAH"] < 0) {
                        $keluar += $b['JUMLAH'];
                    } else {
                        $masuk += $b['JUMLAH'];
                    }
                    ?>
                    <tr>
                        <td>
                            <div class="font-bold"><?= $i + 1; ?></div>
                        </td>
                        <td>
                            <?= $b['TANGGAL']; ?>
                        </td>
                        <td>
                            <?= $b['NOTA']; ?>
                        </td>
                        <th>
                            <?php if (isset(query("SELECT NAMA FROM supplier WHERE KODE = '" . $b['CUSTOMER_ID'] . "'")[0]['NAMA'])) {
                                echo query("SELECT NAMA FROM supplier WHERE KODE = '" . $b['CUSTOMER_ID'] . "'")[0]['NAMA'];
                            } else {
                                if (isset(query("SELECT NAMA FROM customer WHERE KODE = '" . $b['CUSTOMER_ID'] . "'")[0]['NAMA'])) {
                                    echo query("SELECT NAMA FROM customer WHERE KODE = '" . $b['CUSTOMER_ID'] . "'")[0]['NAMA'];
                                } else {
                                    echo $b['CUSTOMER_ID'];
                                }
                            } ?>
                        </th>
                        <th>
                            <?php if ($b['JUMLAH'] > 0) {
                                echo $b['JUMLAH'] * $b['JUMLAH2'];
                            } else {
                                echo '0';
                            }  ?>
                        </th>
                        <th>
                            <?php if ($b['JUMLAH'] < 0) {
                                echo $b['JUMLAH'] * $b['JUMLAH2'] * -1;
                            } else {
                                echo '0';
                            }  ?>
                        </th>
                        <th>
                            <?= $stok; ?>
                        </th>
                        <th>
                            <?= $b['KETERANGAN']; ?>
                        </th>
                    </tr>
                <?php endforeach; ?>

                <tr class="font-bold">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Sub Total</td>
                    <td><?= $masuk; ?></td>
                    <td><?= abs($keluar); ?></td>
                    <td><?= $masuk + $keluar; ?>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>
    <a href="kartustok.php" class="btn btn-primary">Kembali</a>
</main>

<?php include('shared/footer.php') ?>