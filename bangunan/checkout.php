<?php
require_once 'utils/functions.php';
require_once 'utils/logged.php';

$cart = $_COOKIE["shoppingCart"];
$data = json_decode($cart, true);

foreach ($data as $d) {
    $brg = query("SELECT * FROM BARANG a LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID where a.KODE = " . $d['id']);
    foreach ($brg as $b) {
        if ($d['count'] > round($b["STOK"])) {
            $d['count'] = 1;
            $d['stok'] = round($b["STOK"]);
            $dataEncoded = json_encode($d);
            echo "<script>alert('Maaf, barang " . $d['name'] . " beberapa stoknya sudah dibeli. Silahkan ulangi isi keranjang 🤗.')</script>";
            echo "<script>window.location.href = 'pesan.php'</script>";
        }
    }
}

if (isset($_POST["checkout"])) {
    $nota = date('Ymd') . query("SELECT COUNT(*) as COUNT FROM jual WHERE TANGGAL = CURDATE()")[0]["COUNT"];
    $total = 0;
    foreach ($data as $d) {
        $total = $total + ($d['price'] * $d['count']);
    }

    foreach ($data as $d) {
        if (tambahItemNotaCheckout($nota, $d['id'], $d['count'], $d['price']) > 0) {
        } else {
            echo mysqli_error($conn);
        }
    }

    if (tambahNota($nota, $id, $total, $_POST) > 0) {
        echo "<script>document.cookie = 'shoppingCart' +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';</script>";
        echo  "<script>
        alert('Berhasil Menambah Pesanan Kamu!');
        document.location.href = 'riwayat.php';
        </script>";
    } else {
        echo mysqli_error($conn);
        echo  "<script>
        alert('Gagal Menambah Pesanan Kamu!');
        document.location.href = 'riwayat.php';
        </script>";
    }
}

$title = "Checkout";
include('shared/nav.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold mb-4">Halaman Checkout</h1>

    <a class="btn btn-warning mb-8" href="pesan.php">Kembali</a>

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
                                    <span class="text-sm font-semibold opacity-70"><?= rupiah($b["HARGA_JUAL"]); ?></span>
                                    <br>
                                    <span class="text-sm font-semibold opacity-70"><?= rupiah($b["HARGA_JUAL"] * $d['count']); ?></span>
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
            <?php
            $customer = query("SELECT * FROM customer WHERE KODE = '" . $id . "'")[0];
            ?>
            <input type="hidden" name="LOKASI_ID" id="LOKASI_ID" value="GDG1">
            <ul>
                <div class="form-control flex gap-4">
                    <label class="label">
                        <label class="label-text" for="CUSTOMER_NAMA">Atas Nama: </label>
                    </label>
                    <label class="input-group">
                        <span>Nama</span>
                        <input type="text" name="CUSTOMER_NAMA" id="CUSTOMER_NAMA" class="input input-bordered" value="<?= $username; ?>">
                    </label>
                    <label class="input-group">
                        <span>Alamat</span>
                        <input readonly value="<?= $customer['ALAMAT']; ?>" type="text" name="ALAMAT" id="ALAMAT" class="input input-bordered">
                    </label>
                    <label class="input-group">
                        <span>Wilayah</span>
                        <input readonly value="<?= query("SELECT KETERANGAN FROM wilayah WHERE KODE ='" . $customer['WILAYAH_ID'] . "'")[0]["KETERANGAN"]; ?>" type="text" name="WILAYAH_ID" id="WILAYAH_ID" class="input input-bordered">
                    </label>
                    <label class="input-group">
                        <span>Telepon</span>
                        <input readonly value="<?= $customer['TELEPON']; ?>" type="text" name="TELEPON" id="TELEPON" class="input input-bordered">
                    </label>
                </div>
                <a href="profile.php?id=<?= $id; ?>" class="btn btn-primary">Ubah Data</a>
                <button class="btn btn-success mt-4" onclick="return confirm('Apakah anda yakin ingin memesan?'); shoppingCart.clearCart()" type="submit" name="checkout">CHECKOUT</button>
                </li>
            </ul>
        </form>

        <p>Punya pertanyaan seputar pembelian? <a class="link link-success" href="https://wa.me/6289665805560?text=Hallo%20min,%20bisa%20minta%20bantuannya%20dong...">Jangan ragu tanyakan kami</a>.</p>
    <?php } else { ?>
        <p>Kamu belum mengisi keranjang kamu 😅. Yuk <a href="pesan.php" class="text-sky-600">belanja</a>.</p>
    <?php } ?>
</main>
<?php
include('shared/footer.php')
?>