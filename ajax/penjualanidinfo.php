<?php
require '../utils/functions.php';

// Escape the search term for security
$q = $conn->real_escape_string($_GET['q']);

// Build and execute a SQL query
$sql = "select SUM(jumlah*harga_jual) from item_jual where nota = '$q') AS PIUTANG, (select sum(nominal-diskon-retur-diskon_rp) from item_pelunasan_piutang where nota_jual = '$q') as SISA_PIUTANG";
$result = $conn->query($sql);

// Prepare an array to hold the results
$info = array();

// Loop through the results and add them to the array
while ($row = $result->fetch_assoc()) {
    $info[] = $row['PIUTANG'];
    $info[] = $row['SISA_PIUTANG'];
}

// Send the array as a JSON response
header('Content-Type: application/json');
echo json_encode($info);
