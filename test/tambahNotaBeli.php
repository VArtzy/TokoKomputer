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
    $nota = date('Ymd') . query("SELECT COUNT(*) as COUNT FROM beli")[0]["COUNT"];
    $total = 0;
    foreach ($data as $d) {
        $total = $total + ($d['price'] * $d['count']);
    }

    foreach ($data as $d) {
        if (tambahBeliItemNota($nota, $d['id'], $d['count'], $d['price']) > 0) {
        } else {
            echo mysqli_error($conn);
        }
    }

    if (tambahBeli($nota, $username, $total, $_POST) > 0) {
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
<script>
    $(document).on("keydown", function(e) {
        if (e.which === 65 && (e.ctrlKey || e.metaKey)) {
            $("#tambah")[0].click();
        }
        if (e.key === "Escape") {
            location.href = 'pilihBarangBeli.php'
        }
    });
</script>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold mb-4">Tambah Beli</h1>
    <a class="btn btn-warning mb-8" href="pilihBarangBeli.php">Kembali</a>

    <?php if (!empty($data)) { ?>
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
                    foreach ($data as $d) {
                        $brg = query("SELECT * FROM BARANG a LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID where a.KODE = " . $d['id']);
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
                                    Jumlah: <?= $d['count'] * query("SELECT KONVERSI FROM satuan where KODE = '" . $b['SATUAN_ID'] . "'")[0]['KONVERSI']; ?>
                                    <br />
                                    Stok: <?= round($b["STOK"]); ?>
                                    <br />
                                    Satuan: <?= query("SELECT KONVERSI FROM satuan where KODE = '" . $b['SATUAN_ID'] . "'")[0]['KONVERSI']; ?> (<?= query("SELECT NAMA FROM satuan where KODE = '" . $b['SATUAN_ID'] . "'")[0]['NAMA']; ?>)
                                    <br />
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
                                    <span class="text-sm font-semibold opacity-70"><?= rupiah($b["HARGA_BELI"]); ?></span>
                                    <br>
                                    <span class="text-sm font-semibold opacity-70"><?= rupiah($b["HARGA_BELI"] * $d['count']); ?></span>
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
        <span class="text-info text-info-cart">Subtotal: Rp. 0.00</span>


        <form action="" method="post">
            <h3 class="font-bold text-lg">Beli</h3>
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
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="PPN">PPN: </label>
                </label>
                <label class="input-group">
                    <span>PPN:</span>
                    <input type="text" name="PPN" id="PPN" class="input input-bordered">
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="DISKON">Diskon: </label>
                </label>
                <label class="input-group">
                    <span>Diskon:</span>
                    <input type="text" name="DISKON" id="DISKON" class="input input-bordered">
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