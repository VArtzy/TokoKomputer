<?php
require_once 'utils/functions.php';
require_once 'utils/loggedAdmin.php';

$nom = '15';
if (!in_array($nom, $aksesMenu)) return header('Location: admin.php');
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';

if (!isset($_SESSION['hapus']) && empty($_SESSION['hapus'])) $_SESSION['hapus'] = array();
if (!isset($_SESSION['tambah']) && empty($_SESSION['tambah'])) $_SESSION['tambah'] = array();
if (!isset($_GET['nota']) && !isset($_SESSION['hapus']) && empty($_SESSION['hapus'])) $_SESSION['hapus'] = array();
if (!isset($_GET['nota']) && !isset($_SESSION['tambah']) && empty($_SESSION['tambah'])) $_SESSION['tambah'] = array();

$nota = $_GET['nota'];

if (isset($_POST["tambah_item"])) {
    array_push($_SESSION['tambah'], array("KODE_LAMA" => $_POST['KODE_LAMA'], "TAMBAH_BARANG_ID" => $_POST['TAMBAH_BARANG_ID'], "TAMBAH_JUMLAH_BARANG" => $_POST['TAMBAH_JUMLAH_BARANG'], "TAMBAH_HARGA_BELI" => $_POST['TAMBAH_HARGA_BELI'], "TAMBAH_HARGA_JUAL" => $_POST['TAMBAH_HARGA_JUAL'], "TAMBAH_DISKON1" => $_POST['TAMBAH_DISKON1'], "TAMBAH_DISKON2" => $_POST['TAMBAH_DISKON2'], "TAMBAH_DISKON3" => $_POST['TAMBAH_DISKON3'], "TAMBAH_DISKON4" => $_POST['TAMBAH_DISKON4'], "TAMBAH_DISKON_RP" => $_POST['TAMBAH_DISKON_RP'], "TAMBAH_SATUAN" => $_POST['TAMBAH_SATUAN'], "KETERANGAN" => $_POST['KETERANGAN'], "TAMBAH_KET1" => $_POST['TAMBAH_KET1'], "TAMBAH_KET2" => $_POST['TAMBAH_KET2'], "TAMBAH_IMEI" => $_POST['TAMBAH_IMEI']));
}

$notas = query("SELECT DISKON, PPN, CUSTOMER_ID, STATUS_NOTA, STATUS_BAYAR, SALESMAN_ID, TANGGAL, TEMPO, TOTAL_NOTA, TOTAL_PELUNASAN_NOTA, KETERANGAN, PROFIT, OPERATOR, LOKASI_ID FROM JUAL WHERE NOTA = '$nota'")[0];
$salesman = query("SELECT KODE, NAMA FROM salesman");
if (!empty(query("SELECT * FROM CUSTOMER WHERE KODE = '" . $notas['CUSTOMER_ID'] . "'")[0])) {
    $namaPelanggan = query("SELECT * FROM CUSTOMER WHERE KODE = '" . $notas['CUSTOMER_ID'] . "'")[0];
}

$item = query("SELECT * FROM ITEM_JUAL WHERE nota = '$nota'");

if (isset($_GET['barang_id']) && !isset($_GET['bataltambah']) && !isset($_GET['batal'])) {
    array_push($_SESSION['hapus'], $_GET['barang_id']);
    $_SESSION['hapus'] = array_unique($_SESSION['hapus']);
    header("Location: detailInvoice.php?nota=$nota&open");
}

if (isset($_GET['barang_id']) && isset($_GET['batal'])) {
    if (($key = array_search($_GET['barang_id'], $_SESSION['hapus'])) !== false) {
        unset($_SESSION['hapus'][$key]);
    }
    header("Location: detailInvoice.php?nota=$nota&open");
}

if (isset($_GET['barang_id']) && isset($_GET['bataltambah'])) {
    foreach ($_SESSION['tambah'] as $key => $subArray) {
        if ($subArray['TAMBAH_BARANG_ID'] === $_GET['barang_id']) {
            unset($_SESSION['tambah'][$key]);
            break;
        }
        header("Location: detailInvoice.php?nota=$nota&open");
    }
}

if (isset($_POST['hapus_item_all'])) {
    $_SESSION['hapus'] = array();
}

