<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/include/func.php';
$error = [];
if (isset($_POST)) {
    $product = [];
    $product['id'] = isset($_POST['ID']) ? (int)htmlspecialchars(trim($_POST['ID'])) : null;
    $product['name'] = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : null;
    $product['price'] = isset($_POST['price']) ? htmlspecialchars(trim($_POST['price'])) : null;
    $product['photo'] = isset($_POST['photo']) ? htmlspecialchars(trim($_POST['photo'])) : null;
    $product['select'] = isset($_POST['category']) ? htmlspecialchars(trim($_POST['category'])) : null;
    $product['new'] = (int)(bool)(isset($_POST['new']) ? htmlspecialchars(trim($_POST['new'])) : 0);
    $product['sale'] = (int)(bool)(isset($_POST['sale']) ? htmlspecialchars(trim($_POST['sale'])) : 0);
}

if(isset($_FILES['photo']) && chekFileError($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {
    $fileName = getNameFile();
    $path = '/img/products/' . $fileName;
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $path)) {
        echo 'Файл успешно загружен';
        $product['photo'] = basename($path);
    } else {
        echo 'Ошибка загрузки файла';
    }
}
$result = updateProduct($product);
var_dump($result);
