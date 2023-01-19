<?php
require_once('../utils/functions.php');

$brg = query("SELECT *, a.KODE as BARANG_KODE FROM BARANG a LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID ORDER BY RAND() LIMIT 0, 20");
?>

<?php foreach ($brg as $b) : ?>
    <div class="card max-w-lg bg-base-100 shadow-xl">
        <figure class="aspect-video object-cover"><img class="aspect-video w-full h-full object-cover animate-pulse bg-gray-300" src="<?= $b["FOTO"]; ?>" alt="<?= $b["NAMA"]; ?>" /></figure>
        <div class="card-body">
            <h2 class="card-title text-sm"><?= $b["NAMA"]; ?></h2>
            <div class="flex gap-2">
                <span class="badge <?php if (round($b["STOK"]) > 0) {
                                        echo 'badge-accent';
                                    } else {
                                        echo 'badge-error';
                                    } ?> badge-sm text-white"><?= round($b["STOK"]); ?></span>
                <span class="badge badge-sm"><?= rupiah($b["HARGA_JUAL"]); ?></span>
            </div>
            <p class="text-xs"></p>
            <div class="card-actions flex justify-end">
                <input id="input-angka" type="number" value="1">
                <button class="btn <?php if (round($b["STOK"]) > 0) {
                                        echo 'btn-success';
                                    } else {
                                    } ?> btn-sm text-white add-to-cart" onclick="tambahBarang(event)" <?php if (round($b["STOK"]) > 0) {
                                                                                                        } else {
                                                                                                            echo 'disabled';
                                                                                                        } ?> data-id="<?= $b["BARANG_KODE"]; ?>" data-name="<?= $b["NAMA"]; ?>" data-price="<?= $b["HARGA_JUAL"]; ?>" data-stok="<?= $b["STOK"]; ?>">TAMBAH</button>
            </div>
        </div>
    </div>
<?php endforeach; ?>