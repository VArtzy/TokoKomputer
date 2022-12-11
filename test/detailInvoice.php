<?php
require_once 'utils/functions.php';
require_once 'utils/loggedAdmin.php';

$nota = $_GET['nota'];

$notas = query("SELECT CUSTOMER_ID, STATUS_NOTA, STATUS_BAYAR, SALESMAN_ID, TANGGAL, TEMPO, TOTAL_NOTA, TOTAL_PELUNASAN_NOTA, KETERANGAN, PROFIT, OPERATOR, LOKASI_ID FROM JUAL WHERE NOTA = '$nota'")[0];
$salesman = query("SELECT KODE, NAMA FROM salesman");
$namaPelanggan = query("SELECT * FROM CUSTOMER WHERE KODE = '" . $notas['CUSTOMER_ID'] . "'")[0];

$item = query("SELECT * FROM ITEM_JUAL WHERE nota = '$nota'");

if (isset($_POST["submit"])) {
    if (ubahNota($nota, $username, $notas['CUSTOMER_ID'], $_POST) > 0) {
        echo  "<script>
    alert('Berhasil mengubah invoices nota $nota!');
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
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form action="" method="POST">
                <h3 class="font-bold text-lg">Edit Invoices <?= $nota; ?></h3>
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
                        <label class="label-text" for="STATUS_NOTA">Status Nota: </label>
                    </label>
                    <label class="input-group">
                        <span>Status Nota:</span>
                        <input type="text" value="<?= $notas['STATUS_NOTA']; ?>" name="STATUS_NOTA" maxlength="1" id="STATUS_NOTA" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="STATUS_BAYAR">Status Bayar: </label>
                    </label>
                    <label class="input-group">
                        <span>Status Bayar:</span>
                        <input type="text" name="STATUS_BAYAR" maxlength="1" value="<?= $notas['STATUS_BAYAR']; ?>" id="STATUS_BAYAR" class="input input-bordered">
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
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="KETERANGAN">Keterangan: </label>
                    </label>
                    <label class="input-group">
                        <span>Keterangan:</span>
                        <input type="text" name="KETERANGAN" value="<?= $notas['KETERANGAN']; ?>" id="KETERANGAN" class="input input-bordered">
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
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="TOTAL_PELUNASAN_NOTA">Total Pelunasan: </label>
                    </label>
                    <label class="input-group">
                        <span>Total Pelunasan:</span>
                        <input type="number" name="TOTAL_PELUNASAN_NOTA" max="<?= $notas['TOTAL_NOTA']; ?>" value="<?= $notas['TOTAL_PELUNASAN_NOTA']; ?>" id="TOTAL_PELUNASAN_NOTA" class="input input-bordered">
                    </label>
                </div>
                <div class="form-control">
                    <label class="label">
                        <label class="label-text" for="PROFIT">Profit: </label>
                    </label>
                    <label class="input-group">
                        <span>Profit:</span>
                        <input type="number" value="<?= $notas['PROFIT']; ?>" name="PROFIT" id="PROFIT" class="input input-bordered">
                    </label>
                </div>
                <div class="modal-action">
                    <label for="my-modal-6" class="btn">Batal</label>
                    <button name="submit" class="btn btn-success" type="submit">Edit</button>
                </div>
            </form>
        </div>
    </div>

</main>

<?php
include('shared/footer.php')
?>