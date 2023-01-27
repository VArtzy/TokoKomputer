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
    $result = mysqli_query($conn, "SELECT `NAMA`, `GROUP_HAK_AKSES_ID`, `ID`, `HAK_AKSES_USER` FROM `user_admin` WHERE ID = '$id'");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash("sha256", $row['NAMA'])) {
        $username = $row['NAMA'];
        $hakAksesID = $row['GROUP_HAK_AKSES_ID'];
        $userAdminID = $row['ID'];
        $hakAkses = $row['HAK_AKSES_USER'];
        $hakAksesArr = explode(',', $row['HAK_AKSES_USER']);
    } else {
        header("Location: logoutAdmin.php");
    }
} else {
    header("Location: logoutAdmin.php");
}
