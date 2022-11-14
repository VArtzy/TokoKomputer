<?php
$conn = mysqli_connect("localhost", "root", "", "tokokomputer");

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

    // upload gambar
    $FOTO = upload();
    if (!$FOTO) {
        return false;
    }
    // tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO `barang`(`KODE`, `NAMA`, `SATUAN_ID`, `STOK`, `MIN_STOK`, `MAX_STOK`, `HARGA_BELI`, `STOK_AWAL`, `DISKON_RP`, `GARANSI`, `TGL_TRANSAKSI`, `DISKON_GENERAL`, `DISKON_SILVER`, `DISKON_GOLD`, `POIN`, `FOTO`, `MARGIN`) VALUES
     ('$KODE','$NAMA','$SATUAN_ID','$STOK','$MIN_STOK','$MAX_STOK', '$HARGA_BELI', '$STOK_AWAL', '$DISKON_RP', '$GARANSI', '$TGL_TRANSAKSI', '$DISKON_GENERAL','$DISKON_SILVER','$DISKON_GOLD','$POIN','$FOTO','$MARGIN')");

    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    $query = "SELECT * FROM `barang`
    WHERE
    NAMA LIKE '%$keyword%' OR
    KODE LIKE '%$keyword%' OR
    HARGA_BELI LIKE '%$keyword%'
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
    MARGIN = '$MARGIN'
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
     ('$KODE','$NAMA','$PASSWORD','$ALAMAT','$KONTAK','$NPWP', NULL, NULL, NULL, NULL, NULL, NULL,'','','','$KOTA','$TELEPON', NULL)");

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
    $WILAYAH_ID = mysqli_real_escape_string($conn, $data["WILAYAH_ID"]);
    $TELEPON = mysqli_real_escape_string($conn, $data["TELEPON"]);
    $NO_REKENING = mysqli_real_escape_string($conn, $data["NO_REKENING"]);

    $query = "UPDATE `user_` SET
IS_AKTIF = '$IS_AKTIF',
GROUP_HAK_AKSES_ID = '$GROUP_HAK_AKSES_ID',
WILAYAH_ID = '$WILAYAH_ID',
TELEPON = '$TELEPON',
NO_REKENING = '$NO_REKENING'
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
JENIS_ANGGOTA = '$JENISANGOTA'
WHERE KODE = '$id';";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
