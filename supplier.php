<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$item = query("SELECT * FROM Supplier ORDER BY NAMA ASC");

if (isset($_POST["submit"])) {

    // cek apakah daata berhasil diubah
    if (tambahSupplier($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menambah Supplier Baru');
        document.location.href = 'Supplier.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["ubah"])) {

    // cek apakah daata berhasil diubah
    if (ubahSupplier($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Memperbaiki Supplier');
        document.location.href = 'Supplier.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["hapus"])) {

    // cek apakah daata berhasil diubah
    if (hapusSupplier($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menghapus Supplier');
        document.location.href = 'Supplier.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

$title = "Supplier - $username";
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
    <h1 class="text-2xl font-semibold">Supplier</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>

    <div class="tooltip tooltip-success tooltip-right" data-tip="ESC">
        <label for="my-modal-6" class="btn btn-success mb-4">Tambah Supplier</label>
    </div>
    <div class="overflow-x-auto">
        <p class="badge badge-sm">Next Row (Tab)</p>
        <p class="badge badge-sm">Previous Row (Shift + Tab)</p>
        <p class="badge badge-sm">Convert To Excel (CTRL + E)</p>

        <table id="table" class="display table w-full" style="width:100%">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Jatuh Tempo</th>
                    <th>Plafon Hutang</th>
                    <th>Hutang Terakhir</th>
                    <th>Wilayah</th>
                    <th>Default</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($item as $key => $i) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= $i['KODE']; ?></td>
                        <td><?= $i['NAMA']; ?></td>
                        <td><?= $i['JATUH_TEMPO']; ?></td>
                        <td><?= $i['PLAFON_HUTANG']; ?></td>
                        <td><?= $i['TOTAL_HUTANG']; ?></td>
                        <td><?= $i['WILAYAH_ID']; ?> - <?= query("SELECT KETERANGAN FROM wilayah WHERE KODE = '" . $i['WILAYAH_ID'] . "'")[0]["KETERANGAN"] ?></td>
                        <td><?= $i['DEF']; ?></td>
                        <td>
                            <div class="tooltip tooltip-info tooltip-right" data-tip="Enter">
                                <a tabindex="1" href="Supplier.php?kode=<?= $i['KODE']; ?>"><i class="fa-solid fa-pen-to-square text-sky-500 scale-150"></i></a>
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
                <h3 class="font-bold text-lg">Supplier</h3>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="WILAYAH_ID">Wilayah: </label>
                    </label>
                    <label class="input-group">
                        <span>Wilayah:</span>
                        <select class="input input-bordered" name="WILAYAH_ID" id="WILAYAH_ID">
                            <?php
                            $wilayah = query("SELECT * FROM wilayah");
                            foreach ($wilayah as $w) : ?>
                                <option value="<?= $w['KODE']; ?>"><?= $w["KETERANGAN"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="flex">
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="KODE">Kode: </label>
                        </label>
                        <label class="input-group">
                            <span>Kode:</span>
                            <input required type="text" name="KODE" id="KODE" class="input input-bordered">
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="KODE_BARCODE">Barcode: </label>
                        </label>
                        <label class="input-group">
                            <span>Barcode:</span>
                            <input required type="text" name="KODE_BARCODE" id="KODE_BARCODE" class="input input-bordered">
                        </label>
                    </div>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="NAMA">Nama: </label>
                    </label>
                    <label class="input-group">
                        <span>Nama:</span>
                        <input type="text" name="NAMA" id="NAMA" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="ALAMAT">Alamat: </label>
                    </label>
                    <label class="input-group">
                        <span>Alamat:</span>
                        <input type="text" name="ALAMAT" id="ALAMAT" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="ALAMAT2">Alamat 2: </label>
                    </label>
                    <label class="input-group">
                        <span>Alamat 2:</span>
                        <input type="text" name="ALAMAT2" id="ALAMAT2" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="KONTAK">Kontak: </label>
                    </label>
                    <label class="input-group">
                        <span>Kontak:</span>
                        <input type="text" name="KONTAK" id="KONTAK" class="input input-bordered">
                    </label>
                </div>
                <div class="flex">
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="NPWP">NPWP: </label>
                        </label>
                        <label class="input-group">
                            <span>NPWP:</span>
                            <input type="text" name="NPWP" id="NPWP" class="input input-bordered">
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
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="JATUH_TEMPO">Jatuh Tempo: </label>
                    </label>
                    <label class="input-group">
                        <span>Jatuh Tempo:</span>
                        <input type="number" value="0" name="JATUH_TEMPO" id="JATUH_TEMPO" class="input input-bordered">
                        <span> Hari</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="PLAFON_HUTANG">Plafon Hutang: </label>
                    </label>
                    <label class="input-group">
                        <span>Plafon Hutang:</span>
                        <input type="number" value="0" name="PLAFON_HUTANG" id="PLAFON_HUTANG" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label for="DEF" class="cursor-pointer label justify-start gap-4">
                        <span class="label-text">Default</span>
                        <input id="DEF" name="DEF" type="checkbox" class="checkbox checkbox-success" value="1" />
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
    $item = query("SELECT * FROM Supplier WHERE KODE = '$kode'")[0];
    ?>
    <input type="checkbox" checked id="my-modal-edit" class="modal-toggle" />
    <div class="modal visible opacity-100 pointer-events-auto modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <input type="hidden" value="<?= $item['KODE']; ?>" name="KODE_LAMA">
                <h3 class="font-bold text-lg">Aksi Supplier</h3>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="WILAYAH_ID">Wilayah: </label>
                    </label>
                    <label class="input-group">
                        <span>Wilayah:</span>
                        <select class="input input-bordered" name="WILAYAH_ID" id="WILAYAH_ID">
                            <?php
                            $wilayah = query("SELECT * FROM wilayah");
                            foreach ($wilayah as $w) : ?>
                                <option <?php if ($w === $item['WILAYAH_ID']) {
                                            echo 'seleceted';
                                        } ?> value="<?= $w['KODE']; ?>"><?= $w["KETERANGAN"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <div class="flex">
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="KODE">Kode: </label>
                        </label>
                        <label class="input-group">
                            <span>Kode:</span>
                            <input value="<?= $item['KODE']; ?>" required type="text" name="KODE" id="KODE" class="input input-bordered">
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="KODE_BARCODE">Barcode: </label>
                        </label>
                        <label class="input-group">
                            <span>Barcode:</span>
                            <input value="<?= $item['KODE_BARCODE']; ?>" required type="text" name="KODE_BARCODE" id="KODE_BARCODE" class="input input-bordered">
                        </label>
                    </div>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="NAMA">Nama: </label>
                    </label>
                    <label class="input-group">
                        <span>Nama:</span>
                        <input value="<?= $item['NAMA']; ?>" type="text" name="NAMA" id="NAMA" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="ALAMAT">Alamat: </label>
                    </label>
                    <label class="input-group">
                        <span>Alamat:</span>
                        <input value="<?= $item['ALAMAT']; ?>" type="text" name="ALAMAT" id="ALAMAT" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="ALAMAT2">Alamat 2: </label>
                    </label>
                    <label class="input-group">
                        <span>Alamat 2:</span>
                        <input value="<?= $item['ALAMAT2']; ?>" type="text" name="ALAMAT2" id="ALAMAT2" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="KONTAK">Kontak: </label>
                    </label>
                    <label class="input-group">
                        <span>Kontak:</span>
                        <input value="<?= $item['KONTAK']; ?>" type="text" name="KONTAK" id="KONTAK" class="input input-bordered">
                    </label>
                </div>
                <div class="flex">
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="NPWP">NPWP: </label>
                        </label>
                        <label class="input-group">
                            <span>NPWP:</span>
                            <input value="<?= $item['NPWP']; ?>" type="text" name="NPWP" id="NPWP" class="input input-bordered">
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="TELEPON">Telepon: </label>
                        </label>
                        <label class="input-group">
                            <span>Telepon:</span>
                            <input value="<?= $item['TELEPON']; ?>" type="tel" name="TELEPON" id="TELEPON" class="input input-bordered">
                        </label>
                    </div>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="JATUH_TEMPO">Jatuh Tempo: </label>
                    </label>
                    <label class="input-group">
                        <span>Jatuh Tempo:</span>
                        <input value="<?= $item['JATUH_TEMPO']; ?>" type="number" value="0" name="JATUH_TEMPO" id="JATUH_TEMPO" class="input input-bordered">
                        <span> Hari</span>
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="PLAFON_HUTANG">Plafon Hutang: </label>
                    </label>
                    <label class="input-group">
                        <span>Plafon Hutang:</span>
                        <input type="number" value="<?= $item['PLAFON_HUTANG']; ?>" name="PLAFON_HUTANG" id="PLAFON_HUTANG" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label for="DEF" class="cursor-pointer label justify-start gap-4">
                        <span class="label-text">Default</span>
                        <input id="DEF" name="DEF" type="checkbox" class="checkbox checkbox-success" value="1" />
                    </label>
                </div>
                <div class="modal-action">
                    <div class="tooltip tooltip-error" data-tip="CTRL + Q">
                        <button id="hapus" name="hapus" class="btn btn-error" type="submit">Hapus</button>
                    </div>
                    <div class="tooltip" data-tip="ESC (Tekan Lama)">
                        <a id="batal" href="Supplier.php" for="my-modal-edit" class="btn">Batal</a>
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