<?php
    $user = 'mysql';
    $password = 'mysql';
    $db = 'nepogoda';
    $host = 'localhost';

    //PDO подключение к БД
    $dsn = 'mysql:host='.$host.';dbname='.$db;
    $pdo = new PDO($dsn, $user, $password);
?>