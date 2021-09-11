<?php
require $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/func.php';

if (isset($_POST['login']) && isset($_POST['password']) && !empty($_POST['login']) && !empty($_POST['password'])) {
    $login = htmlspecialchars(trim($_POST['login']));
    $password = htmlspecialchars(trim($_POST['password']));
    $profile = getUserByLogin($login);
    $_SESSION['profile'] = $profile;
} else {
    authError();
}
if (password_verify($password, $profile['password'])) {
    $_SESSION['isLogged'] = true;
    setcookie('login', $login, time() + 60 * 60 * 24 * 30, '/'); //устанавливаем куку после успешной авторизации
    header("location: /index.php");
    exit();
} else {
    $_SESSION['isLogged'] = false;
    authError();
}


