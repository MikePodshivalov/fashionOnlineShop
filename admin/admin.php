<?php
require $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/func.php';
require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

if (isset($_SESSION['profile'])) {
    $profile = $_SESSION['profile'];
} else {
    header('Location: /admin/index.php');
}

if($profile['role'] === 'admin') {
    require $_SERVER['DOCUMENT_ROOT'] . '/templates/navAdmin.html';
} elseif ($profile['role'] === 'operator') {
    require $_SERVER['DOCUMENT_ROOT'] . '/templates/navOperator.html';
}

if (isset($_GET['mode']) && ($_GET['mode'] === 'edit' || $_GET['mode'] === 'add')) {
    require $_SERVER['DOCUMENT_ROOT'] . '/include/add.php';
} else {
    require $_SERVER['DOCUMENT_ROOT'] . '/templates/allProducts.php';
}

require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
