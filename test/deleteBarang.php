<?php 
require_once 'utils/functions.php';
require_once 'utils/loggedAdmin.php';
$id = $_GET["id"];

if (
    hapus($id) > 0
) {
    echo "
    <script>
    alert('Barang berhasil dihapus');
    document.location.href = 'barang.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('Barang gagal dihapus');
    document.location.href = 'barang.php';
    </script>
    ";
}
