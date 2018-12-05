<!doctype html>
<html lang="ru">
<head>

    <?php
    $website_title = 'NEPOGODA.BY';
    require 'blocks/head.php';
    ?>

</head>
<body>
<?php require 'blocks/header.php'; ?>

<main class="container mt-5 container-main">
    <div class="row">
        <div class="col-md-8 mb-3">

            <?php require_once 'functions.php';?>
            <?php

            define("API_KEY", "ab06caeacd9e4f38c2b216a394d0ff11");
            date_default_timezone_set('Europe/Minsk');   //Устанавливаем таймзону Беларуси


            $gorod_poisk = trim(filter_var($_POST['gorod_poisk'],FILTER_SANITIZE_STRING));
            $error = '';

            if (strlen($gorod_poisk ) < 3) {
                $error= 'Короткое название!';
            }

            if (strlen($gorod_poisk ) > 23) {
                $error= 'Длинное название название!';
            }

            if ($error != ''){
                echo $error;
                exit();
            }

            require_once 'mysql_connect.php';

            $sql = 'SELECT gorod_id FROM gorod WHERE gorod_name_rus = ?';
            $query = $pdo->prepare($sql);
            $query->execute([$gorod_poisk]);
            $gorod_id = $query->fetchColumn();

            $link = 'http://api.openweathermap.org/data/2.5/forecast?id=' . $gorod_id . '&appid=' . API_KEY . '&units=metric';
            $api = file_get_contents($link);
            $nepogoda = json_decode($api, true);
            $nepogoda_count = count($nepogoda['list']); //количество элементов в массиве API для цикла



            //Определяем переменные для пополнения БД
            $data_prognoza = $nepogoda["list"][$i]["dt_txt"]; //ОБРАБОТАТЬ - получить только дату
            $time_prognoza = $nepogoda["list"][$i]["dt_txt"]; //ОБРАБОТАТЬ - получить только время
            $date_bd = date("Y-m-d");
            $time_bd = date("H:i:s");
            $city_id = $nepogoda["city"]["id"];
            $temp = $nepogoda["list"][$i]["main"]["temp"];
            $temp_max = $nepogoda["list"][$i]["main"]["temp_max"];
            $temp_min = $nepogoda["list"][$i]["main"]["temp_min"];
            $skorost_vetra = $nepogoda["list"][$i]["wind"]["speed"];
            $napravleniye_vetra = $nepogoda["list"][$i]["wind"]["deg"];
            $atmosfernoye_davleniye = $nepogoda["list"][$i]["main"]["sea_level"];
            $vlazhnost = $nepogoda["list"][$i]["main"]["humidity"];
            $usloviya = $nepogoda["list"][$i]["weather"][0]["description"];


            for($i = 0; $i < $nepogoda_count; $i++){
                if($nepogoda["list"][$i]["dt_txt"] != ""){
                    echo $nepogoda["list"][$i]["dt_txt"] . " = " . $nepogoda["list"][$i]["weather"][0]["description"];
                    echo "<br>";
                }
            };

            ?>

        </div>
        <?php require 'blocks/aside.php' ?>
    </div>
</main>

<?php require 'blocks/footer.php' ?>
</body>
</html>