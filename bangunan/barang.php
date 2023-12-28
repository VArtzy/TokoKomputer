<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$nom = '11';
if (!in_array($nom, $aksesMenu)) return header('Location: admin.php');
$aksi = explode('/', $hakAksesArr[array_search($nom, $aksesMenu)])[1] ?? '0000';

$brg = query("SELECT * FROM BARANG ORDER BY NAMA ASC LIMIT 20");

if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

$title = "Barang - $username";
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
    <h1 class="text-2xl font-semibold">Halaman Barang</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>
    <div class="md:flex gap-4">
        <div class="tooltip tooltip-bottom" data-tip="CTRL + A">
            <a id="tambah" class="btn btn-primary" href="tambahBarang.php">Tambah Barang</a>
        </div>
        <div class="tooltip tooltip-bottom" data-tip="CTRL + E">
            <a class="btn btn-success buttons-excel" href="cetakbarang.php">Export Barang</a>
        </div>
        <div class="">
            <input type="text" name="keyword" size="40" class="input input-bordered max-w-xs mr-2" autofocus placeholder="Masukkan Keyword Nama/Kode/Harga" autocomplete="off" id="keyword">
            <button type="submit" name="cari" class="opacity-50" id="tombol-cari">Cari</button>
        </div>
    </div>
    <br><br>

    <div id="container" class="overflow-x-auto w-full mt-8">
        <table id="table" class="table w-full text-sm">
            <!-- head -->
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Satuan/Stok</th>
                    <th>Diskon</th>
                    <th>Harga/Margin</th>
                    <th>Garansi/Poin</th>
                    <th>Golongan<br />/Subgolongan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="container">
                <?php foreach ($brg as $b) : ?>
                    <tr id="card">
                        <td>
                            <div class="flex items-center space-x-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle w-12 h-12">
                                        <img width="50px" height="50px" src="<?= $b["FOTO"]; ?>" alt="<?= $b["FOTO"]; ?>" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold"><?= $b["NAMA"]; ?></div>
                                    <div class="text-sm opacity-50"><?= $b["KODE"]; ?></div>
                                    <div class="text-sm opacity-50"><?= $b["KODE_BARCODE"]; ?></div>
                                    <div class="text-sm opacity-50"><?= $b["TGL_TRANSAKSI"]; ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            Satuan: <?= query("SELECT NAMA FROM satuan WHERE KODE = '" . $b['SATUAN_ID'] . "'")[0]['NAMA']; ?> - <?= query("SELECT KONVERSI FROM satuan WHERE KODE = '" . $b['SATUAN_ID'] . "'")[0]['KONVERSI']; ?>
                            <br />
                            Stok: <?= round($b["STOK"]); ?>
                            <br />
                            <span class="badge badge-ghost badge-sm">Min: <?= $b["MIN_STOK"]; ?></span>
                            <span class="badge badge-ghost badge-sm">Max: <?= $b["MAX_STOK"]; ?></span>
                        </td>
                        <td>
                            Diskon: <?= $b["DISKON_RP"]; ?>
                            <br />
                            <span class="badge badge-ghost badge-sm">Diskon General: <?= $b["DISKON_GENERAL"]; ?></span>
                            <br />
                            <span class="badge badge-sm">Diskon Silver: <?= $b["DISKON_SILVER"]; ?></span>
                            <br />
                            <span class="badge badge-warning badge-sm">Diskon Gold: <?= $b["DISKON_GOLD"]; ?></span>
                        </td>
                        <th>
                            <span class="text-sm font-semibold opacity-70"><?= rupiah($b["HARGA_BELI"]); ?></span>
                            <br>
                            <span class="text-xl font-semibold opacity-70"><?= $b["MARGIN"]; ?></span>
                        </th>
                        <th>
                            <span class="badge mb-2"><?= $b["GARANSI"]; ?></span>
                            <br>
                            <span class="badge badge-warning"><?= $b["POIN"]; ?></span>
                        </th>
                        <th>
                            <span class="badge badge-sm mb-2"><?= query("SELECT KETERANGAN FROM golongan WHERE KODE = '" . $b['GOLONGAN_ID'] . "'")[0]['KETERANGAN']; ?></span>
                            <br>
                            <span class="badge badge-sm badge-warning"><?= query("SELECT KETERANGAN FROM sub_golongan WHERE KODE = '" . $b['SUB_GOLONGAN_ID'] . "'")[0]['KETERANGAN']; ?></span>
                        </th>
                        <td class="grid items-center gap-2">
                            <?php if (isset($aksi[1]) && $aksi[1] === '1') : ?>
                                <a href="editBarang.php?id=<?= $b["KODE"]; ?>"><i class="fa-solid fa-pen-to-square text-sky-500 scale-150"></i></a>
                            <?php endif; ?>
                            <?php if (isset($aksi[2]) && $aksi[2] === '1') : ?>
                                <a href="deleteBarang.php?id=<?= $b["KODE"]; ?>" onclick="return confirm('Apakah anda benar benar ingin menghapus barang ini?')"><i class="fa-solid fa-trash text-rose-500 scale-150"></i></a>
                            <?php endif; ?>
                            <a href="kartuBarang.php?id=<?= $b["KODE"]; ?>"><i class="fa-solid fa-file-lines text-amber-500 scale-150"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <button type="button" class="flex p-4 m-auto mt-16 gap-4 items-center" disabled>
        <svg class="animate-spin h-8 w-8 text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="text-sm md:text-xl">✨ Sebentar lagi...</span>
    </button>
</main>

<script>
    let offset = 20;
    const lastCard = document.querySelector('#card:last-of-type');
    const containerCard = document.querySelector('.container');

    const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            fetch(`ajax/infinitebarang.php?offset=${offset}`).then(function(response) {
                offset += 10
                return response.text();
            }).then(function(html) {
                containerCard.innerHTML += html
                observer.unobserve(entries[0].target)
                observer.observe(document.querySelector('#card:last-of-type'))
            }).catch(function(err) {
                console.warn('Something went wrong.', err);
            });
        }
    });

    observer.observe(lastCard);
</script>

<script src="script/cari.js"></script>

<?php
include('shared/footer.php');
?>