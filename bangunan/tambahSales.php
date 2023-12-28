<?php
require_once './utils/functions.php';
require_once './utils/loggedAdmin.php';

$nom = '9';
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';
if (!in_array($nom, $aksesMenu) || !isset($aksi[0]) || $aksi[0] === '0') return header('Location: userAndAdminManagement.php#salesman');

if (isset($_POST["submit"])) {
    if (tambahSales($userAdminID, $_POST) > 0) {
        echo "
        <script>
        alert('Berhasil Menambah Salesman Baru');
        document.location.href = 'userAndAdminManagement.php';
        </script>
        ";
    } else {
        echo "        
        <script>
        alert('Gagal Menambah Salesman Baru');
        document.location.href = 'userAndAdminManagement.php';
        </script>";
    }
}

$title = "Tambah Salesman";
include('shared/navadmin.php');
?>

<main id="main" class="md:grid place-items-center max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8">
    <h1 class="md:mt-8 text-4xl mb-4 text-center text-amber-600 dark:text-amber-400">Tambah Salesman</h1>
    <p class="max-w-[567px] mx-auto text-center text-slate-800 dark:text-amber-50 mb-8">Tambahkan Salesman untuk noting offline</p>

    <form action="" method="POST">
        <ul class="flex flex-col gap-6 mb-4 justify-center">
            <li>
                <label for="NAMA">Nama Salesman: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="NAMA" id="NAMA">
            </li>
            <li>
                <label for="ALAMAT">Alamat: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="ALAMAT" id="ALAMAT">
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
                <button class="px-4 py-2 rounded-lg uppercase bg-amber-600 text-white hover:outline-amber-600 hover:bg-white hover:text-amber-600 hover:-translate-y-1 transition-all" type="submit" name="submit">Tambah sales</button>
            </li>
        </ul>
    </form>
</main>

<?php
include('shared/footer.php');
?>