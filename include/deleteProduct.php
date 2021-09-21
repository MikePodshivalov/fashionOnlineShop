<?php
require $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/func.php';

authError();

if (!isset($_COOKIE['login']) || $_COOKIE['login'] != $adminLogin) {
    header("Location: /admin/index.php");
    exit();
}

if (isset($_POST['ID']) && !empty($_POST['ID'])) {
    $id = (int)$_POST['ID'];
    if (deleteProductFromDb($id)) {
        echo "Товар с id=" . $id . " успешно удален из базы данных";
    } else {
        echo "error deleting";
    }
}

