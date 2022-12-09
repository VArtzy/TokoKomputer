<?php
require('../utils/functions.php');

$barang = query('select BARANG_ID, sum(JUMLAH) as JUMLAH from item_jual group by BARANG_ID ORDER BY sum(JUMLAH) DESC LIMIT 5;');

echo (json_encode($barang));
