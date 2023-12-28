<?php
require '../utils/functions.php';

// Escape the search term for security
$q = $conn->real_escape_string($_GET['q']);
$s = $conn->real_escape_string($_GET['s']);

// Build and execute a SQL query
$sql = "SELECT * FROM BELI WHERE NOTA LIKE '%$q%' AND SUPPLIER_ID = '$s' AND STATUS_NOTA = 'K' ORDER BY TANGGAL DESC";
$result = $conn->query($sql);

// Prepare an array to hold the results
$pembelian = array();

// Loop through the results and add them to the array
while ($row = $result->fetch_assoc()) {
    $pembelian[] = $row['NOTA'];
}

// Send the array as a JSON response
header('Content-Type: application/json');
echo json_encode($pembelian);
