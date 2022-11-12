<?php
session_start();
require_once('utils/functions.php');

// cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT NAMA FROM customer WHERE `KODE` = '$id'");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash('sha256', $row['NAMA'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: pesan.php");
    exit;
}



if (isset($_POST["login"])) {

    $username = $_POST["NAMA"];
    $password = $_POST["PASSWORD"];

    $result = mysqli_query($conn, "SELECT * FROM customer WHERE NAMA = '$username'");

    // cek username
    if (mysqli_num_rows($result) === 1) {

        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["PASSWORD"])) {
            // set session
            $_SESSION["login"] = true;

            setcookie('id', $row['KODE'], time() + (60 * 60 * 24 * 30));
            setcookie('key', hash('sha256', $row['NAMA']), time() + (60 * 60 * 24 * 30));

            header("Location: pesan.php");
            exit;
        } else {
            $errormsg = 'Password salah!' . $password . $row['PASSWORD'];
            echo password_verify($password, $row["PASSWORD"]);
        }
    } else {
        $errormsg = 'Username Tidak ditemukan! Jika tidak mempunyai akun cobalah daftar.';
    }

    $error = true;
}


include('shared/nav.php');
?>

<main id="main" class="md:grid place-items-center max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-32">
    <h1 class="text-4xl mb-4 text-amber-600 dark:text-amber-400 text-center">Halaman Login</h1>
    <p class="max-w-[567px] mx-auto mb-8 text-center text-slate-800 dark:text-amber-50">Masuk ke akun kamu.</p>

    <?php if (isset($error)) : ?>
        <p style="color: red; font-style:italic;"><?= $errormsg; ?></p>
    <?php endif; ?>

    <form action="" method="POST">

        <ul class="flex flex-col gap-6 mb-8 items-center">

            <li>

                <label for="NAMA">Nama :</label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="text" name="NAMA" id="NAMA">

            </li>

            <li>

                <label for="PASSWORD">Password :</label>
                <input class="px-2 py-1 bg-slate-100 dark:bg-slate-700 dark:text-white rounded-sm" type="password" name="PASSWORD" id="PASSWORD">

            </li>

            <li>
                <button class="px-4 py-2 rounded-lg uppercase bg-amber-600 text-white hover:outline-amber-600 hover:bg-white hover:text-amber-600 dark:text-amber-50 dark:hover:text-amber-400 hover:-translate-y-1 transition-all" type="submit" name="login">LOGIN</button>
            </li>
        </ul>

        <p class="text-emerald-600 dark:text-emerald-400 text-center">Belum memiliki akun? <span><a class="font-bold text-sky-600 dark:text-sky-400" href="daftar.php">Buat akun</a></span></p>
</main>

<?php
include('shared/footer.php')
?>