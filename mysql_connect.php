<?php
    $user = 'admin_nepogoda';
    $password = 'velcom23';
    $db = 'admin_nepogoda';
    $host = 'localhost';
    $charset = 'utf8';

    //PDO подключение к БД
    $dsn = 'mysql:host='.$host.';dbname='.$db.';charset='.$charset;
    $pdo = new PDO($dsn, $user, $password);
?>