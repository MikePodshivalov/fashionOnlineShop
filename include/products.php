<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/func.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';
if (empty($_POST)) {
    $maxId = getCountProduct();
    $maxPages = getNumPagination($maxId);
    $page = $_GET['page'] ?? "1";
    $start = $count * ($page - 1);
    $products = getProducts($start, $count);
} else {
    $filter = [];
    $filter['cat'] = isset($_POST['category']) ? htmlspecialchars(trim($_POST['category'])) : 'all';
    $filter['min'] = isset($_POST['min']) ? (int)htmlspecialchars(str_replace(' ', '', $_POST['min'])) : 350;
    $filter['max'] = isset($_POST['max']) ? (int)htmlspecialchars(str_replace(' ', '', $_POST['max'])) : 32000;
    $filter['sale'] = isset($_POST['sale']) ? 1 : 0;
    $filter['new'] = isset($_POST['new']) ? 1 : 0;
    $allProducts = getAllProductsThroughFilter($filter);
    $maxId = count($allProducts);
    $maxPages = getNumPagination($maxId);
    $page = $_GET['page'] ?? "1";
    $start = $count * ($page - 1);
    $products = getProductsPagination($allProducts, $start, $count);
}

?>
<div id="products">
    <div class="shop__wrapper">
        <section class="shop__sorting">
            <div class="shop__sorting-item custom-form__select-wrapper">
                <select class="custom-form__select" name="category">
                    <option hidden="">Сортировка</option>
                    <option value="price">По цене</option>
                    <option value="name">По названию</option>
                </select>
            </div>
            <div class="shop__sorting-item custom-form__select-wrapper">
                <select class="custom-form__select" name="prices">
                    <option hidden="">Порядок</option>
                    <option value="all">По возрастанию</option>
                    <option value="woman">По убыванию</option>
                </select>
            </div>
            <p class="shop__sorting-res">Найдено <span class="res-sort"><?= $maxId ?></span> моделей</p>
        </section>
        <section class="shop__list">
        <?php foreach ($products as $product): ?>
            <article class="shop__item product" tabindex="0">
                <div class="product__image">
                    <img src="<?=$product['photo']?>" alt="product-name">
                </div>
                <p class="product__name"><?=$product['name']?></p>
                <span class="product__price"><?=$product['price']?> руб.</span>
            </article>
        <?php endforeach; ?>
        </section>

        <?php if ($maxPages > 1): ?>
            <ul class="shop__paginator paginator">
                <?php for ($i = 1; $i <= $maxPages; $i++): ?>
                    <li>
                        <a class="paginator__item" href="/index.php/?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
</section>
