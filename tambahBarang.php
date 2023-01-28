<?php
require_once './utils/functions.php';
require_once './utils/loggedAdmin.php';

$nom = '11';
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';
if (!in_array($nom, $aksesMenu) || !isset($aksi[0]) || $aksi[0] === '0') return header('Location: barang.php');

if (isset($_POST["tambah"])) {
    if (tambahBarang($_POST) > 0) {
        echo  "<script>
    alert('Barang baru berhasil ditambahkan');
    </script>";
        header('Location: barang.php');
    } else {
        echo mysqli_error($conn);
    }
}

$title = "Tambah Data Barang";
include('shared/navadmin.php');
?>

<main id="main" class="md:grid place-items-center max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8">
    <h1 class="md:mt-8 text-4xl mb-4 text-center text-amber-600 dark:text-amber-400">Tambah Data Barang</h1>
    <p class="max-w-[567px] mx-auto text-center text-slate-800 dark:text-amber-50 mb-8">Tambahkan data barang.</p>

    <form action="" method="POST" enctype="multipart/form-data">
        <ul class="flex flex-col gap-6 mb-4 justify-center">
            <li>
                <label for="KODE">Kode: </label>
                <input value="<?= date('Ymd') . query("SELECT COUNT(*) as COUNT FROM barang")[0]["COUNT"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="KODE" id="KODE">
            </li>
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="GOLONGAN_ID">Golongan: </label>
                </label>
                <label class="input-group">
                    <span>Golongan:</span>
                    <select required class="input input-bordered" name="GOLONGAN_ID" id="GOLONGAN_ID">
                        <?php
                        $GOLONGAN = query("SELECT * FROM GOLONGAN");
                        foreach ($GOLONGAN as $w) : ?>
                            <option value="<?= $w['KODE']; ?>"><?= $w["KETERANGAN"]; ?></option>
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
                        $SUB_GOLONGAN = query("SELECT * FROM SUB_GOLONGAN");
                        foreach ($SUB_GOLONGAN as $w) : ?>
                            <option value="<?= $w['KODE']; ?>"><?= $w["KETERANGAN"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <li>
                <label for="NAMA">Nama Barang :</label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" required type="text" name="NAMA" id="NAMA">
            </li>
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="SATUAN_ID">Satuan: </label>
                </label>
                <label class="input-group">
                    <span>Satuan:</span>
                    <select class="input input-bordered" name="SATUAN_ID" id="SATUAN_ID">
                        <?php
                        $SATUAN = query("SELECT * FROM SATUAN");
                        foreach ($SATUAN as $w) : ?>
                            <option value="<?= $w['KODE']; ?>"><?= $w["NAMA"]; ?> - <?= $w["KONVERSI"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <li>
                <label for="HARGA_JUAL">Harga Jual: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="HARGA_JUAL" id="HARGA_JUAL">
            </li>
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="SUPPLIER_ID">Supplier: </label>
                </label>
                <label class="input-group">
                    <span>Supplier:</span>
                    <select class="input input-bordered" name="SUPPLIER_ID" id="SUPPLIER_ID">
                        <?php
                        $SUPPLIER = query("SELECT * FROM SUPPLIER");
                        foreach ($SUPPLIER as $w) : ?>
                            <option value="<?= $w['KODE']; ?>"><?= $w["NAMA"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <li>
                <label for="STOK">Stok :</label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" required type="number" name="STOK" id="STOK">
            </li>
            <li>
                <label for="MIN_STOK">Min Stok: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="MIN_STOK" id="MIN_STOK">
            </li>
            <li>
                <label for="MAX_STOK">Max Stok: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="MAX_STOK" id="MAX_STOK">
            </li>
            <li>
                <label for="HARGA_BELI">Harga Beli: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="HARGA_BELI" id="HARGA_BELI">
            </li>
            <li>
                <label for="STOK_AWAL">Stok Awal: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="STOK_AWAL" id="STOK_AWAL">
            </li>
            <li>
                <label for="DISKON_RP">Diskon: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="DISKON_RP" id="DISKON_RP">
            </li>
            <li>
                <label for="GARANSI">Garansi: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="GARANSI" id="GARANSI">
            </li>
            <li>
                <label for="TGL_TRANSAKSI">Tanggal Transaksi: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="datetime-local" name="TGL_TRANSAKSI" id="TGL_TRANSAKSI">
            </li>
            <li>
                <label for="DISKON_GENERAL">Diskon General: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="DISKON_GENERAL" id="DISKON_GENERAL">
            </li>
            <li>
                <label for="DISKON_SILVER">Diskon Silver: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="DISKON_SILVER" id="DISKON_SILVER">
            </li>
            <li>
                <label for="DISKON_GOLD">Diskon Gold: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="DISKON_GOLD" id="DISKON_GOLD">
            </li>
            <li>
                <label for="POIN">Poin: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="POIN" id="POIN">
            </li>
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="LOKASI_ID">Lokasi: </label>
                </label>
                <label class="input-group">
                    <span>Lokasi:</span>
                    <select required class="input input-bordered" name="LOKASI_ID" id="LOKASI_ID">
                        <?php
                        $LOKASI = query("SELECT * FROM LOKASI");
                        foreach ($LOKASI as $w) : ?>
                            <option value="<?= $w['KODE']; ?>"><?= $w["KETERANGAN"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <li>
                <label for="MARGIN">Margin: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="MARGIN" id="MARGIN">
            </li>
            <li>
                <label for="FOTO">Upload Foto: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" accept="" type="file" name="FOTO" id="FOTO">
            </li>
            <li>
                <button class="px-4 py-2 rounded-lg uppercase bg-amber-600 text-white hover:outline-amber-600 hover:bg-white hover:text-amber-600 hover:-translate-y-1 transition-all" type="submit" name="tambah">TAMBAH BARANG</button>
            </li>
        </ul>
    </form>
</main>

<?php
include('shared/footer.php');
?>