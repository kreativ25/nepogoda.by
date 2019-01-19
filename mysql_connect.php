<?php
    $user = 'mysql';
    $password = 'mysql';
    $db = 'nepogoda';
    $host = 'localhost';
    $charset = 'utf8';

    //PDO подключение к БД
    $dsn = 'mysql:host='.$host.';dbname='.$db.';charset='.$charset;
    $pdo = new PDO($dsn, $user, $password);
?>