    <?php

    //----------------------------РАЗДЕЛ ТЕМПЕРАТУРЫ ДЛЯ ГРАФИКА------------------------------

    require_once 'mysql_connect.php';
    $sql = 'SELECT temp
    FROM prognoz
    WHERE 
    city_id = ? and (
    time_prognoza = \'03:00:00\' or 
    time_prognoza = \'09:00:00\' or 
    time_prognoza = \'15:00:00\' or 
    time_prognoza = \'21:00:00\') 
    ORDER BY data_prognoza ASC, time_prognoza ASC';
    $query = $pdo->prepare($sql);
    $query->execute([$gorod_id]);
    $json__encode_temp = $query->fetchAll(PDO::FETCH_COLUMN ); // возвращает массив, который состоит из всех строк

    //передаем в скрипт данные температуры погоды!
    echo '<script> var json__encode_temp_chart = ['.implode(",",$json__encode_temp).']</script>';

    //var_dump($json__encode_temp);

    //---------------------------------РАЗДЕЛ ДАТЫ ДЛЯ ГРАФИКА----------------------------------
    //получаем данные дня прогноза и делаем массив из коротких названий ПН, ВТ....
    $sql = 'SELECT data_prognoza, time_prognoza
    FROM prognoz
    WHERE city_id = ? and
    (time_prognoza = \'03:00:00\' or 
    time_prognoza = \'09:00:00\' or 
    time_prognoza = \'15:00:00\' or 
    time_prognoza = \'21:00:00\') 
    ORDER BY data_prognoza ASC, time_prognoza ASC';
    $query = $pdo->prepare($sql);
    $query->execute([$gorod_id]);
    $json__encode_data_prognoza = $query->fetchAll(); // возвращает массив, который состоит из всех строк
    $json__encode_data_prognoza_COUNT = count($json__encode_data_prognoza); //определяем количество строк в массиве

    //делаем короткие даты
    $date_prognoza_array = []; // массив в который будут записываться сокращенные даты
    $time_prognoza_array = []; //массив в который будет записываться краткое время

    //-----------
    $data_prognoza_array_1 = '';

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
    $json__encode_data_prognoza[$i]['data_prognoza'] = 'вс.';
        break;
        case 1:
    $json__encode_data_prognoza[$i]['data_prognoza'] = 'пн.';
        break;
        case 2:
    $json__encode_data_prognoza[$i]['data_prognoza'] = 'вт.';
        break;
        case 3:
    $json__encode_data_prognoza[$i]['data_prognoza'] = 'ср.';
        break;
        case 4:
    $json__encode_data_prognoza[$i]['data_prognoza'] = 'чт.';
        break;
        case 5:
    $json__encode_data_prognoza[$i]['data_prognoza'] = 'пт.';
        break;
        case 6:
    $json__encode_data_prognoza[$i]['data_prognoza'] = 'сб.';
        break;
    };

    //---------добавляем период дня сцепки с днем недели-------------------------

    $data_hort = "";
    if ($json__encode_data_prognoza[$i]['time_prognoza'] == '03:00:00'){
        $data_hort = ' ночь';
    }
    if ($json__encode_data_prognoza[$i]['time_prognoza'] == '09:00:00'){
            $data_hort = ' утро';
    }
    if ($json__encode_data_prognoza[$i]['time_prognoza'] == '15:00:00'){
            $data_hort = ' день';
    }
    if ($json__encode_data_prognoza[$i]['time_prognoza'] == '21:00:00'){
            $data_hort = ' вечер';
    }
    //---------------------------------------------------------------------------


    //добавляем короткую дату в основной массив
    $date_prognoza_array_temp['data_prognoza'] = $json__encode_data_prognoza[$i]['data_prognoza'];
    $date_prognoza_array[] = $date_prognoza_array_temp['data_prognoza'];

    //форматируем дату в короткий вид
    $time_chart = date_create( $json__encode_data_prognoza[$i]['time_prognoza']);
    $date_prognoza_array_temp['time_prognoza'] = date_format($time_chart, 'H:i');

    //добовляем в массив время прогноза вторым столбцом
    $time_prognoza_array[] = $date_prognoza_array_temp['time_prognoza'];

    $data_prognoza_array_1 = $data_prognoza_array_1 . '"' . $json__encode_data_prognoza[$i]['data_prognoza'] . $data_hort . '",';
    };

    //убираем последнюю запятую в списке
    $data_prognoza_array_1 = trim($data_prognoza_array_1, ",");

    //передаем в скрипт подписи данных для графика!
    echo '<script> var json__encode_data_chart = ['.$data_prognoza_array_1.']</script>';

// ------------------------------КОНЕЦ ЗАПРОСОВ ДЛЯ ГРАФИКА----------------------------------

?>