<?php
$conn = mysqli_connect("host", "user", "pass", "db");
// $conn = mysqli_connect("localhost", "root", "", "tokokomputer");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function isIdExist($table, $col, $id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM $table WHERE $col = '$id'");
    if (mysqli_fetch_assoc($result)) {
        return substr_replace($id, $id[strlen($id) - 1] . random_bytes(1), strlen($id) - 1);
    } else {
        return $id;
    }
}

function tambahBarang($data)
{
    global $conn;

    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KODE_BARCODE = mysqli_real_escape_string($conn, $data["KODE_BARCODE"]);
    $NAMA = mysqli_real_escape_string($conn, $data["NAMA"]);
    $SATUAN_ID = mysqli_real_escape_string($conn, $data["SATUAN_ID"]);
    $STOK = mysqli_real_escape_string($conn, $data["STOK"]);
    $MIN_STOK = mysqli_real_escape_string($conn, $data["MIN_STOK"]);
    $MAX_STOK = mysqli_real_escape_string($conn, $data["MAX_STOK"]);
    $HARGA_BELI = mysqli_real_escape_string($conn, $data["HARGA_BELI"]);
    $STOK_AWAL = mysqli_real_escape_string($conn, $data["STOK_AWAL"]);
    $DISKON_RP = mysqli_real_escape_string($conn, $data["DISKON_RP"]);
    $GARANSI = mysqli_real_escape_string($conn, $data["GARANSI"]);
    $TGL_TRANSAKSI = mysqli_real_escape_string($conn, $data["TGL_TRANSAKSI"]);
    $DISKON_GENERAL = mysqli_real_escape_string($conn, $data["DISKON_GENERAL"]);
    $DISKON_SILVER = mysqli_real_escape_string($conn, $data["DISKON_SILVER"]);
    $DISKON_GOLD = mysqli_real_escape_string($conn, $data["DISKON_GOLD"]);
    $POIN = mysqli_real_escape_string($conn, $data["POIN"]);
    $MARGIN = mysqli_real_escape_string($conn, $data["MARGIN"]);
    $HARGA_JUAL = mysqli_real_escape_string($conn, $data["HARGA_JUAL"]);
    $GOLONGAN_ID = mysqli_real_escape_string($conn, $data["GOLONGAN_ID"]);
    $SUB_GOLONGAN_ID = mysqli_real_escape_string($conn, $data["SUB_GOLONGAN_ID"]);
    $SUPPLIER_ID = mysqli_real_escape_string($conn, $data["SUPPLIER_ID"]);
    $LOKASI_ID = mysqli_real_escape_string($conn, $data["LOKASI_ID"]);

    // upload gambar

    $FOTO = 'http://www.joga-computer.com/gambar/' . upload($KODE_BARCODE);

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO `barang`(`KODE`, `KODE_BARCODE`, `NAMA`, `SATUAN_ID`, `STOK`, `MIN_STOK`, `MAX_STOK`, `HARGA_BELI`, `GOLONGAN_ID`, `LOKASI_ID`, `SUPPLIER_ID`, `STOK_AWAL`, `DISKON_RP`, `GARANSI`, `SUB_GOLONGAN_ID`, `TGL_TRANSAKSI`, `DISKON_GENERAL`, `DISKON_SILVER`, `DISKON_GOLD`, `POIN`, `FOTO`, `MARGIN`) VALUES
     ('$KODE','$KODE_BARCODE','$NAMA','$SATUAN_ID','$STOK','$MIN_STOK','$MAX_STOK', '$HARGA_BELI', '$GOLONGAN_ID', '$LOKASI_ID', '$SUPPLIER_ID', '$STOK_AWAL', '$DISKON_RP', '$GARANSI', '$SUB_GOLONGAN_ID', '$TGL_TRANSAKSI', '$DISKON_GENERAL','$DISKON_SILVER','$DISKON_GOLD','$POIN','$FOTO','$MARGIN')");

    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    $query = "SELECT * FROM BARANG a LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID
WHERE
a.NAMA LIKE '%$keyword%' OR
a.KODE LIKE '%$keyword%' OR
a.KODE_BARCODE LIKE '%$keyword%' OR
b.HARGA_JUAL LIKE '%$keyword%' ORDER BY a.KODE DESC
";
    return query($query);
}

function cariItem($keyword)
{
    $query = "SELECT * FROM `item_jual`
WHERE
NOTA LIKE '%$keyword%' OR
BARANG_ID LIKE '%$keyword%' OR
JUMLAH LIKE '%$keyword%' OR
HARGA_BELI LIKE '%$keyword%' OR LIMIT 0, 20
";
    return query($query);
}

function cariNota($keyword)
{
    $query = "SELECT * FROM `jual`
WHERE
NOTA LIKE '%$keyword%' OR
SALESMAN_ID LIKE '%$keyword%' OR
STATUS_NOTA LIKE '%$keyword%' OR
OPERATOR LIKE '%$keyword%' OR
TEMPO LIKE '%$keyword%' OR
TANGGAL LIKE '%$keyword%' OR
TOTAL_PELUNASAN_NOTA LIKE '%$keyword%' OR
STATUS_BAYAR LIKE '%$keyword%' ORDER BY id DESC LIMIT 0, 10
";
    return query($query);
}

function cariPelunasan($keyword)
{
    $query = "SELECT * FROM `pelunasan_piutang`
WHERE
NO_PELUNASAN LIKE '%$keyword%' OR
CUSTOMER_ID LIKE '%$keyword%' OR
TANGGAL LIKE '%$keyword%' OR
KETERANGAN LIKE '%$keyword%' OR
OPERATOR LIKE '%$keyword%' LIMIT 0, 20
";
    return query($query);
}

function cariSalesman($keyword)
{
    $query = "SELECT * FROM `salesman`
WHERE
NAMA LIKE '%$keyword%' OR
ALAMAT LIKE '%$keyword%' OR
TELEPON LIKE '%$keyword%' LIMIT 0, 10
";
    return query($query);
}

function cariUser($keyword)
{
    $query = "SELECT * FROM `customer`
WHERE
NAMA LIKE '%$keyword%' OR
TELEPON LIKE '%$keyword%' OR
ALAMAT LIKE '%$keyword%' OR
JENIS_ANGGOTA LIKE '%$keyword%'
";
    return query($query);
}

