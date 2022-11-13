<?php
session_start();
require_once('utils/functions.php');

// cek cookie
if (isset($_COOKIE['1']) && isset($_COOKIE['2'])) {
    $id = $_COOKIE['1'];
    $key = $_COOKIE['2'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT NAMA FROM user_admin WHERE `ID` = '$id'");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if ($key === hash('sha256', $row['NAMA'])) {
        $_SESSION['loginAdmin'] = true;
    }
}

if (isset($_SESSION["loginAdmin"])) {
    header("Location: admin.php");
    exit;
}



if (isset($_POST["loginAdmin"])) {

    $username = $_POST["NAMA"];
    $password = $_POST["PASSWORD"];

    $result = mysqli_query($conn, "SELECT * FROM user_admin WHERE NAMA = '$username'");

    // cek username
    if (mysqli_num_rows($result) === 1) {

        // cek password
        $row = mysqli_fetch_assoc($result);
        if ($password === $row["PASS"]) {
            // set session
            $_SESSION["loginAdmin"] = true;

            setcookie('1', $row['ID'], time() + (60 * 60 * 24 * 30));
            setcookie('2', hash("sha256", $row['NAMA']), time() + (60 * 60 * 24 * 30));

            header("Location: admin.php");
            exit;
        } else {
            $errormsg = 'Password salah!';
        }
    } else {
        $errormsg = 'Username Admin Tidak ditemukan!';
    }

    $error = true;
}

$title = "Login Admin";
include('shared/navAdmin.php');
?>

<main id="main" class="md:grid place-items-center max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-4xl mb-4 text-amber-600 dark:text-amber-400 text-center">Halaman Login Admin</h1>
    <p class="max-w-[567px] mx-auto mb-8 text-center text-slate-800 dark:text-amber-50">Masuk ke Halaman Admin.</p>

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
                <button class="px-4 py-2 rounded-lg uppercase bg-amber-600 text-white hover:outline-amber-600 hover:bg-white hover:text-amber-600 dark:text-amber-50 dark:hover:text-amber-400 hover:-translate-y-1 transition-all" type="submit" name="loginAdmin">LOGIN</button>
            </li>
        </ul>

        <p class="text-emerald-600 dark:text-emerald-400 text-center">Belum memiliki akun? <span class="font-bold text-sky-600 dark:text-sky-400">Minta operator buat.</span></p>
</main>

<?php
include('shared/footer.php')
?>