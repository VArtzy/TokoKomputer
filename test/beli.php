<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$nom = '13';
if (!in_array($nom, $aksesMenu)) return header('Location: admin.php');
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';

$item = query("select a.TANGGAL, a.TEMPO, a.TANGGAL, a.SUPPLIER_ID, a.OPERATOR, a.NOTA, b.NAMA, a.KETERANGAN, a.STATUS_NOTA, a.STATUS_BAYAR, (select SUM(jumlah*harga_beli) from item_beli where nota = a.nota) AS HUTANG, (select SUM(jumlah*harga_beli) from item_beli where nota = a.nota) - (select sum(nominal-diskon-retur-diskon_rp) from item_pelunasan_hutang where nota_beli = a.nota) as SISA_HUTANG from beli a LEFT JOIN supplier b ON a.SUPPLIER_ID = b.KODE ORDER BY TANGGAL DESC LIMIT 0, 20;");

if (isset($_GET['nota'])) $nota = $_GET['nota'];

if (isset($_POST["tambah_item"])) {
    if (tambahBeliItemNota($_POST['KODE_LAMA'], $_POST['TAMBAH_BARANG_ID'], $_POST['TAMBAH_JUMLAH_BARANG'], $_POST['TAMBAH_HARGA_BELI'], $_POST['TAMBAH_HARGA_JUAL'], $_POST['TAMBAH_DISKON1'], $_POST['TAMBAH_DISKON2'], $_POST['TAMBAH_DISKON3'], $_POST['TAMBAH_DISKON4'], $_POST['TAMBAH_DISKON_RP'], $_POST['TAMBAH_SATUAN'], $_POST['KETERANGAN'], $_POST['TAMBAH_KET1'], $_POST['TAMBAH_KET2'], $_POST['TAMBAH_IMEI']) > 0) {
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["ubah"])) {

    $TOTAL = 0;

    foreach ($_POST['BARANG_ID'] as $i => $d) {
        $BARANG_ID = $_POST['BARANG_ID'][$i];
        $IMEI = $_POST['IMEI'][$i];
        $JUMLAH_BARANG = $_POST['JUMLAH_BARANG'][$i];
        $HARGA_BELI = $_POST['HARGA_BELI'][$i];
        $DISKON1 = $_POST['DISKON1'][$i];
        $DISKON2 = $_POST['DISKON2'][$i];
        $DISKON3 = $_POST['DISKON3'][$i];
        $DISKON4 = $_POST['DISKON4'][$i];
        $DISKON_RP = $_POST['DISKON_RP'][$i];
        $HARGA_JUAL = $_POST['HARGA_JUAL'][$i];
        $KET1 = $_POST['KET1'][$i];
        $KET2 = $_POST['KET2'][$i];
        $SATUAN = $_POST['SATUAN'][$i];

        $TOTAL = $TOTAL + $JUMLAH_BARANG * $HARGA_BELI;

        if (ubahBeliItemNota($BARANG_ID, $JUMLAH_BARANG, $HARGA_BELI, $HARGA_JUAL, $DISKON1, $DISKON2, $DISKON3, $DISKON4, $DISKON_RP, $SATUAN, $_POST['KETERANGAN'], $KET1, $KET2, $IMEI) > 0) {
        } else {
            echo mysqli_error($conn);
        }
    }

    // cek apakah daata berhasil diubah
    if (ubahBeli($nota, $username, $TOTAL, $_POST) > 0) {
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
        echo "<script>
        alert('Berhasil Menghapus Beli');
        document.location.href = 'Beli.php';
        </script>
        ";
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

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
                $("#pilihbarang")[0].click();
            }
        });
    })

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
        $("#TAMBAH_BARANG_ID").autocomplete({
            id: '',
            source: function(request, response) {
                $.ajax({
                    url: "ajax/itemid.php",
                    dataType: "json",
                    data: {
                        q: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $.ajax({
                    url: "ajax/hargabarangid.php",
                    dataType: "json",
                    data: {
                        q: ui.item.value
                    },
                    success: function(data) {
                        $("#TAMBAH_HARGA_BELI").val(data[0]).change();
                        $("#TAMBAH_HARGA_JUAL").val(data[1]).change();
                    }
                });
            }
        });
        $('#ui-id-1').css('z-index', 1000)
        $('#ui-id-2').css('z-index', 1000)
    });
</script>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Beli</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>

    <div class="tooltip tooltip-success tooltip-right" data-tip="ESC">
        <?php if (isset($aksi[0]) && $aksi[0] === '1') : ?>
            <a id="pilihbarang" class="btn btn-success mb-4" href="pilihBarangBeli.php">Tambah Beli</a>
        <?php endif; ?>
    </div>
    <a class="btn btn-info text-sm mb-8" href="barangTerbeli.php">Lihat Records Barang Terbeli</a>
    <a class="btn btn-info text-sm mb-8" href="pembelianNota.php">Pelunasan Hutang</a>

    <div class="overflow-x-auto">
        <p class="badge badge-sm">Next Row (Tab)</p>
        <p class="badge badge-sm">Previous Row (Shift + Tab)</p>
        <p class="badge badge-sm">Convert To Excel (CTRL + E)</p>
        <p class="badge badge-sm">Convert To PDF (CTRL + F)</p>

        <table id="table" class="table table-compact w-full">
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
                        <td class="max-w-[10ch] text-ellipsis overflow-hidden"><?php if (isset(query("SELECT NAMA FROM supplier WHERE KODE = '" . $i['SUPPLIER_ID'] . "'")[0]['NAMA'])) {
                                                                                    echo query("SELECT NAMA FROM supplier WHERE KODE = '" . $i['SUPPLIER_ID'] . "'")[0]['NAMA'];
                                                                                } else {
                                                                                    echo $i['SUPPLIER_ID'];
                                                                                } ?></td>
                        <td class="max-w-[20ch] text-ellipsis overflow-hidden"><?= $i['KETERANGAN']; ?></td>
                        <td><?= rupiah($i['HUTANG']); ?></td>
                        <td><?php if ($i['SISA_HUTANG']) {
                                echo rupiah($i['SISA_HUTANG']);
                            } else {
                                echo rupiah($i['HUTANG']);
                            } ?></td>
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

<?php if (isset($_GET['nota'])) : ?>
    <?php
    $nota = $_GET['nota'];
    $item = query("SELECT * FROM Beli WHERE NOTA = '$nota'")[0];
    ?>
    <input type="checkbox" checked id="my-modal-edit" class="modal-toggle" />
    <div class="modal modal-bottom p-4">
        <div class="modal-box w-11/12 max-w-6xl">
            <form action="" method="POST">
                <input type="hidden" value="<?= $item['NOTA']; ?>" name="KODE_LAMA">
                <h3 class="font-bold text-lg">Aksi Beli</h3>
                <div class="flex gap-4">
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="STATUS_NOTA">Status: </label>
                        </label>
                        <label class="input-group">
                            <span>Status:</span>
                            <input readonly class="input input-bordered" name="STATUS_NOTA" id="STATUS_NOTA" value="<?= $item['STATUS_NOTA']; ?>">
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="TANGGAL">Tempo: </label>
                        </label>
                        <label class="input-group">
                            <span>Tempo:</span>
                            <input value="<?= $item['TEMPO']; ?>" type="date" name="TANGGAL" id="TANGGAL" class="input input-bordered">
                        </label>
                    </div>
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
                        <input value="<?= $item['SUPPLIER_ID'] ?>" required type="text" name="SUPPLIER_ID" id="SUPPLIER_ID" class="input input-bordered">
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
                                <th>No. </th>
                                <th>Nama</th>
                                <th>Stok/Satuan</th>
                                <th>Diskon</th>
                                <th>Harga Beli/Jual</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $item_beli = query("SELECT * FROM item_beli where NOTA = '$nota'");
                            foreach ($item_beli as $key => $b) :
                            ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td>
                                        <div class="items-center space-x-3">
                                            <input name="BARANG_ID[]" id="BARANG_ID[]" value="<?= $b["BARANG_ID"]; ?>" type="hidden">
                                            <div class="font-bold"><?= query("SELECT NAMA FROM BARANG where KODE = " . $b['BARANG_ID'])[0]['NAMA']; ?></div>
                                            <div class="text-sm opacity-50"><?= $b["BARANG_ID"]; ?></div>
                                            <div class="text-sm opacity-50"><?= query("SELECT KODE_BARCODE FROM BARANG where KODE = " . $b['BARANG_ID'])[0]['KODE_BARCODE']; ?></div>
                                        </div>
                </div>
        </div>
        </td>
        <td>
            IMEI: <input type="text" name="IMEI[]" id="IMEI[]">
            <br />
            Jumlah: <input type="number" name="JUMLAH_BARANG[]" id="JUMLAH_BARANG[]" value="<?= $b['JUMLAH']; ?>">
            <br />
            Satuan: <select tabindex="1" type="text" name="SATUAN[]" id="SATUAN[]"><?php
                                                                                    $satuan = query("SELECT * FROM satuan");
                                                                                    foreach ($satuan as $l) : ?>
                    <option <?php if ($l['KODE'] === $b['DAFTAR_SATUAN']) {
                                                                                            echo 'selected';
                                                                                        } ?> value="<?= $l['KODE']; ?>"><?= $l["NAMA"]; ?></option>
                <?php endforeach; ?>
            </select>
            <br />
        </td>
        <td>
            % Rupiah: <input value="0" type="number" name="DISKON_RP[]" id="DISKON_RP[]">
            <br />
            <span class="badge badge-ghost badge-sm">%1: <input value="0" type="number" name="DISKON1[]" id="DISKON1[]"></span>
            <br />
            <span class="badge badge-ghost badge-sm">%2: <input value="0" type="number" name="DISKON2[]" id="DISKON2[]"> </span>
            <br />
            <span class="badge badge-ghost badge-sm">%3: <input value="0" type="number" name="DISKON3[]" id="DISKON3[]"> </span>
            <br />
            <span class="badge badge-ghost badge-sm">%4: <input value="0" type="number" name="DISKON4[]" id="DISKON4[]"> </span>
        </td>
        <th>
            <input name="HARGA_BELI[]" id="HARGA_BELI[]" class="text-sm font-semibold opacity-70" value="<?= $b["HARGA_BELI"]; ?>"></input>
            <br>
            <input name="HARGA_JUAL[]" id="HARGA_JUAL[]" class="text-sm font-semibold opacity-70" value="<?= $b["HARGA_JUAL"]; ?>"></input>
            <br>
        </th>
        <th>
            KET1: <input type="text" name="KET1[]" id="KET1[]" value="<?= $b["KET1"]; ?>" class="text-sm opacity-70"></input>
            <br>
            KET2: <input type="text" name="KET2[]" id="KET2[]" value="<?= $b["KET2"]; ?>" class="text-sm opacity-70"></input>
        </th>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td>+</td>
        <td>
            <div class="items-center space-x-3">
                <input class="input input-bordered input-xs" name="TAMBAH_BARANG_ID" placeholder="KODE BARANG" id="TAMBAH_BARANG_ID" type="text">
                <button class="badge badge-success" type="submit" name="tambah_item">Tambah Item</button>
            </div>
    </div>
    </div>
    </td>
    <td>
        IMEI: <input class="input input-bordered input-xs" type="text" name="TAMBAH_IMEI" id="TAMBAH_IMEI">
        <br />
        Jumlah: <input class="input input-bordered input-xs" type="number" name="TAMBAH_JUMLAH_BARANG" id="TAMBAH_JUMLAH_BARANG"> <br />
        Satuan: <select tabindex="1" type="text" name="TAMBAH_SATUAN" id="TAMBAH_SATUAN"><?php
                                                                                            $satuan = query("SELECT * FROM satuan");
                                                                                            foreach ($satuan as $l) : ?>
                <option value="<?= $l['KODE']; ?>"><?= $l['NAMA']; ?></option>
            <?php endforeach; ?>
        </select>
        <br />
    </td>
    <td>
        % Rupiah: <input value="0" class="input input-bordered input-xs" name=" TAMBAH_DISKON_RP" id="TAMBAH_DISKON_RP">
        <br />
        <span class="badge badge-ghost badge-sm">%1: <input value="0" class="input input-bordered input-xs" name="TAMBAH_DISKON1" id="TAMBAH_DISKON1"></span>
        <br />
        <span class="badge badge-ghost badge-sm">%2: <input value="0" class="input input-bordered input-xs" name="TAMBAH_DISKON2" id="TAMBAH_DISKON2"> </span>
        <br />
        <span class="badge badge-ghost badge-sm">%3: <input value="0" class="input input-bordered input-xs" name="TAMBAH_DISKON3" id="TAMBAH_DISKON3"> </span>
        <br />
        <span class="badge badge-ghost badge-sm">%4: <input value="0" class="input input-bordered input-xs" name="TAMBAH_DISKON4" id="TAMBAH_DISKON4"> </span>
    </td>
    <th>
        <input class="input input-bordered input-xs" name="TAMBAH_HARGA_BELI" id="TAMBAH_HARGA_BELI" class="text-sm font-semibold opacity-70" input>
        <br>
        <input class="input input-bordered input-xs" name="TAMBAH_HARGA_JUAL" id="TAMBAH_HARGA_JUAL" class="text-sm font-semibold opacity-70" input>
        <br>
    </th>
    <th>
        KET1: <input class="input input-bordered input-xs" type="text" name="TAMBAH_KET1" id="TAMBAH_KET1" class="text-sm opacity-70"></input>
        <br>
        KET2: <input class="input input-bordered input-xs" type="text" name="TAMBAH_KET2" id="TAMBAH_KET2" class="text-sm opacity-70"></input>
    </th>
    </tr>
    </tbody>
    </table>
    </div>
    <div class="form-control">
        <label class="label">
            <label class="label-text" for="DISKON">Diskon: </label>
        </label>
        <label class="input-group">
            <span>Diskon:</span>
            <input value="<?= $item['DISKON']; ?>" type="text" name="DISKON" id="DISKON" class="input input-bordered">
        </label>
    </div>
    <div class="form-control">
        <label class="label">
            <label class="label-text" for="PPN">PPN: </label>
        </label>
        <label class="input-group">
            <span>PPN:</span>
            <input value="<?= $item['PPN']; ?>" type="text" name="PPN" id="PPN" class="input input-bordered">
        </label>
    </div>
    <div class="modal-action">
        <?php if (isset($aksi[2]) && $aksi[2] === '1') : ?>
            <div class="tooltip tooltip-error" data-tip="CTRL + Q">
                <button id="hapus" name="hapus" class="btn btn-error" type="submit">Hapus</button>
            </div>
        <?php endif; ?>
        <div class="tooltip" data-tip="ESC (Tekan Lama)">
            <a id="batal" href="Beli.php" for="my-modal-edit" class="btn">Batal</a>
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