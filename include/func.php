<?php

/**
 * Функция выводит переменную/объект для проверки
 * @param $var
 */
function debug($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

/**
 * 'Ленивое' подключение к базе данных
 * @return object
 */
function connect()
{
    require $_SERVER['DOCUMENT_ROOT'] . "/include/dbConfig.php";
    static $pdo = null;
    if (null === $pdo) {
        try {
            $pdo = new PDO($dsn, $dbLogin, $dbPassword);
        } catch (PDOException $e) {
            echo "Невозможно установить соединение с базой данных";
        }
    }
    return $pdo;
}

/**
 * Функция подключается к БД с помощью connect() и отправляет sql-запрос с помощью getResultBySql()
 * @param string $login
 */
function getUserByLogin(string $login)
{
    $db = connect(); //подключаемся к БД
    $sql = "SELECT * FROM users WHERE users.login = :something";
    return getResultBySql($db, $sql, $login);
}

/**
 * Функция подключается к БД с помощью connect() и отправляет sql-запрос с помощью getResultBySql()
 * @param mixed $id
 * @return mixed
 */
function getProductById(mixed $id): mixed
{
    if ($id == null) {
        return false;
    } else {
        $db = connect(); //подключаемся к БД
        $sql = "SELECT * FROM products WHERE products.id = :something";
        return getResultBySql($db, $sql, $id);
    }
}

/**
 * Функция выполняет подготовленный запрос к БД
 * @param object $db
 * @param string $sql
 * @param mixed $something
 * @return mixed
 */
function getResultBySql(object $db, string $sql, mixed $something): mixed
{
    $result = $db->prepare($sql);
    $result->execute([':something' => $something]);
    return $result->fetch();
}

/**
 * Функция определяет авторизован ли пользователь и если нет, то отправляет пользователя на страницу авторизации
 */
function authError () : void
{
    if (!isset($_SESSION['isLogged']) || !$_SESSION['isLogged']) {
        header("Location: /admin/index.php");
        exit();
    }
}

/**
 * Функция возвращает весь список продуктов для одной страницы
 * @return array|false
 * @param $start
 * @param $end
 */
function getProducts ($start, $end) : array|false
{
    $db = connect(); //подключаемся к БД
    $sql = "SELECT * FROM products LIMIT " . $start . ", " . $end;
    $result = $db->prepare($sql);
    $result->execute();
    return $result->fetchAll();
}

function getCountProduct (): int
{
    $db = connect(); //подключаемся к БД
    $sql = "SELECT COUNT(*) FROM products";
    $result = $db->prepare($sql);
    $result->execute();
    return (int)($result->fetch()[0]);
}
/**
 * Функция возвращает количество страниц для пагинации
 * @param int $numProduct
 * @return int
 */
function getNumPagination (int $numProduct) : int
{
    if ($numProduct <= 9) {
        return 1;
    } elseif ($numProduct % 9 === 0) {
        return $numProduct / 9;
    } else {
        return (int)($numProduct / 9) + 1;
    }
}

function checkSection(mixed $section, string $value): ?string
{
    if ($section === $value) {
        return "selected";
    } else {
        return null;
    }
}

function updateProduct(array|int $product) : string
{
    $db = connect();
    if ($product['id'] == null) {
        $sql = "INSERT INTO products (id, name, price, photo, section, new, sale)
                VALUES (:id, :nameProduct, :price, :photo, :sect, :newest, :sale)";
    } else {
        $sql = "UPDATE products SET name = :nameProduct, price = :price, photo = :photo, section = :sect, new= :newest, sale=:sale 
                WHERE products.id = :id";
    }
    $result = $db->prepare($sql);
    $task = [
        ':nameProduct' => $product['name'],
        ':price' => $product['price'],
        ':photo' => $product['photo'],
        ':sect' => $product['select'],
        ':newest' => $product['new'],
        ':sale' => $product['sale'],
        ':id' => $product['id']
    ];
    return $result->execute($task);
}

/**
 * Функция возвращает новое имя для нового загружаемого файла (jpg)
 * @return string
 */
function getNameFile(): string
{
    $db = connect();
    $sql = "SELECT MAX(id) AS id FROM products";
    $result = $db->prepare($sql);
    $result->execute();
    $num = (string)($result->fetch()['id'] + 1);
    return ('product-' . $num . '.jpg');
}

/**
 * Функция проверяет загружаемый файл на размер, ошибки, тип и определяет, был ли файл загружен во временную директорию
 * @param array $file
 * @return bool
 */
function chekFileError(array $file): bool
{
    if ($file['error'] > 0) {
        echo 'Ошибка: ';
        echo match ($file['photo']['error']) {
            1 => 'размер файла превышает значения upload_max_filesize',
            2 => 'размер файла превышает значения max_file_size',
            3 => 'файл загружен только частично',
            4 => 'файл не был загружен',
            6 => 'не удалось загрузить файл, не указан временный каталог',
            7 => 'не удалось выполнить запись на диск',
            8 => 'расширение PHP заблокировало загрузку файла',
        };
        return false;
    }
    if (!in_array((string)$file['type'], ['image/jpeg', 'image/jpg'])) {
        echo 'Файл не является изображением';
        return false;
    }
    if ($file['size'] > 2000000) {
        echo 'Размер файла превышает 2мб';
        return false;
    }
    return true;
}

function deleteProductFromDb(int $id): string
{
    $db = connect();
    $sql = "DELETE FROM products WHERE id = :id";
    $result = $db->prepare($sql);
    return $result->execute([':id' => $id]);
}

function getAllProductsThroughFilter (array $filter) : array|false
{
    $db = connect();
    if ($filter['cat'] === 'all') {
        $sql = "SELECT * FROM products WHERE (price > :minimal AND price < :maximum AND `sale`=:sale AND `new`=:newest)";
        $task = [
            ':minimal' => (int)$filter['min'],
            ':maximum' => (int)$filter['max'],
            ':sale' => (int)$filter['sale'],
            ':newest' => (int)$filter['new'],
        ];
    } else {
        $sql = "SELECT * FROM products WHERE (price > :minimal AND price < :maximum AND `section`=:sec AND `sale`=:sale AND `new`=:newest)";
        $task = [
            ':minimal' => (int)$filter['min'],
            ':maximum' => (int)$filter['max'],
            ':sec' => $filter['cat'],
            ':sale' => (int)$filter['sale'],
            ':newest' => (int)$filter['new'],
        ];
    }

    $result = $db->prepare($sql);
    $result->execute($task);
    return $result->fetchAll();
}

function getProductsPagination(array $products, int $start, int $end) : array
{
    if (count($products) < 9) {
        return $products;
    } else {
        $result = [];
        for ($i = $start; $i < $end; $i++) {
            $result[] = $products[$i];
        }
        return $result;
    }
}