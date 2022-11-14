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
  <title><?php if (isset($title)) {
            echo 'Toko Komputer - ' . $title;
          } else {
            echo "Toko Komputer";
          } ?></title>
</head>

<body class="font-dm">
  <nav class="navbar bg-base-100 max-w-6xl mx-auto">
    <div class="navbar-start">
      <div class="dropdown">
        <label tabindex="0" class="btn btn-ghost lg:hidden">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
          </svg>
        </label>
        <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
          <li><a href="admin.php"><i class="fa-solid fa-house"></i> Home</a></li>
          <li><a href="invoices.php"><i class="fa-solid fa-cart-shopping"></i> Invoices</a></li>
          <li><a href="barang.php"><i class="fa-solid fa-truck-field"></i> Barang</a></li>
          <li><a href="userAndAdminManagement.php"><i class="fa-solid fa-user-gear"></i> User & Admin</a></li>
        </ul>
      </div>
      <a class="btn btn-ghost normal-case text-xl">Toko Komputer Admin</a>
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
      </ul>
    </div>
    <div class="navbar-end">
      <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
          <div class="w-10 rounded-full">
            <img src="img/images.png" />
          </div>
        </label>
        <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
          <li class="px-4 mb-2 font-bold"><?php if (isset($username)) {
                                            echo $username;
                                          } ?></li>
          <li><a href="logoutAdmin.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
</body>

</html>