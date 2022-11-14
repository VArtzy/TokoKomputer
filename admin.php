<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$title = "Admin - $username";
include('shared/navadmin.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl">Halaman Admin</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>
    <div class="flex gap-2 items-center opacity-80"><span class="badge">QOTD</span><p id="motivasi"></p></div>
    <div class="flex gap-2 items-center opacity-80"><span class="badge">TIP*</span><p id="tip"></p></div>
</main>

<script defer>
    const tip = document.querySelector('#tip');
    let tips = ['Gunakan tab index untuk memasukan input lebih cepat 🤫', 'Minum air 8 Gelas sehari bisa buat kamu jadi fokus 🥛', 'Kontak dengan pelanggan dapat meningkat konversi hingga 89% 😱']
    let t = tips[Math.floor(Math.random() * tips.length)]
    tip.textContent = t
    const motivasi = document.querySelector('#motivasi');
     fetch("https://quotes.rest/qod?language=en")
  .then(function(response) {
    return response.json();
  })
  .then(function(data) {
    console.log(motivasi);
    motivasi.innerHTML = `"${data.contents.quotes[0].quote}" - <span class="font-semibold">${data.contents.quotes[0].author}</span>`;
  });
</script>

<?php
include('shared/footer.php');
?>