<?php

session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('1', '', time() - 3600);
setcookie('2', '', time() - 3600);

header("Location: loginAdmin.php");
exit;
