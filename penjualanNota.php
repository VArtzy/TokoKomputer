<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$item = query("SELECT * FROM pelunasan_piutang");

function cekAvailable($CUSTOMER_ID, $NOTA_JUAL)
{
    global $conn;
    $isCustomer = mysqli_query($conn, "SELECT NAMA, KODE FROM customer WHERE NAMA = '$CUSTOMER_ID' OR KODE = '$CUSTOMER_ID'");
    $isNota = mysqli_query($conn, "SELECT NOTA FROM jual WHERE NOTA = '$NOTA_JUAL'");

    if (!mysqli_fetch_assoc($isCustomer)) {
        echo "<script>
        if (confirm('Nama atau Kode Customer belum didaftarkan. Silahkan daftar terlebih dahulu.') == true) {
            document.location.href = 'langganan.php'
        } else {
            document.location.href = 'penjualanNota.php'
        }
        </script>";
        return false;
    }

    if (!mysqli_fetch_assoc($isNota)) {
        echo "<script>
        if (confirm('Tidak ada Nota dengan nomor nota tersebut. Silahkan buat penjualan terlebih dahulu.') == true) {
            document.location.href = 'jual.php'
        } else {
            document.location.href = 'penjualanNota.php'
        }
        </script>";
        return false;
    }
}