if (isset($_POST['tambah_item_all'])) {
    $_SESSION['tambah'] = array();
}

if (isset($_POST["submit"])) {
    foreach ($_SESSION['hapus'] as $h) {
        hapusItemJual($nota, $h);
    }

    foreach ($_SESSION['tambah'] as $t) {
        tambahItemNota($t['KODE_LAMA'], $t['TAMBAH_BARANG_ID'], $t['TAMBAH_JUMLAH_BARANG'], $t['TAMBAH_HARGA_BELI'], $t['TAMBAH_HARGA_JUAL'], $t['TAMBAH_DISKON1'], $t['TAMBAH_DISKON2'], $t['TAMBAH_DISKON3'], $t['TAMBAH_DISKON4'], $t['TAMBAH_DISKON_RP'], $t['TAMBAH_SATUAN'], $t['KETERANGAN'], $t['TAMBAH_KET1'], $t['TAMBAH_KET2'], $t['TAMBAH_IMEI']);
    }

    $_SESSION['hapus'] = array();
    $_SESSION['tambah'] = array();

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

        if (ubahJualItemNota($nota, $BARANG_ID, $JUMLAH_BARANG, $HARGA_BELI, $HARGA_JUAL, $DISKON1, $DISKON2, $DISKON3, $DISKON4, $DISKON_RP, $SATUAN, $_POST['KETERANGAN'], $KET1, $KET2, $IMEI) > 0) {
        } else {
            echo mysqli_error($conn);
        }
    }

    if (ubahNota($nota, $username, $_POST) > 0) {
        echo  "<script>
    alert('Berhasil mengubah invoices nota $nota!');
        document.location.href = 'jual.php';
        </script>";
    } else {
        echo mysqli_error($conn);
    }
}

if (isset($_POST["hapus"])) {
    if (hapusJual($nota) > 0) {
        echo  "<script>
    alert('Berhasil menghapus invoices nota $nota!');
        document.location.href = 'jual.php';
        </script>";
    } else {
        echo mysqli_error($conn);
    }
}

if (empty($item)) {
    return header('location: jual.php');
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
                        $("#NAMA_BARANG").text(data[2]);
                    }
                });
            }
        });
        $('#ui-id-1').css('z-index', 1000)
        $('#ui-id-2').css('z-index', 1000)
    });
