<?php
require_once './utils/functions.php';
require_once './utils/loggedAdmin.php';

$id = $_GET["id"];

$brg = query("SELECT * FROM BARANG WHERE KODE = '$id'")[0];

if (isset($_POST["tambah"])) {
    if (editBarang($_POST) > 0) {
        echo  "<script>
    alert('Barang berhasil diedit');
    </script>";
        header('Location: barang.php');
    } else {
        echo mysqli_error($conn);
    }
}

$title = "Edit Data Barang";
include('shared/navadmin.php');
?>

<main id="main" class="md:grid place-items-center max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8">
    <h1 class="md:mt-8 text-4xl mb-4 text-center text-amber-600 dark:text-amber-400">Edit Barang Data.</h1>
    <p class="max-w-[567px] mx-auto text-center text-slate-800 dark:text-amber-50 mb-8">Perbarui Barang Data.</p>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $id; ?>">
        <input type="hidden" name="gambarlama" value="<?= $brg["FOTO"]; ?>">
        <ul class="flex flex-col gap-6 mb-4 justify-center">
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="GOLONGAN_ID">Golongan: </label>
                </label>
                <label class="input-group">
                    <span>Golongan:</span>
                    <select required class="input input-bordered" name="GOLONGAN_ID" id="GOLONGAN_ID">
                        <?php
                        $golongan = query("SELECT * FROM golongan");
                        foreach ($golongan as $s) : ?>
                            <option <?php if ($s['KODE'] === $brg['GOLONGAN_ID']) {
                                        echo 'selected';
                                    } ?> value="<?= $s['KODE']; ?>"><?= $s["KETERANGAN"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="SUB_GOLONGAN_ID">Sub Golongan: </label>
                </label>
                <label class="input-group">
                    <span>Sub Golongan:</span>
                    <select class="input input-bordered" name="SUB_GOLONGAN_ID" id="SUB_GOLONGAN_ID">
                        <?php
                        $subgolongan = query("SELECT * FROM sub_golongan");
                        foreach ($subgolongan as $s) : ?>
                            <option <?php if ($s['KODE'] === $brg['SUB_GOLONGAN_ID']) {
                                        echo 'selected';
                                    } ?> value="<?= $s['KODE']; ?>"><?= $s["KETERANGAN"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <div class="md:flex gap-6">
                <li>
                    <label for="NAMA">Nama Barang :</label>
                    <input value="<?= $brg["NAMA"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" required type="text" name="NAMA" id="NAMA">
                </li>
                <li>
                    <label for="SATUAN_ID">Satuan :</label>
                    <input value="<?= $brg["SATUAN_ID"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" required type="number" name="SATUAN_ID" id="SATUAN_ID">
                </li>
            </div>
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="LOKASI_ID">Lokasi: </label>
                </label>
                <label class="input-group">
                    <span>Lokasi:</span>
                    <select required class="input input-bordered" name="LOKASI_ID" id="LOKASI_ID">
                        <?php
                        $lokasi = query("SELECT * FROM lokasi");
                        foreach ($lokasi as $s) : ?>
                            <option <?php if ($s['KODE'] === $brg['LOKASI_ID']) {
                                        echo 'selected';
                                    } ?> value="<?= $s['KODE']; ?>"><?= $s["KETERANGAN"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <div class="md:grid grid-cols-4">
                <li>
                    <label for="STOK">Stok :</label>
                    <input value="<?= $brg["STOK"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" required type="number" name="STOK" id="STOK">
                </li>
                <li>
                    <label for="MIN_STOK">Min Stok: </label>
                    <input value="<?= $brg["MIN_STOK"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="MIN_STOK" id="MIN_STOK">
                </li>
                <li>
                    <label for="MAX_STOK">Max Stok: </label>
                    <input value="<?= $brg["MAX_STOK"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="MAX_STOK" id="MAX_STOK">
                </li>
                <li>
                    <label for="STOK_AWAL">Stok Awal: </label>
                    <input value="<?= $brg["STOK_AWAL"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="STOK_AWAL" id="STOK_AWAL">
                </li>
            </div>
            <li>
                <label for="HARGA_BELI">Harga: </label>
                <input value="<?= $brg["HARGA_BELI"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="HARGA_BELI" id="HARGA_BELI">
            </li>
            <div class="md:grid grid-cols-4">
                <li>
                    <label for="DISKON_RP">Diskon: </label>
                    <input value="<?= $brg["DISKON_RP"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="DISKON_RP" id="DISKON_RP">
                </li>
                <li>
                    <label for="DISKON_GENERAL">Diskon General: </label>
                    <input value="<?= $brg["DISKON_GENERAL"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="DISKON_GENERAL" id="DISKON_GENERAL">
                </li>
                <li>
                    <label for="DISKON_SILVER">Diskon Silver: </label>
                    <input value="<?= $brg["DISKON_SILVER"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="DISKON_SILVER" id="DISKON_SILVER">
                </li>
                <li>
                    <label for="DISKON_GOLD">Diskon Gold: </label>
                    <input value="<?= $brg["DISKON_GOLD"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="DISKON_GOLD" id="DISKON_GOLD">
                </li>
            </div>
            <li>
                <label for="GARANSI">Garansi: </label>
                <input value="<?= $brg["GARANSI"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="GARANSI" id="GARANSI">
            </li>
            <li>
                <label for="TGL_TRANSAKSI">Tanggal Transaksi: </label>
                <input value="<?= $brg["TGL_TRANSAKSI"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="datetime-local" name="TGL_TRANSAKSI" id="TGL_TRANSAKSI">
            </li>
            <li>
                <label for="POIN">Poin: </label>
                <input value="<?= $brg["POIN"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="POIN" id="POIN">
            </li>
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="SUPPLIER_ID">Supplier: </label>
                </label>
                <label class="input-group">
                    <span>Supplier:</span>
                    <select class="input input-bordered" name="SUPPLIER_ID" id="SUPPLIER_ID">
                        <?php
                        $supplier = query("SELECT * FROM supplier");
                        foreach ($supplier as $s) : ?>
                            <option <?php if ($s['KODE'] === $brg['SUPPLIER_ID']) {
                                        echo 'selected';
                                    } ?> value="<?= $s['KODE']; ?>"><?= $s["NAMA"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <li>
                <label for="MARGIN">Margin: </label>
                <input value="<?= $brg["MARGIN"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="MARGIN" id="MARGIN">
            </li>
            <li>
                <label for="FOTO">Upload Foto: </label>
                <img class="max-w-xl rounded-lg aspect-video object-cover" src="<?= $brg["FOTO"]; ?>" alt="<?= $brg["NAMA"]; ?>">
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" accept="" type="file" name="FOTO" id="FOTO">
            </li>
            <li>
                <button class="px-4 py-2 rounded-lg uppercase bg-amber-600 text-white hover:outline-amber-600 hover:bg-white hover:text-amber-600 hover:-translate-y-1 transition-all" type="submit" name="tambah">SIMPAN PERUBAHAN</button>
                <a href="admin.php" class="btn btn-primary">Kembali</a>
            </li>
        </ul>
    </form>
</main>

<?php
include('shared/footer.php');
?>