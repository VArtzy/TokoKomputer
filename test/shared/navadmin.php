<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Toko Komputer terbaik di Indonesia! Memiliki berbagai macam spare part Komputer terbaik dengan harga yang terjangkau.">
  <link rel="apple-touch-icon" sizes="57x57" href="img/logo/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="img/logo/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="img/logo/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="img/logo/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="img/logo/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="img/logo/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="img/logo/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="img/logo/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="img/logo/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="img/logo/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="img/logo/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="img/logo/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="img/logo/favicon-16x16.png">
  <link rel="shortcut icon" href="img/logo/favicon.ico" type="image/x-icon">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="img/logo/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <script defer src="https://kit.fontawesome.com/cbe188b5fc.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./styles/index.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <script defer src="script/nav.js"></script>
  <title><?php if (isset($title)) {
            echo 'Toko Komputer - ' . $title;
          } else {
            echo "Toko Komputer";
          } ?></title>
</head>

<script>
  window.addEventListener("keydown", function(e) {
    if (e.keyCode === 114 || (e.ctrlKey && e.keyCode === 75)) {
      e.preventDefault();
      document.getElementById('searchlg').focus();
    }
  })

  function myFunction() {
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myMenu");
    li = ul.getElementsByTagName("li");

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
      a = li[i].getElementsByTagName("a")[0];
      if (a.textContent.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
  }

  function search() {
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById("searchlg");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myMenulg");
    li = ul.getElementsByTagName("li");

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
      a = li[i].getElementsByTagName("a")[0];
      if (a.textContent.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
      } else {
        li[i].style.display = "none";
      }
    }
  }
</script>

