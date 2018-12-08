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
            $data_prognoza_temp = date_create($nepogoda["list"][$i]["dt_txt"]); //временная переменная для форматирвоания даты API
            $data_prognoza = date_format($data_prognoza_temp,'Y-m-d'); //принимает отформатированную дату API

            $time_prognoza_temp = date_create($nepogoda["list"][$i]["dt_txt"]); //временная переменная для форматирвоания времени API
            $time_prognoza = date_format( $time_prognoza_temp,'H:i:s'); //принимает отформатированное время API

            $date_bd_temp = date_create(date("Y-m-d"));
            $date_bd = date_format($date_bd_temp, 'Y-m-d'); //дата вставленных данных в БД

            $time_bd_temp = date_create(date("H:i:s"));
            $time_bd = date_format($time_bd_temp,"H:i:s"); //время вставленных данных в БД

            $city_id = $nepogoda["city"]["id"];
            $temp = number_format($nepogoda["list"][$i]["main"]["temp"],0);
            $temp_max = number_format($nepogoda["list"][$i]["main"]["temp_max"],0);
            $temp_min = number_format($nepogoda["list"][$i]["main"]["temp_min"],0);
            $skorost_vetra = number_format($nepogoda["list"][$i]["wind"]["speed"],0);
            $atmosfernoye_davleniye = number_format($nepogoda["list"][$i]["main"]["sea_level"],0, '.', '');
            $vlazhnost = number_format($nepogoda["list"][$i]["main"]["humidity"],0);

            $usloviya = "";
            switch ($nepogoda["list"][$i]["weather"][0]["description"]){
                case 'broken clouds':
                    $usloviya = 'Облачно с прояснениями.';
                    break;
                case 'clear sky':
                    $usloviya = 'Чистое небо.';
                    break;
                case 'few clouds':
                    $usloviya = 'Небольшая облачность.';
                    break;
                case 'light rain':
                    $usloviya = 'Небольшой дождь.';
                    break;
                case 'light snow':
                    $usloviya = 'Снег.';
                    break;
                case 'moderate rain':
                    $usloviya = 'Дождь.';
                    break;
                case 'overcast clouds':
                    $usloviya = 'Сплошная облачность.';
                    break;
                case 'scattered clouds':
                    $usloviya = 'Переменная облачность.';
                    break;
                case 'heavy intensity rain':
                    $usloviya = 'Сильный дождь.';
                    break;
            }


            echo $usloviya;

            echo "<br>";
            echo "<br>";
            echo "<br>";













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