<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$nom = '18';
if (!in_array($nom, $aksesMenu)) return header('Location: admin.php');
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';

$brg = query("SELECT * FROM BARANG ORDER BY NAMA ASC LIMIT 0, 20");

if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

$title = "Kartu Stok - $username";
include('shared/navadmin.php');
?>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
    $(document).on("keydown", function(e) {
        console.log(e.which);
        if (e.which === 65 && (e.ctrlKey || e.metaKey)) {
            $("#tambah")[0].click();
        }
        if (e.which === 69 && (e.ctrlKey || e.metaKey)) {
            $(".buttons-excel")[0].click();
        }
    });
</script>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Halaman Kartu Stok</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>
    <div class="md:flex gap-4">
        <div class="">
            <input type="text" name="keyword" size="40" class="input input-bordered max-w-xs mr-2" autofocus placeholder="Masukkan Keyword Nama/Kode/Harga" autocomplete="off" id="keyword">
            <button type="submit" name="cari" class="opacity-50" id="tombol-cari">Cari</button>
        </div>
    </div>
    <br><br>

    <div id="container" class="overflow-x-auto w-full mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-16">
        <?php foreach ($brg as $b) : ?>
            <a class="border-slate-600 border rounded-md px-8 py-6" href="kartuBarang.php?id=<?= $b["KODE"]; ?>">
                <div class="flex items-center space-x-3">
                    <div class="avatar">
                        <div class="mask mask-squircle w-12 h-12">
                            <img width="50px" height="50px" src="<?= $b["FOTO"]; ?>" alt="<?= $b["FOTO"]; ?>" />
                        </div>
                    </div>
                    <div>
                        <div class="font-bold"><?= $b["NAMA"]; ?></div>
                        <div class="text-sm opacity-50"><?= $b["KODE"]; ?></div>
                        <div class="text-sm opacity-50"><?= $b["TGL_TRANSAKSI"]; ?></div>
                    </div>
                </div>
                <span class="text-sm font-semibold opacity-70"><?= rupiah($b["HARGA_BELI"]); ?></span>
                <br>
                <span class="text-xl font-semibold opacity-70"><?= $b["MARGIN"]; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</main>

<script src="script/cariStok.js"></script>

<?php
include('shared/footer.php');
?>