<?php
session_start();
if (!isset($_SESSION["loginAdmin"])) {
    header("Location: loginAdmin.php");
    exit;
}

if (isset($_COOKIE['1']) && isset($_COOKIE['2'])) {
    $id = $_COOKIE['1'];
    $key = $_COOKIE['2'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT `NAMA` FROM `user_admin` WHERE ID = '$id'");
    $row = mysqli_fetch_assoc($result);

    if ($key === $row['NAMA']) {
        $username = $row['NAMA'];
    } else {
        header("Location: logoutAdmin.php");
    }
} else {
    header("Location: logoutAdmin.php");
}
