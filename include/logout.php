<?php
require $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
unset($_SESSION['isLogged']);
session_destroy();
header("Location: /admin/index.php");
exit();

