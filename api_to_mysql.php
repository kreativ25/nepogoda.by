<?php

    require_once 'mysql_connect.php';
    ini_set('max_execution_time', 5000); //5000 seconds около 83 minutes - меняем время макс продолжительности скрипта

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

        //Записываем полученные данные в БД
        for($i = 0; $i < $nepogoda_count; $i++){

            //Определяем переменные для пополнения БД
            $data_prognoza_temp = date_create($nepogoda["list"][$i]["dt_txt"]); //временная переменная для форматирвоания даты API
            $data_prognoza = date_format($data_prognoza_temp,'Y-m-d'); //принимает отформатированную дату API

            $time_prognoza_temp = date_create($nepogoda["list"][$i]["dt_txt"]); //временная переменная для форматирвоания времени API
            $time_prognoza = date_format( $time_prognoza_temp,'H:i'); //принимает отформатированное время API

            $date_bd_temp = date_create(date("Y-m-d"));
            $date_bd = date_format($date_bd_temp, 'Y-m-d'); //дата вставленных данных в БД

            $time_bd_temp = date_create(date("H:i:s"));
            $time_bd = date_format($time_bd_temp,"H:i"); //время вставленных данных в БД

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
                    $usloviya = 'Облачно с прояснениями';
                    break;
                case 'clear sky':
                    $usloviya = 'Ясно';
                    break;
                case 'few clouds':
                    $usloviya = 'Небольшая облачность';
                    break;
                case 'light rain':
                    $usloviya = 'Небольшой дождь';
                    break;
                case 'light snow':
                    $usloviya = 'Небольшой снег';
                    break;
                case 'moderate rain':
                    $usloviya = 'Дождь';
                    break;
                case 'overcast clouds':
                    $usloviya = 'Сплошная облачность';
                    break;
                case 'scattered clouds':
                    $usloviya = 'Переменная облачность';
                    break;
                case 'heavy intensity rain':
                    $usloviya = 'Сильный дождь';
                    break;
                case 'snow':
                    $usloviya = 'Снег';
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
        usleep(1500000); //делаем задержку записи в БД и обращения к API = 1.5 секунде
    }

    //УДАЛЯЕМ СТАРЫЕ ДАННЫЕ ИЗ БАЗЫ ДАННЫХ!!!
    $sql = 'DELETE FROM prognoz WHERE date_bd <= ? AND time_bd <= ?';
    $query = $pdo->prepare($sql);
    $query->execute([$max_data_obnovlenia_BD, $max_TIME_obnovlenia_BD]);

    //доп проверка - удаляем данные с датой прошлого дня

    $sql = 'SELECT MAX(date_bd) FROM prognoz';
    $query = $pdo->prepare($sql);
    $query->execute();
    $max_data__posle_obnovlenia_BD = $query->fetchColumn(); //возвращает максимальную дату после последнего обновления БД

    $sql = 'DELETE FROM prognoz WHERE date_bd < ?';
    $query = $pdo->prepare($sql);
    $query->execute([$max_data__posle_obnovlenia_BD]);
?>