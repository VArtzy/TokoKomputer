<?php
$conn = mysqli_connect("localhost", "", "", "web_joga_comp");
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

function tambahBarang($data)
{
    global $conn;

    $KODE = uniqid();
    $NAMA = stripslashes($data["NAMA"]);
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
    $FOTO = upload();
    if (!$FOTO) {
        return false;
    }
    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO `barang`(`KODE`, `NAMA`, `SATUAN_ID`, `STOK`, `MIN_STOK`, `MAX_STOK`, `HARGA_BELI`, `GOLONGAN_ID`, `LOKASI_ID`, `SUPPLIER_ID`, `KODE_BARCODE`, `STOK_AWAL`, `DISKON_RP`, `GARANSI`, `SUB_GOLONGAN_ID`, `TGL_TRANSAKSI`, `DISKON_GENERAL`, `DISKON_SILVER`, `DISKON_GOLD`, `POIN`, `FOTO`, `MARGIN`) VALUES
     ('$KODE','$NAMA','$SATUAN_ID','$STOK','$MIN_STOK','$MAX_STOK', '$HARGA_BELI', '$GOLONGAN_ID', '$LOKASI_ID', '$SUPPLIER_ID', '$KODE', '$STOK_AWAL', '$DISKON_RP', '$GARANSI', '$SUB_GOLONGAN_ID', '$TGL_TRANSAKSI', '$DISKON_GENERAL','$DISKON_SILVER','$DISKON_GOLD','$POIN','$FOTO','$MARGIN')");

    mysqli_query($conn, "INSERT INTO multi_price(`KODE_SATUAN`, `CUSTOMER_ID`, `BARANG_ID`, `HARGA_KE`, `JUMLAH_R1`, `JUMLAH_R2`, `HARGA_JUAL`) VALUES
     ('$SATUAN_ID', '', '$KODE', 1, 1, 1000, '$HARGA_JUAL')");

    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    $query = "SELECT * FROM BARANG a LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID
WHERE
a.NAMA LIKE '%$keyword%' OR
a.KODE LIKE '%$keyword%' OR
b.HARGA_JUAL LIKE '%$keyword%' ORDER BY a.KODE DESC LIMIT 0, 10
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

    if ($PASS !== $PASS2) {
        echo "<script>alert('konfirmasi password tidak sesuai');</script>";
        return false;
    }

    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO `user_`(`NAMA`, `PASS`, `IS_AKTIF`, `ALAMAT`, `WILAYAH_ID`, `TELEPON`, `NO_REKENING`, `GAJI_POKOK`) VALUES
     ('$NAMA','$PASS','$IS_AKTIF','$ALAMAT','$WILAYAH_ID','$TELEPON', '$NO_REKENING', '$GAJI_POKOK')");

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
    $TANGGAL = Date('Y-m-d');
    $SALESMAN_ID = mysqli_real_escape_string($conn, $data["SALESMAN_ID"]);
    $CUSTOMER_NAMA = mysqli_real_escape_string($conn, $data["CUSTOMER_NAMA"]);
    $LOKASI_ID = mysqli_real_escape_string($conn, $data["LOKASI_ID"]);

    mysqli_query($conn, "INSERT INTO `jual`(`NOTA`, `CUSTOMER_ID`, `SALESMAN_ID`, `USER_ADMIN`, `OPERATOR`, `LOKASI_ID`, `TOTAL_NOTA`, `TANGGAL`, `TEMPO`) VALUES
     ('$NOTA', '$CUSTOMER_NAMA', '$SALESMAN_ID', '$USER_ADMIN', '$USER_ADMIN', '$LOKASI_ID', '$TOTAL_NOTA', '$TANGGAL', '$TANGGAL')");

    return mysqli_affected_rows($conn);
}

function tambahItemNota($nota, $id, $jumlah, $harga)
{
    global $conn;

    $NOTA = $nota;
    $BARANG_ID = $id;
    $JUMLAH = $jumlah;
    $HARGA_BELI = $harga;

    mysqli_query($conn, "INSERT INTO `item_jual`(`NOTA`, `BARANG_ID`, `JUMLAH`, `HARGA_BELI`) VALUES
     ('$NOTA', '$BARANG_ID','$JUMLAH', '$HARGA_BELI')");

    return mysqli_affected_rows($conn);
}

function upload()
{

    $namafile = $_FILES['FOTO']['name'];
    $ukuranfile = $_FILES['FOTO']['size'];
    $error = $_FILES['FOTO']['error'];
    $tmpname = $_FILES['FOTO']['tmp_name'];

    // cek apakah tidak ada gambar diupload
    if ($error === 4) {
        echo "<script>
    alert('pilih gambar terlebih dahulu');
    </script>";
        return false;
    }

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
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensigambar;

    move_uploaded_file($tmpname, './img/foto/' . $namafilebaru);

    return $namafilebaru;
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
    $NAMA = stripslashes($data["NAMA"]);
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
        $FOTO = upload();
    }

    mysqli_query($conn, "UPDATE `barang` SET 
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

    $KODE = uniqid();
    $NAMA = stripslashes($data["NAMA"]);
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

function ubahNota($nota, $userAdmin, $CUSTOMER_ID, $data)
{
    date_default_timezone_set("Asia/Jakarta");
    global $conn;

    $NO_PELUNASAN = uniqid();
    $STATUS_NOTA = mysqli_real_escape_string($conn, $data["STATUS_NOTA"]);
    $STATUS_BAYAR = mysqli_real_escape_string($conn, $data["STATUS_BAYAR"]);
    $TEMPO = mysqli_real_escape_string($conn, $data["TEMPO"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);
    $TOTAL_PELUNASAN_NOTA = mysqli_real_escape_string($conn, $data["TOTAL_PELUNASAN_NOTA"]);
    $PROFIT = mysqli_real_escape_string($conn, $data["PROFIT"]);
    $SALESMAN_ID = mysqli_real_escape_string($conn, $data["SALESMAN_ID"]);
    $LOKASI_ID = mysqli_real_escape_string($conn, $data["LOKASI_ID"]);
    $USER_ADMIN = query("SELECT ID FROM `user_` WHERE NAMA = '$userAdmin'")[0]['ID'];
    $TANGGAL = Date('Y-m-d');

    mysqli_query($conn, "UPDATE `jual` SET 
    `SALESMAN_ID`='$SALESMAN_ID', 
    `LOKASI_ID`='$LOKASI_ID', 
    `STATUS_NOTA`='$STATUS_NOTA', 
    `STATUS_BAYAR`='$STATUS_BAYAR', 
    `TEMPO`='$TEMPO', 
    `KETERANGAN` = '$KETERANGAN', 
    `USER_ADMIN`='$USER_ADMIN', 
    `OPERATOR`='$USER_ADMIN', 
    `TOTAL_PELUNASAN_NOTA`='$TOTAL_PELUNASAN_NOTA', 
    `PROFIT`='$PROFIT' 
    WHERE NOTA = '$nota';");

    mysqli_query($conn, "INSERT INTO `pelunasan_piutang`(`NO_PELUNASAN`, `CUSTOMER_ID`, `TANGGAL`, `KETERANGAN`, `OPERATOR`) VALUES 
    ('$NO_PELUNASAN', '$CUSTOMER_ID', '$TANGGAL', '$KETERANGAN', '$USER_ADMIN')");

    mysqli_query($conn, "INSERT INTO `item_pelunasan_piutang`(`NO_PELUNASAN`, `NOTA_JUAL`, `NOMINAL`, `KETERANGAN`) VALUES 
    ('$NO_PELUNASAN', '$nota', '$TOTAL_PELUNASAN_NOTA', '$KETERANGAN')");

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
    $GAJI_POKOK = mysqli_real_escape_string($conn, $data["GAJI_POKOK"]);

    $query = "UPDATE `user_` SET
IS_AKTIF = '$IS_AKTIF',
GROUP_HAK_AKSES_ID = '$GROUP_HAK_AKSES_ID',
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

    $query = "UPDATE `user_` SET
IS_AKTIF = '$IS_AKTIF',
ALAMAT = '$ALAMAT',
WILAYAH_ID = '$WILAYAH_ID',
TELEPON = '$TELEPON',
NO_REKENING = '$NO_REKENING'
WHERE ID = '$id';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ubahProfile($data)
{
    global $conn;

    $id = $data["id"];
    $NAMA = stripslashes($data["NAMA"]);
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

function tambahBeli($data, $id)
{
    global $conn;

    $NOTA = mysqli_real_escape_string($conn, $data["NOTA"]);
    $STATUS_NOTA = mysqli_real_escape_string($conn, $data["STATUS_NOTA"]);
    $TANGGAL = mysqli_real_escape_string($conn, $data["TANGGAL"]);
    $LOKASI_ID = mysqli_real_escape_string($conn, $data["LOKASI_ID"]);
    $SUPPLIER_ID = mysqli_real_escape_string($conn, $data["SUPPLIER_ID"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    mysqli_query($conn, "INSERT INTO `Beli`(`NOTA`, `STATUS_NOTA`, `TANGGAL`, `LOKASI_ID`, `SUPPLIER_ID`, `KETERANGAN`, `USER_ADMIN`, `OPERATOR`) VALUES
     ('$NOTA', '$STATUS_NOTA', '$TANGGAL', '$LOKASI_ID', '$SUPPLIER_ID', '$KETERANGAN', '$id', '$id')");

    return mysqli_affected_rows($conn);
}

function ubahBeli($data, $id)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    $NOTA = mysqli_real_escape_string($conn, $data["NOTA"]);
    $STATUS_NOTA = mysqli_real_escape_string($conn, $data["STATUS_NOTA"]);
    $TANGGAL = mysqli_real_escape_string($conn, $data["TANGGAL"]);
    $LOKASI_ID = mysqli_real_escape_string($conn, $data["LOKASI_ID"]);
    $SUPPLIER_ID = mysqli_real_escape_string($conn, $data["SUPPLIER_ID"]);
    $KETERANGAN = mysqli_real_escape_string($conn, $data["KETERANGAN"]);

    $query = "UPDATE `Beli` SET
NOTA = '$NOTA',
STATUS_NOTA = '$STATUS_NOTA',
TANGGAL = '$TANGGAL',
LOKASI_ID = '$LOKASI_ID',
SUPPLIER_ID = '$SUPPLIER_ID',
KETERANGAN = '$KETERANGAN',
USER_ADMIN = '$id',
OPERATOR = '$id'
WHERE NOTA = '$KODE_LAMA';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapusBeli($data)
{
    global $conn;

    $KODE_LAMA = mysqli_real_escape_string($conn, $data["KODE_LAMA"]);
    mysqli_query($conn, "DELETE FROM Beli WHERE NOTA = '$KODE_LAMA'");

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
