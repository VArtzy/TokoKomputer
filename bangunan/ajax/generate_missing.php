<?php require_once('../utils/functions.php');
require_once('../utils/loggedAdmin.php');

if (isset($_POST["generate"])) {
    $brg = query("SELECT BARANG.KODE, BARANG.HARGA_BELI, MULTI_PRICE.BARANG_ID FROM BARANG LEFT JOIN MULTI_PRICE ON BARANG.KODE=MULTI_PRICE.BARANG_ID");

    foreach ($brg as $b) {
        var_dump($b);
        if ($b['KODE'] != $b['BARANG_ID']) {
            $HARGA_BELI = $b['HARGA_BELI'];
            $KODE_BAR = $b['KODE'];
            mysqli_query($conn, "INSERT INTO multi_price(`KODE_SATUAN`, `CUSTOMER_ID`, `BARANG_ID`, `HARGA_KE`, `JUMLAH_R1`, `JUMLAH_R2`, `HARGA_JUAL`) VALUES
     ('1', '', '$KODE_BAR', 1, 1, 1000, '$HARGA_BELI')");
        }
    }
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate missing multi_price</title>
</head>

<body>
    <form action="" method="post">
        <button name="generate" id="generate">Generate</button>
    </form>
</body>

</html>