<body class="font-dm">

  <nav class="navbar bg-base-100 max-w-6xl mx-auto">
    <div class="navbar-start">
      <div class="dropdown">
        <label tabindex="0" class="btn btn-ghost lg:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
          </svg>
        </label>
        <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52 overflow-hidden">
          <input type="text" id="search" autocomplete="off" placeholder="Search" onkeyup="myFunction()" class="input input-bordered lg:hidden" />
          <ul id="myMenu" class="shadow-lg lg:hidden">
            <li><a href="admin.php"><i class="fa-solid fa-house"></i> Home</a></li>
            <li><a href="invoices.php"><i class="fa-solid fa-cart-shopping"></i> Invoices</a></li>
            <li><a href="barang.php"><i class="fa-solid fa-truck-field"></i> Barang</a></li>
            <li><a href="userAndAdminManagement.php"><i class="fa-solid fa-user-tie"></i> User & Admin</a></li>
            <li><a class="fa-solid fa-user-tie">Master</a></li>
            <li><a href="golongan.php">Golongan</a></li>
            <li><a href="subgolongan.php">Subgolongan</a></li>
            <hr />
            <li><a href="wilayah.php">Wilayah</a></li>
            <li><a href="lokasi.php">Lokasi</a></li>
            <hr />
            <li><a href="biaya.php">Biaya</a></li>
            <li><a href="jasa.php">Jasa</a></li>
            <hr />
            <li><a href="userAndAdminManagement.php#customer">Langganan</a></li>
            <li><a href="supplier.php">Supplier</a></li>
            <li><a href="userAndAdminManagement.php#salesman">Salesman</a></li>
            <hr />
            <li><a href="satuan.php">Satuan</a></li>
            <li><a href="multiprice.php">Multi Price</a></li>
            <li><a class="fa-solid fa-money-bills">Transaksi</a></li>
            <li><a href="beli.php">Pembelian</a></li>
            <li><a href="pembelianNota.php">Pelunasan Hutang</a></li>
            <hr>
            <li><a href="invoices.php">Penjualan</a></li>
            <li><a href="penjualanNota.php">Pembayaran Piutang</a></li>
            <hr>
            <li><a href="tandakeluarbarang.php">Tanda Keluar Barang</a></li>
            <li><a href="tandaterimabarang.php">Tanda Masuk Barang</a></li>
          </ul>
        </ul>
      </div>
      <a class="btn btn-ghost normal-case text-xl">Joga Computer Admin</a>
    </div>
    <div class="navbar-center hidden lg:flex">
      <ul class="menu menu-horizontal p-0">
        <div class="tooltip tooltip-bottom" data-tip="Admin Homepage">
          <li><a href="admin.php"><i class="fa-solid fa-house"></i></a></li>
        </div>
        <div class="tooltip tooltip-bottom" data-tip="Order & Invoices">
          <li><a href="invoices.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
        </div>
        <div class="tooltip tooltip-bottom" data-tip="Manajemen Barang">
          <li><a href="barang.php"><i class="fa-solid fa-truck-field"></i></a></li>
        </div>
        <div class="tooltip tooltip-bottom" data-tip="User & Admin Management">
          <li><a href="userAndAdminManagement.php"><i class="fa-solid fa-user-gear"></i></a></li>
        </div>
        <li>
          <div class="dropdown dropdown-bottom dropdown-hover">
            <label tabindex="0" class=""><i class="fa-solid fa-user-tie"></i></label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
              <li><a href="golongan.php">Golongan</a></li>
              <li><a href="subgolongan.php">Subgolongan</a></li>
              <hr />
              <li><a href="wilayah.php">Wilayah</a></li>
              <li><a href="lokasi.php">Lokasi</a></li>
              <hr />
              <li><a href="biaya.php">Biaya</a></li>
              <li><a href="jasa.php">Jasa</a></li>
              <hr />
              <li><a href="userAndAdminManagement.php#customer">Langganan</a></li>
              <li><a href="supplier.php">Supplier</a></li>
              <li><a href="userAndAdminManagement.php#salesman">Salesman</a></li>
              <hr />
              <li><a href="satuan.php">Satuan</a></li>
              <li><a href="barang.php">Barang</a></li>
              <li><a href="multiprice.php">Multi Price</a></li>
            </ul>
          </div>
        </li>
        <li>
          <div class="dropdown dropdown-bottom dropdown-hover">
            <label tabindex="0" class=""><i class="fa-solid fa-money-bills"></i></label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
              <li><a href="beli.php">Pembelian</a></li>
              <li><a href="pembelianNota.php">Pelunasan Hutang</a></li>
              <hr>
              <li><a href="invoices.php">Penjualan</a></li>
              <li><a href="penjualanNota.php">Pembayaran Piutang</a></li>
              <hr>
              <li><a href="tandakeluarbarang.php">Tanda Keluar Barang</a></li>
              <li><a href="tandaterimabarang.php">Tanda Masuk Barang</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
    <div class="navbar-end">
      <div class="group form-control hidden md:block">
        <input type="text" autocomplete="off" placeholder="Search (ctrl + K)" onkeyup="search()" type="search" id="searchlg" class="input input-bordered" />
        <ul id="myMenulg" class="absolute bg-base-100 flex-col gap-4 p-8 mt-2 shadow-lg z-50 hidden group-focus-within:flex">
          <li><a href="admin.php"><i class="fa-solid fa-house"></i> Home</a></li>
          <li><a href="invoices.php"><i class="fa-solid fa-cart-shopping"></i> Invoices</a></li>
          <li><a href="barang.php"><i class="fa-solid fa-truck-field"></i> Barang</a></li>
          <li><a href="userAndAdminManagement.php"><i class="fa-solid fa-user-tie"></i> User & Admin</a></li>
          <li><a href="golongan.php">Golongan</a></li>
          <li><a href="subgolongan.php">Subgolongan</a></li>
          <li><a>
              <hr />
            </a></li>
          <li><a href="wilayah.php">Wilayah</a></li>
          <li><a href="lokasi.php">Lokasi</a></li>
          <li><a>
              <hr />
            </a></li>
          <li><a href="biaya.php">Biaya</a></li>
          <li><a href="jasa.php">Jasa</a></li>
          <li><a>
              <hr />
            </a></li>
          <li><a href="userAndAdminManagement.php#customer">Langganan</a></li>
          <li><a href="supplier.php">Supplier</a></li>
          <li><a href="userAndAdminManagement.php#salesman">Salesman</a></li>
          <li><a>
              <hr />
            </a></li>
          <li><a href="satuan.php">Satuan</a></li>
          <li><a href="multiprice.php">Multi Price</a></li>
          <li><a href="beli.php">Pembelian</a></li>
          <li><a href="pembelianNota.php">Pelunasan Hutang</a></li>
          <li><a>
              <hr />
            </a></li>
          <li><a href="invoices.php">Penjualan</a></li>
          <li><a href="penjualanNota.php">Pembayaran Piutang</a></li>
          <li><a>
              <hr />
            </a></li>
          <li><a href="tandakeluarbarang.php">Tanda Keluar Barang</a></li>
          <li><a href="tandaterimabarang.php">Tanda Masuk Barang</a></li>
        </ul>
      </div>
      <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
          <div class="w-10 rounded-full">
            <img id="profile" src="img/images.png" />
          </div>
        </label>
        <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
          <li class="px-4 mb-2 font-bold"><?php if (isset($username)) {
                                            echo $username;
                                          } ?></li>
          <li><a href="logoutAdmin.php">Logout</a></li>
        </ul>
      </div>

      <p id="toggleTheme" class="mb-2 md:mb-0 hover:translate-y-1 transition-all cursor-pointer text-2xl">🌚</p>
    </div>
  </nav>
</body>

</html>