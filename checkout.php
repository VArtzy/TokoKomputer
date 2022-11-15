<?php
require_once 'utils/functions.php';
require_once 'utils/logged.php';

$cart = $_COOKIE["shoppingCart"];
$data = json_decode($cart, true);

foreach ($data as $d) {
    $brg = query("SELECT `KODE`, `NAMA`, `SATUAN_ID`, `STOK`, `MIN_STOK`, `MAX_STOK`, `HARGA_BELI`,`STOK_AWAL`, `DISKON_RP`, `GARANSI`, `DISKON_GENERAL`, `DISKON_SILVER`, `DISKON_GOLD`, `POIN`, `FOTO` FROM BARANG where id = " . $d['id']);
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
    if (tambahNota($_POST) > 0) {
        echo  "<script>
    alert('Berhasil memesan pesanan kamu!');
    </script>";
        header('Location: barang.php');
    } else {
        echo mysqli_error($conn);
    }
}

$title = "Checkout";
include('shared/nav.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold mb-4">Halaman Checkout</h1>

    <button class="btn btn-warning mb-8" href="pesan.php">Kembali</button>

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
                        $brg = query("SELECT `KODE`, `NAMA`, `SATUAN_ID`, `STOK`, `MIN_STOK`, `MAX_STOK`, `HARGA_BELI`,`STOK_AWAL`, `DISKON_RP`, `GARANSI`, `DISKON_GENERAL`, `DISKON_SILVER`, `DISKON_GOLD`, `POIN`, `FOTO` FROM BARANG where id = " . $d['id']);
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

        <div tabindex="0" class="collapse collapse-arrow border border-base-300 bg-base-100 rounded-box mb-8">
            <div class="collapse-title text-xl font-medium">
                Mulai Order
            </div>
            <div class="collapse-content">
                <form action="" method="post">
                    <input type="hidden" name="CUSTOMER_ID" id="CUSTOMER_ID" value="<?= $id; ?>">
                    <ul>
                        <li>
                            <label for="CUSTOMER_NAMA">Atas Nama: </label>
                            <input type="text" name="CUSTOMER_NAMA" id="CUSTOMER_NAMA" value="<?= $username; ?>">
                        </li>
                        <li>
                            <button class="btn btn-success" type="submit" name="checkout">CHECKOUT</button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>

        <p>Punya pertanyaan seputar pembelian? <a class="link link-success">Jangan ragu tanyakan kami</a>.</p>
    <?php } else { ?>
        <p>Kamu belum mengisi keranjang kamu 😅. Yuk <a href="pesan.php" class="text-sky-600">belanja</a>.</p>
    <?php } ?>
</main>
<?php
include('shared/footer.php')
?>