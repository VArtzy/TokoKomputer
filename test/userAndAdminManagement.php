<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$user = query("SELECT * FROM customer LIMIT 20");
$admin = query("SELECT * FROM user_admin LIMIT 5");
$salesman = query("SELECT * FROM salesman LIMIT 10");
$currAdmin = query("SELECT * FROM user_admin WHERE ID = $id")[0];

if (isset($_POST["cari"])) {
    $mahasiswa = cariUser($_POST["keyword"]);
}

if (isset($_POST["caris"])) {
    $mahasiswas = cariSalesman($_POST["keywords"]);
}

$title = "User & Admin Management - $username";
include('shared/navadmin.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Halaman Manajemen User & Admin dan Sales</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>
    <h2 id="customer" class="text-xl mb-4">Customer</h2>

    <a href="langganan.php" class="btn btn-primary mb-4">Tambah Customer</a>

    <div class="mb-4">
        <input type="text" name="keyword" size="40" class="input input-bordered max-w-xs mr-2" autofocus placeholder="Masukkan Keyword Nama/Telepon/Alamat/Jenis Anggota user" autocomplete="off" id="keyword">
        <button type="submit" name="cari" class="opacity-50" id="tombol-cari">Cari</button>
    </div>

    <div class="overflow-x-auto w-full mb-16">
        <table id="container" class="table w-full">
            <!-- head -->
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kontak</th>
                    <th>NPWP</th>
                    <th>Piutang</th>
                    <th>Jenis Anggota</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($user as $u) : ?>
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold"><?= $u['NAMA']; ?></div>
                                    <div class="text-sm opacity-50">Kode: <?= $u['KODE'] ?></div>
                                    <div class="text-sm opacity-50"><?= $u['ALAMAT'] . ', ' . $u["KOTA"]; ?></div>
                                    <div class="text-sm opacity-50"><?= $u['ALAMAT2']; ?></div>
                                    <div class="text-sm opacity-50"><?php if (isset($u["WILAYAH_ID"])) {
                                                                        echo $u['WILAYAH_ID'] . ' - ' . query("SELECT KETERANGAN FROM wilayah WHERE KODE = '" . $u['WILAYAH_ID'] . "'")[0]["KETERANGAN"];
                                                                    } else {
                                                                        echo 'belum memasukan wilayah';
                                                                    } ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?= $u['KONTAK']; ?>
                            <br />
                            <a target="_blank" href="https://wa.me/<?php
                                                                    if ($u['TELEPON'][0] === '0') {
                                                                        echo '62' . substr($u['TELEPON'], 1) . "/?text=Hai%20pelangan%20" . $u['NAMA'] . ",%20...";
                                                                    } else {
                                                                        echo $u['TELEPON'] . "/?text=Hai%20pelangan%20" . $u['NAMA'] . ",%20...";
                                                                    }
                                                                    ?>"><i class="fa-brands fa-whatsapp"></i> Chat Pelanggan</a>
                            <br />
                            <span class=" badge badge-ghost badge-sm"><?= $u['TELEPON']; ?></span>
                        </td>
                        <td><?= $u['NPWP']; ?></td>
                        <th>
                            <span class="badge badge-ghost badge-sm">Plafon: <?= $u['PLAFON_PIUTANG']; ?></span>
                            <br>
                            <span class="badge badge-sm">Total: <?= $u['TOTAL_PIUTANG']; ?></span>
                            <br>
                            <span class="badge badge-warning badge-sm">Total Pembayaran: <?= $u['TOTAL_PEMBAYARAN_PIUTANG']; ?></span>
                            <br>
                            <a href="editPiutang.php?id=<?= $u["KODE"]; ?>" class="btn btn-info btn-xs">Edit Piutang</a>
                        </th>
                        <td>
                            <?= $u['JENIS_ANGGOTA']; ?>
                            <br>
                            <a href="editJenisAnggota.php?id=<?= $u["KODE"]; ?>" class="btn btn-info btn-xs">Edit Jenis Anggota</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h2 class="text-xl mb-4" id="salesman">SALESMANS</h2>

    <a href="tambahSales.php" class="btn btn-primary mb-4">Tambah Salesman</a>

    <div class="">
        <input type="text" name="keywords" size="40" class="input mb-4 input-bordered max-w-xs mr-2" autofocus placeholder="Masukkan Keyword Nama, No Telp, Alamat" autocomplete="off" id="keywords">
        <button type="submit" name="caris" class="opacity-50" id="tombol-caris">Cari</button>
    </div>

    <div class="overflow-x-auto w-full mb-8">
        <table class="table w-full">
            <!-- head -->
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No. Telp</th>
                    <th>No. Rekening</th>
                    <th>Penjualan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="containers">
                <?php foreach ($salesman as $s) : ?>
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold"><?= $s['NAMA']; ?></div>
                                    <div class="text-sm opacity-50"><?= $s['ALAMAT']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-ghost badge-sm"><?= $s['TELEPON']; ?></span>
                        </td>
                        <td><?= $s['NO_REKENING']; ?></td>
                        </td>
                        <td>
                            <span class="badge text-white badge-success badge-sm"><?= $s['TOTAL_NOTA_PENJUALAN']; ?> Nota</span>
                            <br>
                            <span class="badge badge-sm"><?= $s['TOTAL_ITEM_PENJUALAN']; ?> Item</span>
                        </td>
                        <td>
                            <a href="editSales.php?kode=<?= $s["KODE"]; ?>" class="btn btn-info btn-xs">Edit Sales</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h2 class="text-xl mb-4">ADMINS</h2>

    <?php if ($hakAksesID > 1) : ?>
        <a href="tambahAdmin.php" class="btn btn-primary mb-8">Tambah Admin</a>
    <?php endif; ?>

    <div class="overflow-x-auto w-full mb-8">
        <table class="table w-full">
            <!-- head -->
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Aktif</th>
                    <th>No. Rekening</th>
                    <th>Gaji</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="flex items-center space-x-3">
                            <div>
                                <div class="font-bold"><?= $currAdmin['NAMA']; ?></div>
                                <div class="text-sm opacity-50"><?= $currAdmin['ALAMAT'] . ', ' . $currAdmin["WILAYAH_ID"]; ?></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php if ($currAdmin['IS_AKTIF']) {
                            echo '<span class="badge badge-success text-white badge-sm">Aktif</span>';
                        } else {
                            echo '<span class="badge badge-error text-white badge-sm">Nonaktif</span>';
                        }
                        ?>
                        <br>
                        <span class="badge badge-ghost badge-sm"><?= $currAdmin['TELEPON']; ?></span>
                    </td>
                    <td><?= $currAdmin['NO_REKENING']; ?></td>
                    <td><?= rupiah($currAdmin['GAJI_POKOK']); ?></td>
                    </td>
                    <td>
                        <?php if ($hakAksesID > 1) : ?>
                            <a href="editAdmin.php?id=<?= $currAdmin["ID"]; ?>" class="btn btn-info btn-xs">Edit Admin</a>
                            <br>
                        <?php endif; ?>
                        <a href="editAdminSendiri.php?id=<?= $currAdmin["ID"]; ?>" class="btn btn-info btn-xs">Edit Profile</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="overflow-x-auto w-full">
        <table class="table w-full">
            <!-- head -->
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Aktif</th>
                    <th>No. Rekening</th>
                    <th>Gaji</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($admin as $a) : ?>
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold"><?= $a['NAMA']; ?></div>
                                    <div class="text-sm opacity-50"><?= $a['ALAMAT'] . ', ' . $a["WILAYAH_ID"]; ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if ($a['IS_AKTIF']) {
                                echo '<span class="badge badge-success text-white badge-sm">Aktif</span>';
                            } else {
                                echo '<span class="badge badge-error text-white badge-sm">Nonaktif</span>';
                            }
                            ?>
                            <br>
                            <span class="badge badge-ghost badge-sm"><?= $a['TELEPON']; ?></span>
                        </td>
                        <td><?= $a['NO_REKENING']; ?></td>
                        <td><?= rupiah($a['GAJI_POKOK']); ?></td>
                        </td>
                        <td>
                            <?php if ($hakAksesID > 1) : ?>
                                <a href="editAdmin.php?id=<?= $a["ID"]; ?>" class="btn btn-info btn-xs">Edit Admin</a>
                                <br>
                            <?php endif; ?>
                            <?php if ($a["NAMA"] === $username) : ?>
                                <a href="editAdminSendiri.php?id=<?= $currAdmin["ID"]; ?>" class="btn btn-info btn-xs">Edit Profile</a>
                            <?php endif; ?>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script src="script/cariUser.js"></script>
<script src="script/cariSalesman.js"></script>

<?php
include('shared/footer.php');
?>