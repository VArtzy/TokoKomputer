<?php
require '../utils/functions.php';

// Escape the search term for security
$q = $conn->real_escape_string($_GET['q']);
$c = $conn->real_escape_string($_GET['c']);

// Build and execute a SQL query
$sql = "SELECT * FROM JUAL WHERE NOTA LIKE '%$q%' AND CUSTOMER_ID = '$c' AND STATUS_NOTA = 'K' ORDER BY TANGGAL DESC";
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
