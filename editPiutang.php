<?php
require_once './utils/functions.php';
require_once './utils/loggedAdmin.php';

$id = $_GET["id"];

$customer = query("SELECT * FROM `customer` WHERE KODE = '$id'")[0];

if (isset($_POST["submit"])) {

    // cek apakah daata berhasil diubah
    if (ubahPiutangUser($_POST) > 0) {
        echo "
        <script>
        alert('Berhasil mengubah Piutang');
        document.location.href = 'userAndAdminManagement.php';
        </script>
        ";
    } else {
        echo "        
        <script>
        alert('Gagal mengubah Piutang');
        document.location.href = 'userAndAdminManagement.php';
        </script>";
    }
}

$title = $customer["NAMA"] . "- Piutang";
include('shared/navadmin.php');
?>

<main id="main" class="md:grid place-items-center max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8">
    <h1 class="md:mt-8 text-4xl mb-4 text-center text-amber-600 dark:text-amber-400">Edit Piutang <?= $customer["NAMA"]; ?></h1>
    <p class="max-w-[567px] mx-auto text-center text-slate-800 dark:text-amber-50 mb-8">Perbarui Piutang User.</a></p>

    <form action="" method="POST">
        <input type="hidden" name="id" value="<?= $customer["KODE"]; ?>">
        <ul class="flex flex-col gap-6 mb-4 justify-center">
            <li>
                <label for="nama">Nama: </label>
                <input value="<?= $customer["NAMA"]; ?>" readonly class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="nama" id="nama">
            </li>
            <li>
                <label for="PLAFON_PIUTANG">Plafon Piutang: </label>
                <input value="<?= $customer["PLAFON_PIUTANG"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="PLAFON_PIUTANG" id="PLAFON_PIUTANG">
            </li>
            <li>
                <label for="TOTAL_PIUTANG">Total Piutang: </label>
                <input value="<?= $customer["TOTAL_PIUTANG"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="TOTAL_PIUTANG" id="TOTAL_PIUTANG">
            </li>
            <li>
                <label for="TOTAL_PEMBAYARAN_PIUTANG">Total Pembayaran Piutang: </label>
                <input value="<?= $customer["TOTAL_PEMBAYARAN_PIUTANG"]; ?>" class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="TOTAL_PEMBAYARAN_PIUTANG" id="TOTAL_PEMBAYARAN_PIUTANG">
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