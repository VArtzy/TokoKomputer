<?php
require_once('utils/functions.php');
require_once('utils/loggedAdmin.php');

$title = "Admin - $username";
include('shared/navadmin.php');
?>

<main id="main" class="max-w-7xl mx-auto leading-relaxed tracking-wider px-8 py-8 md:mt-8">
    <h1 class="text-2xl font-semibold">Master Page</h1>
    <h2 class="text-xl mb-4">Admin: <?= $username; ?></h2>

    <a href="golongan.php" class="btn btn-success">Golongan</a>
</main>

<?php
include('shared/footer.php');
?>