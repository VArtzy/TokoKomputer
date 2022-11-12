<?php
require_once './utils/functions.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo  "<script>
    alert('user baru berhasil ditambahkan');
    </script>";
        header('Location: login');
    } else {
        echo mysqli_error($conn);
    }
}

include('shared/nav.php');
?>

<main id="main" class="md:grid place-items-center max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8">
    <h1 class="md:mt-32 text-4xl mb-4 text-center text-amber-600 dark:text-amber-400">Halaman Pendaftaran</h1>
    <p class="max-w-[567px] mx-auto text-center text-slate-800 dark:text-amber-50 mb-8">Sebelum kamu memesan, ada baiknya kamu melakukan daftar terlebih dahulu. Biar kami bisa memproses pesanan kamu. Ga lama kok, ga sampai semenit :)</p>

    <form action="" method="POST">
        <ul class="flex flex-col gap-6 mb-4 justify-center">
            <li>
                <label for="NAMA">Nama :</label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" required type="text" name="NAMA" id="NAMA">
            </li>
            <li>
                <label for="PASSWORD">Password :</label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" required type="password" name="PASSWORD" id="PASSWORD">
            </li>
            <li>
                <label for="PASSWORD2">Konfirmasi Password :</label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" required type="password" name="PASSWORD2" id="PASSWORD2">
            </li>
            <li>
                <label for="ALAMAT">Alamat: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="ALAMAT" id="ALAMAT">
            </li>
            <li>
                <label for="KONTAK">Kontak: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="KONTAK" id="KONTAK">
            </li>
            <li>
                <label for="NPWP">NPWP: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="number" name="NPWP" id="NPWP">
            </li>
            <li>
                <label for="KOTA">Kota: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="KOTA" id="KOTA">
            </li>
            <li>
                <label for="TELEPON">No. Telepon: </label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="tel" name="TELEPON" id="TELEPON">
            </li>
            <li>
                <button class="px-4 py-2 rounded-lg uppercase bg-amber-600 text-white hover:outline-amber-600 hover:bg-white hover:text-amber-600 hover:-translate-y-1 transition-all" type="submit" name="register">Register</button>
            </li>
        </ul>
        <p class="text-emerald-600 dark:text-emerald-400 text-center">Sudah memiliki akun? <span><a class="font-bold text-sky-600 dark:text-sky-400" href="login.php">Login</a></span></p>
    </form>
</main>

<?php
include('shared/footer.php');
?>