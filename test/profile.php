<?php
require_once './utils/functions.php';
require_once './utils/logged.php';

$id = $_GET["id"];

$customer = query("SELECT * FROM `customer` WHERE KODE = '$id'")[0];

if (isset($_POST["submit"])) {

    // cek apakah daata berhasil diubah
    if (ubahProfile($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil mengubah profile anda');
        document.location.href = 'pesan.php';
        </script>
        ";
    } else {
        echo "        
        <script>
        alert('Gagal mengubah profile anda');
        document.location.href = 'pesan.php';
        </script>";
    }
}

$title = "Profile & Preferences";
include('shared/nav.php');
?>

<main id="main" class="md:grid place-items-center max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8">
    <h1 class="md:mt-8 text-4xl mb-4 text-center text-amber-600 dark:text-amber-400">Halaman Profile & Preferences</h1>
    <p class="max-w-[567px] mx-auto text-center text-slate-800 dark:text-amber-50 mb-8">Jangan lupa buat penuhin data kamu ya! biar kami makin gampang untuk <a href="pesan.php" class="text-emerald-600">pesanin kamu 😋.</a></p>

    <form action="" method="POST">
        <input type="hidden" name="id" value="<?= $customer["KODE"]; ?>">
        <ul class="flex flex-col gap-6 mb-4 justify-center">
            <div class="form-control">
                <label class="label">
                    <label class="label-text" for="WILAYAH_ID">Wilayah: </label>
                </label>
                <label class="input-group">
                    <span>Wilayah:</span>
                    <select class="input input-bordered" name="WILAYAH_ID" id="WILAYAH_ID">
                        <?php
                        $wilayah = query("SELECT * FROM wilayah");
                        foreach ($wilayah as $w) : ?>
                            <option value="<?= $w['KODE']; ?>"><?= $w["KETERANGAN"]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            <li>
                <label for="NAMA">Nama :</label>
                <input value="<?= $customer["NAMA"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" required type="text" name="NAMA" id="NAMA">
            </li>
            <li>
                <label for="PASSWORD">Password :</label>
                <input value="" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" required type="password" name="PASSWORD" id="PASSWORD">
            </li>
            <li>
                <label for="PASSWORD2">Konfirmasi Password :</label>
                <input value="" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" required type="password" name="PASSWORD2" id="PASSWORD2">
            </li>
            <li>
                <label for="ALAMAT">Alamat: </label>
                <input value="<?= $customer["ALAMAT"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="ALAMAT" id="ALAMAT">
            </li>
            <li>
                <label for="KONTAK">Kontak: </label>
                <input value="<?= $customer["KONTAK"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="KONTAK" id="KONTAK">
            </li>
            <li>
                <label for="NPWP">NPWP: </label>
                <input value="<?= $customer["NPWP"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="NPWP" id="NPWP">
            </li>
            <li>
                <label for="KOTA">Kota: </label>
                <input value="<?= $customer["KOTA"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="KOTA" id="KOTA">
            </li>
            <li>
                <label for="TELEPON">No. Telepon: </label>
                <input value="<?= $customer["TELEPON"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="tel" name="TELEPON" id="TELEPON">
            </li>
            <li>
                <label for="ALAMAT2">Alamat Alternatif: </label>
                <input value="<?= $customer["ALAMAT2"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="tel" name="ALAMAT2" id="ALAMAT2">
            </li>
            <li>
                <label for="JENISANGOTA">Jenis Anggota: </label>
                <input value="<?= $customer["JENIS_ANGGOTA"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="tel" name="JENISANGOTA" id="JENISANGOTA">
            </li>
            <li>
                <button class="px-4 py-2 rounded-lg uppercase bg-amber-600 text-white hover:outline-amber-600 hover:bg-white hover:text-amber-600 hover:-translate-y-1 transition-all" type="submit" name="submit">Perbarui</button>
            </li>
        </ul>
    </form>
</main>

<?php
include('shared/footer.php');
?>