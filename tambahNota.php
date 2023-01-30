<?php
require_once 'utils/functions.php';
require_once 'utils/loggedAdmin.php';

$nom = '15';
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';
if (!in_array($nom, $aksesMenu) || !isset($aksi[0]) || $aksi[0] === '0') return header('Location: jual.php');

$cart = $_COOKIE["shoppingCart"];
$data = json_decode($cart, true);
$salesman = query("SELECT KODE, NAMA FROM salesman");

foreach ($data as $d) {
    $brg = query("SELECT * FROM BARANG a LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID where a.KODE = " . $d['id']);
    foreach ($brg as $b) {
        if ($d['count'] > round($b["STOK"])) {
            $d['count'] = 1;
            $d['stok'] = round($b["STOK"]);
            $dataEncoded = json_encode($d);
            echo "<script>alert('Maaf, barang " . $d['name'] . " beberapa stoknya sudah dibeli. Silahkan ulangi isi keranjang 🤗.')</script>";
            echo "<script>document.cookie = 'shoppingCart' +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';</script>";
            echo "<script>window.location.href = 'pilihBarang.php'</script>";
        }
    }
}

if (isset($_POST["checkout"])) {
    $nota = $_POST['NOTA'];
    $TOTAL = 0;

    $CUSTOMER_NAMA = mysqli_real_escape_string($conn, $_POST["CUSTOMER_NAMA"]);
    $isCustomer = mysqli_query($conn, "SELECT NAMA, KODE FROM customer WHERE NAMA = '$CUSTOMER_NAMA' OR KODE = '$CUSTOMER_NAMA'");

    if (!mysqli_fetch_assoc($isCustomer)) {
        echo "<script>
        if (confirm('Nama atau Kode Customer belum didaftarkan. Silahkan daftar terlebih dahulu.') == true) {
            document.location.href = 'userAndAdminManagement.php#customer'
        } else {
            document.location.href = 'tambahNota.php'
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

        $TOTAL = $TOTAL + $JUMLAH_BARANG * $HARGA_JUAL;
        if (tambahItemNota($nota, $d['id'], $JUMLAH_BARANG, $HARGA_BELI, $HARGA_JUAL, $DISKON1, $DISKON2, $DISKON3, $DISKON4, $DISKON_RP, $SATUAN, $_POST['KETERANGAN'], $KET1, $KET2, $IMEI) > 0) {
        } else {
            echo mysqli_error($conn);
        }
    }

    if (tambahNotaAdmin($nota, $username, $TOTAL, $_POST) > 0) {
        mysqli_query($conn, "UPDATE salesman SET TOTAL_ITEM_PENJUALAN = TOTAL_ITEM_PENJUALAN + $d->count WHERE KODE = '$SALESMAN_ID'");
        echo "<script>document.cookie = 'shoppingCart' +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';</script>";
        echo  "<script>
        alert('Berhasil Menambah Jual!');
        document.location.href = 'invoices.php';
        </script>";
    } else {
        echo mysqli_error($conn);
        echo  "<script>
        alert('Gagal Menambah Jual!');
        document.location.href = 'invoices.php';
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

$title = "Tambah Nota - $username";
include('shared/navadmin.php');
?>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<script>
    $(function() {
        $("#CUSTOMER_NAMA").autocomplete({
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
    });
</script>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <div class="flex justify-between items-center w-full mb-2">
        <h1 class="text-2xl font-semibold">Tambah Nota</h1>
        <div class="tooltip" data-tip="ESC">
            <a href="pilihBarang.php" class="badge">x</a>
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
                            <input tabindex="1" value="<?= date('Ymd') . query("SELECT COUNT(*) as COUNT FROM jual")[0]["COUNT"]; ?>" required type="text" name="NOTA" id="NOTA" class="input input-bordered">
                        </label>
                    </div>
                    <div class="flex gap-4">
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
                    <div class="flex gap-4">
                        <div class="form-control">
                            <label class="label">
                                <label class="label-text" for="CUSTOMER_NAMA">Atas Nama: </label>
                            </label>
                            <label class="input-group">
                                <span>Nama</span>
                                <input tabindex="1" type="text" name="CUSTOMER_NAMA" id="CUSTOMER_NAMA" class="input input-bordered" placeholder="berikan nama/kode pelanggan...">
                                <button class="btn" type="submit" name="carinama">Cari Pelanggan</button>
                            </label>
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <label class="label-text" for="LOKASI_ID">Lokasi: </label>
                            </label>
                            <label class="input-group">
                                <span>Lokasi:</span>
                                <select tabindex="1" class="input input-bordered" name="LOKASI_ID" id="LOKASI_ID">
                                    <?php
                                    $lokasi = query("SELECT * FROM lokasi");
                                    foreach ($lokasi as $l) : ?>
                                        <option value="<?= $l['KODE']; ?>"><?= $l["KETERANGAN"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="form-control">
                            <label class="label">
                                <label class="label-text" for="SALESMAN_ID">Salesman: </label>
                            </label>
                            <label class="input-group">
                                <span>Salesman:</span>
                                <select tabindex="1" class="input input-bordered" name="SALESMAN_ID" id="SALESMAN_ID">
                                    <?php foreach ($salesman as $s) : ?>
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

            <h2 class="font-bold mt-8 mb-4">Rincian Pembelian</h2>

            <div class="overflow-x-auto w-full mb-4">
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
                                        IMEI: <input tabindex="1" type="text" name="IMEI[]" id="IMEI[]">
                                        <br />
                                        Jumlah: <input tabindex="1" type="number" class="jumlah-barang" name="JUMLAH_BARANG[]" id="JUMLAH_BARANG[]" value="<?= $d['count']; ?>">
                                        <br />
                                        Stok: <?= round($b["STOK"]); ?>
                                        <br />
                                        Satuan: <input tabindex="1" type="text" name="SATUAN[]" id="SATUAN[]" value="<?= $b['SATUAN_ID'] ?>">
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
                                        <input tabindex="1" name="HARGA_BELI[]" id="HARGA_BELI[]" type="hidden" class="text-sm font-semibold opacity-70" value="<?= $b["HARGA_BELI"]; ?>"></input>
                                        <br>
                                        <input tabindex="1" name="HARGA_JUAL[]" id="HARGA_JUAL[]" type="number" class="text-sm font-semibold opacity-70 harga-jual" value="<?php if (isset(query("SELECT HARGA_JUAL FROM MULTI_PRICE where BARANG_ID = " . $b['KODE'])[0]['HARGA_JUAL'])) {
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
                <div class="">
                    <label class="input-group gap-2">
                        <input tabindex="1" type="checkbox" name="cetak" id="cetak">
                        <label class="label-text" for="cetak">Cetak Nota Penjualan</label>
                    </label>
                    <p>Tab: untuk pindah baris/item berikutnya</p>
                </div>
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
                    <a tabindex="1" href="pilihBarang.php" for="my-modal-6" id="batal" class="btn">Batal</a>
                </div>
                <div class="tooltip tooltip-success" data-tip="CTRL + A">
                    <button tabindex="1" class="btn btn-success" onclick="return confirm('Apakah anda yakin ingin memesan?'); shoppingCart.clearCart()" type="submit" name="checkout">CHECKOUT</button>
                </div>
            </div>
            </li>
        </form>
    <?php } else { ?>
        <p>Kamu belum mengisi keranjang kamu 😅.</p>
    <?php } ?>
</main>

<script>
    const textInfoTotal = document.querySelector('.text-info-total');
    const hargaJual = document.querySelectorAll('.harga-jual');
    const jumlahBarang = document.querySelectorAll('.jumlah-barang');
    let harga = 0;

    const updateUI = () => {
        let hargaSementara = 0
        hargaJual.forEach((h, i) => hargaSementara += (parseInt(h.value) | 0) * (jumlahBarang[i].value | 0))

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