<?php
require_once('../utils/functions.php');

$keyword = $_GET["keyword"];

$query = "SELECT * FROM `customer`
WHERE
NAMA LIKE '%$keyword%' OR
TELEPON LIKE '%$keyword%' OR
ALAMAT LIKE '%$keyword%' OR
JENIS_ANGGOTA LIKE '%$keyword%' LIMIT 10
";
$user = query($query);
?>

<?php if (!empty($user)) : ?>
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
<?php endif ?>
<?php if (empty($user)) : ?>
    <h2 class="text-2xl text-rose-600 font-bold text-center">Sayangnya, User Tidak Ditemukan 😥.</h2>
<?php endif; ?>