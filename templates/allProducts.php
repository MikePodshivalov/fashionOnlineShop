<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/func.php';
$maxId = getIdLastProduct();
$maxPages = getNumPagination($maxId);
$page = $_GET['page'] ?? "1";
$start = $count * ($page - 1);
$products = getProducts($start, $count);


?>
<main class="page-products">
<h1 class="h h--1">Товары</h1>
<a class="page-products__button button" href="/include/add.php?mode=add">Добавить товар</a>
<div class="page-products__header">
    <span class="page-products__header-field">Название товара</span>
    <span class="page-products__header-field">ID</span>
    <span class="page-products__header-field">Цена</span>
    <span class="page-products__header-field">Категория</span>
    <span class="page-products__header-field">Новинка</span>
</div>
<?php foreach ($products as $product): ?>
    <ul class="page-products__list">
    <li class="product-item page-products__item" id="<?= $product['id'] ?>">
      <b class="product-item__name"><?= $product['name'] ?></b>
      <span class="product-item__field product-item__id"><?= $product['id'] ?></span>
      <span class="product-item__field"> <?= $product['price'] ?></span>
      <span class="product-item__field"><?= $product['section'] ?></span>
      <span class="product-item__field"><?= $product['new'] ? "да" : "нет" ?></span>
      <a href="/include/add.php/?mode=edit&id=<?= $product['id'] ?>" class="product-item__edit" aria-label="Редактировать"></a>
      <button class="product-item__delete" name="delete" value="<?= $product['id'] ?>"></button>
    </li>
  </ul>
<?php endforeach; ?>
<br>
<?php if ($maxPages > 1): ?>
    <ul class="shop__paginator paginator">
        <?php for ($i = 1; $i <= $maxPages; $i++): ?>
            <li>
                <a class="paginator__item" href="/admin/admin.php/?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
<?php endif; ?>
