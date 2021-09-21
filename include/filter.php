<?php
if (isset($_POST)) {
    echo 'POST получен';
    var_dump($_POST);
} else {
    echo 'POST НЕ получен';
}
