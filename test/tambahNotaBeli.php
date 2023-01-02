<?php
require_once 'utils/functions.php';
require_once 'utils/loggedAdmin.php';

$cart = $_COOKIE["shoppingCart"];
$data = json_decode($cart, true);
$salesman = query("SELECT KODE, NAMA FROM salesman");

foreach ($data as $d) {
    $brg = query("SELECT * FROM BARANG a LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID where a.KODE = " . $d['id']);
}

if (isset($_POST["submit"])) {
    $nota = $_POST['NOTA'];
    $TOTAL = 0;

    foreach ($data as $i => $d) {
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

        if (tambahBeliItemNota($nota, $d['id'], $JUMLAH_BARANG, $HARGA_BELI, $HARGA_JUAL, $DISKON1, $DISKON2, $DISKON3, $DISKON4, $DISKON_RP, $SATUAN, $_POST['KETERANGAN'], $KET1, $KET2, $IMEI) > 0) {
        } else {
            echo mysqli_error($conn);
        }
    }

    if (tambahBeli($nota, $username, $TOTAL, $_POST) > 0) {
        echo "<script>document.cookie = 'shoppingCart' +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';</script>";
        echo  "<script>
        alert('Berhasil Menambah Beli!');
        document.location.href = 'beli.php';
        </script>";
    } else {
        echo mysqli_error($conn);
        echo  "<script>
        alert('Gagal Menambah Beli!');
        document.location.href = 'beli.php';
        </script>";
    }
}

if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

if (isset($_POST["carinama"])) {
    $namaPelanggan = query("SELECT NAMA FROM customer WHERE KODE = '" . $_POST['CUSTOMER_NAMA'] . "'")[0]["NAMA"];
    echo  "<script>
        alert('Nama Pelanggan dari id itu adalah $namaPelanggan');
        </script>";
}

$title = "Tambah Beli - $username";
include('shared/navadmin.php');
?>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>
    $(document).on("keydown", function(e) {
        if (e.which === 65 && (e.ctrlKey || e.metaKey)) {
            $("#tambah")[0].click();
        }
        if (e.key === "Escape") {
            location.href = 'pilihBarangBeli.php'
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
    });
</script>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold mb-4">Tambah Beli</h1>
    <a class="btn btn-warning mb-8" href="pilihBarangBeli.php">Kembali</a>

    <?php if (!empty($data)) { ?>
        <form action="" method="post">
            <div class="overflow-x-auto w-full mt-8 mb-4">
                <table class="table w-full">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Stok/Satuan</th>
                            <th>Diskon</th>
                            <th>Harga Beli/Jual</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data as $d) {
                            $brg = query("SELECT * FROM BARANG where KODE = " . $d['id']);
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
                                    <td>
                                        IMEI: <input type="text" name="IMEI[]" id="IMEI[]">
                                        <br />
                                        Jumlah: <input type="number" name="JUMLAH_BARANG[]" id="JUMLAH_BARANG[]" value="<?= $d['count']; ?>">
                                        <br />
                                        Stok: <?= round($b["STOK"]); ?>
                                        <br />
                                        Satuan: <input type="text" name="SATUAN[]" id="SATUAN[]" value="<?= query("SELECT NAMA FROM satuan where KODE = '" . $b['SATUAN_ID'] . "'")[0]['NAMA']; ?>">
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
                                        <input name="HARGA_BELI[]" id="HARGA_BELI[]" type="number" class="text-sm font-semibold opacity-70" value="<?= $b["HARGA_BELI"]; ?>"></input>
                                        <br>
                                        <input name="HARGA_JUAL[]" id="HARGA_JUAL[]" type="number" class="text-sm font-semibold opacity-70" value="<?php if (isset(query("SELECT HARGA_JUAL FROM MULTI_PRICE where BARANG_ID = " . $b['KODE'])[0]['HARGA_JUAL'])) {
                                                                                                                                                        echo query("SELECT HARGA_JUAL FROM MULTI_PRICE where BARANG_ID = " . $b['KODE'])[0]['HARGA_JUAL'];
                                                                                                                                                    } else {
                                                                                                                                                        echo '0';
                                                                                                                                                    }; ?>"></input>
                                        <br>
                                    </th>
                                    <th>
                                        KET1: <input type="text" name="KET1[]" id="KET1[]" class="text-sm opacity-70"></input>
                                        <br>
                                        KET2: <input type="text" name="KET2[]" id="KET2[]" class="text-sm opacity-70"></input>
                                    </th>
                                </tr>
                            <?php endforeach; ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <span class="text-info text-info-cart">Subtotal: Rp. 0.00</span>

            <h3 class="font-bold text-lg">Beli</h3>
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="NOTA">Nota: </label>
                </label>
                <label class="input-group">
                    <span>Nota:</span>
                    <input value="<?= date('Ymd') . query("SELECT COUNT(*) as COUNT FROM beli")[0]["COUNT"]; ?>" required type="number" name="NOTA" id="NOTA" class="input input-bordered">
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
                        <label class="label-text" for="TANGGAL">Tempo: </label>
                    </label>
                    <label class="input-group">
                        <span>Tempo:</span>
                        <input value="<?= date('Y-m-d'); ?>" type="date" name="TANGGAL" id="TANGGAL" class="input input-bordered">
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
            <div class="flex gap-4">
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
                        <input required type="text" name="KETERANGAN" id="KETERANGAN" class="input input-bordered">
                    </label>
                </div>
            </div>
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="PPN">PPN: </label>
                </label>
                <label class="input-group">
                    <span>PPN:</span>
                    <input type="number" value="0" name="PPN" id="PPN" class="input input-bordered">
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="DISKON">Diskon: </label>
                </label>
                <label class="input-group">
                    <span>Diskon:</span>
                    <input type="number" value="0" name="DISKON" id="DISKON" class="input input-bordered">
                </label>
            </div>
            <div class="modal-action">
                <div class="tooltip" data-tip="ESC">
                    <label for="my-modal-6" id="batal" class="btn">Batal</label>
                </div>
                <div class="tooltip tooltip-success" data-tip="CTRL + A">
                    <button onclick="return confirm('yakin ingin membeli barang?')" id="tambah" name="submit" class="btn btn-success" type="submit">Tambah</button>
                </div>
            </div>
        </form>
    <?php } else { ?>
        <p>Kamu belum mengisi keranjang kamu 😅.</p>
    <?php } ?>
</main>
<?php
include('shared/footer.php')
?>