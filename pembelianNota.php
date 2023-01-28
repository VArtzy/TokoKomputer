<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

if (!in_array("14", $aksesMenu)) return header('Location: admin.php');

$item = query("SELECT * FROM pelunasan_hutang");

function cekAvailable($SUPPLIER_ID, $NOTA_BELI)
{
    global $conn;
    $isSupplier = mysqli_query($conn, "SELECT NAMA, KODE FROM supplier WHERE NAMA = '$SUPPLIER_ID' OR KODE = '$SUPPLIER_ID'");
    $isNota = mysqli_query($conn, "SELECT NOTA FROM beli WHERE NOTA = '$NOTA_BELI'");

    if (!mysqli_fetch_assoc($isSupplier)) {
        echo "<script>
        if (confirm('Nama atau Kode Supplier belum didaftarkan. Silahkan daftar terlebih dahulu.') == true) {
            document.location.href = 'supplier.php'
        } else {
            document.location.href = 'pembelianNota.php'
        }
        </script>";
        return false;
    }

    if (!mysqli_fetch_assoc($isNota)) {
        echo "<script>
        if (confirm('Tidak ada Nota dengan nomor nota tersebut. Silahkan buat pembelian terlebih dahulu.') == true) {
            document.location.href = 'beli.php'
        } else {
            document.location.href = 'pembelianNota.php'
        }
        </script>";
        return false;
    }
}

