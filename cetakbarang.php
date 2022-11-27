<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$title = "Barang - $username";
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
            lengthMenu: [
                [10, 25, 50, -1],
                ['10 rows', '25 rows', '50 rows', 'Tampilkan Semua']
            ],
            dom: 'Blfrtip',
            buttons: [{
                extend: 'excel',
                text: 'Export to Excel',
                exportOptions: {
                    modifier: {
                        // DataTables core
                        order: 'original', // 'current', 'applied', 'index',  'original'
                        page: 'all', // 'all',     'current'
                        search: 'applied' // 'none',    'applied', 'removed'
                    }
                }
            }],
            processing: true,
            serverSide: true,
            ajax: 'ajax/cetakbarang.php',
        });

        $(document).on("keydown", function(e) {
            console.log(e.which);
            if (e.key === "Escape") {
                $("#kembali")[0].click();
            }
            if (e.which === 69 && (e.ctrlKey || e.metaKey)) {
                $(".buttons-excel")[0].click();
            }
        });
    })
</script>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Halaman Admin</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>
    <div class="tooltip tooltip-right" data-tip="ESC (Tekan lama)">
        <a id="kembali" class="btn btn-primary mb-4" href="barang.php">Kembali</a>
    </div>

    <div id="container" class="overflow-x-auto w-full mt-8">
        <p class="badge badge-sm">Convert To Excel (CTRL + E)</p>
        <table id="table" class="table w-full">
            <!-- head -->
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Stok Awal</th>
                    <th>Stok</th>
                    <th>Stok Min</th>
                    <th>Stok Max</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Garansi</th>
                    <th>Golongan</th>
                    <th>Subgolongan</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</main>

<?php
include('shared/footer.php');
?>