<?php
require_once './utils/functions.php';
require_once './utils/loggedAdmin.php';

$id = $_GET["id"];
$userAdmin = query("SELECT * FROM `user_admin` WHERE ID = '$id'")[0];

if ($username !== $userAdmin["NAMA"]) {
    header("Location: userAndAdminManagement.php");
}


if (isset($_POST["submit"])) {

    // cek apakah daata berhasil diubah
    if (ubahAdminSendiri($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil mengubah Admin Sendiri');
        document.location.href = 'userAndAdminManagement.php';
        </script>
        ";
    } else {
        echo "        
        <script>
        alert('Gagal mengubah Admin Sendiri');
        document.location.href = 'userAndAdminManagement.php';
        </script>";
    }
}

$title = $userAdmin["NAMA"] . " - Edit Admin";
include('shared/navadmin.php');
?>

<main id="main" class="md:grid place-items-center max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8">
    <h1 class="md:mt-8 text-4xl mb-4 text-center text-amber-600 dark:text-amber-400">Edit Profile Admin</h1>
    <p class="max-w-[567px] mx-auto text-center text-slate-800 dark:text-amber-50 mb-8">Edit Profile Admin Sendiri.</a></p>

    <form action="" method="POST">
        <input type="hidden" name="id" value="<?= $userAdmin["ID"]; ?>">
        <ul class="flex flex-col gap-6 mb-4 justify-center">
            <li>
                <label for="name">Nama Admin: </label>
                <input value="<?= $userAdmin["NAMA"]; ?>" readonly class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="name" id="name">
            </li>
            <li>
                <label for="IS_AKTIF">Aktif: </label>
                <select name="IS_AKTIF" id="IS_AKTIF">
                    <option value="1">Aktif</option>
                    <option <?php if (!$userAdmin["IS_AKTIF"]) echo 'selected' ?> value="0">Nonaktif</option>
                </select>
            </li>
            <li>
                <label for="ALAMAT">Alamat: </label>
                <input value="<?= $userAdmin["ALAMAT"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="ALAMAT" id="ALAMAT">
            </li>
            <li>
                <label for="WILAYAH_ID">Kode Pos: </label>
                <input value="<?= $userAdmin["WILAYAH_ID"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="WILAYAH_ID" id="WILAYAH_ID">
            </li>
            <li>
                <label for="TELEPON">Telepon: </label>
                <input value="<?= $userAdmin["TELEPON"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="tel" name="TELEPON" id="TELEPON">
            </li>
            <li>
                <label for="NO_REKENING">No Rekening: </label>
                <input value="<?= $userAdmin["NO_REKENING"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="NO_REKENING" id="NO_REKENING">
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