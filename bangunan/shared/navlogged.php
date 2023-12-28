    <nav class="navbar bg-base-100 max-w-6xl mx-auto">
      <div class="flex-1">
        <a class="btn btn-ghost normal-case text-xl">Joga Computer</a>
      </div>
      <div class="flex-none items-center">
        <div class="dropdown dropdown-end">
          <label tabindex="0" class="btn btn-ghost btn-circle">
            <div class="indicator">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <span class="badge badge-sm indicator-item">...</span>
            </div>
          </label>
          <div tabindex="0" class="mt-3 cards card-compact dropdown-content w-52 bg-base-100 shadow">
            <div class="card-body">
              <span class="font-bold text-lg text-info-total">0 Barang</span>
              <span class="text-info text-info-cart">Subtotal: Rp. 0.00</span>
              <div class="card-actions">
                <label for="my-modal-6" class="btn btn-primary btn-block">Lihat Keranjang</label>
                <button class="btn btn-error btn-block btn-clear-cart">Hapus Keranjang</button>
              </div>
            </div>
          </div>
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
            <li><a href="pesan.php">Belanja</a></li>
            <li>
              <a href="riwayat.php" class="justify-between">
                Pesanan
              </a>
            </li>
            <li>
              <label for="my-modal-7" class="justify-between">
                Cek Nota Servis
                <span class="badge">New</span>
              </label>
            </li>
            <li>
              <a href="profile.php?id=<?= $id; ?>">
                Profile
              </a>
            </li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div>
        <p id="toggleTheme" class="mb-2 md:mb-0 hover:translate-y-1 transition-all cursor-pointer text-2xl">🌚</p>
        <a target="_blank" href="https://tokopedia.link/jogacomputer"><img class="h-6" src="../img/tokopedia.png" alt="Tokopedia"></a <div class="toast toast-end z-50">
        <a target="_blank" href="https://shopee.co.id/joga_computer"><img class="h-6" src="../img/shopee.png" alt="Shoope"></a>
      </div>
    </nav>

    <input type="checkbox" id="my-modal-6" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
      <div class="modal-box">
        <h3 class="font-bold text-lg">Keranjang Kamu.</h3>
        <p class="py-4">Sebelum checkout pastikan barang kamu sudah sesuai, ya 😎.</p>
        <div class="isi-modal"></div>
        <p class="text-info-cart font-semibold mt-4">Total Harga:</p>
        <div class="modal-action">
          <a href="checkout.php" class="btn btn-success">Checkout</a>
          <label for="my-modal-6" class="btn">Kembali</label>
        </div>
      </div>
    </div>

    <input type="checkbox" id="my-modal-7" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
      <div class="modal-box">
        <h3 class="font-bold text-lg">Cek Nota Servis Kamu.</h3>
        <p class="py-4">Silahkan cek nota servis dengan mengisi nomer nota dan PIN yang diberikan 🤗.</p>
        <div id="isi-modal" class="isi-modal mb-4"></div>
        <div class="flex justify-between">
          <div class="form-control">
            <label class="label">
              <span class="label-text">Nomer Nota Servis</span>
            </label>
            <input required id="no-nota" type="number" placeholder="Nomer Nota" class="input input-bordered" />
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text">PIN</span>
            </label>
            <input required id="pin" type="number" placeholder="XXXXXX" class="input input-bordered" />
          </div>
        </div>
        <div class="modal-action">
          <a id="btn-cek" class="btn btn-success">Cek Nota</a>
          <label for="my-modal-7" class="btn">Kembali</label>
        </div>
      </div>
    </div>

    <script src="script/cart.js" defer></script>
    <script src="script/ceknota.js" defer></script>