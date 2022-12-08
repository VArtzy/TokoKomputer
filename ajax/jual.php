<?php
require('../utils/functions.php');

$senin = query("select COUNT(*) as jumlah, DAYNAME(CURDATE()) as senin from jual where TANGGAL = CURDATE();");
$selasa = query("select COUNT(*) as jumlah, DAYNAME(DATE_SUB(CURDATE(),INTERVAL 1 DAY)) as selasa from jual where TANGGAL = DATE_SUB(CURDATE(),INTERVAL 1 DAY);");
$rabu = query("select COUNT(*) as jumlah, DAYNAME(DATE_SUB(CURDATE(),INTERVAL 2 DAY)) as rabu from jual where TANGGAL = DATE_SUB(CURDATE(),INTERVAL 2 DAY);");
$kamis = query("select COUNT(*) as jumlah, DAYNAME(DATE_SUB(CURDATE(),INTERVAL 3 DAY)) as kamis from jual where TANGGAL = DATE_SUB(CURDATE(),INTERVAL 3 DAY);");
$jumat = query("select COUNT(*) as jumlah, DAYNAME(DATE_SUB(CURDATE(),INTERVAL 4 DAY)) as jumat from jual where TANGGAL = DATE_SUB(CURDATE(),INTERVAL 4 DAY);");
$sabtu = query("select COUNT(*) as jumlah, DAYNAME(DATE_SUB(CURDATE(),INTERVAL 5 DAY)) as sabtu from jual where TANGGAL = DATE_SUB(CURDATE(),INTERVAL 5 DAY);");
$minggu = query("select COUNT(*) as jumlah, DAYNAME(DATE_SUB(CURDATE(),INTERVAL 6 DAY)) as minggu from jual where TANGGAL = DATE_SUB(CURDATE(),INTERVAL 6 DAY);");

function convertTanggal($tanggal)
{
    if ($tanggal === 'Monday') return 'Senin';
    if ($tanggal === 'Tuesday') return 'Selasa';
    if ($tanggal === 'Wednesday') return 'Rabu';
    if ($tanggal === 'Thursday') return 'Kamis';
    if ($tanggal === 'Friday') return 'Jumat';
    if ($tanggal === 'Saturday') return 'Sabtu';
    if ($tanggal === 'Sunday') return 'Minggu';

    return 'Invalid';
}

$jual = [
    'hari' => [convertTanggal($senin[0]['senin']), convertTanggal($selasa[0]['selasa']), convertTanggal($rabu[0]['rabu']), convertTanggal($kamis[0]['kamis']), convertTanggal($jumat[0]['jumat']), convertTanggal($sabtu[0]['sabtu']), convertTanggal($minggu[0]['minggu'])],
    'jumlah' => [$senin[0]['jumlah'], $selasa[0]['jumlah'], $rabu[0]['jumlah'], $kamis[0]['jumlah'], $jumat[0]['jumlah'], $sabtu[0]['jumlah'], $minggu[0]['jumlah']]
];

echo (json_encode($jual));
