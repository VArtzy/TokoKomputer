<?php
require_once 'utils/functions.php';
require_once 'utils/loggedAdmin.php';

$nom = '15';
if (!in_array($nom, $aksesMenu)) return header('Location: admin.php');
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';

$nota = $_GET['nota'];

$notas = query("SELECT DISKON, PPN, CUSTOMER_ID, STATUS_NOTA, STATUS_BAYAR, SALESMAN_ID, TANGGAL, TEMPO, TOTAL_NOTA, TOTAL_PELUNASAN_NOTA, KETERANGAN, PROFIT, OPERATOR, LOKASI_ID FROM JUAL WHERE NOTA = '$nota'")[0];
$salesman = query("SELECT KODE, NAMA FROM salesman");
if (!empty(query("SELECT * FROM CUSTOMER WHERE KODE = '" . $notas['CUSTOMER_ID'] . "'")[0])) {
    $namaPelanggan = query("SELECT * FROM CUSTOMER WHERE KODE = '" . $notas['CUSTOMER_ID'] . "'")[0];
}

$item = query("SELECT * FROM ITEM_JUAL WHERE nota = '$nota'");

if (isset($_POST["submit"])) {
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

        if (ubahJualItemNota($BARANG_ID, $JUMLAH_BARANG, $HARGA_BELI, $HARGA_JUAL, $DISKON1, $DISKON2, $DISKON3, $DISKON4, $DISKON_RP, $SATUAN, $_POST['KETERANGAN'], $KET1, $KET2, $IMEI) > 0) {
        } else {
            echo mysqli_error($conn);
        }
    }

    if (ubahNota($nota, $username, $_POST) > 0) {
        echo  "<script>
    alert('Berhasil mengubah invoices nota $nota!');
        document.location.href = 'invoices.php';
        </script>";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["hapus"])) {
    if (hapusJual($nota) > 0) {
        echo  "<script>
    alert('Berhasil menghapus invoices nota $nota!');
        document.location.href = 'invoices.php';
        </script>";
    } else {
        echo mysqli_error($conn);
    }
}

if (empty($item)) {
    return header('location: invoices.php');
}

$title = "Detail Invoices - " . $nota;
include('shared/navadmin.php');
?>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>
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
        $('#ui-id-1').css('z-index', 1000)
    });
