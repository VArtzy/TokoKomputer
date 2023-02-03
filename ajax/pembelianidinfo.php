<?php
require '../utils/functions.php';

// Escape the search term for security
$q = $conn->real_escape_string($_GET['q']);

// Build and execute a SQL query
$sql = "select (select SUM(jumlah*harga_beli) from item_beli where nota = '$q') AS HUTANG, (select SUM(jumlah*harga_beli) from item_beli where nota = '$q') - (select sum(nominal-diskon-retur-diskon_rp) from item_pelunasan_hutang where nota_beli = '$q') AS SISA_HUTANG;";
$result = $conn->query($sql);

// Prepare an array to hold the results
$info = array();

// Loop through the results and add them to the array
while ($row = $result->fetch_assoc()) {
    $info[] = $row['HUTANG'];
    $info[] = $row['SISA_HUTANG'] ?? $row['HUTANG'];
}

// Send the array as a JSON response
header('Content-Type: application/json');
echo json_encode($info);
