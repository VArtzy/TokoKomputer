<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$nom = '9';
if (!in_array($nom, $aksesMenu)) return header('Location: admin.php');
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';

$item = query("SELECT * FROM salesman ORDER BY NAMA ASC");

$title = "Salesman - $username";
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
                $("#batal")[0].click();
            }
        });
    })
</script>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Salesman</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>

    <?php if (isset($aksi[0]) && $aksi[0] === '1') : ?>
        <div class="tooltip tooltip-success tooltip-right" data-tip="ESC">
            <a href="tambahSales.php" class="btn btn-success" id="tambah">Tambah Salesman</a>
        </div>
    <?php endif; ?>
    <a href="userAndAdminManagement.php" class="btn btn-primary mb-4">Kembali ke Managemen</a>

    <div class="overflow-x-auto">
        <p class="badge badge-sm">Next Row (Tab)</p>
        <p class="badge badge-sm">Previous Row (Shift + Tab)</p>
        <p class="badge badge-sm">Convert To Excel (CTRL + E)</p>
        <p class="badge badge-sm">Convert To PDF (CTRL + F)</p>

        <table id="table" class="display table w-full" style="width:100%">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Alamat 2</th>
                    <th>No. HP</th>
                    <th>No. Rekening</th>
                    <th>Plafon</th>
                    <th>Sisa Piutang</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($item as $key => $i) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= $i['NAMA']; ?></td>
                        <td><?= $i['ALAMAT']; ?></td>
                        <td><?= $i['ALAMAT2']; ?></td>
                        <td><?= $i['TELEPON']; ?></td>
                        <td><?= $i['NO_REKENING']; ?></td>
                        <td><?= $i['PLAFON_PIUTANG']; ?></td>
                        <td><?= $i['TOTAL_PIUTANG']; ?></td>
                        <td>
                            <div class="tooltip tooltip-info tooltip-right" data-tip="Enter">
                                <a tabindex="1" href="editSales.php?kode=<?= $i["KODE"]; ?>" class="btn btn-info btn-xs">Edit Sales</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php
include('shared/footer.php');
?>