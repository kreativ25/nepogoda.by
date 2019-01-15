<!doctype html>
<html lang="ru">
<head>

    <?php
    $website_title = 'nepogoda.by';
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
















            //*********************************************************
            echo "<br>";
            echo "<br>";
            echo "<br>";

/*            //---------------------------------------------------
            require_once 'mysql_connect.php';
            ini_set('max_execution_time', 3000); //3000 seconds = 50 minutes - меняем время макс продолжительности скрипта

            //Прописываем API_KEY и таймзону
            define("API_KEY", "ab06caeacd9e4f38c2b216a394d0ff11");
            date_default_timezone_set('Europe/Minsk');   //Устанавливаем таймзону Беларуси

            $sql = 'SELECT MAX(date_bd) FROM prognoz';
            $query = $pdo->prepare($sql);
            $query->execute();
            $max_data_obnovlenia_BD = $query->fetchColumn(); //возвращает максимальную дату последнего обновления БД

            $sql = 'SELECT MAX(time_bd) FROM prognoz WHERE date_bd = ?';
            $query = $pdo->prepare($sql);
            $query->execute([$max_data_obnovlenia_BD]);
            $max_TIME_obnovlenia_BD = $query->fetchColumn(); //возвращает максимальное ВРЕМЯ последнего обновления БД

            //определяем количество городов в БД
            $sql = 'SELECT COUNT(*) FROM gorod';
            $query = $pdo->prepare($sql);
            $query->execute();
            $gorod_count = $query->fetchColumn(); //возвращает количество городов в БД

            //Создаем массив со списком городов
            $gorod_id_temp = $pdo->query('SELECT gorod_id FROM gorod')->fetchAll(PDO::FETCH_COLUMN);

            //НАЧАЛО ЦИКЛА
            for ($a = 0; $a < $gorod_count; $a++){ //количество городов

                $gorod_id_bd = $gorod_id_temp[$a]; //получаем город по списку

                $link = 'http://api.openweathermap.org/data/2.5/forecast?id=' . $gorod_id_bd . '&appid=' . API_KEY . '&units=metric';
                $url = trim($link);
                $api = file_get_contents($url);
                $nepogoda = json_decode($api, true);
                $nepogoda_count = count($nepogoda['list']); //количество элементов в массиве API для цикла


/*
                //Запускаем в цикл не подключившиеся соединения с API
                for($i = 0; $i < 20; $i++){

                    $link = 'http://api.openweathermap.org/data/2.5/forecast?id=' . $gorod_id_bd . '&appid=' . API_KEY . '&units=metric';
                    $url = trim($link);
                    $api = file_get_contents($url);
                    $nepogoda = json_decode($api, true);

                    if (!$nepogoda){

                        //увеличиваем время задержки
                        if ($i = 0){
                            sleep(1);
                        };

                        if ($i != 0 and $i <= 20){
                            $sleep = $sleep * 2;
                            sleep($sleep);
                        }
                    } else {
                        break;
                    }
                    //break;
                };

                $nepogoda_count = count($nepogoda['list']); //количество элементов в массиве API для цикла
*/
 /*               //Записываем полученные данные в БД
                for($i = 0; $i < $nepogoda_count; $i++){

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
                            $usloviya = 'Небольшой снег.';
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
                        case 'snow':
                            $usloviya = 'Снег.';
                            break;
                    }

                    $sql = 'INSERT INTO prognoz(
            data_prognoza,
            time_prognoza,
            date_bd,
            time_bd,
            city_id,
            temp,
            temp_max,
            temp_min,
            skorost_vetra,
            atmosfernoye_davleniye,
            vlazhnost,
            usloviya) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                    $query = $pdo->prepare($sql);
                    $query->execute([
                        $data_prognoza,
                        $time_prognoza,
                        $date_bd,
                        $time_bd,
                        $city_id,
                        $temp,
                        $temp_max,
                        $temp_min,
                        $skorost_vetra,
                        $atmosfernoye_davleniye,
                        $vlazhnost,
                        $usloviya]);
                };
                sleep(1); //делаем задержку записи в БД и обращения к API = 1 секунде
            }

            //УДАЛЯЕМ СТАРЫЕ ДАННЫЕ ИЗ БАЗЫ ДАННЫХ!!!
            $sql = 'DELETE FROM prognoz WHERE  date_bd <= ? AND time_bd <= ?';
            $query = $pdo->prepare($sql);
            $query->execute([$max_data_obnovlenia_BD, $max_TIME_obnovlenia_BD]);

            //---------------------------------------------------
*/

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