if (isset($_POST["submit"])) {
    $SUPPLIER_ID = mysqli_real_escape_string($conn, $_POST["SUPPLIER_ID"]);
    $NOTA_BELI = mysqli_real_escape_string($conn, $_POST["NOTA_BELI"]);
    cekAvailable($SUPPLIER_ID, $NOTA_BELI);

    // cek apakah daata berhasil diubah
    if (tambahPelunasan($username, $_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menambah Pelunasan');
        document.location.href = 'pembelianNota.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["ubah"])) {
    $SUPPLIER_ID = mysqli_real_escape_string($conn, $_POST["SUPPLIER_ID"]);
    $NOTA_BELI = mysqli_real_escape_string($conn, $_POST["NOTA_BELI"]);
    cekAvailable($SUPPLIER_ID, $NOTA_BELI);

    // cek apakah daata berhasil diubah
    if (ubahPelunasan($username, $_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Memperbaiki Pelunasan');
        document.location.href = 'pembelianNota.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["hapus"])) {
    $SUPPLIER_ID = mysqli_real_escape_string($conn, $_POST["SUPPLIER_ID"]);
    $NOTA_BELI = mysqli_real_escape_string($conn, $_POST["NOTA_BELI"]);
    cekAvailable($SUPPLIER_ID, $NOTA_BELI);

    // cek apakah daata berhasil diubah
    if (hapusPelunasan($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menghapus Pelunasan');
        document.location.href = 'pembelianNota.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}


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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>
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

    $(function() {
        $("#SUPPLIER_ID").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "ajax/supplierid.php",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            }
        });
        $("#NOTA_BELI").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "ajax/pembelianid.php",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            }
        });
        $('#ui-id-1').css('z-index', 1000)
        $('#ui-id-2').css('z-index', 1000)
    });
</script>

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
        <div class="tooltip tooltip-success tooltip-right" data-tip="ESC">
            <label for="my-modal-6" class="btn btn-success mb-4">Tambah Pelunasan</label>
        </div>
    <?php endif; ?>
    <a class="btn btn-warning mb-8" href="beli.php">Kembali</a>

    <div class="overflow-x-auto">
        <p class="badge badge-sm">Convert To Excel (CTRL + E)</p>
        <p class="badge badge-sm">Convert To PDF (CTRL + F)</p>

        <table id="table" class="table table-compact w-full">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No Pelunasan</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Pelunasan</th>
                    <th>Diskon</th>
                    <th>Retur</th>
                    <th>Keterangan</th>
                    <th>Operator</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="container">
                <?php foreach ($item as $key => $i) {
                    $p = query("SELECT * FROM item_pelunasan_hutang WHERE NO_PELUNASAN = '" . $i['NO_PELUNASAN'] . "'")[0];
                ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <th><?= $i['NO_PELUNASAN']; ?></th>
                        <td><?= $i['TANGGAL']; ?></td>
                        <td><?php if (isset(query("SELECT NAMA FROM supplier WHERE KODE = '" . $i['SUPPLIER_ID'] . "'")[0]['NAMA'])) {
                                echo query("SELECT NAMA FROM supplier WHERE KODE = '" . $i['SUPPLIER_ID'] . "'")[0]['NAMA'];
                            } else {
                                echo $i['SUPPLIER_ID'];
                            } ?></td>
                        <td><?= $p['NOMINAL']; ?></td>
                        <td><?= $p['DISKON']; ?></td>
                        <td><?= $p['RETUR']; ?></td>
                        <td><?= $i['KETERANGAN']; ?></td>
                        <td><?= query("SELECT NAMA FROM user_admin WHERE ID =" . $i['OPERATOR'])[0]["NAMA"]; ?></td>
                        <td>
                            <div class="tooltip tooltip-info tooltip-right" data-tip="Enter">
                                <a tabindex="1" href="pembelianNota.php?nota=<?= $i['NO_PELUNASAN']; ?>"><i class="fa-solid fa-pen-to-square text-sky-500 scale-150"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
        </table>
    </div>
</main>

<?php if (!isset($_GET['kode']) && isset($aksi[0]) && $aksi[0] === '1') : ?>
    <input type="checkbox" id="my-modal-6" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <h3 class="font-bold text-lg">Tambah Pembayaran Hutang</h3>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="NO_PELUNASAN">No Pelunasan: </label>
                    </label>
                    <label class="input-group">
                        <span>No Pelunasan:</span>
                        <input value="<?= date('Ymd') . query("SELECT COUNT(*) as COUNT FROM pelunasan_hutang")[0]["COUNT"] ?>" required type="number" name="NO_PELUNASAN" id="KETERANGAN" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="TANGGAL2">Tanggal: </label>
                    </label>
                    <label class="input-group">
                        <span>Tanggal:</span>
                        <input value="<?= date('Y-m-d'); ?>" type="date" name="TANGGAL2" id="TANGGAL2" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="SUPPLIER_ID">Supplier: </label>
                    </label>
                    <label class="input-group">
                        <span>Supplier:</span>
                        <input required type="text" name="SUPPLIER_ID" id="SUPPLIER_ID" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="KETERANGAN">Keterangan: </label>
                    </label>
                    <label class="input-group">
                        <span>Keterangan:</span>
                        <input type="text" name="KETERANGAN" id="KETERANGAN" class="input input-bordered">
                    </label>
                </div>
                <div class="overflow-x-auto w-full mt-8 mb-4">
                    <table class="table w-full">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nota Beli</th>
                                <th>Total</th>
                                <th>Kekurangan</th>
                                <th>Pelunasan</th>
                                <th>Diskon</th>
                                <th>Retur (RP)</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <th>
                                <input class="w-8" type="text" name="NO" />
                            </th>
                            <th>
                                <input type="text" id="NOTA_BELI" name="NOTA_BELI" />
                            </th>
                            <th>
                                <input type="text" name="" />
                            </th>
                            <th>
                                <input type="text" name="" />
                            </th>
                            <th>
                                <input type="text" name="TOTAL_PELUNASAN_NOTA" />
                            </th>
                            <th>
                                <input type="text" name="DISKON_PELUNASAN" />
                            </th>
                            <th>
                                <input type="text" name="RETUR" />
                            </th>
                            <th>
                                <input type="text" name="KETERANGAN_PELUNASAN" />
                            </th>
                        </tbody>
                    </table>
                </div>
                <div class="modal-action">
                    <div class="tooltip" data-tip="ESC (Tekan Lama)">
                        <a id="batal" href="pembelianNota.php" for="my-modal-edit" class="btn">Batal</a>
                    </div>
                    <div class="tooltip tooltip-success" data-tip="CTRL + A">
                        <button id="tambah" name="submit" class="btn btn-success" type="submit">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($_GET['nota'])) : ?>
    <?php
    $kode = $_GET['nota'];
    $item = query("SELECT * FROM pelunasan_hutang WHERE NO_PELUNASAN = '$kode'")[0];
    $itemp = query("SELECT * FROM item_pelunasan_hutang WHERE NO_PELUNASAN = '$kode'")[0];
    ?>
    <input type="checkbox" checked id="my-modal-edit" class="modal-toggle" />
    <div class="modal visible opacity-100 pointer-events-auto modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <h3 class="font-bold text-lg">Aksi Pembayaran Hutang</h3>

                <input value="<?= $item['NO_PELUNASAN']; ?>" required type="hidden" name="KODE_LAMA" id="KODE_LAMA" class="input input-bordered">
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="NO_PELUNASAN">No Pelunasan: </label>
                    </label>
                    <label class="input-group">
                        <span>No Pelunasan:</span>
                        <input value="<?= $item['NO_PELUNASAN']; ?>" required type="number" name="NO_PELUNASAN" id="NO_PELUNASAN" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="TANGGAL2">Tanggal: </label>
                    </label>
                    <label class="input-group">
                        <span>Tanggal:</span>
                        <input value="<?= $item['TANGGAL']; ?>" type="date" name="TANGGAL2" id="TANGGAL2" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="SUPPLIER_ID">Supplier: </label>
                    </label>
                    <label class="input-group">
                        <span>Supplier:</span>
                        <input value="<?= $item['SUPPLIER_ID']; ?>" required type="text" name="SUPPLIER_ID" id="SUPPLIER_ID" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="KETERANGAN">Keterangan: </label>
                    </label>
                    <label class="input-group">
                        <span>Keterangan:</span>
                        <input value="<?= $item['KETERANGAN']; ?>" type="text" name="KETERANGAN" id="KETERANGAN" class="input input-bordered">
                    </label>
                </div>
                <div class="overflow-x-auto w-full mt-8 mb-4">
                    <table class="table w-full">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nota Beli</th>
                                <th>Total</th>
                                <th>Kekurangan</th>
                                <th>Pelunasan</th>
                                <th>Diskon</th>
                                <th>Retur (RP)</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <th>
                                <input class="w-8" type="text" name="NO" />
                            </th>
                            <th>
                                <input type="text" value="<?= $itemp['NOTA_BELI']; ?>" name="NOTA_BELI" />
                            </th>
                            <th>
                                <input type="text" name="" />
                            </th>
                            <th>
                                <input type="text" name="" />
                            </th>
                            <th>
                                <input type="text" value="<?= $itemp['NOMINAL']; ?>" name="TOTAL_PELUNASAN_NOTA" />
                            </th>
                            <th>
                                <input type="text" value="<?= $itemp['DISKON']; ?>" name="DISKON_PELUNASAN" />
                            </th>
                            <th>
                                <input type="text" value="<?= $itemp['RETUR']; ?>" name="RETUR" />
                            </th>
                            <th>
                                <input type="text" value="<?= $itemp['KETERANGAN']; ?>" name="KETERANGAN_PELUNASAN" />
                            </th>
                        </tbody>
                    </table>
                </div>
                <div class="modal-action">
                    <?php if (isset($aksi[2]) && $aksi[2] === '1') : ?>
                        <div class="tooltip tooltip-error" data-tip="CTRL + Q">
                            <button id="hapus" name="hapus" class="btn btn-error" type="submit">Hapus</button>
                        </div>
                    <?php endif; ?>
                    <div class="tooltip" data-tip="ESC (Tekan Lama)">
                        <a id="batal" href="pembelianNota.php" for="my-modal-edit" class="btn">Batal</a>
                    </div>
                    <?php if (isset($aksi[1]) && $aksi[1] === '1') : ?>
                        <div class="tooltip tooltip-success" data-tip="CTRL + A">
                            <button id="tambah" name="ubah" class="btn btn-success" type="submit">Perbaiki</button>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
<?php
include('shared/footer.php');
?>