<?php
require $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/include/func.php';
require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
if (isset($_SESSION['isLogged']) && !$_SESSION['isLogged']) {
    $errorMessage = 'Ошибка авторизации, попробуйте снова';
}
?>
    <nav class="page-header__menu">
        <ul class="main-menu main-menu--header">
            <li>
                <a class="main-menu__item" href="/index.php">Главная</a>
            </li>
        </ul>
    </nav>
</header>
    <main class="page-authorization">
        <h1 class="h h--1">Авторизация</h1>
        <form class="custom-form" action="/include/chekLoginPass.php" method="post">
            <input type="email" name="login" class="custom-form__input" required="">
            <input type="password" name="password" class="custom-form__input" required="">
            <button class="button" name="submit" type="submit" value="true">Войти в личный кабинет</button>
        </form>
        <p><?= $errorMessage ?? '' ?></p>
    </main>

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';
