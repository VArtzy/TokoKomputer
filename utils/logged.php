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
    $result = mysqli_query($conn, "SELECT NAMA, TOTAL_PEMBAYARAN_PIUTANG FROM customer WHERE `KODE` = '$id'");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash('sha256', $row['NAMA'])) {
        $username = $row['NAMA'];
        $totalPembayaranPiutang = $row['TOTAL_PEMBAYARAN_PIUTANG'];
    } else {
        header("Location: logout.php");
    }
} else {
    header("Location: logout.php");
}