</script>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">

    <h1 class="text-2xl mb-8 font-semibold">Details Nota <?= $nota; ?></h1>

    <a class="btn btn-warning mb-8" href="jual.php">Kembali</a>
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
                    <th>No. </th>
                    <th>Nama</th>
                    <th>Stok/Satuan</th>
                    <th>Diskon</th>
                    <th>Jumlah/Harga</th>
                    <th>Garansi/Poin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($item as $key => $i) {
                    $brg = query("SELECT * FROM BARANG a LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID where a.KODE = " . $i['BARANG_ID']);
                    foreach ($brg as $b) : ?>
                        <tr>
                            <td><?= $key + 1; ?></td>
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

    <?php if (isset($_GET['open'])) : ?>

        <input type="checkbox" id="my-modal-6" class="modal-toggle" />
        <div class="modal rounded-none modal-bottom items-start modal-open">
            <div class="modal-box h-screen max-h-screen rounded-none w-full">
                <form action="" method="POST">
                    <input type="hidden" value="<?= $item[0]['NOTA']; ?>" name="KODE_LAMA" />
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

                    <div class="flex justify-between items-center w-full mb-8 mt-8">
                        <div>
                            <h2 class="text-4xl font-bold">TOTAL</h2>
                            <button name="hapus_item_all" class="badge badge-error">Hapus Semua Antrean Hapus</button>
                            <button name="tambah_item_all" class="badge badge-error">Hapus Semua Antrean Tambah</button>
                        </div>
                        <h3 class="text-2xl font-bold text-info text-info-total"></h3>
                    </div>

                    <div class="overflow-x-auto w-full mt-8 mb-4">
                        <table class="table table-compact w-full">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>No. </th>
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
                                foreach ($item_jual as $key => $b) :
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
                <?php $BARANG_ID = $b["BARANG_ID"]; ?>
                Jumlah: <input class="jumlah-barang" type="number" name="JUMLAH_BARANG[]" id="JUMLAH_BARANG[]" value="<?= $b['JUMLAH']; ?>" max="<?= $b['JUMLAH'] + max(query("SELECT STOK FROM BARANG WHERE KODE = '$BARANG_ID'")[0]['STOK'], 0) ?>">
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
                <input type="hidden" name="HARGA_BELI[]" id="HARGA_BELI[]" class="text-sm font-semibold opacity-70" value="<?= $b["HARGA_BELI"]; ?>"></input>
                <br>
                <input name="HARGA_JUAL[]" id="HARGA_JUAL[]" class="text-sm font-semibold opacity-70 harga-jual" value="<?= $b["HARGA_JUAL"]; ?>"></input>
                <br>
                <br>
                <span class="harga-barang"><?= number_format($b["HARGA_JUAL"] * $b["JUMLAH"]); ?></span>
            </th>
            <th>
                KET1: <input type="text" name="KET1[]" id="KET1[]" value="<?= $b["KET1"]; ?>" class="text-sm opacity-70"></input>
                <br>
                KET2: <input type="text" name="KET2[]" id="KET2[]" value="<?= $b["KET2"]; ?>" class="text-sm opacity-70"></input>
                <?php if (!in_array($b['BARANG_ID'], $_SESSION['hapus'])) : ?>
                    <a class="badge badge-error" type="submit" href="DetailInvoice.php?nota=<?= $nota; ?>&barang_id=<?= $b['BARANG_ID']; ?>&open" name="hapus_item">Hapus</a>
                <?php endif; ?>
                <?php if (in_array($b['BARANG_ID'], $_SESSION['hapus'])) : ?>
                    <a class="badge badge-error" type="submit" href="DetailInvoice.php?nota=<?= $nota; ?>&barang_id=<?= $b['BARANG_ID']; ?>&batal&open" name="batal_hapus">Batal</a>
                <?php endif; ?>
            </th>
            </tr>
        <?php endforeach; ?>
        <?php
        foreach ($_SESSION['tambah'] as $key => $t) :
        ?>
            <tr>
                <td><?= $key + 1; ?></td>
                <td>
                    <div class="items-center space-x-3">
                        <input name="BARANG_ID[]" id="BARANG_ID[]" value="<?= $t["TAMBAH_BARANG_ID"]; ?>" type="hidden">
                        <div class="font-bold"><?= query("SELECT NAMA FROM BARANG where KODE = " . $t['TAMBAH_BARANG_ID'])[0]['NAMA']; ?></div>
                        <div class="text-sm opacity-50"><?= $t["TAMBAH_BARANG_ID"]; ?></div>
                        <div class="text-sm opacity-50"><?= query("SELECT KODE_BARCODE FROM BARANG where KODE = " . $t['TAMBAH_BARANG_ID'])[0]['KODE_BARCODE']; ?></div>
                    </div>
        </div>
        </div>
        </td>
        <td>
            IMEI: <input type="text" name="IMEI[]" id="IMEI[]">
            <br />
            Jumlah: <input type="number" class="jumlah-barang" name="JUMLAH_BARANG[]" id="JUMLAH_BARANG[]" value="<?= $t['TAMBAH_JUMLAH_BARANG']; ?>">
            <br />
            Satuan: <select tabindex="1" type="text" name="SATUAN[]" id="SATUAN[]"><?php
                                                                                    $satuan = query("SELECT * FROM satuan");
                                                                                    foreach ($satuan as $l) : ?>
                    <option <?php if ($l['KODE'] === $t['TAMBAH_SATUAN']) {
                                                                                            echo 'selected';
                                                                                        } ?> value="<?= $l['KODE']; ?>"><?= $l["NAMA"]; ?></option>
                <?php endforeach; ?>
            </select>
            <br />
        </td>
        <td>
            % Rupiah: <input value="0" type="number" name="DISKON_RP[]" id="DISKON_RP[]">
            <br />
            <span class="badge badge-ghost badge-sm">%1: <input className="input-xs" value="0" type="number" name="DISKON1[]" id="DISKON1[]"></span>
            <br />
            <span class="badge badge-ghost badge-sm">%2: <input className="input-xs" value="0" type="number" name="DISKON2[]" id="DISKON2[]"> </span>
            <br />
            <span class="badge badge-ghost badge-sm">%3: <input className="input-xs" value="0" type="number" name="DISKON3[]" id="DISKON3[]"> </span>
            <br />
            <span class="badge badge-ghost badge-sm">%4: <input className="input-xs" value="0" type="number" name="DISKON4[]" id="DISKON4[]"> </span>
        </td>
        <th>
            <br>
            <input name="HARGA_BELI[]" id="HARGA_BELI[]" class="text-sm font-semibold opacity-70 harga-beli" value="<?= $t["TAMBAH_HARGA_BELI"]; ?>"></input>
            <br>
            <input name="HARGA_JUAL[]" id="HARGA_JUAL[]" class="text-sm font-semibold opacity-70" value="<?= $t["TAMBAH_HARGA_JUAL"]; ?>"></input>
            <br>
            <br>
            <span class="harga-barang"><?= $t["TAMBAH_HARGA_BELI"] * $t["TAMBAH_JUMLAH_BARANG"]; ?></span>
        </th>
        <th>
            KET1: <input type="text" name="KET1[]" id="KET1[]" value="<?= $t["TAMBAH_KET1"]; ?>" class="text-sm opacity-70"></input>
            <br>
            KET2: <input type="text" name="KET2[]" id="KET2[]" value="<?= $t["TAMBAH_KET2"]; ?>" class="text-sm opacity-70"></input>
            <a class="badge badge-error" type="submit" href="detailInvoice.php?nota=<?= $item[0]['NOTA']; ?>&barang_id=<?= $t['TAMBAH_BARANG_ID']; ?>&bataltambah&open" name="hapus_item_tambah">Hapus Draf</a>
        </th>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td>+</td>
        <td>
            <div class="gap-2 flex flex-col space-x-3">
                <div class="font-bold" id="NAMA_BARANG"></div>
                <input class="input input-bordered input-xs" name="TAMBAH_BARANG_ID" placeholder="KODE BARANG" id="TAMBAH_BARANG_ID" type="text">
                <button class="badge badge-success" type="submit" name="tambah_item">Tambah Item</button>
            </div>
            </div>
            </div>
        </td>
        <td>
            IMEI: <input class="input input-bordered input-xs" type="text" name="TAMBAH_IMEI" id="TAMBAH_IMEI">
            <br />
            Jumlah: <input class="input input-bordered input-xs" value="1" type="number" name="TAMBAH_JUMLAH_BARANG" id="TAMBAH_JUMLAH_BARANG"> <br />
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
            KET1: <input class="input input-bordered input-xs" type="text" name="TAMBAH_KET1" id="TAMBAH_KET1" class="text-sm opacity-70 input-xs"></input>
            <br>
            KET2: <input class="input input-bordered input-xs" type="text" name="TAMBAH_KET2" id="TAMBAH_KET2" class="text-sm opacity-70 input-xs"></input>
        </th>
    </tr>
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
        <a for="my-modal-6" class="btn" href="jual.php">Batal</a>
        <?php if (isset($aksi[1]) && $aksi[1] === '1') : ?>
            <button name="submit" class="btn btn-success" type="submit">Perbaiki</button>
        <?php endif; ?>
    </div>
    </form>
    </div>
    </div>
<?php endif; ?>

</main>
<script>
    const textInfoTotal = document.querySelector('.text-info-total');
    const hargaJual = document.querySelectorAll('.harga-jual');
    const jumlahBarang = document.querySelectorAll('.jumlah-barang');
    const hargaBarang = document.querySelectorAll('.harga-barang');
    let harga = 0;

    const updateUI = () => {
        let hargaSementara = 0

        hargaJual.forEach((h, i) => {
            hargaSementara += (parseInt(h.value) | 0) * (jumlahBarang[i].value | 0)
            hargaBarang[i].textContent = (parseInt(h.value) | 0) * (jumlahBarang[i].value | 0)
        })

        textInfoTotal.textContent = rupiah(hargaSementara)
    }

    hargaJual.forEach((h, i) => {
        harga += parseInt(h.value) * parseInt(jumlahBarang[i].value)

        jumlahBarang[i].addEventListener('keyup', updateUI)
        h.addEventListener('keyup', updateUI)
    })

    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
        }).format(number)
    }
    textInfoTotal.textContent = rupiah(harga)
</script>
<?php
include('shared/footer.php')
?>