<?php
require_once 'utils/functions.php';
require_once 'utils/logged.php';

$cart = $_COOKIE["shoppingCart"];
$data = json_decode($cart, true);

foreach ($data as $d) {
    $ids = $d['id'] . ',';
}


$title = "Checkout";
include('shared/nav.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl mb-8">Halaman Checkout</h1>

</main>

<script></script>
<?php
include('shared/footer.php')
?>