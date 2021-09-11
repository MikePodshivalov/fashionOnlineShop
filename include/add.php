<?php
require $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/func.php';
authError();
if (!isset($_COOKIE['login']) || $_COOKIE['login'] != $adminLogin) {
    header("Location: /admin/index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $product = getProductById($id);
} else {
    $id = false;
    $product['section'] = false;
    $product['new'] = 0;
    $product['sale'] = 0;
}

?>
<script src="/js/jquery-3.6.0.js"></script>
<script src="/js/myScript.js"></script>
<main class="page-add">
    <h1 class="h h--1"><?= isset($_GET['id']) ? 'Изменение' : 'Добавление' ?> товара</h1>
    <form class="custom-form" id="change-add-product" enctype="multipart/form-data">
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Данные о товаре</legend>
                <p class="custom-form__input-label">
                    Название товара
                </p>
                <input type="text" class="custom-form__input afterClear" id="productName" name="name" value="<?= $product['name'] ?? '' ?>" id="product-name">
                <p class="custom-form__input-label">
                    Цена товара
                </p>
                <input type="text" class="custom-form__input afterClear" name="price" value="<?= $product['price'] ?? '' ?>" id="product-price">
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Фотография товара</legend>
            <ul class="add-list">
                <div class="product__image">
                    <img id="photo" class="product__image" src="<?= $product['photo'] ?? '' ?>" alt="product-name">
                </div>
                <li class="add-list__item add-list__item--add">
                    <label for="product-photo"><?= isset($product['photo']) ? 'Изменить' : 'Добавить' ?> фотографию</label> <br>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                    <input type="file" name="photo" id="product-photo">
                </li>
            </ul>
        </fieldset>
        <fieldset class="page-add__group custom-form__group">
            <legend class="page-add__small-title custom-form__title">Раздел</legend>
            <div class="page-add__select">
                <select name="category" class="custom-form__select afterClear" >
                    <option <?= $product['section'] ? "hidden=''" : '' ?>>Название раздела</option>
                    <option value="female" <?= checkSection($product['section'], "female") ?>>Женщины</option>
                    <option value="male" <?= checkSection($product['section'], "male") ?>>Мужчины</option>
                    <option value="children" <?= checkSection($product['section'], "children") ?>>Дети</option>
                    <option value="accessories" <?= checkSection($product['section'], "accessories") ?>>Аксессуары</option>
                </select>
            </div>
            <input type="checkbox" name="new" id="new" <?= $product['new'] ? 'checked' : '' ?> class="custom-form__checkbox afterClear">
            <label for="new" class="custom-form__checkbox-label">Новинка</label>
            <input type="checkbox" name="sale" id="sale" <?= $product['sale'] ? 'checked' : '' ?> class="custom-form__checkbox afterClear">
            <label for="sale" class="custom-form__checkbox-label">Распродажа</label>
        </fieldset>
        <input type="text" id="ID" class="afterClear" value="<?= $_GET['id'] ?? '' ?>" hidden="">
        <input class="button" id="changeProduct" name="submit" type="submit" value="<?= $id ? 'Изменить' : 'Добавить' ?> товар">
    </form>
    <div class="result-ajax"></div>
    <section class="shop-page__popup-end page-add__popup-end" hidden="">
        <div class="shop-page__wrapper shop-page__wrapper--popup-end">
            <h2 class="h h--1 h--icon shop-page__end-title">Товар успешно добавлен/изменен</h2>
            <a href="/admin/admin.php">Вернуться обратно к списку товаров</a>
        </div>
    </section>
</main>
