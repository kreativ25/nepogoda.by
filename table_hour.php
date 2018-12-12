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

            define("API_KEY", "ab06caeacd9e4f38c2b216a394d0ff11");
            date_default_timezone_set('Europe/Minsk');   //Устанавливаем таймзону Беларуси

            $sql = 'SELECT gorod_id FROM gorod WHERE gorod_name_rus = ?';
            $query = $pdo->prepare($sql);
            $query->execute([$gorod_poisk]);
            $gorod_id = $query->fetchColumn();

            $link = 'http://api.openweathermap.org/data/2.5/forecast?id=' . $gorod_id . '&appid=' . API_KEY . '&units=metric';
            $api = file_get_contents($link);
            $nepogoda = json_decode($api, true);
            $nepogoda_count = count($nepogoda['list']); //количество элементов в массиве API для цикла

            //*********************************************************
            //для тестов

            echo $gorod_id;
            echo "</br>";





            //*********************************************************

            echo "</br>";



            //--------СОЗДАЕМ ТАБЛИЦУ С ПРОГНОЗОМ------
            require_once 'mysql_connect.php';
            $sql = 'SELECT data_prognoza, time_prognoza, temp, usloviya, skorost_vetra, vlazhnost  
                    FROM prognoz
                    WHERE city_id = ? 
                    ORDER BY data_prognoza ASC, time_prognoza ASC';
            $query = $pdo->prepare($sql);
            $query->execute([$gorod_id]);
            $gorod_id = $query->fetchAll(); // возвращает массив, который состоит из всех строк

            $i = 1;

            echo $gorod_id[$i]["data_prognoza"] . "</br>";
            echo $gorod_id[$i]["time_prognoza"]. "</br>";
            echo $gorod_id[$i]["temp"] . "</br>";
            echo $gorod_id[$i]["usloviya"] . "</br>";
            echo $gorod_id[$i]["skorost_vetra"] . "</br>";
            echo $gorod_id[$i]["vlazhnost"] . "</br>";

            $gorod_id_COUNT = count($gorod_id); //определяем количество строк в массиве


            echo "</br>";
            echo "</br>";

            //Начало новой таблицы
            echo '
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>t°с</th>
                        <th>Условия</th>
                        <th>Ветер, м/с</th>
                        <th>Влажность, %</th>
                    </tr>
                    </thead>
                    <tbody>
            ';

            for ($i = 0; $i < $gorod_id_COUNT; $i++){

                //добавляем плюс к положительным цифрам, убираем отрицательный ноль и тд.
                if ($gorod_id[$i]["temp"] > 0){
                    $gorod_id_print =  "+".$gorod_id[$i]["temp"];
                };

                if ($gorod_id[$i]["temp"] < 0){
                    $gorod_id_print =  $gorod_id[$i]["temp"];
                };

                if ($gorod_id[$i]["temp"] == "-0"){
                    $gorod_id_print =  0;
                };


                //убираем дублирующиеся записи при обновлении БД
                $x = $i - 1;
                if ($gorod_id[$i]["data_prognoza"] == $gorod_id[$x]["data_prognoza"] and
                    $gorod_id[$i]["time_prognoza"] == $gorod_id[$x]["time_prognoza"]){
                    continue;
                };

                //выводим название дней недели на русском
                $den_nedeli = strftime("%w", strtotime($gorod_id[$i]["data_prognoza"]));

                //вытягиваем день месяца
                $date = date_create($gorod_id[$i]["data_prognoza"]);
                $month_day = date_format($date, 'd');

                $den_nedeli_rus = "";
                switch ($den_nedeli){
                    case 0:
                        $den_nedeli_rus = 'Воскресенье';
                        break;
                    case 1:
                        $den_nedeli_rus = 'Понедельник';
                        break;
                    case 2:
                        $den_nedeli_rus = 'Вторник';
                        break;
                    case 3:
                        $den_nedeli_rus = 'Среда';
                        break;
                    case 4:
                        $den_nedeli_rus = 'Четверг';
                        break;
                    case 5:
                        $den_nedeli_rus = 'Пятница';
                        break;
                    case 6:
                        $den_nedeli_rus = 'Суббота';
                        break;
                };

                //вытягиваем месяц на русском
                $month = date_format($date, 'n');
                switch ($month){
                    case 1:
                        $month_rus = 'января';
                        break;
                    case 2:
                        $month_rus = 'февраля';
                        break;
                    case 3:
                        $month_rus = 'марта';
                        break;
                    case 4:
                        $month_rus = 'апреля';
                        break;
                    case 5:
                        $month_rus = 'мая';
                        break;
                    case 6:
                        $month_rus = 'июня';
                        break;
                    case 7:
                        $month_rus = 'июля';
                        break;
                    case 8:
                        $month_rus = 'августа';
                        break;
                    case 9:
                        $month_rus = 'сентября';
                        break;
                    case 10:
                        $month_rus = 'октября';
                        break;
                    case 11:
                        $month_rus = 'ноября';
                        break;
                    case 12:
                        $month_rus = 'декабря';
                        break;
                };

                //делаем короткое время
                $time_BD = date_create($gorod_id[$i]["time_prognoza"]);
                $time_hort = date_format($time_BD, 'H:i');

                //разделяем дни
                if ($gorod_id[$i]["time_prognoza"] == '00:00:00'){
                    echo '
                    
                    <tr class="bg-secondary text-white">
                        <td class="bg-secondary text-white"> ' . $den_nedeli_rus .", " . $month_day . " " . $month_rus . ' </td>
                    </tr>
                    
                    ';
                }
                echo '
                    <tr>
                        <td>' . $time_hort . '</td>
                        <td>' . $gorod_id_print . '</td>
                        <td>' . '<img src="img/облачно_с_прояснениями.png" alt="небольшой дождь">' . " " . $gorod_id[$i]["usloviya"] . '</td>
                        <td class="text-center">' . $gorod_id[$i]["skorost_vetra"] . '</td>
                        <td class="text-center">' . $gorod_id[$i]["vlazhnost"] . '</td>
                    </tr>
                ';
            }

            echo '
             </tbody>
             </table>
             </div>
            ';
            ?>

        </div>
        <?php require 'blocks/aside.php' ?>
    </div>
</main>

<?php require 'blocks/footer.php' ?>
</body>
</html>