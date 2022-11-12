<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT NAMA FROM customer WHERE `KODE` = '$id'");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash('sha256', $row['NAMA'])) {
        $username = $row['NAMA'];
    } else {
        echo $key . '                      ' . hash('sha256', $row['NAMA']);
        // header("Location: logout.php");
    }
} else {
    echo 'pass';
    // header("Location: logout.php");
}
