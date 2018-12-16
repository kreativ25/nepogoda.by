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

            <canvas id="myChart" width="400" height="200"></canvas>

            <?php
            echo "</br>";
            echo "</br>";
            echo "</br>";
            ?>

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

            // ------------------------------ДЕЛАЕМ ЗАПРОСЫ ДЛЯ ГРАФИКА------------------------------
            require_once 'mysql_connect.php';
            $sql = 'SELECT temp 
                    FROM prognoz
                    WHERE city_id = ? 
                    ORDER BY data_prognoza ASC, time_prognoza ASC';
            $query = $pdo->prepare($sql);
            $query->execute([$gorod_id]);
            $json__encode_temp = $query->fetchAll(PDO::FETCH_COLUMN ); // возвращает массив, который состоит из всех строк

            //передаем в скрипт данные температуры погоды!
            echo '<script>var json__encode_temp_chart = ['.implode(",",$json__encode_temp).']</script>';

            //------------------------------------------------------------------------------------------
            //получаем данные дня прогноза и делаем массив из коротких названий ПН, ВТ....
            $sql = 'SELECT data_prognoza, time_prognoza 
                    FROM prognoz
                    WHERE city_id = ? 
                    ORDER BY data_prognoza ASC, time_prognoza ASC';
            $query = $pdo->prepare($sql);
            $query->execute([$gorod_id]);
            $json__encode_data_prognoza = $query->fetchAll(); // возвращает массив, который состоит из всех строк
            $json__encode_data_prognoza_COUNT = count($json__encode_data_prognoza); //определяем количество строк в массиве

            //делаем короткие даты

            $date_prognoza_array = []; // массив в который будут записываться сокращенные даты
            $time_prognoza_array = []; //массив в который будет записываться краткое время


            for ($i = 0; $i < $json__encode_data_prognoza_COUNT; $i++){

                //иницилизируем временный массив для записи в основной
                $date_prognoza_array_temp = [];

                //убираем дублирующиеся записи при обновлении БД
                $x = $i - 1;
                if ($json__encode_data_prognoza[$i]['data_prognoza'] == $json__encode_data_prognoza[$x]['data_prognoza'] and
                    $json__encode_data_prognoza[$i]['time_prognoza'] == $json__encode_data_prognoza[$x]['time_prognoza']){
                    continue;
                };

                //преобразуем дату в короткий формат
                $den_nedeli_array_chart = strftime("%w", strtotime($json__encode_data_prognoza[$i]['data_prognoza']));
                switch ($den_nedeli_array_chart){
                    case 0:
                        $json__encode_data_prognoza[$i]['data_prognoza'] = 'вс';
                        break;
                    case 1:
                        $json__encode_data_prognoza[$i]['data_prognoza'] = 'пн';
                        break;
                    case 2:
                        $json__encode_data_prognoza[$i]['data_prognoza'] = 'вт';
                        break;
                    case 3:
                        $json__encode_data_prognoza[$i]['data_prognoza'] = 'ср';
                        break;
                    case 4:
                        $json__encode_data_prognoza[$i]['data_prognoza'] = 'чт';
                        break;
                    case 5:
                        $json__encode_data_prognoza[$i]['data_prognoza'] = 'пт';
                        break;
                    case 6:
                        $json__encode_data_prognoza[$i]['data_prognoza'] = 'сб';
                        break;
                };

                //добавляем короткую дату в основной массив
                $date_prognoza_array_temp['data_prognoza'] = $json__encode_data_prognoza[$i]['data_prognoza'];
                $date_prognoza_array[] = $date_prognoza_array_temp['data_prognoza'];

                //форматируем дату в короткий вид
                $time_chart = date_create( $json__encode_data_prognoza[$i]['time_prognoza']);
                $date_prognoza_array_temp['time_prognoza'] = date_format($time_chart, 'H:i');

                //добовляем в массив время прогноза вторым столбцом
                $time_prognoza_array[] = $date_prognoza_array_temp['time_prognoza'];
            };

            //передаем в скрипт подписи данных для графика!
            echo '<script>var json__encode_data_chart = ['.implode(",",$date_prognoza_array).']</script>';

            echo "</br>";
            echo "</br>";
            echo "</br>";
            echo "</br>";


            print_r(implode(",",$json__encode_temp));

            echo "</br>";
            echo "</br>";

            print_r(implode(",",$date_prognoza_array));





            // ------------------------------КОНЕЦ ЗАПРОСОВ ДЛЯ ГРАФИКА----------------------------------

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



            $gorod_id_COUNT = count($gorod_id); //определяем количество строк в массиве


            echo "</br>";
            echo "</br>";

            //Начало новой таблицы
            echo '
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr class="bg-dark text-white " style="height: 41px">
                        <th class="text-center h6" >Дата</th>
                        <th class="h6">Темп.</th>
                        <th></th>
                        <th class="h6">Погодные явления</th>
                        <th class="h6">Ветер, м/с</th>
                        <th class="h6">Влаж., %</th>
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
                    
                    <tr class="bg-secondary text-white ">
                        <td class="bg-secondary text-white" colspan="6"> ' . $den_nedeli_rus .", " . $month_day . " " . $month_rus . ' </td>
                    </tr>
                    
                    ';
                }
                echo '
                    <tr>
                        <td class="text-center">' . $time_hort . '</td>
                        <td class="text-center">' . $gorod_id_print . '</td>
                        <td> <img src="img/Ясно%20(32х32)%20день.png" alt="небольшой дождь"> </td>
                        <td>' . $gorod_id[$i]["usloviya"] . '</td>
                        <td >' . $gorod_id[$i]["skorost_vetra"] . '</td>
                        <td >' . $gorod_id[$i]["vlazhnost"] . '</td>
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

<script src="/js/Chart.min.js"></script>
<script src="/js/chart_for_nepogoda.js"></script>

</body>
</html>
