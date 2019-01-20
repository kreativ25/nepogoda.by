<?php
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
                        <tr class="bg-dark text-white" style="height: 33px;  vertical-align: middle">
                            <th class="text-center h6" >Дата</th>
                            <th class="text-center h6">Темп.</th>
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

        //выбираем тучки в зависимости от условий погоды

        if ($gorod_id[$i]["usloviya"] == 'Облачно с прояснениями'){
            if ($gorod_id[$i]["time_prognoza"] == '09:00:00' or
                $gorod_id[$i]["time_prognoza"] == '12:00:00' or
                $gorod_id[$i]["time_prognoza"] == '15:00:00')
            {
                $linck = '../img/32х32/Обл_с_проясн_32_х_32_день.png';
            } else {
                $linck = '../img/32х32/Обл_с_проясн_32_х_32_ночь.png';
            }
        }


        //выбираем тучки в зависимости от восхода солнца по каждому месяцу года
        //-------------------ЯСНО----------------------
        if ($month == 1 or
            $month == 2 or
            $month == 11 or
            $month == 12){

            if ($gorod_id[$i]["usloviya"] == 'Ясно'){
                if ($gorod_id[$i]["time_prognoza"] == '09:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '12:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '15:00:00')
                {
                    $linck = '../img/32х32/Ясно_32_х_32_день.png';
                } else {
                    $linck = '../img/32х32/Ясно_32_х_32_ночь.png';
                }
            }
        }

        if ($month == 3 or
            $month == 4 or
            $month == 5 or
            $month == 6 or
            $month == 7 or
            $month == 8){

            if ($gorod_id[$i]["usloviya"] == 'Ясно'){
                if ($gorod_id[$i]["time_prognoza"] == '06:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '09:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '12:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '15:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '18:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '21:00:00')
                {
                    $linck = '../img/32х32/Ясно_32_х_32_день.png';
                } else {
                    $linck = '../img/32х32/Ясно_32_х_32_ночь.png';
                }
            }
        }

        if ($month == 9 or
            $month == 10){

            if ($gorod_id[$i]["usloviya"] == 'Ясно'){
                if ($gorod_id[$i]["time_prognoza"] == '06:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '09:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '12:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '15:00:00')
                {
                    $linck = '../img/32х32/Ясно_32_х_32_день.png';
                } else {
                    $linck = '../img/32х32/Ясно_32_х_32_ночь.png';
                }
            }
        }

        //------------------------ КОНЕЦ---ЯСНО----------------------------------

        if ($gorod_id[$i]["usloviya"] == 'Небольшая облачность'){
            if ($gorod_id[$i]["time_prognoza"] == '09:00:00' or
                $gorod_id[$i]["time_prognoza"] == '12:00:00' or
                $gorod_id[$i]["time_prognoza"] == '15:00:00')
            {
                $linck = '../img/32х32/Неб_обл_32_х_32_день.png';
            } else {
                $linck = '../img/32х32/Неб_обл_32_х_32_ночь.png';
            }
        }

        if ($gorod_id[$i]["usloviya"] == 'Небольшой дождь'){
            $linck = '../img/32х32/Неб_дождь_32_х_32.png';
        }

        if ($gorod_id[$i]["usloviya"] == 'Небольшой снег'){
            $linck = '../img/32х32/Снег_32_х_32.png';
        }

        if ($gorod_id[$i]["usloviya"] == 'Дождь'){
            $linck = '../img/32х32/Дождь_32_х_32.png';
        }

        if ($gorod_id[$i]["usloviya"] == 'Сплошная облачность'){
            $linck = '../img/32х32/Сплошн_обл_32_х_32.png';
        }

        //---------------------начало---ПЕРЕМЕННАЯ ОБЛАЧНОСТЬ-----------------------------
        if ($month == 1 or
            $month == 2 or
            $month == 11 or
            $month == 12){

            if ($gorod_id[$i]["usloviya"] == 'Переменная облачность'){
                if ($gorod_id[$i]["time_prognoza"] == '09:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '12:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '15:00:00')
                {
                    $linck = '../img/32х32/Перем_обл_32_х_32_день.png';
                } else {
                    $linck = '../img/32х32/Перем_обл_32_х_32_ночь.png';
                }
            }
        }

        if ($month == 3 or
            $month == 4 or
            $month == 5 or
            $month == 6 or
            $month == 7 or
            $month == 8){

            if ($gorod_id[$i]["usloviya"] == 'Переменная облачность'){
                if ($gorod_id[$i]["time_prognoza"] == '06:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '09:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '12:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '15:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '18:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '21:00:00')
                {
                    $linck = '../img/32х32/Перем_обл_32_х_32_день.png';
                } else {
                    $linck = '../img/32х32/Перем_обл_32_х_32_ночь.png';
                }
            }
        }

        if ($month == 9 or
            $month == 10){

            if ($gorod_id[$i]["usloviya"] == 'Переменная облачность'){
                if ($gorod_id[$i]["time_prognoza"] == '06:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '09:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '12:00:00' or
                    $gorod_id[$i]["time_prognoza"] == '15:00:00')
                {
                    $linck = '../img/32х32/Перем_обл_32_х_32_день.png';
                } else {
                    $linck = '../img/32х32/Перем_обл_32_х_32_ночь.png';
                }
            }
        }
        //--------------------конец---ПЕРЕМЕННАЯ ОБЛАЧНОСТЬ------------------------------------

        if ($gorod_id[$i]["usloviya"] == 'Сильный дождь'){
            $linck = '../img/32х32/Сильн_дождь_32_х_32.png';
        }

        if ($gorod_id[$i]["usloviya"] == 'Снег'){
            $linck = '../img/32х32/Снег_32_х_32.png';
        }

        //разделяем дни
        if ($gorod_id[$i]["time_prognoza"] == '00:00:00'){
            echo '
                        
                        <tr class="bg-secondary text-white" >
                            <td class="bg-secondary text-white" colspan="6"> ' . $den_nedeli_rus .", " . $month_day . " " . $month_rus . ' </td>
                        </tr>
                        
                        ';
        }

        //делаем разделение по периоду дня - День, Вечер...

        //-------------------------------НОЧЬ---------------------------------
        if ($gorod_id[$i]["time_prognoza"] == '03:00:00'){

            //выделяем дни с аномальной температурой
            if (($gorod_id[$i]["temp"] < -15) or ($gorod_id[$i]["temp"] > 28) ){
                echo '
                        <tr style="background-color:   #f1b0b7">
                            <td class="text-center"> ночь </td>
                            <td class="text-center">' . $gorod_id_print . '</td>
                            <td> <img src=' . $linck . ' alt="Условия погоды" title="nepogoda.by"> </td>
                            <td>' . $gorod_id[$i]["usloviya"] . '</td>
                            <td >' . $gorod_id[$i]["skorost_vetra"] . '</td>
                            <td >' . $gorod_id[$i]["vlazhnost"] . '</td>
                        </tr>
                        ';
            } else {
                echo '
                        <tr>
                            <td class="text-center"> ночь </td>
                            <td class="text-center">' . $gorod_id_print . '</td>
                            <td> <img src=' . $linck . ' alt="Условия погоды" title="nepogoda.by"> </td>
                            <td>' . $gorod_id[$i]["usloviya"] . '</td>
                            <td >' . $gorod_id[$i]["skorost_vetra"] . '</td>
                            <td >' . $gorod_id[$i]["vlazhnost"] . '</td>
                        </tr>
                    ';
            }
        }
        //------------------------конец-НОЧИ-----------------------------------

        //-------------------------------УТРО---------------------------------
        if ($gorod_id[$i]["time_prognoza"] == '09:00:00'){

            //выделяем дни с аномальной температурой
            if (($gorod_id[$i]["temp"] < -15) or ($gorod_id[$i]["temp"] > 28) ){
                echo '
                        <tr style="background-color: #f1b0b7">
                            <td class="text-center"> утро </td>
                            <td class="text-center">' . $gorod_id_print . '</td>
                            <td> <img src=' . $linck . ' alt="Условия погоды" title="nepogoda.by"> </td>
                            <td>' . $gorod_id[$i]["usloviya"] . '</td>
                            <td >' . $gorod_id[$i]["skorost_vetra"] . '</td>
                            <td >' . $gorod_id[$i]["vlazhnost"] . '</td>
                        </tr>
                        ';
            } else {
                echo '
                        <tr>
                            <td class="text-center"> утро </td>
                            <td class="text-center">' . $gorod_id_print . '</td>
                            <td> <img src=' . $linck . ' alt="Условия погоды" title="nepogoda.by"> </td>
                            <td>' . $gorod_id[$i]["usloviya"] . '</td>
                            <td >' . $gorod_id[$i]["skorost_vetra"] . '</td>
                            <td >' . $gorod_id[$i]["vlazhnost"] . '</td>
                        </tr>
                    ';
            }
        }
        //------------------------конец-УТРО-----------------------------------

        //-------------------------------ДЕНЬ---------------------------------
        if ($gorod_id[$i]["time_prognoza"] == '15:00:00'){

            //выделяем дни с аномальной температурой
            if (($gorod_id[$i]["temp"] < -15) or ($gorod_id[$i]["temp"] > 28) ){
                echo '
                        <tr style="background-color: #f1b0b7">
                            <td class="text-center"> день </td>
                            <td class="text-center">' . $gorod_id_print . '</td>
                            <td> <img src=' . $linck . ' alt="Условия погоды" title="nepogoda.by"> </td>
                            <td>' . $gorod_id[$i]["usloviya"] . '</td>
                            <td >' . $gorod_id[$i]["skorost_vetra"] . '</td>
                            <td >' . $gorod_id[$i]["vlazhnost"] . '</td>
                        </tr>
                        ';
            } else {
                echo '
                        <tr>
                            <td class="text-center"> день </td>
                            <td class="text-center">' . $gorod_id_print . '</td>
                            <td> <img src=' . $linck . ' alt="Условия погоды" title="nepogoda.by"> </td>
                            <td>' . $gorod_id[$i]["usloviya"] . '</td>
                            <td >' . $gorod_id[$i]["skorost_vetra"] . '</td>
                            <td >' . $gorod_id[$i]["vlazhnost"] . '</td>
                        </tr>
                    ';
            }
        }
        //------------------------конец-ДЕНЬ-----------------------------------

        //-------------------------------ВЕЧЕР---------------------------------
        if ($gorod_id[$i]["time_prognoza"] == '21:00:00'){

            //выделяем дни с аномальной температурой
            if (($gorod_id[$i]["temp"] < -15) or ($gorod_id[$i]["temp"] > 28) ){
                echo '
                        <tr style="background-color: #f1b0b7">
                            <td class="text-center"> вечер </td>
                            <td class="text-center">' . $gorod_id_print . '</td>
                            <td> <img src=' . $linck . ' alt="Условия погоды" title="nepogoda.by"> </td>
                            <td>' . $gorod_id[$i]["usloviya"] . '</td>
                            <td >' . $gorod_id[$i]["skorost_vetra"] . '</td>
                            <td >' . $gorod_id[$i]["vlazhnost"] . '</td>
                        </tr>
                        ';
            } else {
                echo '
                        <tr>
                            <td class="text-center"> вечер </td>
                            <td class="text-center">' . $gorod_id_print . '</td>
                            <td> <img src=' . $linck . ' alt="Условия погоды" title="nepogoda.by"> </td>
                            <td>' . $gorod_id[$i]["usloviya"] . '</td>
                            <td >' . $gorod_id[$i]["skorost_vetra"] . '</td>
                            <td >' . $gorod_id[$i]["vlazhnost"] . '</td>
                        </tr>
                    ';
            }
        }
        //------------------------конец-ВЕЧЕР-----------------------------------
}
                echo '
                 </tbody>
                 </table>
                 </div>
                ';
    ?>