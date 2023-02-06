<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = <<<EOT
 (
    SELECT
      a.KODE,
      a.NAMA,
      a.STOK_AWAL,
      a.STOK,
      a.MIN_STOK,
      a.MAX_STOK,
      a.HARGA_BELI,
      b.HARGA_JUAL,
      a.GARANSI,
      a.GOLONGAN_ID,
      a.SUB_GOLONGAN_ID
    FROM barang a
    LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID
 ) temp
EOT;

// Table's primary key
$primaryKey = 'KODE';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => 'KODE', 'dt' => 0),
    array('db' => 'NAMA',  'dt' => 1),
    array('db' => 'STOK_AWAL',     'dt' => 2),
    array('db' => 'STOK',     'dt' => 3),
    array('db' => 'MIN_STOK',     'dt' => 4),
    array('db' => 'MAX_STOK',     'dt' => 5),
    array('db' => 'HARGA_BELI',     'dt' => 6),
    array('db' => 'HARGA_JUAL',     'dt' => 7),
    array('db' => 'GARANSI',     'dt' => 8),
    array('db' => 'GOLONGAN_ID',     'dt' => 9),
    array('db' => 'SUB_GOLONGAN_ID',     'dt' => 10),
    // array(
    //     'db'        => 'start_date',
    //     'dt'        => 4,
    //     'formatter' => function ($d, $row) {
    //         return date('jS M y', strtotime($d));
    //     }
    // ),
    // array(
    //     'db'        => 'salary',
    //     'dt'        => 5,
    //     'formatter' => function ($d, $row) {
    //         return '$' . number_format($d);
    //     }
    // )
);

// SQL server connection information
$sql_details = array(
    'user' => 'admin',
    'pass' => 'admin789',
    'db'   => 'web_joga_comp_test',
    'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require('ssp.class.php');

echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
// echo json_encode(
//     SSP::simple($_GET, $sql_details, 'multi_price', 'KODE', array(
//         array('db' => 'HARGA_JUAL', 'dt' => 11),
//     ))
// );
