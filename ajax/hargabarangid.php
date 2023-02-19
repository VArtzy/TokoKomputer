<?php
require '../utils/functions.php';

// Escape the search term for security
$q = $conn->real_escape_string($_GET['q']);

// Build and execute a SQL query
$sql = "SELECT * FROM BARANG WHERE KODE LIKE '%$q%' OR KODE_BARCODE = '$q' ORDER BY KODE DESC";
$result = $conn->query($sql);

// Prepare an array to hold the results
$pembelian = array();

// Loop through the results and add them to the array
while ($row = $result->fetch_assoc()) {
    $pembelian[] = $row['HARGA_BELI'] ?? 0;
    $pembelian[] = query("SELECT HARGA_JUAL from MULTI_PRICE WHERE BARANG_ID = '$q'")[0]['HARGA_JUAL'] ?? 0;
    $pembelian[] = query("SELECT NAMA from BARANG WHERE KODE = '$q'")[0]['NAMA'] ?? "";
}

// Send the array as a JSON response
header('Content-Type: application/json');
echo json_encode($pembelian);
