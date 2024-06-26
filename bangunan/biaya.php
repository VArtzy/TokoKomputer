<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$nom = '5';
if (!in_array($nom, $aksesMenu)) return header('Location: admin.php');
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';

$item = query("SELECT * FROM Biaya ORDER BY KETERANGAN ASC");

if (isset($_POST["submit"])) {

    // cek apakah daata berhasil diubah
    if (tambahBiaya($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menambah Biaya Baru');
        document.location.href = 'Biaya.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["ubah"])) {

    // cek apakah daata berhasil diubah
    if (ubahBiaya($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Memperbaiki Biaya');
        document.location.href = 'Biaya.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["hapus"])) {

    // cek apakah daata berhasil diubah
    if (hapusBiaya($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menghapus Biaya');
        document.location.href = 'Biaya.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

$title = "Biaya - $username";
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
    <h1 class="text-2xl font-semibold">Biaya</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>

    <?php if (isset($aksi[0]) && $aksi[0] === '1') : ?>
        <div class="tooltip tooltip-success tooltip-right" data-tip="ESC">
            <label for="my-modal-6" class="btn btn-success mb-4">Tambah Biaya</label>
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
                    <th>No. </th>
                    <th>Kode</th>
                    <th>Keterangan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($item as $key => $i) : ?>
                    <tr>
                        <td><?= $key + 1; ?></td>
                        <td><?= $i['KODE']; ?></td>
                        <td><?= $i['KETERANGAN']; ?></td>
                        <td>
                            <div class="tooltip tooltip-info tooltip-right" data-tip="Enter">
                                <a tabindex="1" href="Biaya.php?kode=<?= $i['KODE']; ?>"><i class="fa-solid fa-pen-to-square text-sky-500 scale-150"></i></a>
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
                <h3 class="font-bold text-lg">Biaya</h3>
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
                        <label class="label-text" for="KETERANGAN">Keterangan: </label>
                    </label>
                    <label class="input-group">
                        <span>Keterangan:</span>
                        <input type="text" name="KETERANGAN" id="KETERANGAN" class="input input-bordered">
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
    $item = query("SELECT * FROM Biaya WHERE KODE = '$kode'")[0];
    ?>
    <input type="checkbox" checked id="my-modal-edit" class="modal-toggle" />
    <div class="modal visible opacity-100 pointer-events-auto modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <input type="hidden" value="<?= $item['KODE']; ?>" name="KODE_LAMA">
                <h3 class="font-bold text-lg">Aksi Biaya</h3>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="KODE">Kode: </label>
                    </label>
                    <label class="input-group">
                        <span>Kode:</span>
                        <input value="<?= $item['KODE']; ?>" type="text" name="KODE" id="KODE" class="input input-bordered">
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
                <div class="modal-action">
                    <?php if (isset($aksi[2]) && $aksi[2] === '1') : ?>
                        <div class="tooltip tooltip-error" data-tip="CTRL + Q">
                            <button id="hapus" name="hapus" class="btn btn-error" type="submit">Hapus</button>
                        </div>
                    <?php endif; ?>
                    <div class="tooltip" data-tip="ESC (Tekan Lama)">
                        <a id="batal" href="Biaya.php" for="my-modal-edit" class="btn">Batal</a>
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