function tambahAdmin($data)
{
    global $conn;

    $NAMA = mysqli_real_escape_string($conn, $data["NAMA"]);
    $PASS = mysqli_real_escape_string($conn, $data["PASS"]);
    $PASS2 = mysqli_real_escape_string($conn, $data["PASS2"]);
    $IS_AKTIF = mysqli_real_escape_string($conn, $data["IS_AKTIF"]);
    $WILAYAH_ID = mysqli_real_escape_string($conn, $data["WILAYAH_ID"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);
    $NO_REKENING = mysqli_real_escape_string($conn, $data["NO_REKENING"]);
    $ALAMAT = mysqli_real_escape_string($conn, $data["ALAMAT"]);
    $GAJI_POKOK = mysqli_real_escape_string($conn, $data["GAJI_POKOK"]);
    $HAK_AKSES_USER = mysqli_real_escape_string($conn, $data["HAK_AKSES_USER"]);

    if ($PASS !== $PASS2) {
        echo "<script>alert('konfirmasi password tidak sesuai');</script>";
        return false;
    }

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO `user_`(`NAMA`, `PASS`, `IS_AKTIF`, `HAK_AKSES_USER`, `ALAMAT`, `WILAYAH_ID`, `TELEPON`, `NO_REKENING`, `GAJI_POKOK`) VALUES
     ('$NAMA','$PASS','$IS_AKTIF','$HAK_AKSES_USER','$ALAMAT','$WILAYAH_ID','$TELEPON', '$NO_REKENING', '$GAJI_POKOK')");

    return mysqli_affected_rows($conn);
}

function tambahSales($userAdminID, $data)
{
    global $conn;

    $KODE = uniqid();
    $NAMA = mysqli_real_escape_string($conn, $data["NAMA"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);
    $NO_REKENING = mysqli_real_escape_string($conn, $data["NO_REKENING"]);
    $ALAMAT = mysqli_real_escape_string($conn, $data["ALAMAT"]);
    $OPERATOR_ID = $userAdminID;

    mysqli_query($conn, "INSERT INTO `salesman`(`KODE`, `NAMA`, `ALAMAT`, `TELEPON`, `NO_REKENING`, `OPERATOR_ID`) VALUES
     ('$KODE', '$NAMA', '$ALAMAT','$TELEPON', '$NO_REKENING', '$OPERATOR_ID')");

    return mysqli_affected_rows($conn);
}

function ubahSales($userAdminID, $data)
{
    global $conn;

    $KODE = $data["id"];
    $NAMA = mysqli_real_escape_string($conn, $data["name"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);
    $NO_REKENING = mysqli_real_escape_string($conn, $data["NO_REKENING"]);
    $ALAMAT = mysqli_real_escape_string($conn, $data["ALAMAT"]);
    $TOTAL_NOTA_PENJUALAN = mysqli_real_escape_string($conn, $data["TOTAL_NOTA_PENJUALAN"]);
    $TOTAL_ITEM_PENJUALAN = mysqli_real_escape_string($conn, $data["TOTAL_ITEM_PENJUALAN"]);
    $OPERATOR_ID = $userAdminID;

    mysqli_query($conn, "UPDATE `salesman` SET 
    `NAMA`='$NAMA',
    `TELEPON`='$TELEPON',
    `NO_REKENING`='$NO_REKENING',
    `ALAMAT`='$ALAMAT',
    `TOTAL_NOTA_PENJUALAN`='$TOTAL_NOTA_PENJUALAN',
    `TOTAL_ITEM_PENJUALAN`='$TOTAL_ITEM_PENJUALAN',
    `OPERATOR_ID`='$OPERATOR_ID'
    WHERE KODE = '$KODE'");

    return mysqli_affected_rows($conn);
}

function tambahNota($nota, $id, $total, $data)
{
    date_default_timezone_set("Asia/Jakarta");
    global $conn;

    $NOTA = $nota;
    $CUSTOMER_ID = $id;
    $USER_ADMIN = query("SELECT ID FROM `user_` WHERE NAMA = ' website'")[0]['ID'];
    $SALESMAN_ID = query("SELECT KODE FROM `salesman` WHERE NAMA = ' website'")[0]['KODE'];
    $TOTAL_NOTA = $total;
    $LOKASI_ID = mysqli_real_escape_string($conn, $data["LOKASI_ID"]);
    $TANGGAL = Date('Y-m-d');

    mysqli_query($conn, "UPDATE salesman SET TOTAL_NOTA_PENJUALAN = TOTAL_NOTA_PENJUALAN + 1 WHERE KODE = '$SALESMAN_ID'");

    mysqli_query($conn, "INSERT INTO `jual`(`NOTA`, `CUSTOMER_ID`, `SALESMAN_ID`, `USER_ADMIN`, `OPERATOR`, `LOKASI_ID`, `TOTAL_NOTA`, `TANGGAL`, `TEMPO`) VALUES
     ('$NOTA', '$CUSTOMER_ID', '$SALESMAN_ID', '$USER_ADMIN', '$USER_ADMIN', '$LOKASI_ID', '$TOTAL_NOTA', '$TANGGAL', '$TANGGAL')");

    return mysqli_affected_rows($conn);
}

function tambahNotaAdmin($nota, $username, $total, $data)
{
    date_default_timezone_set("Asia/Jakarta");
    global $conn;

    $NOTA = $nota;
    $USER_ADMIN = query("SELECT ID FROM `user_` WHERE NAMA = '$username'")[0]['ID'];
    $TOTAL_NOTA = $total;
    $TANGGAL = mysqli_real_escape_string($conn, $data["TANGGAL2"]);
    $STATUS_NOTA = mysqli_real_escape_string($conn, $data["STATUS_NOTA"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);
    $SALESMAN_ID = mysqli_real_escape_string($conn, $data["SALESMAN_ID"]);
    $CUSTOMER_NAMA = mysqli_real_escape_string($conn, $data["CUSTOMER_NAMA"]);
    $LOKASI_ID = mysqli_real_escape_string($conn, $data["LOKASI_ID"]);

    if (!is_numeric($CUSTOMER_NAMA)) $CUSTOMER_NAMA = query("SELECT KODE FROM `customer` WHERE NAMA = '$CUSTOMER_NAMA'")[0]['KODE'];

    // $result = mysqli_query($conn, "SELECT NOTA FROM item_jual WHERE NOTA = '$nota'");
    // if (mysqli_fetch_assoc($result)) {
    //     echo "<script>
    //     alert('Nota jual dengan NOTA ini sudah ada. Coba gunakan NOTA lain.');
    //     </script>";
    //     return false;
    // }

    $result2 = mysqli_query($conn, "SELECT NOTA FROM jual WHERE NOTA = '$nota'");
    if (mysqli_fetch_assoc($result2)) {
        echo "<script>
        alert('Nota jual dengan kode ini sudah ada. Coba gunakan kode lain.');
        </script>";
        return false;
    }

    mysqli_query($conn, "UPDATE salesman SET TOTAL_NOTA_PENJUALAN = TOTAL_NOTA_PENJUALAN + 1 WHERE KODE = '$SALESMAN_ID'");

    if ($STATUS_NOTA === 'T') {
        $NO_PELUNASAN = date('Ymd') . query("SELECT COUNT(*) + 1 as COUNT FROM pelunasan_piutang WHERE TANGGAL = CURDATE()")[0]["COUNT"];
        mysqli_query($conn, "INSERT INTO `pelunasan_piutang`(`NO_PELUNASAN`, `CUSTOMER_ID`, `TANGGAL`, `KETERANGAN`, `OPERATOR`) VALUES 
    ('$NO_PELUNASAN', '$CUSTOMER_NAMA', '$TANGGAL', '$KETERANGAN', '$USER_ADMIN')");

        mysqli_query($conn, "INSERT INTO `item_pelunasan_piutang`(`NO_PELUNASAN`, `NOTA_JUAL`, `NOMINAL`, `KETERANGAN`) VALUES 
    ('$NO_PELUNASAN', '$nota', '$TOTAL_NOTA', '$KETERANGAN')");
    }

    mysqli_query($conn, "INSERT INTO `jual`(`NOTA`, `CUSTOMER_ID`, `SALESMAN_ID`, `STATUS_NOTA`, `USER_ADMIN`, `OPERATOR`, `LOKASI_ID`, `TOTAL_NOTA`, `TANGGAL`, `TEMPO`) VALUES
     ('$NOTA', '$CUSTOMER_NAMA', '$SALESMAN_ID', '$STATUS_NOTA', '$USER_ADMIN', '$USER_ADMIN', '$LOKASI_ID', '$TOTAL_NOTA', '$TANGGAL', '$TANGGAL')");

    return mysqli_affected_rows($conn);
}

function tambahItemNotaCheckout($nota, $id, $jumlah, $harga)
{
    global $conn;

    $NOTA = $nota;
    $BARANG_ID = $id;
    $JUMLAH = $jumlah;
    $HARGA_BELI = query("SELECT HARGA_BELI FROM barang WHERE KODE = '" . $BARANG_ID . "'")[0]["HARGA_BELI"];
    $HARGA_JUAL = $harga;
    $SATUAN_ID = query("SELECT SATUAN_ID FROM barang WHERE KODE = '" . $BARANG_ID . "'")[0]["SATUAN_ID"];
    $JUMLAH2 = query("SELECT KONVERSI FROM satuan WHERE KODE = '" . $SATUAN_ID . "'")[0]["KONVERSI"];

    mysqli_query($conn, "INSERT INTO `item_jual`(`NOTA`, `BARANG_ID`, `JUMLAH`, `JUMLAH2`, `HARGA_BELI`, `HARGA_JUAL`) VALUES
     ('$NOTA', '$BARANG_ID','$JUMLAH', '$JUMLAH2', '$HARGA_BELI', '$HARGA_JUAL')");

    return mysqli_affected_rows($conn);
}

function tambahItemNota($nota, $id, $JUMLAH_BARANG, $HARGA_BELI, $HARGA_JUAL, $DISKON1, $DISKON2, $DISKON3, $DISKON4, $DISKON_RP, $SATUAN, $KETERANGAN, $KET1, $KET2, $IMEI)
{
    global $conn;

    $NOTA = $nota;
    $BARANG_ID = $id;
    $SATUAN_ID = query("SELECT SATUAN_ID FROM barang WHERE KODE = '" . $BARANG_ID . "'")[0]["SATUAN_ID"];
    $JUMLAH2 = query("SELECT KONVERSI FROM satuan WHERE KODE = '" . $SATUAN_ID . "'")[0]["KONVERSI"];

    mysqli_query($conn, "INSERT INTO `item_jual`(`NOTA`, `BARANG_ID`, `JUMLAH`, `JUMLAH2`, `HARGA_BELI`, `DISKON_1`, `DISKON_2`, `DISKON_3`, `DISKON_4`, `HARGA_JUAL`, `KETERANGAN`, `DISKON_RP`, `DAFTAR_SATUAN`, `KET1`, `KET2`, `IMEI`) VALUES
     ('$NOTA', '$BARANG_ID','$JUMLAH_BARANG', '$JUMLAH2', '$HARGA_BELI', '$DISKON1', '$DISKON2', '$DISKON3', '$DISKON4', '$HARGA_JUAL', '$KETERANGAN', '$DISKON_RP', '$SATUAN', '$KET1', '$KET2', '$IMEI')");

    return mysqli_affected_rows($conn);
}

function tambahBeliItemNota($nota, $id, $JUMLAH_BARANG, $HARGA_BELI, $HARGA_JUAL, $DISKON1, $DISKON2, $DISKON3, $DISKON4, $DISKON_RP, $SATUAN, $KETERANGAN, $KET1, $KET2, $IMEI)
{
    global $conn;

    $NOTA = $nota;
    $BARANG_ID = $id;
    $SATUAN_ID = query("SELECT SATUAN_ID FROM barang WHERE KODE = '" . $BARANG_ID . "'")[0]["SATUAN_ID"];
    $JUMLAH2 = query("SELECT KONVERSI FROM satuan WHERE KODE = '" . $SATUAN_ID . "'")[0]["KONVERSI"];

    mysqli_query($conn, "INSERT INTO `item_beli`(`NOTA`, `BARANG_ID`, `JUMLAH`, `JUMLAH2`, `HARGA_BELI`, `DISKON_1`, `DISKON_2`, `DISKON_3`, `DISKON_4`, `HARGA_JUAL`, `KETERANGAN`, `DISKON_RP`, `DAFTAR_SATUAN`, `KET1`, `KET2`, `IMEI`) VALUES
     ('$NOTA', '$BARANG_ID','$JUMLAH_BARANG', '$JUMLAH2', '$HARGA_BELI', '$DISKON1', '$DISKON2', '$DISKON3', '$DISKON4', '$HARGA_JUAL', '$KETERANGAN', '$DISKON_RP', '$SATUAN', '$KET1', '$KET2', '$IMEI')");

    return mysqli_affected_rows($conn);
}

function ubahJualItemNota($ID, $BARANG_ID, $JUMLAH_BARANG, $HARGA_BELI, $HARGA_JUAL, $DISKON1, $DISKON2, $DISKON3, $DISKON4, $DISKON_RP, $SATUAN, $KETERANGAN, $KET1, $KET2, $IMEI)
{
    global $conn;

    $SATUAN_ID = query("SELECT SATUAN_ID FROM barang WHERE KODE = '" . $BARANG_ID . "'")[0]["SATUAN_ID"];
    $JUMLAH2 = query("SELECT KONVERSI FROM satuan WHERE KODE = '" . $SATUAN_ID . "'")[0]["KONVERSI"];

    mysqli_query($conn, "UPDATE `item_jual` SET
JUMLAH = '$JUMLAH_BARANG',
HARGA_BELI = '$HARGA_BELI',
HARGA_JUAL = '$HARGA_JUAL',
DISKON_1= '$DISKON1',
DISKON_2 = '$DISKON2',
DISKON_3 = '$DISKON3',
DISKON_4 = '$DISKON4',
DISKON_RP = '$DISKON_RP',
JUMLAH2 = '$JUMLAH2',
DAFTAR_SATUAN = '$SATUAN',
KETERANGAN = '$KETERANGAN',
KET1 = '$KET1',
KET2 = '$KET2',
IMEI = '$IMEI'
WHERE ID = '$ID'");

    return mysqli_affected_rows($conn);
}

function ubahBeliItemNota($ID, $BARANG_ID, $JUMLAH_BARANG, $HARGA_BELI, $HARGA_JUAL, $DISKON1, $DISKON2, $DISKON3, $DISKON4, $DISKON_RP, $SATUAN, $KETERANGAN, $KET1, $KET2, $IMEI)
{
    global $conn;

    $SATUAN_ID = query("SELECT SATUAN_ID FROM barang WHERE KODE = '" . $BARANG_ID . "'")[0]["SATUAN_ID"];
    $JUMLAH2 = query("SELECT KONVERSI FROM satuan WHERE KODE = '" . $SATUAN_ID . "'")[0]["KONVERSI"];

    mysqli_query($conn, "UPDATE `item_beli` SET
JUMLAH = '$JUMLAH_BARANG',
HARGA_BELI = '$HARGA_BELI',
HARGA_JUAL = '$HARGA_JUAL',
DISKON_1= '$DISKON1',
DISKON_2 = '$DISKON2',
DISKON_3 = '$DISKON3',
DISKON_4 = '$DISKON4',
DISKON_RP = '$DISKON_RP',
JUMLAH2 = '$JUMLAH2',
DAFTAR_SATUAN = '$SATUAN',
KETERANGAN = '$KETERANGAN',
KET1 = '$KET1',
KET2 = '$KET2',
IMEI = '$IMEI'
WHERE ID = '$ID'");

    return mysqli_affected_rows($conn);
}

function upload($barcode)
{
    $namafile = $_FILES['FOTO']['name'];
    $ukuranfile = $_FILES['FOTO']['size'];
    $error = $_FILES['FOTO']['error'];
    $tmpname = $_FILES['FOTO']['tmp_name'];

    // cek yg diapload gambar bkn yang lain
    $ekstensigambarvalid = ['jpg', 'jpeg', 'png', 'webp'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigambar = strtolower(end($ekstensigambar));
    if (!in_array($ekstensigambar, $ekstensigambarvalid)) {
        echo "<script>
    alert('yang anda upload bukan gambar');
    </script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranfile > 1000000) {
        echo "<script>
    alert('ukuran gambar terlalu besar');
    </script>";
        return false;
    }

    // lolos pengecekan gambar siap diupload
    // generate nama gambar baru
    $namafilebaru = $barcode;
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensigambar;

    move_uploaded_file($tmpname, './GAMBAR/' . $namafilebaru);

    if ($namafilebaru) {
        return $namafilebaru;
    } else {
        return '';
    }
}

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM barang WHERE KODE = '$id'");
    mysqli_query($conn, "DELETE FROM multi_price WHERE BARANG_ID = '$id'");

    return mysqli_affected_rows($conn);
}

function hapusSales($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM salesman WHERE KODE = '$id'");

    return mysqli_affected_rows($conn);
}

function hapusAdmin($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM user_ WHERE ID = '$id'");

    return mysqli_affected_rows($conn);
}

function editBarang($data)
{
    global $conn;

    $id = $data["id"];
    $KODE_BARCODE = mysqli_real_escape_string($conn, $data["KODE_BARCODE"]);
    $NAMA = mysqli_real_escape_string($conn, $data["NAMA"]);
    $SATUAN_ID = mysqli_real_escape_string($conn, $data["SATUAN_ID"]);
    $STOK = mysqli_real_escape_string($conn, $data["STOK"]);
    $MIN_STOK = mysqli_real_escape_string($conn, $data["MIN_STOK"]);
    $MAX_STOK = mysqli_real_escape_string($conn, $data["MAX_STOK"]);
    $HARGA_BELI = mysqli_real_escape_string($conn, $data["HARGA_BELI"]);
    $STOK_AWAL = mysqli_real_escape_string($conn, $data["STOK_AWAL"]);
    $DISKON_RP = mysqli_real_escape_string($conn, $data["DISKON_RP"]);
    $GARANSI = mysqli_real_escape_string($conn, $data["GARANSI"]);
    $TGL_TRANSAKSI = mysqli_real_escape_string($conn, $data["TGL_TRANSAKSI"]);
    $DISKON_GENERAL = mysqli_real_escape_string($conn, $data["DISKON_GENERAL"]);
    $DISKON_SILVER = mysqli_real_escape_string($conn, $data["DISKON_SILVER"]);
    $DISKON_GOLD = mysqli_real_escape_string($conn, $data["DISKON_GOLD"]);
    $POIN = mysqli_real_escape_string($conn, $data["POIN"]);
    $MARGIN = mysqli_real_escape_string($conn, $data["MARGIN"]);
    $gambarlama = mysqli_real_escape_string($conn, $data["gambarlama"]);
    $GOLONGAN_ID = mysqli_real_escape_string($conn, $data["GOLONGAN_ID"]);
    $SUB_GOLONGAN_ID = mysqli_real_escape_string($conn, $data["SUB_GOLONGAN_ID"]);
    $SUPPLIER_ID = mysqli_real_escape_string($conn, $data["SUPPLIER_ID"]);
    $LOKASI_ID = mysqli_real_escape_string($conn, $data["LOKASI_ID"]);

    // upload gambar
    // check apakah user pilih gambar baru aatau tidak
    if ($_FILES['FOTO']['error'] === 4) {
        $FOTO = $gambarlama;
    } else {
        $FOTO = 'http://www.joga-computer.com/gambar/' . upload($KODE_BARCODE);
    }

    mysqli_query($conn, "UPDATE `barang` SET 
    KODE_BARCODE = '$KODE_BARCODE',
    NAMA = '$NAMA',
    SATUAN_ID = '$SATUAN_ID',
    STOK = '$STOK',
    MIN_STOK = '$MIN_STOK',
    MAX_STOK = '$MAX_STOK',
    HARGA_BELI = '$HARGA_BELI',
    STOK_AWAL = '$STOK_AWAL',
    DISKON_RP = '$DISKON_RP',
    GARANSI = '$GARANSI',
    TGL_TRANSAKSI = '$TGL_TRANSAKSI',
    DISKON_GENERAL = '$DISKON_GENERAL',
    DISKON_SILVER = '$DISKON_SILVER',
    DISKON_GOLD = '$DISKON_GOLD',
    POIN = '$POIN',
    FOTO = '$FOTO',
    MARGIN = '$MARGIN',
    GOLONGAN_ID = '$GOLONGAN_ID',
    SUB_GOLONGAN_ID = '$SUB_GOLONGAN_ID',
    SUPPLIER_ID = '$SUPPLIER_ID',
    LOKASI_ID = '$LOKASI_ID'
    WHERE KODE = '$id';
    ");

    return mysqli_affected_rows($conn);
}

function registrasi($data)
{
    global $conn;

    $KODE = date('Ymd') . query("SELECT COUNT(*) as COUNT FROM customer")[0]["COUNT"];
    $NAMA = mysqli_real_escape_string($conn, $data["NAMA"]);
    $PASSWORD = mysqli_real_escape_string($conn, $data["PASSWORD"]);
    $PASSWORD2 = mysqli_real_escape_string($conn, $data["PASSWORD2"]);
    $ALAMAT = mysqli_real_escape_string($conn, $data["ALAMAT"]);
    $WILAYAH_ID = mysqli_real_escape_string($conn, $data["WILAYAH_ID"]);
    $KONTAK = mysqli_real_escape_string($conn, $data["KONTAK"]);
    $NPWP = mysqli_real_escape_string($conn, $data["NPWP"]);
    $KOTA = mysqli_real_escape_string($conn, $data["KOTA"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);

    $result = mysqli_query($conn, "SELECT NAMA FROM customer WHERE NAMA = '$NAMA'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('Nama yang dipakai sudah terdaftar');
        </script>";
        return false;
    }

    if ($PASSWORD !== $PASSWORD2) {
        echo "<script>alert('konfirmasi password tidak sesuai');</script>";
        return false;
    }

    $PASSWORD = password_hash($PASSWORD, PASSWORD_DEFAULT);

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO `customer`(`KODE`, `NAMA`, `PASSWORD`, `ALAMAT`, `KONTAK`, `NPWP`, `JATUH_TEMPO`, `URUT`, `WILAYAH_ID`, `DEF`, `ALAMAT2`, `KODE_BARCODE`, `PLAFON_PIUTANG`, `TOTAL_PIUTANG`, `TOTAL_PEMBAYARAN_PIUTANG`, `KOTA`, `TELEPON`, `JENIS_ANGGOTA`) VALUES
     ('$KODE','$NAMA','$PASSWORD','$ALAMAT', '$KONTAK','$NPWP', NULL, NULL, '$WILAYAH_ID', NULL, NULL, NULL, 0,0.00,0.00,'$KOTA','$TELEPON', NULL)");

    return mysqli_affected_rows($conn);
}

function ubahNota($nota, $userAdmin, $data)
{
    date_default_timezone_set("Asia/Jakarta");
    global $conn;

    $STATUS_NOTA = mysqli_real_escape_string($conn, $data["STATUS_NOTA"]);
    $TEMPO = mysqli_real_escape_string($conn, $data["TEMPO"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);
    $DISKON = mysqli_real_escape_string($conn, $data["DISKON"]);
    $PPN = mysqli_real_escape_string($conn, $data["PPN"]);
    $SALESMAN_ID = mysqli_real_escape_string($conn, $data["SALESMAN_ID"]);
    $CUSTOMER_ID = mysqli_real_escape_string($conn, $data["CUSTOMER_ID"]);
    $LOKASI_ID = mysqli_real_escape_string($conn, $data["LOKASI_ID"]);
    $USER_ADMIN = query("SELECT ID FROM `user_` WHERE NAMA = '$userAdmin'")[0]['ID'];
    $TANGGAL = mysqli_real_escape_string($conn, $data["TANGGAL"]);

    if (!is_numeric($CUSTOMER_ID)) $CUSTOMER_ID = query("SELECT KODE FROM `customer` WHERE NAMA = '$CUSTOMER_ID'")[0]['KODE'];

    mysqli_query($conn, "UPDATE `jual` SET 
    `SALESMAN_ID`='$SALESMAN_ID', 
    `CUSTOMER_ID`='$CUSTOMER_ID', 
    `LOKASI_ID`='$LOKASI_ID', 
    `STATUS_NOTA`='$STATUS_NOTA', 
    `TEMPO`='$TEMPO', 
    `TANGGAL`='$TANGGAL', 
    `KETERANGAN` = '$KETERANGAN', 
    `USER_ADMIN`='$USER_ADMIN', 
    `OPERATOR`='$USER_ADMIN', 
    `PPN`='$PPN', 
    `DISKON`='$DISKON' 
    WHERE NOTA = '$nota';");

    return mysqli_affected_rows($conn);
}

function ubahJenisAnggotaUser($data)
{
    global $conn;

    $id = $data["id"];
    $JENISANGOTA = mysqli_real_escape_string($conn, $data["JENISANGOTA"]);

    $query = "UPDATE `customer` SET
JENIS_ANGGOTA = '$JENISANGOTA'
WHERE KODE = '$id';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ubahAdmin($data)
{
    global $conn;

    $id = $data["id"];
    $IS_AKTIF = mysqli_real_escape_string($conn, $data["IS_AKTIF"]);
    $GROUP_HAK_AKSES_ID = mysqli_real_escape_string($conn, $data["GROUP_HAK_AKSES_ID"]);
    $HAK_AKSES_USER = mysqli_real_escape_string($conn, $data["HAK_AKSES_USER"]);
    $GAJI_POKOK = mysqli_real_escape_string($conn, $data["GAJI_POKOK"]);

    $query = "UPDATE `user_` SET
IS_AKTIF = '$IS_AKTIF',
GROUP_HAK_AKSES_ID = '$GROUP_HAK_AKSES_ID',
HAK_AKSES_USER = '$HAK_AKSES_USER',
GAJI_POKOK = '$GAJI_POKOK'
WHERE ID = '$id';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ubahAdminSendiri($data)
{
    global $conn;

    $id = $data["id"];
    $IS_AKTIF = mysqli_real_escape_string($conn, $data["IS_AKTIF"]);
    $ALAMAT = mysqli_real_escape_string($conn, $data["ALAMAT"]);
    $WILAYAH_ID = mysqli_real_escape_string($conn, $data["WILAYAH_ID"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);
    $NO_REKENING = mysqli_real_escape_string($conn, $data["NO_REKENING"]);
    $PASSWORD = mysqli_real_escape_string($conn, $data["PASSWORD"]);
    $PASSWORD2 = mysqli_real_escape_string($conn, $data["PASSWORD2"]);

    $result = query("SELECT PASS FROM user_ WHERE ID = '$id'")[0]['PASS'];

    if ($result === $PASSWORD && $PASSWORD2 !== '') {
        $PASSWORD = $PASSWORD2;
    } else {
        $PASSWORD = $result;
    }

    $query = "UPDATE `user_` SET
IS_AKTIF = '$IS_AKTIF',
ALAMAT = '$ALAMAT',
WILAYAH_ID = '$WILAYAH_ID',
TELEPON = '$TELEPON',
NO_REKENING = '$NO_REKENING',
PASS = '$PASSWORD'
WHERE ID = '$id';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ubahProfile($data)
{
    global $conn;

    $id = $data["id"];
    $NAMA = mysqli_real_escape_string($conn, $data["NAMA"]);
    $PASSWORD = mysqli_real_escape_string($conn, $data["PASSWORD"]);
    $PASSWORD2 = mysqli_real_escape_string($conn, $data["PASSWORD2"]);
    $ALAMAT = mysqli_real_escape_string($conn, $data["ALAMAT"]);
    $KONTAK = mysqli_real_escape_string($conn, $data["KONTAK"]);
    $WILAYAH_ID = mysqli_real_escape_string($conn, $data["WILAYAH_ID"]);
    $NPWP = mysqli_real_escape_string($conn, $data["NPWP"]);
    $KOTA = mysqli_real_escape_string($conn, $data["KOTA"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);
    $ALAMAT2 = mysqli_real_escape_string($conn, $data["ALAMAT2"]);
    $JENISANGOTA = mysqli_real_escape_string($conn, $data["JENISANGOTA"]);

    if ($PASSWORD !== $PASSWORD2) {
        echo "<script>alert('konfirmasi password tidak sesuai');</script>";
        return false;
    }

    $PASSWORD = password_hash($PASSWORD, PASSWORD_DEFAULT);

    $query = "UPDATE `customer` SET
NAMA = '$NAMA',
PASSWORD = '$PASSWORD',
ALAMAT = '$ALAMAT',
KONTAK = '$KONTAK',
NPWP = '$NPWP',
KOTA = '$KOTA',
TELEPON = '$TELEPON',
ALAMAT2 = '$ALAMAT2',
WILAYAH_ID = '$WILAYAH_ID',
JENIS_ANGGOTA = '$JENISANGOTA'
WHERE KODE = '$id';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function tambahGolongan($data)
{
    global $conn;

    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    mysqli_query($conn, "INSERT INTO `golongan`(`KODE`, `KETERANGAN`) VALUES
     ('$KODE', '$KETERANGAN')");

    return mysqli_affected_rows($conn);
}

function ubahGolongan($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    $query = "UPDATE `golongan` SET
KODE = '$KODE',
KETERANGAN = '$KETERANGAN'
WHERE KODE = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusGolongan($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    mysqli_query($conn, "DELETE FROM golongan WHERE KODE = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function tambahSubgolongan($data)
{
    global $conn;

    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    mysqli_query($conn, "INSERT INTO `sub_golongan`(`KODE`, `KETERANGAN`) VALUES
     ('$KODE', '$KETERANGAN')");

    return mysqli_affected_rows($conn);
}

function ubahSubgolongan($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    $query = "UPDATE `sub_golongan` SET
KODE = '$KODE',
KETERANGAN = '$KETERANGAN'
WHERE KODE = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusSubgolongan($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    mysqli_query($conn, "DELETE FROM sub_golongan WHERE KODE = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function tambahWilayah($data)
{
    global $conn;

    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    mysqli_query($conn, "INSERT INTO `Wilayah`(`KODE`, `KETERANGAN`) VALUES
     ('$KODE', '$KETERANGAN')");

    return mysqli_affected_rows($conn);
}

function ubahWilayah($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    $query = "UPDATE `Wilayah` SET
KODE = '$KODE',
KETERANGAN = '$KETERANGAN'
WHERE KODE = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusWilayah($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    mysqli_query($conn, "DELETE FROM Wilayah WHERE KODE = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function tambahBiaya($data)
{
    global $conn;

    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    mysqli_query($conn, "INSERT INTO `Biaya`(`KODE`, `KETERANGAN`) VALUES
     ('$KODE', '$KETERANGAN')");

    return mysqli_affected_rows($conn);
}

function ubahBiaya($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    $query = "UPDATE `Biaya` SET
KODE = '$KODE',
KETERANGAN = '$KETERANGAN'
WHERE KODE = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusBiaya($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    mysqli_query($conn, "DELETE FROM Biaya WHERE KODE = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function tambahJasa($data)
{
    global $conn;

    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    mysqli_query($conn, "INSERT INTO `Jasa`(`KODE`, `KETERANGAN`) VALUES
     ('$KODE', '$KETERANGAN')");

    return mysqli_affected_rows($conn);
}

function ubahJasa($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    $query = "UPDATE `Jasa` SET
KODE = '$KODE',
KETERANGAN = '$KETERANGAN'
WHERE KODE = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusJasa($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    mysqli_query($conn, "DELETE FROM Jasa WHERE KODE = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function tambahBeli($nota, $username, $total, $data)
{
    date_default_timezone_set("Asia/Jakarta");
    global $conn;

    $NOTA = $nota;
    $USER_ADMIN = query("SELECT ID FROM `user_` WHERE NAMA = '$username'")[0]['ID'];
    $STATUS_NOTA = mysqli_real_escape_string($conn, $data["STATUS_NOTA"]);
    $TOTAL_NOTA = $total;
    $TANGGAL = Date('Y-m-d');
    $TEMPO = mysqli_real_escape_string($conn, $data["TANGGAL"]);
    $TANGGAL = mysqli_real_escape_string($conn, $data["TANGGAL2"]);
    $LOKASI_ID = mysqli_real_escape_string($conn, $data["LOKASI_ID"]);
    $SUPPLIER_ID = mysqli_real_escape_string($conn, $data["SUPPLIER_ID"]);

    if (!is_numeric($SUPPLIER_ID)) $SUPPLIER_ID = query("SELECT KODE FROM `supplier` WHERE NAMA = '$SUPPLIER_ID'")[0]['KODE'];

    // $result = mysqli_query($conn, "SELECT NOTA FROM item_beli WHERE NOTA = '$nota'");
    // if (mysqli_fetch_assoc($result)) {
    //     echo "<script>
    //     alert('Nota beli dengan NOTA ini sudah ada. Coba gunakan NOTA lain.');
    //     </script>";
    //     return false;
    // }

    $result2 = mysqli_query($conn, "SELECT NOTA FROM beli WHERE NOTA = '$nota'");
    if (mysqli_fetch_assoc($result2)) {
        echo "<script>
        alert('Nota beli dengan kode ini sudah ada. Coba gunakan kode lain.');
        </script>";
        return false;
    }

    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);
    $DISKON = mysqli_real_escape_string($conn, $data["DISKON"]);
    $PPN = mysqli_real_escape_string($conn, $data["PPN"]);

    if ($STATUS_NOTA === 'T') {
        $NO_PELUNASAN = date('Ymd') . query("SELECT COUNT(*) + 1 as COUNT FROM pelunasan_hutang WHERE TANGGAL = CURDATE()")[0]["COUNT"];
        mysqli_query($conn, "INSERT INTO `pelunasan_hutang`(`NO_PELUNASAN`, `SUPPLIER_ID`, `TANGGAL`, `KETERANGAN`, `OPERATOR`) VALUES 
    ('$NO_PELUNASAN', '$SUPPLIER_ID', '$TANGGAL', '$KETERANGAN', '$USER_ADMIN')");

        mysqli_query($conn, "INSERT INTO `item_pelunasan_hutang`(`NO_PELUNASAN`, `NOTA_BELI`, `NOMINAL`, `KETERANGAN`) VALUES 
    ('$NO_PELUNASAN', '$nota', '$TOTAL_NOTA', '$KETERANGAN')");
    }

    mysqli_query($conn, "INSERT INTO `Beli`(`NOTA`, `STATUS_NOTA`, `TOTAL_NOTA`, `TANGGAL`, `TEMPO`, `LOKASI_ID`, `SUPPLIER_ID`, `KETERANGAN`, `DISKON`, `PPN`, `USER_ADMIN`, `OPERATOR`) VALUES
     ('$NOTA', '$STATUS_NOTA', '$TOTAL_NOTA', '$TANGGAL', '$TEMPO', '$LOKASI_ID', '$SUPPLIER_ID', '$KETERANGAN', '$DISKON', '$PPN', '$USER_ADMIN', '$USER_ADMIN')");

    return mysqli_affected_rows($conn);
}

function ubahBeli($userAdmin, $TOTAL_NOTA, $data)
{
    date_default_timezone_set("Asia/Jakarta");
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $STATUS_NOTA = mysqli_real_escape_string($conn, $data["STATUS_NOTA"]);
    $TANGGAL = mysqli_real_escape_string($conn, $data["TANGGAL2"]);
    $USER_ADMIN = query("SELECT ID FROM `user_` WHERE NAMA = '$userAdmin'")[0]['ID'];
    $TEMPO = mysqli_real_escape_string($conn, $data["TANGGAL"]);
    $LOKASI_ID = mysqli_real_escape_string($conn, $data["LOKASI_ID"]);
    $SUPPLIER_ID = mysqli_real_escape_string($conn, $data["SUPPLIER_ID"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);
    $DISKON = mysqli_real_escape_string($conn, $data["DISKON"]);
    $PPN = mysqli_real_escape_string($conn, $data["PPN"]);

    if (!is_numeric($SUPPLIER_ID)) $SUPPLIER_ID = query("SELECT KODE FROM `supplier` WHERE NAMA = '$SUPPLIER_ID'")[0]['KODE'];

    $query = "UPDATE `Beli` SET
STATUS_NOTA = '$STATUS_NOTA',
TANGGAL = '$TANGGAL',
TEMPO = '$TEMPO',
LOKASI_ID = '$LOKASI_ID',
SUPPLIER_ID = '$SUPPLIER_ID',
KETERANGAN = '$KETERANGAN',
DISKON = '$DISKON',
PPN = '$PPN',
USER_ADMIN = '$USER_ADMIN',
TOTAL_NOTA = '$TOTAL_NOTA',
OPERATOR = '$USER_ADMIN'
WHERE NOTA = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusBeli($nota)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $nota);

    mysqli_query($conn, "DELETE FROM Beli WHERE NOTA = '$KODE_LAMA'");
    mysqli_query($conn, "DELETE FROM ITEM_BELI WHERE NOTA = '$KODE_LAMA'");
    mysqli_query($conn, "DELETE FROM ITEM_PELUNASAN_HUTANG WHERE NOTA_BELI = '$KODE_LAMA'");

    $item = query("SELECT NO_PELUNASAN FROM item_pelunasan_hutang WHERE NOTA_BELI = '$KODE_LAMA'");
    foreach ($item as $i) {
        mysqli_query($conn, "DELETE FROM PELUNASAN_HUTANG WHERE NO_PELUNASAN = '" . $i['NO_PELUNASAN'] . "'");
    }

    return mysqli_affected_rows($conn);
}

function hapusJual($nota)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM Jual WHERE NOTA = '$nota'");
    mysqli_query($conn, "DELETE FROM ITEM_JUAL WHERE NOTA = '$nota'");
    mysqli_query($conn, "DELETE FROM ITEM_PELUNASAN_PIUTANG WHERE NOTA_JUAL = '$nota'");

    $item = query("SELECT NO_PELUNASAN FROM item_pelunasan_piutang WHERE NOTA_JUAL = '$nota'");
    foreach ($item as $i) {
        mysqli_query($conn, "DELETE FROM PELUNASAN_PIUTANG WHERE NO_PELUNASAN = '" . $i['NO_PELUNASAN'] . "'");
    }

    return mysqli_affected_rows($conn);
}

function tambahMultiPrice($data)
{
    global $conn;

    $BARANG_ID = mysqli_real_escape_string($conn, $data["BARANG_ID"]);
    $KODE_SATUAN = mysqli_real_escape_string($conn, $data["KODE_SATUAN"]);
    $CUSTOMER_ID = mysqli_real_escape_string($conn, $data["CUSTOMER_ID"]);
    $HARGA_KE = mysqli_real_escape_string($conn, $data["HARGA_KE"]);
    $JUMLAH_R1 = mysqli_real_escape_string($conn, $data["JUMLAH_R1"]);
    $JUMLAH_R2 = mysqli_real_escape_string($conn, $data["JUMLAH_R2"]);
    $HARGA_JUAL = mysqli_real_escape_string($conn, $data["HARGA_JUAL"]);

    mysqli_query($conn, "INSERT INTO `Multi_price`(`BARANG_ID`, `KODE_SATUAN`, `HARGA_KE`, `CUSTOMER_ID`, `JUMLAH_R1`, `JUMLAH_R2`, `HARGA_JUAL`) VALUES
     ('$BARANG_ID', '$KODE_SATUAN', '$HARGA_KE', '$CUSTOMER_ID', '$JUMLAH_R1', '$JUMLAH_R2', '$HARGA_JUAL')");

    return mysqli_affected_rows($conn);
}

function ubahMultiPrice($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $BARANG_ID = mysqli_real_escape_string($conn, $data["BARANG_ID"]);
    $KODE_SATUAN = mysqli_real_escape_string($conn, $data["KODE_SATUAN"]);
    $CUSTOMER_ID = mysqli_real_escape_string($conn, $data["CUSTOMER_ID"]);
    $HARGA_KE = mysqli_real_escape_string($conn, $data["HARGA_KE"]);
    $JUMLAH_R1 = mysqli_real_escape_string($conn, $data["JUMLAH_R1"]);
    $JUMLAH_R2 = mysqli_real_escape_string($conn, $data["JUMLAH_R2"]);
    $HARGA_JUAL = mysqli_real_escape_string($conn, $data["HARGA_JUAL"]);

    $query = "UPDATE `Multi_price` SET
BARANG_ID = '$BARANG_ID',
KODE_SATUAN = '$KODE_SATUAN',
CUSTOMER_ID = '$CUSTOMER_ID',
HARGA_KE = '$HARGA_KE',
JUMLAH_R1 = '$JUMLAH_R1',
JUMLAH_R2 = '$JUMLAH_R2',
HARGA_JUAL = '$HARGA_JUAL'
WHERE KODE = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusMultiPrice($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    mysqli_query($conn, "DELETE FROM Multi_price WHERE KODE = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function tambahLokasi($data)
{
    global $conn;

    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    if (isset($data['DEF'])) {
        $DEF = mysqli_real_escape_string($conn, $data["DEF"]);
    } else {
        $DEF = 0;
    }

    mysqli_query($conn, "INSERT INTO `lokasi`(`KODE`, `KETERANGAN`, `DEF`) VALUES
     ('$KODE', '$KETERANGAN', '$DEF')");

    return mysqli_affected_rows($conn);
}

function ubahLokasi($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    if (isset($data['DEF'])) {
        $DEF = mysqli_real_escape_string($conn, $data["DEF"]);
    } else {
        $DEF = 0;
    }
    $query = "UPDATE `lokasi` SET
KODE = '$KODE',
KETERANGAN = '$KETERANGAN',
DEF = '$DEF'
WHERE KODE = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusLokasi($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    mysqli_query($conn, "DELETE FROM lokasi WHERE KODE = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function tambahSatuan($data)
{
    global $conn;

    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $NAMA = mysqli_real_escape_string($conn, $data["NAMA"]);
    $KONVERSI = mysqli_real_escape_string($conn, $data["KONVERSI"]);


    mysqli_query($conn, "INSERT INTO `Satuan`(`KODE`, `NAMA`, `KONVERSI`) VALUES
     ('$KODE', '$NAMA', '$KONVERSI')");

    return mysqli_affected_rows($conn);
}

function ubahSatuan($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $NAMA = mysqli_real_escape_string($conn, $data["NAMA"]);
    $KONVERSI = mysqli_real_escape_string($conn, $data["KONVERSI"]);

    $query = "UPDATE `Satuan` SET
KODE = '$KODE',
NAMA = '$NAMA',
NAMA = '$NAMA',
KONVERSI = '$KONVERSI'
WHERE KODE = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusSatuan($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    mysqli_query($conn, "DELETE FROM Satuan WHERE KODE = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function tambahSupplier($data)
{
    global $conn;

    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KODE_BARCODE = mysqli_real_escape_string($conn, $data["KODE_BARCODE"]);
    $NAMA = mysqli_real_escape_string($conn, $data["NAMA"]);
    $ALAMAT = mysqli_real_escape_string($conn, $data["ALAMAT"]);
    $ALAMAT2 = mysqli_real_escape_string($conn, $data["ALAMAT2"]);
    $WILAYAH_ID = mysqli_real_escape_string($conn, $data["WILAYAH_ID"]);
    $KONTAK = mysqli_real_escape_string($conn, $data["KONTAK"]);
    $NPWP = mysqli_real_escape_string($conn, $data["NPWP"]);
    $JATUH_TEMPO = mysqli_real_escape_string($conn, $data["JATUH_TEMPO"]);
    $PLAFON_HUTANG = mysqli_real_escape_string($conn, $data["PLAFON_HUTANG"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);

    if (isset($data['DEF'])) {
        $DEF = mysqli_real_escape_string($conn, $data["DEF"]);
    } else {
        $DEF = 0;
    }

    mysqli_query($conn, "INSERT INTO `Supplier`(`KODE`, `NAMA`, `ALAMAT`, `KONTAK`, `NPWP`, `JATUH_TEMPO`, `WILAYAH_ID`, `DEF`, `ALAMAT2`, `KODE_BARCODE`, `PLAFON_HUTANG`, `TELEPON`) VALUES
     ('$KODE', '$NAMA', '$ALAMAT', '$KONTAK', '$NPWP', '$JATUH_TEMPO', '$WILAYAH_ID', '$DEF', '$ALAMAT2', '$KODE_BARCODE', '$PLAFON_HUTANG', '$TELEPON')");

    return mysqli_affected_rows($conn);
}

function ubahSupplier($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KODE_BARCODE = mysqli_real_escape_string($conn, $data["KODE_BARCODE"]);
    $NAMA = mysqli_real_escape_string($conn, $data["NAMA"]);
    $ALAMAT = mysqli_real_escape_string($conn, $data["ALAMAT"]);
    $ALAMAT2 = mysqli_real_escape_string($conn, $data["ALAMAT2"]);
    $WILAYAH_ID = mysqli_real_escape_string($conn, $data["WILAYAH_ID"]);
    $KONTAK = mysqli_real_escape_string($conn, $data["KONTAK"]);
    $NPWP = mysqli_real_escape_string($conn, $data["NPWP"]);
    $JATUH_TEMPO = mysqli_real_escape_string($conn, $data["JATUH_TEMPO"]);
    $PLAFON_HUTANG = mysqli_real_escape_string($conn, $data["PLAFON_HUTANG"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);

    if (isset($data['DEF'])) {
        $DEF = mysqli_real_escape_string($conn, $data["DEF"]);
    } else {
        $DEF = 0;
    }
    $query = "UPDATE `Supplier` SET
KODE = '$KODE',
KODE_BARCODE = '$KODE_BARCODE',
NAMA = '$NAMA',
ALAMAT = '$ALAMAT',
ALAMAT2 = '$ALAMAT2',
WILAYAH_ID = '$WILAYAH_ID',
KONTAK = '$KONTAK',
NPWP = '$NPWP',
JATUH_TEMPO = '$JATUH_TEMPO',
PLAFON_HUTANG = '$PLAFON_HUTANG',
TELEPON = '$TELEPON',
DEF = '$DEF'
WHERE KODE = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusSupplier($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    mysqli_query($conn, "DELETE FROM Supplier WHERE KODE = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function tambahLangganan($data)
{
    global $conn;

    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KODE_BARCODE = mysqli_real_escape_string($conn, $data["KODE_BARCODE"]);
    $NAMA = mysqli_real_escape_string($conn, $data["NAMA"]);
    $ALAMAT = mysqli_real_escape_string($conn, $data["ALAMAT"]);
    $ALAMAT2 = mysqli_real_escape_string($conn, $data["ALAMAT2"]);
    $WILAYAH_ID = mysqli_real_escape_string($conn, $data["WILAYAH_ID"]);
    $KONTAK = mysqli_real_escape_string($conn, $data["KONTAK"]);
    $NPWP = mysqli_real_escape_string($conn, $data["NPWP"]);
    $JATUH_TEMPO = mysqli_real_escape_string($conn, $data["JATUH_TEMPO"]);
    $KOTA = mysqli_real_escape_string($conn, $data["KOTA"]);
    $PLAFON_PIUTANG = mysqli_real_escape_string($conn, $data["PLAFON_PIUTANG"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);
    $JENIS_ANGGOTA = mysqli_real_escape_string($conn, $data["JENIS_ANGGOTA"]);

    mysqli_query($conn, "INSERT INTO `Customer`(`KODE`, `NAMA`, `ALAMAT`, `KONTAK`, `NPWP`, `JATUH_TEMPO`, `WILAYAH_ID`, `KOTA`, `ALAMAT2`, `KODE_BARCODE`, `PLAFON_PIUTANG`, `TELEPON`, `JENIS_ANGGOTA`) VALUES
     ('$KODE', '$NAMA', '$ALAMAT', '$KONTAK', '$NPWP', '$JATUH_TEMPO', '$WILAYAH_ID', '$KOTA', '$ALAMAT2', '$KODE_BARCODE', '$PLAFON_PIUTANG', '$TELEPON', '$JENIS_ANGGOTA')");

    return mysqli_affected_rows($conn);
}

function ubahLangganan($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $KODE = mysqli_real_escape_string($conn, $data["KODE"]);
    $KODE_BARCODE = mysqli_real_escape_string($conn, $data["KODE_BARCODE"]);
    $NAMA = mysqli_real_escape_string($conn, $data["NAMA"]);
    $ALAMAT = mysqli_real_escape_string($conn, $data["ALAMAT"]);
    $ALAMAT2 = mysqli_real_escape_string($conn, $data["ALAMAT2"]);
    $WILAYAH_ID = mysqli_real_escape_string($conn, $data["WILAYAH_ID"]);
    $KONTAK = mysqli_real_escape_string($conn, $data["KONTAK"]);
    $NPWP = mysqli_real_escape_string($conn, $data["NPWP"]);
    $JATUH_TEMPO = mysqli_real_escape_string($conn, $data["JATUH_TEMPO"]);
    $KOTA = mysqli_real_escape_string($conn, $data["KOTA"]);
    $PLAFON_PIUTANG = mysqli_real_escape_string($conn, $data["PLAFON_PIUTANG"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);
    $JENIS_ANGGOTA = mysqli_real_escape_string($conn, $data["JENIS_ANGGOTA"]);

    $query = "UPDATE `Customer` SET
KODE = '$KODE',
KODE_BARCODE = '$KODE_BARCODE',
NAMA = '$NAMA',
ALAMAT = '$ALAMAT',
ALAMAT2 = '$ALAMAT2',
WILAYAH_ID = '$WILAYAH_ID',
KONTAK = '$KONTAK',
NPWP = '$NPWP',
JATUH_TEMPO = '$JATUH_TEMPO',
KOTA = '$KOTA',
PLAFON_PIUTANG = '$PLAFON_PIUTANG',
JENIS_ANGGOTA = '$JENIS_ANGGOTA',
TELEPON = '$TELEPON'
WHERE KODE = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusLangganan($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    mysqli_query($conn, "DELETE FROM Customer WHERE KODE = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function hapusItemBeli($id)
{
    global $conn;

    $ID = mysqli_real_escape_string($conn, $id);
    mysqli_query($conn, "DELETE FROM item_beli WHERE ID = '$ID'");

    return mysqli_affected_rows($conn);
}

function hapusItemJual($id)
{
    global $conn;

    $ID = mysqli_real_escape_string($conn, $id);
    mysqli_query($conn, "DELETE FROM item_jual WHERE ID = '$ID'");

    return mysqli_affected_rows($conn);
}

function tambahTandaMasukBarang($data, $username)
{
    global $conn;

    $TANGGAL = mysqli_real_escape_string($conn, $data["TANGGAL"]);
    $NOTA =
        date('Ymd') . query("SELECT COUNT(*) + 1 as COUNT FROM tanda_terima_barang WHERE TANGGAL = $TANGGAL")[0]["COUNT"];
    $CUSTOMER = mysqli_real_escape_string($conn, $data["CUSTOMER"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);
    $KELUHAN = mysqli_real_escape_string($conn, $data["KELUHAN"]);
    $KELENGKAPAN = mysqli_real_escape_string($conn, $data["KELENGKAPAN"]);
    $PIN = mt_rand(100000, 999999);
    $STATUS = mysqli_real_escape_string($conn, $data["STATUS"]);

    mysqli_query($conn, "INSERT INTO `tanda_terima_barang`(`NOTA`, `TANGGAL`, `CUSTOMER`, `TELEPON`, `KELUHAN`, `KELENGKAPAN`, `PIN`, `ADDED_BY`, `MODIFIED_BY`, `STATUS`) VALUES
     ('$NOTA', '$TANGGAL', '$CUSTOMER', '$TELEPON', '$KELUHAN', '$KELENGKAPAN', '$PIN', '$username', '$username', '$STATUS')");

    return mysqli_affected_rows($conn);
}

function ubahTandaMasukBarang($data, $username)
{
    date_default_timezone_set("Asia/Jakarta");
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $CUSTOMER = mysqli_real_escape_string($conn, $data["CUSTOMER"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);
    $KELUHAN = mysqli_real_escape_string($conn, $data["KELUHAN"]);
    $KELENGKAPAN = mysqli_real_escape_string($conn, $data["KELENGKAPAN"]);
    $SOLUSI = mysqli_real_escape_string($conn, $data["SOLUSI"]);
    $NO_NOTA_BAYAR = mysqli_real_escape_string($conn, $data["NO_NOTA_BAYAR"]);
    $BIAYA_SERVIS = mysqli_real_escape_string($conn, $data["BIAYA_SERVIS"]);
    $TGL_SELESAI = mysqli_real_escape_string($conn, $data["TGL_SELESAI"]);
    $NETTO = mysqli_real_escape_string($conn, $data["NETTO"]);
    $TEKNISI = mysqli_real_escape_string($conn, $data["TEKNISI"]);

    $query = "UPDATE `tanda_terima_barang` SET
CUSTOMER = '$CUSTOMER',
TELEPON = '$TELEPON',
KELUHAN = '$KELUHAN',
KELENGKAPAN = '$KELENGKAPAN',
SOLUSI = '$SOLUSI',
NO_NOTA_BAYAR = '$NO_NOTA_BAYAR',
BIAYA_SERVIS = '$BIAYA_SERVIS',
TGL_SELESAI = '$TGL_SELESAI',
NETTO = '$NETTO',
TEKNISI = '$TEKNISI',
MODIFIED_BY = '$username'
WHERE NOTA = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusTandaMasukBarang($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    mysqli_query($conn, "DELETE FROM tanda_terima_barang WHERE NOTA = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function tambahTandaKeluarBarang($data, $userAdmin)
{
    global $conn;

    $NOTA = mysqli_real_escape_string($conn, $data["NOTA"]);
    $TANGGAL = mysqli_real_escape_string($conn, $data["TANGGAL"]);
    $CUSTOMER = mysqli_real_escape_string($conn, $data["CUSTOMER"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);
    $KELUHAN = mysqli_real_escape_string($conn, $data["KELUHAN"]);
    $SOLUSI = mysqli_real_escape_string($conn, $data["SOLUSI"]);

    mysqli_query($conn, "INSERT INTO `tanda_keluar_barang`(`NOTA`, `TANGGAL`, `CUSTOMER`, `TELEPON`, `KELUHAN`, `SOLUSI`, `ADDED_BY`, `MODIFIED_BY`) VALUES
     ('$NOTA', '$TANGGAL', '$CUSTOMER', '$TELEPON', '$KELUHAN', '$SOLUSI', '$userAdmin', '$userAdmin')");

    return mysqli_affected_rows($conn);
}

function ubahTandaKeluarBarang($data, $userAdmin)
{
    date_default_timezone_set("Asia/Jakarta");
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $TANGGAL = mysqli_real_escape_string($conn, $data["TANGGAL"]);
    $CUSTOMER = mysqli_real_escape_string($conn, $data["CUSTOMER"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);
    $KELUHAN = mysqli_real_escape_string($conn, $data["KELUHAN"]);
    $SOLUSI = mysqli_real_escape_string($conn, $data["SOLUSI"]);

    $query = "UPDATE `tanda_keluar_barang` SET
TANGGAL = '$TANGGAL',
CUSTOMER = '$CUSTOMER',
TELEPON = '$TELEPON',
KELUHAN = '$KELUHAN',
SOLUSI = '$SOLUSI',
MODIFIED_BY = '$userAdmin'
WHERE NOTA = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusTandaKeluarBarang($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    mysqli_query($conn, "DELETE FROM tanda_keluar_barang WHERE NOTA = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function tambahPelunasan($userAdmin, $data)
{
    global $conn;

    $NO_PELUNASAN = mysqli_real_escape_string($conn, $data["NO_PELUNASAN"]);
    $TANGGAL = mysqli_real_escape_string($conn, $data["TANGGAL2"]);
    $USER_ADMIN = query("SELECT ID FROM `user_` WHERE NAMA = '$userAdmin'")[0]['ID'];
    $SUPPLIER_ID = mysqli_real_escape_string($conn, $data["SUPPLIER_ID"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);
    $TOTAL_PELUNASAN_NOTA = mysqli_real_escape_string($conn, $data["TOTAL_PELUNASAN_NOTA"]);
    $NOTA_BELI = mysqli_real_escape_string($conn, $data["NOTA_BELI"]);
    $RETUR = mysqli_real_escape_string($conn, $data["RETUR"]);
    $DISKON_PELUNASAN = mysqli_real_escape_string($conn, $data["DISKON_PELUNASAN"]);
    $KETERANGAN_PELUNASAN = mysqli_real_escape_string($conn, $data["KETERANGAN_PELUNASAN"]);

    if (!is_numeric($SUPPLIER_ID)) $SUPPLIER_ID = query("SELECT KODE FROM `supplier` WHERE NAMA = '$SUPPLIER_ID'")[0]['KODE'];

    mysqli_query($conn, "INSERT INTO `pelunasan_hutang`(`NO_PELUNASAN`, `SUPPLIER_ID`, `TANGGAL`, `KETERANGAN`, `OPERATOR`) VALUES 
    ('$NO_PELUNASAN', '$SUPPLIER_ID', '$TANGGAL', '$KETERANGAN', '$USER_ADMIN')");

    mysqli_query($conn, "INSERT INTO `item_pelunasan_hutang`(`NO_PELUNASAN`, `NOTA_BELI`, `NOMINAL`, `KETERANGAN`, `DISKON`, `RETUR`) VALUES 
    ('$NO_PELUNASAN', '$NOTA_BELI', '$TOTAL_PELUNASAN_NOTA', '$KETERANGAN_PELUNASAN', '$DISKON_PELUNASAN', '$RETUR')");

    return mysqli_affected_rows($conn);
}

function ubahPelunasan($userAdmin, $data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $NO_PELUNASAN = mysqli_real_escape_string($conn, $data["NO_PELUNASAN"]);
    $TANGGAL = mysqli_real_escape_string($conn, $data["TANGGAL2"]);
    $USER_ADMIN = query("SELECT ID FROM `user_` WHERE NAMA = '$userAdmin'")[0]['ID'];
    $SUPPLIER_ID = mysqli_real_escape_string($conn, $data["SUPPLIER_ID"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);
    $TOTAL_PELUNASAN_NOTA = mysqli_real_escape_string($conn, $data["TOTAL_PELUNASAN_NOTA"]);
    $NOTA_BELI = mysqli_real_escape_string($conn, $data["NOTA_BELI"]);
    $RETUR = mysqli_real_escape_string($conn, $data["RETUR"]);
    $DISKON_PELUNASAN = mysqli_real_escape_string($conn, $data["DISKON_PELUNASAN"]);
    $KETERANGAN_PELUNASAN = mysqli_real_escape_string($conn, $data["KETERANGAN_PELUNASAN"]);

    if (!is_numeric($SUPPLIER_ID)) $SUPPLIER_ID = query("SELECT KODE FROM `supplier` WHERE NAMA = '$SUPPLIER_ID'")[0]['KODE'];

    mysqli_query($conn, "UPDATE `item_pelunasan_hutang` SET `NO_PELUNASAN`='$NO_PELUNASAN',`NOTA_BELI`='$NOTA_BELI',`NOMINAL`='$TOTAL_PELUNASAN_NOTA',`KETERANGAN`='$KETERANGAN_PELUNASAN',`DISKON`='$DISKON_PELUNASAN',`RETUR`='$RETUR' WHERE NO_PELUNASAN = '$KODE_LAMA'");
    mysqli_query($conn, "UPDATE `pelunasan_hutang` SET `NO_PELUNASAN`='$NO_PELUNASAN',`SUPPLIER_ID`='$SUPPLIER_ID',`TANGGAL`='$TANGGAL',`KETERANGAN`='$KETERANGAN',`OPERATOR`='$USER_ADMIN' WHERE NO_PELUNASAN = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function hapusPelunasan($data)
{
    global $conn;

    $NO_PELUNASAN = mysqli_real_escape_string($conn, $data["NO_PELUNASAN"]);
    mysqli_query($conn, "DELETE FROM `pelunasan_hutang` WHERE NO_PELUNASAN = '$NO_PELUNASAN'");
    mysqli_query($conn, "DELETE FROM `item_pelunasan_hutang` WHERE NO_PELUNASAN = '$NO_PELUNASAN'");

    return mysqli_affected_rows($conn);
}

function tambahPelunasanP($userAdmin, $data)
{
    global $conn;

    $NO_PELUNASAN = mysqli_real_escape_string($conn, $data["NO_PELUNASAN"]);
    $TANGGAL = mysqli_real_escape_string($conn, $data["TANGGAL2"]);
    $USER_ADMIN = query("SELECT ID FROM `user_` WHERE NAMA = '$userAdmin'")[0]['ID'];
    $CUSTOMER_ID = mysqli_real_escape_string($conn, $data["CUSTOMER_ID"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);
    $TOTAL_PELUNASAN_NOTA = mysqli_real_escape_string($conn, $data["TOTAL_PELUNASAN_NOTA"]);
    $NOTA_JUAL = mysqli_real_escape_string($conn, $data["NOTA_JUAL"]);
    $RETUR = mysqli_real_escape_string($conn, $data["RETUR"]);
    $DISKON_PELUNASAN = mysqli_real_escape_string($conn, $data["DISKON_PELUNASAN"]);
    $KETERANGAN_PELUNASAN = mysqli_real_escape_string($conn, $data["KETERANGAN_PELUNASAN"]);

    if (!is_numeric($CUSTOMER_ID)) $CUSTOMER_ID = query("SELECT KODE FROM `customer` WHERE NAMA = '$CUSTOMER_ID'")[0]['KODE'];

    mysqli_query($conn, "INSERT INTO `pelunasan_piutang`(`NO_PELUNASAN`, `CUSTOMER_ID`, `TANGGAL`, `KETERANGAN`, `OPERATOR`) VALUES 
    ('$NO_PELUNASAN', '$CUSTOMER_ID', '$TANGGAL', '$KETERANGAN', '$USER_ADMIN')");

    mysqli_query($conn, "INSERT INTO `item_pelunasan_piutang`(`NO_PELUNASAN`, `NOTA_JUAL`, `NOMINAL`, `KETERANGAN`, `DISKON`, `RETUR`) VALUES 
    ('$NO_PELUNASAN', '$NOTA_JUAL', '$TOTAL_PELUNASAN_NOTA', '$KETERANGAN_PELUNASAN', '$DISKON_PELUNASAN', '$RETUR')");

    return mysqli_affected_rows($conn);
}

function ubahPelunasanP($userAdmin, $data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $NO_PELUNASAN = mysqli_real_escape_string($conn, $data["NO_PELUNASAN"]);
    $TANGGAL = mysqli_real_escape_string($conn, $data["TANGGAL2"]);
    $USER_ADMIN = query("SELECT ID FROM `user_` WHERE NAMA = '$userAdmin'")[0]['ID'];
    $CUSTOMER_ID = mysqli_real_escape_string($conn, $data["CUSTOMER_ID"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);
    $TOTAL_PELUNASAN_NOTA = mysqli_real_escape_string($conn, $data["TOTAL_PELUNASAN_NOTA"]);
    $NOTA_JUAL = mysqli_real_escape_string($conn, $data["NOTA_JUAL"]);
    $RETUR = mysqli_real_escape_string($conn, $data["RETUR"]);
    $DISKON_PELUNASAN = mysqli_real_escape_string($conn, $data["DISKON_PELUNASAN"]);
    $KETERANGAN_PELUNASAN = mysqli_real_escape_string($conn, $data["KETERANGAN_PELUNASAN"]);

    if (!is_numeric($CUSTOMER_ID)) $CUSTOMER_ID = query("SELECT KODE FROM `customer` WHERE NAMA = '$CUSTOMER_ID'")[0]['KODE'];

    mysqli_query($conn, "UPDATE `item_pelunasan_piutang` SET `NO_PELUNASAN`='$NO_PELUNASAN',`NOTA_JUAL`='$NOTA_JUAL',`NOMINAL`='$TOTAL_PELUNASAN_NOTA',`KETERANGAN`='$KETERANGAN_PELUNASAN',`DISKON`='$DISKON_PELUNASAN',`RETUR`='$RETUR' WHERE NO_PELUNASAN = '$KODE_LAMA'");
    mysqli_query($conn, "UPDATE `pelunasan_piutang` SET `NO_PELUNASAN`='$NO_PELUNASAN',`CUSTOMER_ID`='$CUSTOMER_ID',`TANGGAL`='$TANGGAL',`KETERANGAN`='$KETERANGAN',`OPERATOR`='$USER_ADMIN' WHERE NO_PELUNASAN = '$KODE_LAMA'");

    return mysqli_affected_rows($conn);
}

function hapusPelunasanP($data)
{
    global $conn;

    $NO_PELUNASAN = mysqli_real_escape_string($conn, $data["NO_PELUNASAN"]);
    mysqli_query($conn, "DELETE FROM `pelunasan_piutang` WHERE NO_PELUNASAN = '$NO_PELUNASAN'");
    mysqli_query($conn, "DELETE FROM `item_pelunasan_piutang` WHERE NO_PELUNASAN = '$NO_PELUNASAN'");

    return mysqli_affected_rows($conn);
}
