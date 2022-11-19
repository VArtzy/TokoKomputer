<?php
require_once 'utils/functions.php';
require_once 'utils/loggedAdmin.php';

$cart = $_COOKIE["shoppingCart"];
$data = json_decode($cart, true);
$salesman = query("SELECT KODE, NAMA FROM salesman");

foreach ($data as $d) {
    $brg = query("SELECT `KODE`, `NAMA`, `SATUAN_ID`, `STOK`, `MIN_STOK`, `MAX_STOK`, `HARGA_BELI`,`STOK_AWAL`, `DISKON_RP`, `GARANSI`, `DISKON_GENERAL`, `DISKON_SILVER`, `DISKON_GOLD`, `POIN`, `FOTO` FROM BARANG where KODE = " . $d['id']);
    foreach ($brg as $b) {
        if ($d['count'] > round($b["STOK"])) {
            $d['count'] = 1;
            $d['stok'] = round($b["STOK"]);
            $dataEncoded = json_encode($d);
            echo "<script>alert('Maaf, barang " . $d['name'] . " beberapa stoknya sudah dibeli. Silahkan ulangi isi keranjang 🤗.')</script>";
            echo "<script>document.cookie = 'shoppingCart' +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';</script>";
            echo "<script>window.location.href = 'pesan.php'</script>";
        }
    }
}

if (isset($_POST["checkout"])) {
    $nota = uniqid();
    $total = 0;
    foreach ($data as $d) {
        $total = $total + ($d['price'] * $d['count']);
    }

    foreach ($data as $d) {
        if (tambahItemNota($nota, $d['id'], $d['count'], $d['price']) > 0) {
        } else {
            echo mysqli_error($conn);
        }
    }

    if (tambahNotaAdmin($nota, $username, $total, $_POST) > 0) {
        echo "<script>document.cookie = 'shoppingCart' +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';</script>";
        echo  "<script>
        alert('Berhasil Menambah Nota!');
        document.location.href = 'invoices.php';
        </script>";
    } else {
        echo mysqli_error($conn);
        echo  "<script>
        alert('Gagal Menambah Nota!');
        document.location.href = 'invoices.php';
        </script>";
    }
}

if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

$title = "Tambah Nota - $username";
include('shared/navadmin.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold mb-4">Tambah Nota</h1>
    <a class="btn btn-warning mb-8" href="pilihBarang.php">Kembali</a>

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
                        $brg = query("SELECT `KODE`, `NAMA`, `SATUAN_ID`, `STOK`, `MIN_STOK`, `MAX_STOK`, `HARGA_BELI`,`STOK_AWAL`, `DISKON_RP`, `GARANSI`, `DISKON_GENERAL`, `DISKON_SILVER`, `DISKON_GOLD`, `POIN`, `FOTO` FROM BARANG where KODE = " . $d['id']);
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
                                    Jumlah: <?= $d['count']; ?>
                                    <br />
                                    Stok: <?= round($b["STOK"]); ?>
                                    <br />
                                    Satuan: <?= $b["SATUAN_ID"]; ?>
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
            <ul>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="CUSTOMER_NAMA">Atas Nama: </label>
                    </label>
                    <label class="input-group">
                        <span>Nama</span>
                        <input type="text" name="CUSTOMER_NAMA" id="CUSTOMER_NAMA" class="input input-bordered" placeholder="berikan nama pelanggan...">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="SALESMAN_ID">Salesman ID: </label>
                    </label>
                    <label class="input-group">
                        <span>Salesman ID:</span>
                        <select class="input input-bordered" name="SALESMAN_ID" id="SALESMAN_ID">
                            <?php foreach ($salesman as $s) : ?>
                                <option value="<?= $s['KODE']; ?>"><?= $s["NAMA"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <button class="btn btn-success mt-4" onclick="return confirm('Apakah anda yakin ingin memesan?'); shoppingCart.clearCart()" type="submit" name="checkout">CHECKOUT</button>
                </li>
            </ul>
        </form>
    <?php } else { ?>
        <p>Kamu belum mengisi keranjang kamu 😅.</p>
    <?php } ?>
</main>
<?php
include('shared/footer.php')
?>