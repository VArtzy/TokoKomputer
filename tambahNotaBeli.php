<?php
require_once 'utils/functions.php';
require_once 'utils/loggedAdmin.php';

$nom = '13';
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';
if (!in_array($nom, $aksesMenu) || !isset($aksi[0]) || $aksi[0] === '0') return header('Location: beli.php');

$cart = $_COOKIE["shoppingCart"];
$data = json_decode($cart, true);
var_dump($data);
$salesman = query("SELECT KODE, NAMA FROM salesman");

foreach ($data as $d) {
    $brg = query("SELECT * FROM BARANG a LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID where a.KODE = " . $d['id']);
}

if (isset($_POST["submit"])) {
    $nota = $_POST['NOTA'];
    $TOTAL = 0;

    $SUPPLIER_ID = mysqli_real_escape_string($conn, $_POST["SUPPLIER_ID"]);
    $isSupplier = mysqli_query($conn, "SELECT NAMA, KODE FROM supplier WHERE NAMA = '$SUPPLIER_ID' OR KODE_BARCODE = '$SUPPLIER_ID'");

    if (!mysqli_fetch_assoc($isSupplier)) {
        echo "<script>
        if (confirm('Nama atau Kode Supplier belum didaftarkan. Silahkan daftar terlebih dahulu.') == true) {
            document.location.href = 'supplier.php'
        } else {
            document.location.href = 'tambahNotaBeli.php'
        }
        </script>";
        return false;
    }

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
    <div class="flex justify-between items-center w-full mb-2">
        <h1 class="text-2xl font-semibold">Tambah Beli</h1>
        <div class="tooltip" data-tip="ESC">
            <a href="pilihBarangBeli.php" class="badge">x</a>
        </div>
    </div>
    <div class="flex justify-between items-center w-full mb-8">
        <h2 class="text-4xl font-bold">TOTAL</h2>
        <h3 class="text-2xl font-bold text-info text-info-total"></h3>
    </div>

    <?php if (!empty($data)) { ?>
        <form action="" method="post">
            <div class="md:flex justify-between">
                <div class="">
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="NOTA">Nota: </label>
                        </label>
                        <label class="input-group">
                            <span>Nota:</span>
                            <input tabindex="1" value="<?= date('Ymd') . query("SELECT COUNT(*) as COUNT FROM beli")[0]["COUNT"]; ?>" required type="text" name="NOTA" id="NOTA" class="input input-bordered">
                        </label>
                    </div>
                    <div class="md:flex gap-4">
                        <div class="form-control">
                            <label class="label">
                                <label class="label-text" for="STATUS_NOTA">Status: </label>
                            </label>
                            <label class="input-group">
                                <span>Status:</span>
                                <select tabindex="1" class="input input-bordered" name="STATUS_NOTA" id="STATUS_NOTA">
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
                                <input tabindex="1" value="<?= date('Y-m-d'); ?>" type="date" name="TANGGAL" id="TANGGAL" class="input input-bordered">
                            </label>
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <label class="label-text" for="TANGGAL2">Tanggal: </label>
                            </label>
                            <label class="input-group">
                                <span>Tanggal:</span>
                                <input tabindex="1" value="<?= date('Y-m-d'); ?>" type="date" name="TANGGAL2" id="TANGGAL2" class="input input-bordered">
                            </label>
                        </div>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="LOKASI_ID">Lokasi: </label>
                        </label>
                        <label class="input-group">
                            <span>Lokasi:</span>
                            <select tabindex="1" class="input input-bordered" name="LOKASI_ID" id="LOKASI_ID">
                                <?php
                                $Lokasi = query("SELECT * FROM Lokasi");
                                foreach ($Lokasi as $s) : ?>
                                    <option value="<?= $s['KODE']; ?>"><?= $s["KETERANGAN"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                    </div>
                    <div class="md:flex gap-4 items-end">
                        <div class="form-control">
                            <label class="label">
                                <label class="label-text" for="SUPPLIER_ID">Supplier: </label>
                            </label>
                            <label class="input-group">
                                <span>Supplier:</span>
                                <input tabindex="1" required type="text" name="SUPPLIER_ID" id="SUPPLIER_ID" class="input input-bordered">
                            </label>
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <label class="label-text" for="KETERANGAN">Keterangan: </label>
                            </label>
                            <label class="input-group">
                                <span>Keterangan:</span>
                                <input tabindex="1" type="text" name="KETERANGAN" id="KETERANGAN" class="input input-bordered">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="HISTORIHARGA">Histori Harga: </label>
                    </label>
                    <label class="input-group">
                        <span>Histori Harga: </span>
                        <textarea readonly type="text" name="HISTORIHARGA" id="HISTORIHARGA" class="input input-bordered h-full" rows="12"></textarea>
                    </label>
                </div>
            </div>
            </div>

            <h2 class="font-bold mt-8 mb-4">Rincian Pembelian</h2>

            <div class="overflow-x-auto w-full mb-4">
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
                        foreach ($data as $key => $d) {
                            $brg = query("SELECT * FROM BARANG where KODE = " . $d['id']);
                            foreach ($brg as $b) : ?>
                                <tr>
                                    <td><?= $key + 1; ?></td>
                                    <td>
                                        <div class="md:flex items-center space-x-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-12 h-12">
                                                    <img width="50px" height="50px" src="<?= $b["FOTO"]; ?>" alt="<?= $b["FOTO"]; ?>" />
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold"><?= $b["NAMA"]; ?></div>
                                                <div class="text-sm opacity-50"><?= $b["KODE"]; ?></div>
                                                <div class="text-sm opacity-50"><?= $b["KODE_BARCODE"]; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        IMEI: <input tabindex="1" type="text" name="IMEI[]" id="IMEI[]">
                                        <br />
                                        Jumlah: <input tabindex="1" type="number" class="jumlah-barang" name="JUMLAH_BARANG[]" id="JUMLAH_BARANG[]" value="<?= $d['count']; ?>">
                                        <br />
                                        Stok: <?= round($b["STOK"]); ?>
                                        <br />
                                        Satuan: <select tabindex="1" type="text" name="SATUAN[]" id="SATUAN[]"><?php
                                                                                                                $satuan = query("SELECT * FROM satuan");
                                                                                                                foreach ($satuan as $l) : ?>
                                                <option <?php if ($l['KODE'] === $b['SATUAN_ID']) {
                                                                                                                        echo 'selected';
                                                                                                                    } ?> value="<?= $l['KODE']; ?>"><?= $l["NAMA"]; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <br />
                                    </td>
                                    <td>
                                        % Rupiah: <input tabindex="1" value="0" type="number" name="DISKON_RP[]" id="DISKON_RP[]">
                                        <br />
                                        <span class="badge badge-ghost badge-sm">%1: <input tabindex="1" value="0" type="number" name="DISKON1[]" id="DISKON1[]"></span>
                                        <br />
                                        <span class="badge badge-ghost badge-sm">%2: <input tabindex="1" value="0" type="number" name="DISKON2[]" id="DISKON2[]"> </span>
                                        <br />
                                        <span class="badge badge-ghost badge-sm">%3: <input tabindex="1" value="0" type="number" name="DISKON3[]" id="DISKON3[]"> </span>
                                        <br />
                                        <span class="badge badge-ghost badge-sm">%4: <input tabindex="1" value="0" type="number" name="DISKON4[]" id="DISKON4[]"> </span>
                                    </td>
                                    <th>
                                        <input tabindex="1" name="HARGA_BELI[]" id="HARGA_BELI[]" type="number" class="text-sm font-semibold opacity-70 harga-beli" value="<?= $b["HARGA_BELI"]; ?>"></input>
                                        <br>
                                        <input tabindex="1" name="HARGA_JUAL[]" id="HARGA_JUAL[]" type="number" class="text-sm font-semibold opacity-70" value="<?php if (isset(query("SELECT HARGA_JUAL FROM MULTI_PRICE where BARANG_ID = " . $b['KODE'])[0]['HARGA_JUAL'])) {
                                                                                                                                                                    echo query("SELECT HARGA_JUAL FROM MULTI_PRICE where BARANG_ID = " . $b['KODE'])[0]['HARGA_JUAL'];
                                                                                                                                                                } else {
                                                                                                                                                                    echo '0';
                                                                                                                                                                }; ?>"></input>
                                        <br>
                                    </th>
                                    <th>
                                        KET1: <input tabindex="1" type="text" name="KET1[]" id="KET1[]" class="text-sm opacity-70"></input>
                                        <br>
                                        KET2: <input tabindex="1" type="text" name="KET2[]" id="KET2[]" class="text-sm opacity-70"></input>
                                    </th>
                                </tr>
                            <?php endforeach; ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="md:flex justify-between w-full">
                <p>Tab: untuk pindah baris/item berikutnya</p>
                <div class="">
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="DISKON">Diskon: </label>
                        </label>
                        <label class="input-group">
                            <span>Diskon:</span>
                            <input tabindex="1" type="number" value="0" name="DISKON" id="DISKON" class="input input-bordered">
                        </label>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <label class="label-text" for="PPN">PPN: </label>
                        </label>
                        <label class="input-group">
                            <span>PPN:</span>
                            <input tabindex="1" type="number" value="0" name="PPN" id="PPN" class="input input-bordered">
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-action">
                <div class="tooltip" data-tip="ESC">
                    <a tabindex="1" href="pilihBarangBeli.php" for="my-modal-6" id="batal" class="btn">Batal</a>
                </div>
                <div class="tooltip tooltip-success" data-tip="CTRL + A">
                    <button tabindex="1" onclick="return confirm('yakin ingin membeli barang?')" id="tambah" name="submit" class="btn btn-success" type="submit">Tambah</button>
                </div>
            </div>
        </form>
    <?php } else { ?>
        <p>Kamu belum mengisi keranjang kamu 😅.</p>
    <?php } ?>
</main>

<script>
    const textInfoTotal = document.querySelector('.text-info-total');
    const hargaBeli = document.querySelectorAll('.harga-beli');
    const jumlahBarang = document.querySelectorAll('.jumlah-barang');
    let harga = 0;

    const updateUI = () => {
        let hargaSementara = 0
        hargaBeli.forEach((h, i) => hargaSementara += (parseInt(h.value) | 0) * (jumlahBarang[i].value | 0))

        textInfoTotal.textContent = rupiah(hargaSementara)
    }

    hargaBeli.forEach((h, i) => {
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