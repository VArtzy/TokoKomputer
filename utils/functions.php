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
