<?php
require '../utils/functions.php';

// Escape the search term for security
$q = $conn->real_escape_string($_GET['q']);

// Build and execute a SQL query
$sql = "SELECT * FROM JUAL WHERE NOTA LIKE '%$q%'";
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
