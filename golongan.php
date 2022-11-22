<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$item = query("SELECT * FROM golongan ORDER BY KETERANGAN ASC");

if (isset($_POST["submit"])) {

    // cek apakah daata berhasil diubah
    if (tambahGolongan($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menambah Golongan Baru');
        document.location.href = 'golongan.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["ubah"])) {

    // cek apakah daata berhasil diubah
    if (ubahGolongan($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Memperbaiki golongan');
        document.location.href = 'golongan.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["hapus"])) {

    // cek apakah daata berhasil diubah
    if (hapusGolongan($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menghapus golongan');
        document.location.href = 'golongan.php';
        </script>
        ";
    } else {
        echo mysqli_error($conn);
    }
}

$title = "Golongan - $username";
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
    <h1 class="text-2xscl font-semibold">Golongan</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>

    <label for="my-modal-6" class="btn btn-success mb-4">Tambah Golongan</label>
    <div class="overflow-x-auto">
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
                        <td><a tabindex="1" href="golongan.php?kode=<?= $i['KODE']; ?>"><i class="fa-solid fa-pen-to-square text-sky-500 scale-150"></i></a></td>
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
                <h3 class="font-bold text-lg">Golongan</h3>
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
                    <label for="my-modal-6" id="batal" class="btn">Batal</label>
                    <button id="tambah" name="submit" class="btn btn-success" type="submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($_GET['kode'])) : ?>
    <?php
    $kode = $_GET['kode'];
    $item = query("SELECT * FROM golongan WHERE KODE = '$kode'")[0];
    ?>
    <input type="checkbox" checked id="my-modal-edit" class="modal-toggle" />
    <div class="modal visible opacity-100 pointer-events-auto modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <input type="hidden" value="<?= $item['KODE']; ?>" name="KODE_LAMA">
                <h3 class="font-bold text-lg">Aksi Golongan</h3>
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
                    <button id="hapus" name="hapus" class="btn btn-error" type="submit">Hapus</button>
                    <a id="batal" href="golongan.php" for="my-modal-edit" class="btn">Batal</a>
                    <button id="tambah" name="ubah" class="btn btn-success" type="submit">Perbaiki</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
<?php
include('shared/footer.php');
?>