</script>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">

    <h1 class="text-2xl mb-8 font-semibold">Details Nota <?= $nota; ?></h1>

    <a class="btn btn-warning mb-8" href="invoices.php">Kembali</a>
    <label for="my-modal-6" class="btn btn-success">Proses nota</label>

    <div class="flex gap-4 mb-4">
        <p class="font-semibold text-lg">Total Harga <span class="badge badge-lg badge-info mb-2"><?= rupiah(round($notas["TOTAL_NOTA"])); ?></span></p>
        <p>Status Nota <span class="badge mb-2"><?= $notas["STATUS_NOTA"]; ?></span></p>
        <p>Status Bayar <span class="badge badge-warning"><?= $notas["STATUS_BAYAR"]; ?></span></p>
        <p>Pelanggan <span class="badge badge-primary"><?php if (!empty($namaPelanggan)) {
                                                            echo $namaPelanggan["NAMA"];
                                                        } else {
                                                            echo $notas['CUSTOMER_ID'];
                                                        }; ?></span></p>
        <p>Tanggal Pemesanan <span class="badge badge-primary"><?= $notas["TANGGAL"]; ?></span></p>
        <p>Total Pelunasan Nota <span class="badge badge-primary"><?= $notas["TOTAL_PELUNASAN_NOTA"]; ?></span></p>
        <p>Profit <span class="badge badge-primary"><?= $notas["PROFIT"]; ?></span></p>
        <p>Lokasi <span class="badge badge-primary"><?= $notas["LOKASI_ID"]; ?></span></p>
    </div>
    <div class="flex gap-4">
        <p>Salesman <span class="badge badge-primary"><?= query("SELECT NAMA FROM salesman WHERE KODE = '" . $notas['SALESMAN_ID'] . "'")[0]['NAMA']; ?></span>
        <p>Operator <span class="badge badge-primary"><?= query("SELECT NAMA FROM user_admin WHERE ID = " . $notas['OPERATOR'])[0]['NAMA']; ?></span></p>
    </div>
    <?php if (!empty($namaPelanggan)) : ?>
        <div class="flex gap-4">
            <p>Alamat <span class="badge"><?= $namaPelanggan["ALAMAT"]; ?></span></p>
            <p>Wilayah <span class="badge"><?= query("SELECT KETERANGAN FROM wilayah WHERE KODE ='" . $namaPelanggan['WILAYAH_ID'] . "'")[0]["KETERANGAN"]; ?></span></p>
            <p>Kota <span class="badge"><?= $namaPelanggan["KOTA"]; ?></span></p>
            <a href="https://wa.me/<?php
                                    if ($namaPelanggan['TELEPON'][0] === '0') {
                                        echo '62' . substr($namaPelanggan['TELEPON'], 1) . "/?text=Hai%20pelangan%20" . $namaPelanggan['NAMA'] . ",%20...";
                                    } else {
                                        echo $namaPelanggan['TELEPON'] . "/?text=Hai%20pelangan%20" . $namaPelanggan['NAMA'] . ",%20...";
                                    }
                                    ?>"><i class="fa-brands fa-whatsapp"></i> <span class=" badge"><?= $namaPelanggan["TELEPON"]; ?></span></a>
        </div>
    <?php else : ?>

        <p><span class="text-rose-600">Sepertinya Customer belum terdaftar</span>. Untuk memenuhi Informasi, silahkan <a href="langganan.php" class="link link-success">daftarkan customer</a>.</p>

    <?php endif; ?>

    <div class="overflow-x-auto w-full mt-8 mb-4">
        <table class="table w-full">
            <!-- head -->
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Stok/Satuan</th>
                    <th>Diskon</th>
                    <th>Jumlah/Harga</th>
                    <th>Garansi/Poin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($item as $i) {
                    $brg = query("SELECT * FROM BARANG a LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID where a.KODE = " . $i['BARANG_ID']);
                    foreach ($brg as $b) : ?>
                        <tr>
                            <td>
                                <div class="flex items-center space-x-3">
                                    <div class="avatar">
                                        <div class="mask mask-squircle w-12 h-12">
                                            <img width="50px" height="50px" src="<?= $b["FOTO"]; ?>" alt="<?= $b["FOTO"]; ?>" />
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold"><?= $b["NAMA"]; ?></div>
                                        <div class="text-sm opacity-50"><?= $b["KODE"]; ?></div>
                                    </div>
                                </div>
                            </td>
                            <td> Jumlah: <?= $i['JUMLAH'] * query("SELECT KONVERSI FROM satuan where KODE = '" . $b['SATUAN_ID'] . "'")[0]['KONVERSI']; ?>
                                <br />
                                Stok: <?= round($b["STOK"]); ?>
                                <br />
                                Satuan: <?= query("SELECT KONVERSI FROM satuan where KODE = '" . $b['SATUAN_ID'] . "'")[0]['KONVERSI']; ?> (<?= query("SELECT NAMA FROM satuan where KODE = '" . $b['SATUAN_ID'] . "'")[0]['NAMA']; ?>)
                            </td>
                            <td>
                                Diskon: <?= $b["DISKON_RP"]; ?>
                                <br />
                                <span class="badge badge-ghost badge-sm">Diskon General: <?= $b["DISKON_GENERAL"]; ?></span>
                                <br />
                                <span class="badge badge-sm">Diskon Silver: <?= $b["DISKON_SILVER"]; ?></span>
                                <br />
                                <span class="badge badge-warning badge-sm">Diskon Gold: <?= $b["DISKON_GOLD"]; ?></span>
                            </td>
                            <th>
                                <span class="text-sm font-semibold opacity-70"><?= rupiah($b["HARGA_JUAL"]); ?></span>
                                <br>
                                <span class="text-sm font-semibold opacity-70"><?= rupiah($b["HARGA_JUAL"] * $i["JUMLAH"]); ?></span>
                                <br>
                            </th>
                            <th>
                                <span class="badge mb-2"><?= $b["GARANSI"]; ?></span>
                                <br>
                                <span class="badge badge-warning"><?= $b["POIN"]; ?></span>
                            </th>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <input type="checkbox" id="my-modal-6" class="modal-toggle" />
    <div class="modal modal-bottom p-4">
        <div class="modal-box w-11/12 max-w-6xl">
            <form action="" method="POST">
                <h3 class="font-bold text-lg">Edit Invoices <?= $nota; ?></h3>
                <div class="flex gap-4">
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="STATUS_NOTA">Status: </label>
                        </label>
                        <label class="input-group">
                            <span>Status:</span>
                            <input type="text" value="<?= $notas['STATUS_NOTA']; ?>" name="STATUS_NOTA" maxlength="1" id="STATUS_NOTA" class="input input-bordered">
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="TEMPO">Tempo: </label>
                        </label>
                        <label class="input-group">
                            <span>Tempo:</span>
                            <input type="date" name="TEMPO" id="TEMPO" value="<?= $notas['TEMPO']; ?>" class="input input-bordered">
                        </label>
                    </div>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="TANGGAL">Tanggal: </label>
                    </label>
                    <label class="input-group">
                        <span>Tanggal:</span>
                        <input type="date" name="TANGGAL" id="TANGGAL" value="<?= $notas['TANGGAL']; ?>" class="input input-bordered">
                    </label>
                </div>
                <div class="flex gap-4">
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="CUSTOMER_ID">Langganan: </label>
                        </label>
                        <label class="input-group">
                            <span>Langganan:</span>
                            <input value="<?= $notas['CUSTOMER_ID'] ?>" required type="text" name="CUSTOMER_ID" id="CUSTOMER_ID" class="input input-bordered">
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
                                $lokasi = query("SELECT * FROM lokasi");
                                foreach ($lokasi as $l) : ?>
                                    <option <?php if ($l['KODE'] === $notas['LOKASI_ID']) {
                                                echo 'selected';
                                            } ?> value="<?= $l['KODE']; ?>"><?= $l["KETERANGAN"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="SALESMAN_ID">Salesman ID: </label>
                        </label>
                        <label class="input-group">
                            <span>Salesman ID:</span>
                            <select class="input input-bordered" name="SALESMAN_ID" id="SALESMAN_ID">
                                <?php foreach ($salesman as $s) : ?>
                                    <option <?php if ($s['KODE'] === $notas['SALESMAN_ID']) {
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
                            <input type="text" name="KETERANGAN" value="<?= $notas['KETERANGAN']; ?>" id="KETERANGAN" class="input input-bordered">
                        </label>
                    </div>
                </div>
                <div class="overflow-x-auto w-full mt-8 mb-4">
                    <table class="table w-full">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Stok/Satuan</th>
                                <th>Diskon</th>
                                <th>Harga Jual</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $item_jual = query("SELECT * FROM item_jual where NOTA = '$nota'");
                            foreach ($item_jual as $b) :
                            ?>
                                <tr>
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <input name="BARANG_ID[]" id="BARANG_ID[]" value="<?= $b["BARANG_ID"]; ?>" type="hidden">
                                            <div class="text-sm opacity-50"><?= $b["BARANG_ID"]; ?></div>
                                        </div>
                </div>
        </div>
        </td>
        <td>
            IMEI: <input type="text" name="IMEI[]" id="IMEI[]">
            <br />
            <?php $BARANG_ID = $b["BARANG_ID"]; ?>
            Jumlah: <input type="number" name="JUMLAH_BARANG[]" id="JUMLAH_BARANG[]" value="<?= $b['JUMLAH']; ?>" max="<?= $b['JUMLAH'] + query("SELECT STOK FROM BARANG WHERE KODE = '$BARANG_ID'")[0]['STOK'] ?>">
            <br />
            Satuan: <input type="text" name="SATUAN[]" id="SATUAN[]" value="<?= $b['DAFTAR_SATUAN']; ?>">
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
            <input type="hidden" name="HARGA_BELI[]" id="HARGA_BELI[]" class="text-sm font-semibold opacity-70" value="<?= $b["HARGA_BELI"]; ?>"></input>
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
    </tbody>
    </table>
    </div>
    <div class="form-control">
        <label class="label">
            <label class="label-text" for="PPN">PPN: </label>
        </label>
        <label class="input-group">
            <span>PPN:</span>
            <input type="number" value="<?= $notas['PPN']; ?>" name="PPN" id="PPN" class="input input-bordered">
        </label>
    </div>
    <div class="form-control">
        <label class="label">
            <label class="label-text" for="DISKON">Diskon: </label>
        </label>
        <label class="input-group">
            <span>Diskon:</span>
            <input type="number" value="<?= $notas['DISKON']; ?>" name="DISKON" id="DISKON" class="input input-bordered">
        </label>
    </div>
    <div class="modal-action">
        <?php if (isset($aksi[2]) && $aksi[2] === '1') : ?>
            <button name="hapus" class="btn btn-error" type="submit">Hapus</button>
        <?php endif; ?>
        <label for="my-modal-6" class="btn">Batal</label>
        <?php if (isset($aksi[1]) && $aksi[1] === '1') : ?>
            <button name="submit" class="btn btn-success" type="submit">Perbaiki</button>
        <?php endif; ?>
    </div>
    </form>
    </div>
    </div>

</main>

<?php
include('shared/footer.php')
?>