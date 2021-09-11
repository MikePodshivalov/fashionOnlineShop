<?php
$maxId = getIdLastProduct();
$maxPages = getNumPagination($maxId);
$page = $_GET['page'] ?? "1";
$start = $count * ($page - 1);
$products = getProducts($start, $count);
?>

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
</section>
