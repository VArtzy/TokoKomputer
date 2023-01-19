<?php
require '../utils/functions.php';

// Escape the search term for security
$q = $conn->real_escape_string($_GET['q']);

// Build and execute a SQL query
$sql = "SELECT * FROM supplier WHERE NAMA LIKE '%$q%' OR KODE_BARCODE LIKE '%$q%'";
$result = $conn->query($sql);

// Prepare an array to hold the results
$supplier = array();

// Loop through the results and add them to the array
while ($row = $result->fetch_assoc()) {
    $supplier[] = $row['NAMA'];
    $supplier[] = $row['KODE_BARCODE'];
}

// Send the array as a JSON response
header('Content-Type: application/json');
echo json_encode($supplier);
