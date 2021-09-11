<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/include/func.php";

if (isset($_SESSION['isLogged']) && $_SESSION['isLogged']) {
    $loginInOut = "Выйти";
    $loginInOutPath = "/include/logout.php";
} else {
    $loginInOut = "Войти";
    $loginInOutPath = "/admin/index.php";
}

if (isset($_SESSION['profile']['role'])) {
    $role = $_SESSION['profile']['role'];
}

?>
    <nav class="page-header__menu">
        <ul class="main-menu main-menu--header">
            <li>
                <a class="main-menu__item" href="/index.php">Главная</a>
            </li>
            <li>
                <a class="main-menu__item" href="/index.php/?new=on">Новинки</a>
            </li>
            <li>
                <a class="main-menu__item active" href="/index.php/?sale=on">Sale</a>
            </li>
            <li>
                <a class="main-menu__item" href="/templates/delivery.php">Доставка</a>
            </li>
            <?php if (isset($role)): ?>
                <li>
                    <a class="main-menu__item" href="/admin/<?=$role?>.php"><?= $role ?></a>
                </li>
            <?php endif; ?>
            <li>
                <a class="main-menu__item" href="<?= $loginInOutPath ?>"><?= $loginInOut ?></a>
            </li>
        </ul>
    </nav>
</header>