<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$title = "Admin - $username";
include('shared/navadmin.php');
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
  <div class="grid lg:grid-cols-2 gap-8 items-center justify-center mb-32">
    <div class="shadow rounded p-8">
      <h1 class="text-2xl font-semibold">Halaman Admin</h1>
      <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>
      <div class="flex gap-2 items-center opacity-80"><span class="badge">QOTD</span>
        <p id="motivasi"></p>
      </div>
      <div class="flex gap-2 items-center opacity-80"><span class="badge">TIP*</span>
        <p id="tip"></p>
      </div>
    </div>
    <div class="stats shadow">
      <div class="stat">
        <div class="stat-figure text-secondary">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <div class="stat-title">Total Orders</div>
        <div class="stat-value"><?= query('select COUNT(*) as jualmingguini from jual where TANGGAL between date_sub(now(),INTERVAL 1 WEEK) and now();')[0]['jualmingguini'] ?></div>
        <div class="stat-desc" id="salestanggal">Dalam minggu terakhir</div>
      </div>
      <div class="stat">
        <div class="stat-figure text-secondary">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
          </svg>
        </div>
        <div class="stat-title">Sales</div>
        <div class="stat-value"><?= query("select ROUND(SUM(a.JUMLAH*a.JUMLAH2)) as sales from item_jual a LEFT JOIN jual b ON a.NOTA=b.NOTA where b.TANGGAL between date_sub(now(),INTERVAL 1 WEEK) and now();")[0]['sales']; ?></div>
        <div class="stat-desc">Dalam minggu terakhir</div>
      </div>
      <div class="stat">
        <div class="stat-figure text-secondary">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-8 h-8 stroke-current">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
          </svg>
        </div>
        <div class="stat-title">Registers</div>
        <div class="stat-value"><?= query("SELECT COUNT(*) AS registers FROM customer")[0]['registers']; ?></div>
        <div class="stat-desc">Total Customer</div>
      </div>
    </div>

  </div>
  <div class="grid lg:grid-cols-2 gap-8 shadow rounded">
    <canvas style="width:100%;max-width:500px" id="pembelian"></canvas>
    <canvas style="width:100%;max-width:500px" id="penjualan"></canvas>
  </div>
</main>

<script>
  var xyValues = [{
      x: 50,
      y: 7
    },
    {
      x: 60,
      y: 8
    },
    {
      x: 70,
      y: 8
    },
    {
      x: 80,
      y: 9
    },
    {
      x: 90,
      y: 9
    },
    {
      x: 100,
      y: 9
    },
    {
      x: 110,
      y: 10
    },
    {
      x: 120,
      y: 11
    },
    {
      x: 130,
      y: 14
    },
    {
      x: 140,
      y: 14
    },
    {
      x: 150,
      y: 15
    }
  ];

  var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
  var yValues = [55, 49, 44, 24, 15];
  var barColors = ["red", "green", "blue", "orange", "brown"];

  new Chart("penjualan", {
    type: "bar",
    data: {
      labels: xValues,
      datasets: [{
        backgroundColor: barColors,
        data: yValues
      }]
    },
    options: {}
  });

  new Chart("pembelian", {
    type: "scatter",
    data: {
      datasets: [{
        pointRadius: 4,
        pointBackgroundColor: "rgba(0,0,255,1)",
        data: xyValues
      }]
    },
  });
</script>

<script defer>
  const tip = document.querySelector('#tip');
  let tips = ['Gunakan tab index untuk memasukan input lebih cepat 🤫', 'Minum air 8 Gelas sehari bisa buat kamu jadi fokus 🥛', 'Kontak dengan pelanggan dapat meningkat konversi hingga 89% 😱', 'Gunakan Laptop/PC untuk exprience administratif terbaik 💻']
  let t = tips[Math.floor(Math.random() * tips.length)]
  tip.textContent = t
  const motivasi = document.querySelector('#motivasi');
  fetch("https://quotes.rest/qod?language=en")
    .then(function(response) {
      return response.json();
    })
    .then(function(data) {
      motivasi.innerHTML = `"${data.contents.quotes[0].quote}" - <span class="font-semibold">${data.contents.quotes[0].author}</span>`;
    });
</script>

<?php
include('shared/footer.php');
?>