if (isset($_POST["submit"])) {
    $CUSTOMER_ID = mysqli_real_escape_string($conn, $_POST["CUSTOMER_ID"]);
    $NOTA_JUAL = mysqli_real_escape_string($conn, $_POST["NOTA_JUAL"]);
    cekAvailable($CUSTOMER_ID, $NOTA_JUAL);

    // cek apakah daata berhasil diubah
    if (tambahPelunasanP($username, $_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menambah Pembayaran');
        document.location.href = 'penjualanNota.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["ubah"])) {
    $CUSTOMER_ID = mysqli_real_escape_string($conn, $_POST["CUSTOMER_ID"]);
    $NOTA_JUAL = mysqli_real_escape_string($conn, $_POST["NOTA_JUAL"]);
    cekAvailable($CUSTOMER_ID, $NOTA_JUAL);

    // cek apakah daata berhasil diubah
    if (ubahPelunasanP($username, $_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Memperbaiki Pembayaran');
        document.location.href = 'penjualanNota.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["hapus"])) {
    $CUSTOMER_ID = mysqli_real_escape_string($conn, $_POST["CUSTOMER_ID"]);
    $NOTA_JUAL = mysqli_real_escape_string($conn, $_POST["NOTA_JUAL"]);
    cekAvailable($CUSTOMER_ID, $NOTA_JUAL);

    // cek apakah daata berhasil diubah
    if (hapusPelunasanP($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menghapus Pembayaran');
        document.location.href = 'penjualanNota.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}


$title = "Records Nota Pembayaran - $username";
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
        $("#CUSTOMER_ID").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "ajax/customerid.php",
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
        $("#NOTA_JUAL").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "ajax/penjualanid.php",
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
    <h1 class="text-2xl font-semibold">Halaman Track Records Pembayaran Nota</h1>
    <label for="my-modal-6" class="btn btn-success mb-4">Tambah Pembayaran</label>
    <a class="btn btn-warning mb-8" href="jual.php">Kembali</a>

    <div class="overflow-x-auto">
        <p class="badge badge-sm">Convert To Excel (CTRL + E)</p>
        <p class="badge badge-sm">Convert To PDF (CTRL + F)</p>

        <table id="table" class="table table-compact w-full">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No Pembayaran</th>
                    <th>Tanggal</th>
                    <th>Langganan</th>
                    <th>Pembayaran</th>
                    <th>Diskon</th>
                    <th>Retur</th>
                    <th>Keterangan</th>
                    <th>Operator</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="container">
                <?php foreach ($item as $key => $i) {
                    $p = query("SELECT * FROM item_pelunasan_piutang WHERE NO_PELUNASAN = '" . $i['NO_PELUNASAN'] . "'")[0];
                ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <th><?= $i['NO_PELUNASAN']; ?></th>
                        <td><?= $i['TANGGAL']; ?></td>
                        <td><?php if (isset(query("SELECT NAMA FROM customer WHERE KODE = '" . $i['CUSTOMER_ID'] . "'")[0]['NAMA'])) {
                                echo query("SELECT NAMA FROM customer WHERE KODE = '" . $i['CUSTOMER_ID'] . "'")[0]['NAMA'];
                            } else {
                                echo $i['CUSTOMER_ID'];
                            } ?></td>
                        <td><?= $p['NOMINAL']; ?></td>
                        <td><?= $p['DISKON']; ?></td>
                        <td><?= $p['RETUR']; ?></td>
                        <td><?= $i['KETERANGAN']; ?></td>
                        <td><?= query("SELECT NAMA FROM user_admin WHERE ID =" . $i['OPERATOR'])[0]["NAMA"]; ?></td>
                        <td>
                            <div class="tooltip tooltip-info tooltip-right" data-tip="Enter">
                                <a tabindex="1" href="penjualanNota.php?nota=<?= $i['NO_PELUNASAN']; ?>"><i class="fa-solid fa-pen-to-square text-sky-500 scale-150"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
        </table>
    </div>
</main>

<?php if (!isset($_GET['nota'])) : ?>
    <input type="checkbox" id="my-modal-6" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <h3 class="font-bold text-lg">Tambah Pembayaran Piutang</h3>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="NO_PELUNASAN">No Pembayaran: </label>
                    </label>
                    <label class="input-group">
                        <span>No Pembayaran:</span>
                        <input value="<?= date('Ymd') . query("SELECT COUNT(*) as COUNT FROM pelunasan_piutang")[0]["COUNT"] ?>" required type="number" name="NO_PELUNASAN" id="KETERANGAN" class="input input-bordered">
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
                        <label class="label-text" for="CUSTOMER_ID">Langganan: </label>
                    </label>
                    <label class="input-group">
                        <span>Langganan:</span>
                        <input required type="text" name="CUSTOMER_ID" id="CUSTOMER_ID" class="input input-bordered">
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
                                <th>Nota Jual</th>
                                <th>Total</th>
                                <th>Kekurangan</th>
                                <th>Pembayaran</th>
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
                                <input type="text" id="NOTA_JUAL" name="NOTA_JUAL" />
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
                        <a id="batal" href="penjualanNota.php" for="my-modal-edit" class="btn">Batal</a>
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
    $item = query("SELECT * FROM pelunasan_piutang WHERE NO_PELUNASAN = '$kode'")[0];
    $itemp = query("SELECT * FROM item_pelunasan_piutang WHERE NO_PELUNASAN = '$kode'")[0];
    ?>
    <input type="checkbox" checked id="my-modal-edit" class="modal-toggle" />
    <div class="modal visible opacity-100 pointer-events-auto modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <h3 class="font-bold text-lg">Aksi Pembayaran Piutang</h3>

                <input value="<?= $item['NO_PELUNASAN']; ?>" required type="hidden" name="KODE_LAMA" id="KODE_LAMA" class="input input-bordered">
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="NO_PELUNASAN">No Pembayaran: </label>
                    </label>
                    <label class="input-group">
                        <span>No Pembayaran:</span>
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
                        <label class="label-text" for="CUSTOMER_ID">Langganan: </label>
                    </label>
                    <label class="input-group">
                        <span>Langganan:</span>
                        <input value="<?= $item['CUSTOMER_ID']; ?>" required type="text" name="CUSTOMER_ID" id="CUSTOMER_ID" class="input input-bordered">
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
                                <th>Nota Jual</th>
                                <th>Total</th>
                                <th>Kekurangan</th>
                                <th>Pembayaran</th>
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
                                <input type="text" value="<?= $itemp['NOTA_JUAL']; ?>" name="NOTA_JUAL" />
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
                    <div class="tooltip tooltip-error" data-tip="CTRL + Q">
                        <button id="hapus" name="hapus" class="btn btn-error" type="submit">Hapus</button>
                    </div>
                    <div class="tooltip" data-tip="ESC (Tekan Lama)">
                        <a id="batal" href="penjualanNota.php" for="my-modal-edit" class="btn">Batal</a>
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