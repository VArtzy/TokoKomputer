<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$item = query("SELECT * FROM Beli ORDER BY TANGGAL DESC");

if (isset($_POST["submit"])) {

    // cek apakah daata berhasil diubah
    if (tambahBeli($_POST, $id) > 0) {
        echo "
        <script>
        alert('Berhasil Menambah Beli Baru');
        document.location.href = 'Beli.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["ubah"])) {

    // cek apakah daata berhasil diubah
    if (ubahBeli($_POST, $id) > 0) {
        echo "
        <script>
        alert('Berhasil Memperbaiki Beli');
        document.location.href = 'Beli.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["hapus"])) {

    // cek apakah daata berhasil diubah
    if (hapusBeli($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menghapus Beli');
        document.location.href = 'Beli.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

$title = "Pembelian - $username";
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
            dom: 'Bfrtip',
            buttons: [
                'excel'
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
    <h1 class="text-2xl font-semibold">Beli</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>

    <div class="tooltip tooltip-success tooltip-right" data-tip="ESC">
        <label for="my-modal-6" class="btn btn-success mb-4">Tambah Beli</label>
    </div>
    <div class="overflow-x-auto">
        <p class="badge badge-sm">Next Row (Tab)</p>
        <p class="badge badge-sm">Previous Row (Shift + Tab)</p>
        <p class="badge badge-sm">Convert To Excel (CTRL + E)</p>

        <table id="table" class="display table w-full" style="width:100%">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Tanggal</th>
                    <th>Nota</th>
                    <th>Supplier</th>
                    <th>Keterangan</th>
                    <th>Hutang</th>
                    <th>Sisa Hutang</th>
                    <th>Tempo (Nota)</th>
                    <th>Operator</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($item as $key => $i) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= $i['TANGGAL']; ?></td>
                        <td><?= $i['NOTA']; ?></td>
                        <td><?= query("SELECT NAMA FROM supplier WHERE KODE = '" . $i['SUPPLIER_ID'] . "'")[0]['NAMA']; ?></td>
                        <td><?= $i['KETERANGAN']; ?></td>
                        <td><?= $i['NOTA']; ?></td>
                        <td><?= $i['NOTA']; ?></td>
                        <td><?= $i['TEMPO']; ?></td>
                        <td><?= query("SELECT NAMA FROM user_admin WHERE ID = " . $i['OPERATOR'])[0]['NAMA']; ?></td>
                        <td>
                            <div class="tooltip tooltip-info tooltip-right" data-tip="Enter">
                                <a tabindex="1" href="Beli.php?nota=<?= $i['NOTA']; ?>"><i class="fa-solid fa-pen-to-square text-sky-500 scale-150"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php if (!isset($_GET['nota'])) : ?>
    <input type="checkbox" id="my-modal-6" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <h3 class="font-bold text-lg">Beli</h3>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="NOTA">Nota: </label>
                    </label>
                    <label class="input-group">
                        <span>Nota:</span>
                        <input required type="text" name="NOTA" id="NOTA" class="input input-bordered">
                    </label>
                </div>
                <div class="flex gap-4">
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="STATUS_NOTA">Status: </label>
                        </label>
                        <label class="input-group">
                            <span>Status:</span>
                            <select class="input input-bordered" name="STATUS_NOTA" id="STATUS_NOTA">
                                <option value="T">Tunai</option>
                                <option value="K">Kredit</option>
                            </select>
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="TANGGAL">Tanggal: </label>
                        </label>
                        <label class="input-group">
                            <span>Tanggal:</span>
                            <input type="date" name="TANGGAL" id="TANGGAL" class="input input-bordered">
                        </label>
                    </div>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="LOKASI_ID">Lokasi: </label>
                    </label>
                    <label class="input-group">
                        <span>Lokasi:</span>
                        <select class="input input-bordered" name="LOKASI_ID" id="LOKASI_ID">
                            <?php
                            $Lokasi = query("SELECT * FROM Lokasi");
                            foreach ($Lokasi as $s) : ?>
                                <option value="<?= $s['KODE']; ?>"><?= $s["KETERANGAN"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="SUPPLIER_ID">Supplier: </label>
                    </label>
                    <label class="input-group">
                        <span>Supplier:</span>
                        <select class="input input-bordered" name="SUPPLIER_ID" id="SUPPLIER_ID">
                            <?php
                            $Supplier = query("SELECT * FROM Supplier");
                            foreach ($Supplier as $s) : ?>
                                <option value="<?= $s['KODE']; ?>"><?= $s["NAMA"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="KETERANGAN">Keterangan: </label>
                    </label>
                    <label class="input-group">
                        <span>Keterangan:</span>
                        <input required type="text" name="KETERANGAN" id="KETERANGAN" class="input input-bordered">
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

<?php if (isset($_GET['nota'])) : ?>
    <?php
    $nota = $_GET['nota'];
    $item = query("SELECT * FROM Beli WHERE NOTA = '$nota'")[0];
    ?>
    <input type="checkbox" checked id="my-modal-edit" class="modal-toggle" />
    <div class="modal visible opacity-100 pointer-events-auto modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <input type="hidden" value="<?= $item['NOTA']; ?>" name="KODE_LAMA">
                <h3 class="font-bold text-lg">Aksi Beli</h3>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="NOTA">Nota: </label>
                    </label>
                    <label class="input-group">
                        <span>Nota:</span>
                        <input value="<?= $item['NOTA']; ?>" required type="text" name="NOTA" id="NOTA" class="input input-bordered">
                    </label>
                </div>
                <div class="flex gap-4">
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="STATUS_NOTA">Status: </label>
                        </label>
                        <label class="input-group">
                            <span>Status:</span>
                            <select class="input input-bordered" name="STATUS_NOTA" id="STATUS_NOTA">
                                <option <?php if ($item['STATUS_NOTA'] === 'T') {
                                            echo 'selected';
                                        } ?> value="T">Tunai</option>
                                <option <?php if ($item['STATUS_NOTA'] === 'K') {
                                            echo 'selected';
                                        } ?> value="K">Kredit</option>
                            </select>
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="TANGGAL">Tanggal: </label>
                        </label>
                        <label class="input-group">
                            <span>Tanggal:</span>
                            <input value="<?= $item['TANGGAL']; ?>" type="date" name="TANGGAL" id="TANGGAL" class="input input-bordered">
                        </label>
                    </div>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="LOKASI_ID">Lokasi: </label>
                    </label>
                    <label class="input-group">
                        <span>Lokasi:</span>
                        <select class="input input-bordered" name="LOKASI_ID" id="LOKASI_ID">
                            <?php
                            $Lokasi = query("SELECT * FROM Lokasi");
                            foreach ($Lokasi as $s) : ?>
                                <option <?php if ($s['KODE'] === $item['LOKASI_ID']) {
                                            echo 'selected';
                                        } ?> value="<?= $s['KODE']; ?>"><?= $s["KETERANGAN"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="SUPPLIER_ID">Supplier: </label>
                    </label>
                    <label class="input-group">
                        <span>Supplier:</span>
                        <select class="input input-bordered" name="SUPPLIER_ID" id="SUPPLIER_ID">
                            <?php
                            $Supplier = query("SELECT * FROM Supplier");
                            foreach ($Supplier as $s) : ?>
                                <option <?php if ($s['KODE'] === $item['SUPPLIER_ID']) {
                                            echo 'selected';
                                        } ?> value="<?= $s['KODE']; ?>"><?= $s["NAMA"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="KETERANGAN">Keterangan: </label>
                    </label>
                    <label class="input-group">
                        <span>Keterangan:</span>
                        <input value="<?= $item['KETERANGAN']; ?>" required type="text" name="KETERANGAN" id="KETERANGAN" class="input input-bordered">
                    </label>
                </div>
                <div class="modal-action">
                    <div class="tooltip tooltip-error" data-tip="CTRL + Q">
                        <button id="hapus" name="hapus" class="btn btn-error" type="submit">Hapus</button>
                    </div>
                    <div class="tooltip" data-tip="ESC (Tekan Lama)">
                        <a id="batal" href="Jasa.php" for="my-modal-edit" class="btn">Batal</a>
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