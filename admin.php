<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$brg = query("SELECT * FROM BARANG");

include('shared/navadmin.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl">Halaman Admin</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>
    <a class="btn btn-primary" href="tambahBarang.php">Tambah Barang</a>

    <div class="overflow-x-auto w-full mt-8">
        <table class="table w-full">
            <!-- head -->
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Satuan/Stok</th>
                    <th>Diskon</th>
                    <th>Margin</th>
                    <th>Garansi/Poin</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($brg as $b) : ?>
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div class="avatar">
                                    <div class="mask mask-squircle w-12 h-12">
                                        <img width="50px" height="50px" src="/tailwind-css-component-profile-2@56w.png" alt="Avatar Tailwind CSS Component" />
                                    </div>
                                </div>
                                <div>
                                    <div class="font-bold"><?= $b["NAMA"]; ?></div>
                                    <div class="text-sm opacity-50"><?= $b["KODE"]; ?></div>
                                    <div class="text-sm opacity-50"><?= $b["TGL_TRANSAKSI"]; ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            Satuan: <?= $b["SATUAN_ID"]; ?>
                            <br />
                            Stok: <?= $b["STOK"]; ?>
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
                            <span class="text-xl font-semibold opacity-70"><?= $b["MARGIN"]; ?></span>
                        </th>
                        <th>
                            <span class="badge mb-2"><?= $b["GARANSI"]; ?> Tahun</span>
                            <br>
                            <span class="badge badge-warning"><?= $b["POIN"]; ?></span>
                        </th>
                        <td>
                            <a><i class="fa-solid fa-file-lines"></i></a>
                            <a><i class="fa-solid fa-pen-to-square"></i></a>
                            <a><i class="fa-solid fa-trash"></i></a>
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