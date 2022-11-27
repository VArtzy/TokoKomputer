<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$item = query("SELECT * FROM Multi_price ORDER BY KODE ASC");

if (isset($_POST["submit"])) {

    // cek apakah daata berhasil diubah
    if (tambahMultiPrice($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menambah Multiprice Baru');
        document.location.href = 'Multiprice.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["ubah"])) {

    // cek apakah daata berhasil diubah
    if (ubahMultiPrice($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Memperbaiki Multiprice');
        document.location.href = 'Multiprice.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["hapus"])) {

    // cek apakah daata berhasil diubah
    if (hapusMultiPrice($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menghapus Multiprice');
        document.location.href = 'Multiprice.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["caribarang"])) {
    $keyword = $_POST['BARANG_ID'];
    $query = "SELECT NAMA FROM `barang`
    WHERE
    KODE LIKE '%$keyword%'
    ";
    $barang = query($query);
}

$title = "Multi Price - $username";
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
            dom: 'Blfrtip',
            buttons: [{
                extend: 'excel',
                text: 'Export to Excel',
                exportOptions: {
                    modifier: {
                        // DataTables core
                        order: 'current', // 'current', 'applied', 'index',  'original'
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
        });
    })
</script>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Multi Price</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>

    <div class="tooltip tooltip-success tooltip-right" data-tip="ESC">
        <label for="my-modal-6" class="btn btn-success mb-4">Tambah Multi Price</label>
    </div>
    <div class="overflow-x-auto">
        <p class="badge badge-sm">Next Row (Tab)</p>
        <p class="badge badge-sm">Previous Row (Shift + Tab)</p>
        <p class="badge badge-sm">Convert To Excel (CTRL + E)</p>

        <table id="table" class="display table w-full" style="width:100%">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Barang ID</th>
                    <th>Satuan</th>
                    <th>Harga Ke</th>
                    <th>Customer</th>
                    <th>Jumlah R1</th>
                    <th>Jumlah R2</th>
                    <th>Harga Jual</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($item as $key => $i) : ?>
                    <tr>
                        <td><?= $i['KODE']; ?></td>
                        <td><?= $i['BARANG_ID']; ?></td>
                        <td><?= query("SELECT NAMA FROM satuan WHERE KODE = '" . $i['KODE_SATUAN'] . "'")[0]["NAMA"]; ?></td>
                        <td><?= $i['HARGA_KE']; ?></td>
                        <td><?= $i['CUSTOMER_ID']; ?></td>
                        <td><?= $i['JUMLAH_R1']; ?></td>
                        <td><?= $i['JUMLAH_R2']; ?></td>
                        <td><?= $i['HARGA_JUAL']; ?></td>
                        <td>
                            <div class="tooltip tooltip-info tooltip-right" data-tip="Enter">
                                <a tabindex="1" href="multiprice.php?kode=<?= $i['KODE']; ?>"><i class="fa-solid fa-pen-to-square text-sky-500 scale-150"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php if (!isset($_GET['kode'])) : ?>
    <input type="checkbox" id="my-modal-6" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <h3 class="font-bold text-lg">Multi Price</h3>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="BARANG_ID">Barcode: </label>
                    </label>
                    <label class="input-group flex items-center gap-4">
                        <span>Barcode:</span>
                        <input required type="text" name="BARANG_ID" id="BARANG_ID" class="input input-bordered">
                        <button type="submit" name="caribarang" id="caribarang" class="btn btn-sm">Cari Barang</button>
                    </label>
                    <label for=""><?php if (isset($barang)) {
                                        echo $barang[0]["NAMA"];
                                    } else {
                                        echo '...';
                                    } ?></label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="KODE_SATUAN">Satuan: </label>
                    </label>
                    <label class="input-group">
                        <span>Satuan:</span>
                        <select class="input input-bordered" name="KODE_SATUAN" id="KODE_SATUAN">
                            <?php
                            $Satuan = query("SELECT * FROM Satuan");
                            foreach ($Satuan as $s) : ?>
                                <option value="<?= $s['KODE']; ?>"><?= $s["NAMA"]; ?> - <?= $s["KONVERSI"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="HARGA_JUAL">Harga Jual: </label>
                    </label>
                    <label class="input-group">
                        <span>Harga Jual:</span>
                        <input value="1000" required type="number" name="HARGA_JUAL" id="HARGA_JUAL" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="HARGA_KE">Harga Ke: </label>
                    </label>
                    <label class="input-group">
                        <span>Harga Ke:</span>
                        <input required type="number" value="1" name="HARGA_KE" id="HARGA_KE" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="CUSTOMER_ID">Customer: </label>
                    </label>
                    <label class="input-group">
                        <span>Customer:</span>
                        <input type="number" value="" name="CUSTOMER_ID" id="CUSTOMER_ID" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="JUMLAH_R1">Jumlah R1: </label>
                    </label>
                    <label class="input-group">
                        <span>Jumlah R1:</span>
                        <input value="1" required type="number" name="JUMLAH_R1" id="JUMLAH_R1" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="JUMLAH_R2">Jumlah R2: </label>
                    </label>
                    <label class="input-group">
                        <span>Jumlah R2:</span>
                        <input value="1000" required type="number" name="JUMLAH_R2" id="JUMLAH_R2" class="input input-bordered">
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
    $item = query("SELECT * FROM Multi_price WHERE KODE = '$kode'")[0];
    ?>
    <input type="checkbox" checked id="my-modal-edit" class="modal-toggle" />
    <div class="modal visible opacity-100 pointer-events-auto modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <input type="hidden" value="<?= $item['KODE']; ?>" name="KODE_LAMA">
                <h3 class="font-bold text-lg">Aksi Multi Price</h3>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="BARANG_ID">Barcode: </label>
                    </label>
                    <label class="input-group mb-4">
                        <span>Barcode:</span>
                        <input value="<?= $i['BARANG_ID']; ?>" required type="text" name="BARANG_ID" id="BARANG_ID" class="input input-bordered">
                    </label>
                    <label class="badge" for=""><?php if (isset($item['BARANG_ID'])) {
                                                    echo query("SELECT NAMA FROM barang WHERE KODE = '" . $item['BARANG_ID'] . "'")[0]["NAMA"];
                                                } else {
                                                    echo '...';
                                                } ?></label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="KODE_SATUAN">Satuan: </label>
                    </label>
                    <label class="input-group">
                        <span>Satuan:</span>
                        <select class="input input-bordered" name="KODE_SATUAN" id="KODE_SATUAN">
                            <?php
                            $Satuan = query("SELECT * FROM Satuan");
                            foreach ($Satuan as $s) : ?>
                                <option <?php if ($s === $item['KODE_SATUAN']) {
                                            echo 'seleceted';
                                        } ?> value="<?= $s['KODE']; ?>"><?= $s["NAMA"]; ?> - <?= $s["KONVERSI"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="HARGA_JUAL">Harga Jual: </label>
                    </label>
                    <label class="input-group">
                        <span>Harga Jual:</span>
                        <input value="<?= $item["HARGA_JUAL"]; ?>" required type="number" name="HARGA_JUAL" id="HARGA_JUAL" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="HARGA_KE">Harga Ke: </label>
                    </label>
                    <label class="input-group">
                        <span>Harga Ke:</span>
                        <input value="<?= $item["HARGA_KE"]; ?>" required type="number" value="1" name="HARGA_KE" id="HARGA_KE" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="CUSTOMER_ID">Customer: </label>
                    </label>
                    <label class="input-group">
                        <span>Customer:</span>
                        <input value="<?= $item["CUSTOMER_ID"]; ?>" type="text" value="" name="CUSTOMER_ID" id="CUSTOMER_ID" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="JUMLAH_R1">Jumlah R1: </label>
                    </label>
                    <label class="input-group">
                        <span>Jumlah R1:</span>
                        <input value="<?= $item["JUMLAH_R1"]; ?>" required type="number" name="JUMLAH_R1" id="JUMLAH_R1" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="JUMLAH_R2">Jumlah R2: </label>
                    </label>
                    <label class="input-group">
                        <span>Jumlah R2:</span>
                        <input value="<?= $item["JUMLAH_R2"]; ?>" required type="number" name="JUMLAH_R2" id="JUMLAH_R2" class="input input-bordered">
                    </label>
                </div>
                <div class="modal-action">
                    <div class="tooltip tooltip-error" data-tip="CTRL + Q">
                        <button id="hapus" name="hapus" class="btn btn-error" type="submit">Hapus</button>
                    </div>
                    <div class="tooltip" data-tip="ESC (Tekan Lama)">
                        <a id="batal" href="Multi_price.php" for="my-modal-edit" class="btn">Batal</a>
                    </div>
                    <div class="tooltip tooltip-success" data-tip="CTRL + A">
                        <button id="tambah" name="ubah" class="btn btn-success" type="submit">Perbaiki</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
<?php
include('shared/footer.php');
?>