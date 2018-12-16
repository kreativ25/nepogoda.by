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