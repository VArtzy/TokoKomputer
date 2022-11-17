<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Toko Komputer terbaik di Indonesia! Memiliki berbagai macam spare part Komputer terbaik dengan harga yang terjangkau.">
    <link rel="apple-touch-icon" sizes="57x57" href="img/logo/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/logo/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/logo/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/logo/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/logo/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/logo/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/logo/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/logo/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/logo/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="img/logo/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/logo/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/logo/favicon-16x16.png">
    <link rel="shortcut icon" href="img/logo/favicon.ico" type="image/x-icon">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="img/logo/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script defer src="https://kit.fontawesome.com/cbe188b5fc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/index.css">
    <title><?php if (isset($title)) {
                echo 'Joga Computer - ' . $title;
            } else {
                echo "Joga Computer";
            } ?></title>
</head>

<body class="font-dm">
    <?php
    require_once('utils/functions.php');

    if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
        $id = $_COOKIE['id'];
        $key = $_COOKIE['key'];

        // ambil username berdasarkan id
        $result = mysqli_query($conn, "SELECT NAMA FROM customer WHERE `KODE` = '$id'");
        $row = mysqli_fetch_assoc($result);

        if ($key === hash('sha256', $row['NAMA'])) {
            $username = $row['NAMA'];
            include('shared/navlogged.php');
        }
    } else {
        include('shared/navlog.php');
    }
    ?>
</body>

</html>