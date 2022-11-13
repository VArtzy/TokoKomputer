<?php
require_once './utils/functions.php';
require_once './utils/loggedAdmin.php';
require_once './utils/hakAksesAdminLv2.php';

$id = $_GET["id"];

$userAdmin = query("SELECT * FROM `user_admin` WHERE ID = '$id'")[0];

if (isset($_POST["submit"])) {

    // cek apakah daata berhasil diubah
    if (ubahAdmin($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil mengubah Admin');
        document.location.href = 'userAndAdminManagement.php';
        </script>
        ";
    } else {
        echo "        
        <script>
        alert('Gagal mengubah Admin');
        document.location.href = 'userAndAdminManagement.php';
        </script>";
    }
}

$title = $userAdmin["NAMA"] . " - Edit Admin";
include('shared/navadmin.php');
?>

<main id="main" class="md:grid place-items-center max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8">
    <h1 class="md:mt-8 text-4xl mb-4 text-center text-amber-600 dark:text-amber-400">Edit Admin</h1>
    <p class="max-w-[567px] mx-auto text-center text-slate-800 dark:text-amber-50 mb-8">Edit Admin khusus Admin Lv 2.</a></p>

    <form action="" method="POST">
        <input type="hidden" name="id" value="<?= $userAdmin["ID"]; ?>">
        <ul class="flex flex-col gap-6 mb-4 justify-center">
            <li>
                <label for="name">Nama Admin: </label>
                <input value="<?= $userAdmin["NAMA"]; ?>" readonly class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="name" id="name">
            </li>
            <li>
                <label for="IS_AKTIF">Aktif: </label>
                <input value="<?= $userAdmin["IS_AKTIF"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="IS_AKTIF" id="IS_AKTIF">
            </li>
            <li>
                <label for="GROUP_HAK_AKSES_ID">Hak Akses Lv: </label>
                <input value="<?= $userAdmin["GROUP_HAK_AKSES_ID"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="GROUP_HAK_AKSES_ID" id="GROUP_HAK_AKSES_ID">
            </li>
            <li>
                <label for="GAJI_POKOK">Gaji Pokok: </label>
                <input value="<?= $userAdmin["GAJI_POKOK"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="GAJI_POKOK" id="GAJI_POKOK">
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