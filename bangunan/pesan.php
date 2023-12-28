<?php
require_once 'utils/functions.php';
require_once 'utils/logged.php';
// kalo mau tamplilin yang ada harganya doang pake INNER JOIN dan ganti BARANG_KODE jadi BARANG_ID
$brg = query("SELECT *, a.KODE as BARANG_KODE FROM BARANG a LEFT JOIN multi_price b ON a.KODE = b.BARANG_ID ORDER BY RAND() LIMIT 0, 20");

if (isset($_POST["cari"])) {
  $mahasiswa = cari($_POST["keyword"]);
}

$title = "Belanja";
include('shared/nav.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">

  <h1 class="text-2xl mb-8 font-semibold">Belanja</h1>

  <h2 class="text-xl mb-4 loading-dom-content">Loading...</h2>

  <div class="">
    <input type="text" name="keyword" size="30" class="input input-bordered max-w-xs mr-2" autofocus placeholder="Masukkan Keyword Nama/Kode/Harga" autocomplete="off" id="keyword">
    <button type="submit" name="cari" class="opacity-50" id="tombol-cari">Cari</button>
  </div>


  <div id="container" class="grid lg:grid-cols-4 md:grid-cols-2 gap-16 mt-8">
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
                                } ?> btn-sm text-white add-to-cart" <?php if (round($b["STOK"]) > 0) {
                                                                    } else {
                                                                      echo 'disabled';
                                                                    } ?> data-id="<?= $b["BARANG_KODE"]; ?>" data-name="<?= $b["NAMA"]; ?>" data-price="<?= $b["HARGA_JUAL"]; ?>" data-stok="<?= $b["STOK"]; ?>">TAMBAH</button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <button type="button" class="flex p-4 m-auto mt-16 gap-4 items-center" disabled>
    <svg class="animate-spin h-8 w-8 text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    <span class="text-sm md:text-xl">✨ Banyak Keajaiban Menunggumu</span>
  </button>

</main>

<script>
  const lastCard = document.querySelector('.card:last-of-type');
  const containerCard = document.querySelector('#container');

  const observer = new IntersectionObserver(entries => {
    if (entries[0].isIntersecting) {
      console.log('true')
      fetch('ajax/infinitescroll.php').then(function(response) {
        return response.text();
      }).then(function(html) {
        containerCard.innerHTML += html
        observer.unobserve(entries[0].target)
        observer.observe(document.querySelector('.card:last-of-type'))
      }).catch(function(err) {
        console.warn('Something went wrong.', err);
      });
    }
  });

  observer.observe(lastCard);
</script>

<script src="script/cariBarang.js"></script>

<?php
include('shared/footer.php')
?>