<?php
require_once './utils/functions.php';
require_once './utils/loggedAdmin.php';
require_once './utils/hakAksesAdminLv2.php';

if (isset($_POST["submit"])) {

    // cek apakah daata berhasil diubah
    if (tambahAdmin($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menambah Admin Baru');
        document.location.href = 'userAndAdminManagement.php';
        </script>
        ";
    } else {
        echo "        
        <script>
        alert('Gagal Menambah Admin Baru');
        document.location.href = 'userAndAdminManagement.php';
        </script>";
    }
}

$title = "Tambah Admin";
include('shared/navadmin.php');
?>

<main id="main" class="md:grid place-items-center max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8">
    <h1 class="md:mt-8 text-4xl mb-4 text-center text-amber-600 dark:text-amber-400">Tambah Admin</h1>
    <p class="max-w-[567px] mx-auto text-center text-slate-800 dark:text-amber-50 mb-8">Tambahkan Admin untuk meng<i>operasi</i> aplikasi! Khusus Admin Lv 2.</a></p>

    <form action="" method="POST">
        <ul class="flex flex-col gap-6 mb-4 justify-center">
            <li>
                <label for="NAMA">Nama Admin: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="NAMA" id="NAMA">
            </li>
            <li>
                <label for="PASS">Password: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="password" name="PASS" id="PASS">
            </li>
            <li>
                <label for="PASS2">Konfirmasi Password: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="password" name="PASS2" id="PASS2">
            </li>
            <li>
                <label for="IS_AKTIF">Aktif: </label>
                <select name="IS_AKTIF" id="IS_AKTIF">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </li>
            <li>
                <label for="ALAMAT">Alamat: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="ALAMAT" id="ALAMAT">
            </li>
            <li>
                <label for="WILAYAH_ID">Kode Pos: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="WILAYAH_ID" id="WILAYAH_ID">
            </li>
            <li>
                <label for="TELEPON">Telepon: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="tel" name="TELEPON" id="TELEPON">
            </li>
            <li>
                <label for="NO_REKENING">No Rekening: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="NO_REKENING" id="NO_REKENING">
            </li>
            <li>
                <label for="GAJI_POKOK">Gaji Awal: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="GAJI_POKOK" id="GAJI_POKOK">
            </li>
            <li>
                <button class="px-4 py-2 rounded-lg uppercase bg-amber-600 text-white hover:outline-amber-600 hover:bg-white hover:text-amber-600 hover:-translate-y-1 transition-all" type="submit" name="submit">Tambah admin</button>
            </li>
        </ul>
    </form>
</main>

<?php
include('shared/footer.php');
?>