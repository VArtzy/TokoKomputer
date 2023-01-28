<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

if (!in_array("18", $aksesMenu)) return header('Location: admin.php');

$item = query("SELECT * FROM `tanda_terima_barang`");

if (isset($_POST["submit"])) {

    // cek apakah daata berhasil diubah
    if (tambahTandaMasukBarang($_POST, $username) > 0) {
        echo "
        <script>
        alert('Berhasil Menambah Tanda Terima Barang Baru');
        document.location.href = 'tandaTerimaBarang.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["ubah"])) {

    // cek apakah daata berhasil diubah
    if (ubahTandaMasukBarang($_POST, $username) > 0) {
        echo "
        <script>
        alert('Berhasil Memperbaiki Tanda Terima Barang');
        document.location.href = 'tandaTerimaBarang.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["hapus"])) {

    // cek apakah daata berhasil diubah
    if (hapusTandaMasukBarang($_POST, $username) > 0) {
        echo "
        <script>
        alert('Berhasil Menghapus Tanda Terima Barang');
        document.location.href = 'tandaTerimaBarang.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["carinama"])) {
    $namaPelanggan = query("SELECT NAMA FROM customer WHERE KODE = '" . $_POST['CUSTOMER_NAMA'] . "'")[0]["NAMA"];
    $noPelanggan = query("SELECT TELEPON FROM customer WHERE KODE = '" . $_POST['CUSTOMER_NAMA'] . "'")[0]["TELEPON"];
    echo  "<script>
        alert('Nama Pelanggan dari id itu adalah $namaPelanggan dengan nomor telp. $noPelanggan');
        </script>";
}

$title = "Tanda Terima Barang - $username";
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
    $("#caribarang").click(function(event) {
        event.preventDefault();
    });

    $(document).ready(function() {
        var table = $('#table').DataTable({
            "pageLength": 50,
            <?php if (isset($aksi[3]) && $aksi[3] === '1') : ?>
                dom: 'Blfrtip',
            <?php endif; ?>
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
            }, {
                extend: 'pdf',
                text: 'Export to PDF',
                exportOptions: {
                    modifier: {
                        // DataTables core
                        order: 'original', // 'current', 'applied', 'index',  'original'
                        page: 'all', // 'all',     'current'
                        search: 'applied' // 'none',    'applied', 'removed'
                    }
                }
            }]
        });

        $(document).on("keydown", function(e) {
            console.log(e.which);
            if (e.which === 65 && (e.ctrlKey || e.metaKey)) {
                $("#tambah")[0].click();
            }
            if (e.which === 69 && (e.ctrlKey || e.metaKey)) {
                $(".buttons-excel")[0].click();
            }
            if (e.which === 81 && (e.ctrlKey || e.metaKey)) {
                $("#hapus")[0].click();
            }
            if (e.key === "Escape") {
                $("#batal")[0].click();
            }
            if (e.which === 70 && (e.ctrlKey || e.metaKey)) {
                $(".buttons-pdf")[0].click();
            }
        });
    })
</script>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Tanda Terima Barang</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>

    <?php if (isset($aksi[0]) && $aksi[0] === '1') : ?>
        <div class="tooltip tooltip-success tooltip-right" data-tip="ESC">
            <label for="my-modal-6" class="btn btn-success mb-4">Tambah Tanda Terima Barang</label>
        </div>
    <?php endif; ?>
    <div class="overflow-x-auto">
        <p class="badge badge-sm">Next Row (Tab)</p>
        <p class="badge badge-sm">Previous Row (Shift + Tab)</p>
        <p class="badge badge-sm">Convert To Excel (CTRL + E)</p>
        <p class="badge badge-sm">Convert To PDF (CTRL + F)</p>

        <table id="table" class="display table w-full" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nota</th>
                    <th>Tanggal</th>
                    <th>Langganan</th>
                    <th>Telepon</th>
                    <th>Keluhan</th>
                    <th>Solusi</th>
                    <th>Operator</th>
                    <th>Operator Edit</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($item as $key => $i) : ?>
                    <tr>
                        <th><?= $key + 1; ?></th>
                        <td><?= $i['NOTA']; ?></td>
                        <td><?= $i['TANGGAL']; ?></td>
                        <td><?= $i['CUSTOMER']; ?></td>
                        <td><?= $i['TELEPON']; ?></td>
                        <td><?= $i['KELUHAN']; ?></td>
                        <td><?= $i['SOLUSI']; ?></td>
                        <td><?= $i['ADDED_BY']; ?></td>
                        <td><?= $i['MODIFIED_BY']; ?></td>
                        <td><?= $i['STATUS']; ?></td>
                        <td>
                            <div class="tooltip tooltip-info tooltip-right" data-tip="Enter">
                                <a tabindex="1" href="tandaTerimaBarang.php?kode=<?= $i['NOTA']; ?>"><i class="fa-solid fa-pen-to-square text-sky-500 scale-150"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php if (!isset($_GET['kode']) && isset($aksi[0]) && $aksi[0] === '1') : ?>
    <input type="checkbox" id="my-modal-6" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <h3 class="font-bold text-lg">Tanda Terima Barang</h3>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="TANGGAL">Tanggal: </label>
                    </label>
                    <label class="input-group">
                        <span>Tanggal:</span>
                        <input type="date" required name="TANGGAL" id="TANGGAL" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="CUSTOMER">Customer: </label>
                    </label>
                    <label class="input-group">
                        <span>Customer</span>
                        <input type="text" name="CUSTOMER" required id="CUSTOMER" class="input input-bordered" placeholder="berikan Nama/Kode Customer...">
                        <button class="btn" type="submit" name="carinama">Cari Customer</button>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="TELEPON">Telepon: </label>
                    </label>
                    <label class="input-group">
                        <span>Telepon:</span>
                        <input type="tel" name="TELEPON" id="TELEPON" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="KELUHAN">Keluhan: </label>
                    </label>
                    <label class="input-group">
                        <span>Keluhan:</span>
                        <input type="text" name="KELUHAN" id="KELUHAN" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="SOLUSI">Solusi: </label>
                    </label>
                    <label class="input-group">
                        <span>Solusi:</span>
                        <input type="text" name="SOLUSI" id="SOLUSI" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="STATUS">Status: </label>
                    </label>
                    <label class="input-group">
                        <span>Status:</span>
                        <input type="text" name="STATUS" id="STATUS" class="input input-bordered">
                    </label>
                </div>
                <div class="modal-action">
                    <div class="tooltip" data-tip="ESC">
                        <label for="my-modal-6" id="batal" class="btn">Batal</label>
                    </div>
                    <div class="tooltip tooltip-success" data-tip="CTRL + A">
                        <button id="tambah" name="submit" class="btn btn-success" type="submit">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($_GET['kode'])) : ?>
    <?php
    $kode = $_GET['kode'];
    $item = query("SELECT * FROM tanda_terima_barang WHERE NOTA = '$kode'")[0];
    ?>
    <input type="checkbox" checked id="my-modal-edit" class="modal-toggle" />
    <div class="modal visible opacity-100 pointer-events-auto modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <input type="hidden" value="<?= $item['NOTA']; ?>" name="KODE_LAMA">
                <h3 class="font-bold text-lg">Aksi Tanda Terima Barang</h3>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="TANGGAL">Tanggal: </label>
                    </label>
                    <label class="input-group">
                        <span>Tanggal:</span>
                        <input type="date" name="TANGGAL" value="<?= $item['TANGGAL']; ?>" id="TANGGAL" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="CUSTOMER">Customer: </label>
                    </label>
                    <label class="input-group">
                        <span>Customer</span>
                        <input type="text" name="CUSTOMER" id="CUSTOMER" value="<?= $item['CUSTOMER']; ?>" class="input input-bordered" placeholder="berikan Nama Customer...">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="TELEPON">Telepon: </label>
                    </label>
                    <label class="input-group">
                        <span>Telepon:</span>
                        <input type="tel" name="TELEPON" id="TELEPON" value="<?= $item['TELEPON']; ?>" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="KELUHAN">Keluhan: </label>
                    </label>
                    <label class="input-group">
                        <span>Keluhan:</span>
                        <input type="text" name="KELUHAN" id="KELUHAN" value="<?= $item['KELUHAN']; ?>" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="SOLUSI">Solusi: </label>
                    </label>
                    <label class="input-group">
                        <span>Solusi:</span>
                        <input type="text" name="SOLUSI" id="SOLUSI" value="<?= $item['SOLUSI']; ?>" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="STATUS">Status: </label>
                    </label>
                    <label class="input-group">
                        <span>Status:</span>
                        <input type="text" name="STATUS" id="STATUS" value="<?= $item['STATUS']; ?>" class="input input-bordered">
                    </label>
                </div>
                <div class="modal-action">
                    <?php if (isset($aksi[2]) && $aksi[2] === '1') : ?>
                        <div class="tooltip tooltip-error" data-tip="CTRL + Q">
                            <button id="hapus" name="hapus" class="btn btn-error" type="submit">Hapus</button>
                        </div>
                    <?php endif; ?>
                    <div class="tooltip" data-tip="ESC (Tekan Lama)">
                        <a id="batal" href="Multi_price.php" for="my-modal-edit" class="btn">Batal</a>
                    </div>
                    <?php if (isset($aksi[1]) && $aksi[1] === '1') : ?>
                        <div class="tooltip tooltip-success" data-tip="CTRL + A">
                            <button id="tambah" name="ubah" class="btn btn-success" type="submit">Perbaiki</button>
                        </div>
                    <?php endif ?>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
<?php
include('shared/footer.php');
?>