<?php
    //добавляем плюс к положительным цифрам, убираем отрицательный ноль и тд.
    $temp_card = '';
    if ($gorod_id[0][3] > 0){
        $temp_card = "+".$gorod_id[0][3];
    }

    if ($gorod_id[0][3] < 0){
        $temp_card = $gorod_id[0][3];
    }

    if ($gorod_id[0][3] == "-0"){
        $temp_card = 0;
    }

    //вытягиваем день месяца
    $date = date_create($gorod_id[0]["data_prognoza"]);
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
    $time_BD = date_create($gorod_id[0]["time_prognoza"]);
    $time_hort = date_format($time_BD, 'H:i');

    //выбираем тучки в зависимости от условий погоды
    if ($gorod_id[0]["usloviya"] == 'Облачно с прояснениями'){
        if ($gorod_id[0]["time_prognoza"] == '09:00:00' or
            $gorod_id[0]["time_prognoza"] == '12:00:00' or
            $gorod_id[0]["time_prognoza"] == '15:00:00')
        {
            $linck = 'img/32х32/Обл_с_проясн_32_х_32_день.png';
        } else {
            $linck = 'img/32х32/Обл_с_проясн_32_х_32_ночь.png';
        }
    }

    //выбираем тучки в зависимости от восхода солнца по каждому месяцу года
    //-------------------ЯСНО----------------------
    if ($month == 1 or
        $month == 2 or
        $month == 11 or
        $month == 12){

        if ($gorod_id[0]["usloviya"] == 'Ясно'){
            if ($gorod_id[0]["time_prognoza"] == '09:00:00' or
                $gorod_id[0]["time_prognoza"] == '12:00:00' or
                $gorod_id[0]["time_prognoza"] == '15:00:00')
            {
                $linck = 'img/32х32/Ясно_32_х_32_день.png';
            } else {
                $linck = 'img/32х32/Ясно_32_х_32_ночь.png';
            }
        }
    }

    if ($month == 3 or
        $month == 4 or
        $month == 5 or
        $month == 6 or
        $month == 7 or
        $month == 8){

        if ($gorod_id[0]["usloviya"] == 'Ясно'){
            if ($gorod_id[0]["time_prognoza"] == '06:00:00' or
                $gorod_id[0]["time_prognoza"] == '09:00:00' or
                $gorod_id[0]["time_prognoza"] == '12:00:00' or
                $gorod_id[0]["time_prognoza"] == '15:00:00' or
                $gorod_id[0]["time_prognoza"] == '18:00:00' or
                $gorod_id[0]["time_prognoza"] == '21:00:00')
            {
                $linck = 'img/32х32/Ясно_32_х_32_день.png';
            } else {
                $linck = 'img/32х32/Ясно_32_х_32_ночь.png';
            }
        }
    }

    if ($month == 9 or
        $month == 10){

        if ($gorod_id[0]["usloviya"] == 'Ясно'){
            if ($gorod_id[0]["time_prognoza"] == '06:00:00' or
                $gorod_id[0]["time_prognoza"] == '09:00:00' or
                $gorod_id[0]["time_prognoza"] == '12:00:00' or
                $gorod_id[0]["time_prognoza"] == '15:00:00')
            {
                $linck = 'img/32х32/Ясно_32_х_32_день.png';
            } else {
                $linck = 'img/32х32/Ясно_32_х_32_ночь.png';
            }
        }
    }

    //------------------------ КОНЕЦ---ЯСНО----------------------------------
    if ($gorod_id[0]["usloviya"] == 'Небольшая облачность'){
        if ($gorod_id[0]["time_prognoza"] == '09:00:00' or
            $gorod_id[0]["time_prognoza"] == '12:00:00' or
            $gorod_id[0]["time_prognoza"] == '15:00:00')
        {
            $linck = 'img/32х32/Неб_обл_32_х_32_день.png';
        } else {
            $linck = 'img/32х32/Неб_обл_32_х_32_ночь.png';
        }
    }

    if ($gorod_id[0]["usloviya"] == 'Небольшой дождь'){
        $linck = 'img/32х32/Неб_дождь_32_х_32.png';
    }

    if ($gorod_id[0]["usloviya"] == 'Небольшой снег'){
        $linck = 'img/32х32/Снег_32_х_32.png';
    }

    if ($gorod_id[0]["usloviya"] == 'Дождь'){
        $linck = 'img/32х32/Дождь_32_х_32.png';
    }

    if ($gorod_id[0]["usloviya"] == 'Сплошная облачность'){
        $linck = 'img/32х32/Сплошн_обл_32_х_32.png';
    }

    //---------------------начало---ПЕРЕМЕННАЯ ОБЛАЧНОСТЬ-----------------------------
    if ($month == 1 or
        $month == 2 or
        $month == 11 or
        $month == 12){

        if ($gorod_id[0]["usloviya"] == 'Переменная облачность'){
            if ($gorod_id[0]["time_prognoza"] == '09:00:00' or
                $gorod_id[0]["time_prognoza"] == '12:00:00' or
                $gorod_id[0]["time_prognoza"] == '15:00:00')
            {
                $linck = 'img/32х32/Перем_обл_32_х_32_день.png';
            } else {
                $linck = 'img/32х32/Перем_обл_32_х_32_ночь.png';
            }
        }
    }

    if ($month == 3 or
        $month == 4 or
        $month == 5 or
        $month == 6 or
        $month == 7 or
        $month == 8){

        if ($gorod_id[0]["usloviya"] == 'Переменная облачность'){
            if ($gorod_id[0]["time_prognoza"] == '06:00:00' or
                $gorod_id[0]["time_prognoza"] == '09:00:00' or
                $gorod_id[0]["time_prognoza"] == '12:00:00' or
                $gorod_id[0]["time_prognoza"] == '15:00:00' or
                $gorod_id[0]["time_prognoza"] == '18:00:00' or
                $gorod_id[0]["time_prognoza"] == '21:00:00')
            {
                $linck = 'img/32х32/Перем_обл_32_х_32_день.png';
            } else {
                $linck = 'img/32х32/Перем_обл_32_х_32_ночь.png';
            }
        }
    }

    if ($month == 9 or
        $month == 10){

        if ($gorod_id[0]["usloviya"] == 'Переменная облачность'){
            if ($gorod_id[0]["time_prognoza"] == '06:00:00' or
                $gorod_id[0]["time_prognoza"] == '09:00:00' or
                $gorod_id[0]["time_prognoza"] == '12:00:00' or
                $gorod_id[0]["time_prognoza"] == '15:00:00')
            {
                $linck = 'img/32х32/Перем_обл_32_х_32_день.png';
            } else {
                $linck = 'img/32х32/Перем_обл_32_х_32_ночь.png';
            }
        }
    }
    //--------------------конец---ПЕРЕМЕННАЯ ОБЛАЧНОСТЬ------------------------------------

?>