<?php
require_once './utils/functions.php';
require_once './utils/loggedAdmin.php';

$kode = $_GET["kode"];

$sales = query("SELECT * FROM `salesman` WHERE KODE = '$kode'")[0];

if (isset($_POST["submit"])) {

    // cek apakah daata berhasil diubah
    if (ubahSales($userAdminID, $_POST) > 0) {
        echo "
        <script>
        alert('Berhasil mengubah Sales');
        document.location.href = 'userAndAdminManagement.php';
        </script>
        ";
    } else {
        echo "        
        <script>
        alert('Gagal mengubah Sales');
        document.location.href = 'userAndAdminManagement.php';
        </script>";
    }
}

if (isset($_POST["hapus"])) {
    // cek apakah daata berhasil diubah
    if (hapusSales($_POST['id']) > 0) {
        echo "
        <script>
        alert('Berhasil menghapus Sales');
        document.location.href = 'userAndAdminManagement.php';
        </script>
        ";
    } else {
        echo "        
        <script>
        alert('Gagal menghapus Sales');
        document.location.href = 'userAndAdminManagement.php';
        </script>";
    }
}

$title = $sales["NAMA"] . " - Edit Sales";
include('shared/navadmin.php');
?>

<main id="main" class="md:grid place-items-center max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8">
    <h1 class="md:mt-8 text-4xl mb-4 text-center text-amber-600 dark:text-amber-400">Edit Sales</h1>
    <p class="max-w-[567px] mx-auto text-center text-slate-800 dark:text-amber-50 mb-8">Edit Sales disini.</p>

    <form action="" method="POST">
        <input type="hidden" name="id" value="<?= $sales["KODE"]; ?>">
        <ul class="flex flex-col gap-6 mb-4 justify-center">
            <li>
                <label for="TOTAL_NOTA_PENJUALAN">Total Nota Penjualan: </label>
                <input value="<?= $sales["TOTAL_NOTA_PENJUALAN"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="TOTAL_NOTA_PENJUALAN" id="TOTAL_NOTA_PENJUALAN">
            </li>
            <li>
                <label for="TOTAL_ITEM_PENJUALAN">Total Item Penjualan: </label>
                <input value="<?= $sales["TOTAL_ITEM_PENJUALAN"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="TOTAL_ITEM_PENJUALAN" id="TOTAL_ITEM_PENJUALAN">
            </li>
            <li>
                <label for="name">Nama Sales: </label>
                <input value="<?= $sales["NAMA"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="name" id="name">
            </li>
            <li>
                <label for="TELEPON">Telepon: </label>
                <input value="<?= $sales["TELEPON"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="TELEPON" id="TELEPON">
            </li>
            <li>
                <label for="ALAMAT">Alamat: </label>
                <input value="<?= $sales["ALAMAT"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="ALAMAT" id="ALAMAT">
            </li>
            <li>
                <label for="NO_REKENING">No. Rekening: </label>
                <input value="<?= $sales["NO_REKENING"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="NO_REKENING" id="NO_REKENING">
            </li>
            <li>
                <button class="px-4 py-2 rounded-lg uppercase bg-amber-600 text-white hover:outline-amber-600 hover:bg-white hover:text-amber-600 hover:-translate-y-1 transition-all" type="submit" name="submit">Perbarui</button>
                <button class="btn btn-error" onclick="return confirm('Apakah anda yakin ingin menghapus sales ini?')" type="submit" name="hapus">!Hapus admin</button>
            </li>
        </ul>
    </form>
</main>

<?php
include('shared/footer.php');
?>