<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$user = query("SELECT * FROM customer");
$admin = query("SELECT * FROM user_admin");
$currAdmin = query("SELECT * FROM user_admin WHERE ID = $id")[0];

$title = "User & Admin Management - $username";
include('shared/navadmin.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl">Halaman Manajemen User & Admin</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>
    <h2 class="text-xl mb-4">USERS</h2>

    <div class="overflow-x-auto w-full mb-16">
        <table class="table w-full">
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
                                    <div class="text-sm opacity-50"><?= $u['ALAMAT'] . ', ' . $u["KOTA"]; ?></div>
                                    <div class="text-sm opacity-50"><?= $u['ALAMAT2']; ?></div>
                                    <div class="text-sm opacity-50"><?php if (isset($u["WILAYAH_ID"])) {
                                                                        echo $u["WILAYAH_ID"];
                                                                    } else {
                                                                        echo 'belum memasukan kodepos';
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

<?php
include('shared/footer.php');
?>